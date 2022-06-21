<?php

    // Infected Patients
    // Table Columns
    $columns = array('infected_id', 'diagnose', 'doctor_id');
                        
    $required_columns = $columns;
                        
    // Set POST Request Params in array
    $POST = $_POST;

    // Check if Parameter Action is Sent in Request
    if(!isset($POST['action'])) {
        $result['error'] = 'Action Parameter is Missing';
    } else {
        $action = $POST['action'];
        // Check Required Action
        if($action == 'fetch') {

            // Check if Request looking for any Specific Rows
            $where = '';
            if(isset($POST['infected_id']) && is_numeric($POST['infected_id'])) {
                $where .= " AND voting_for_infection.infected_id = ".$POST['infected_id'];
            }
            if(isset($POST['doctor_id']) && is_numeric($POST['doctor_id'])) {
                $where .= " AND voting_for_infection.doctor_id = ".$POST['doctor_id'];
            }

            // Fetch Data to Result array
            $cols = $columns;

            $cols = "voting_for_infection.ID, voting_for_infection.".implode(", voting_for_infection.", $cols)
                    .", (SELECT username FROM users WHERE users.ID = voting_for_infection.doctor_id) as doctor"
                    .", (SELECT username FROM users WHERE users.ID = patient_id) as patient";

            // Fetch Data From Database
            $sql = "SELECT $cols FROM voting_for_infection
                    INNER JOIN infected_patients ON infected_patients.ID = voting_for_infection.infected_id 
                    WHERE 1 $where";
            $result['data'] = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            $result['num_of_votes'] = count($result['data']);
            for($i = 0; $i < count($result['data']); $i++) {
                $sql = "SELECT * FROM patient_ct_scans WHERE infected_id = ".$result['data'][$i]['ID'];
                $result['data'][$i]['ct_scans'] = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            }

            // If Data is Not Empty then Ok, Else Data Not Found 404 :)
            if(!empty($result['data'])) {
                $result['success'] = 'Ok';
            } else {
                $result['error'] = 'No Data Were Found';
            }

        } elseif($action == 'add') {
            // Required Fields That Must be Sent in The Request
            $fields = $required_columns;

            $votes_required = settings("doctors_votes_required");

            $post_fields = array_keys($POST);
            $missing_fields = array_diff($fields, $post_fields);

            // Check if Any Field is missing
            if(!empty( $missing_fields )) {
                $result['error'] = 'Some Required Fields are Missing';
                $result['details'] = implode(", ", $missing_fields);
            } else {

                // Set Fields in Variables
                $infected_id             = sanitize($POST['infected_id']);
                $doctor_id              = sanitize($POST['doctor_id']);
                $diagnose               = $POST['diagnose'];

                if($con->query("SELECT * FROM voting_for_infection WHERE infected_id = '$infected_id'")->rowCount() >= $votes_required) {
                    $result['error'] = 'No Voting Required for This Patient';
                } elseif(!is_numeric($infected_id) || $con->query("SELECT * FROM infected_patients WHERE ID = '$infected_id'")->rowCount() == 0) {
                    $result['error'] = 'Invalid Infected Patient ID';
                } elseif($con->query("SELECT * FROM infected_patients WHERE ID = '$infected_id' AND status = 'Doctors to Decide'")->rowCount() == 0) {
                    $result['error'] = 'Doctors Decision is Not Required for This Patient';
                } elseif(!is_numeric($doctor_id) || $con->query("SELECT * FROM users WHERE ID = '$doctor_id' AND role_id = 3")->rowCount() == 0) {
                    $result['error'] = 'Invalid Doctor ID';
                } elseif(!in_array($diagnose, array("covid19", "pneumonia", "none"))) {
                    $result['error'] = 'Invalid Diagnoses';
                } else {

                    // If No Errors Were Found
                    // If Doctor Voted Before Update
                    if($con->query("SELECT * FROM voting_for_infection WHERE infected_id = '$infected_id' AND doctor_id = '$doctor_id'")->rowCount() > 0) {
                        // $result['error'] = 'You Have Already Voted for This Infection';

                        $update = 1;
                        // Update Data in Database
                        $sql = "UPDATE voting_for_infection SET diagnose = '$diagnose' 
                                WHERE infected_id = '$infected_id' AND doctor_id = '$doctor_id';";
                    } else { // Else Insert
                        $update = 0;
                        // Insert Data into Database
                        $sql = "INSERT INTO voting_for_infection 
                                       (infected_id, diagnose, doctor_id)
                                VALUES ('$infected_id', '$diagnose', '$doctor_id');";
                    }
                    
                    $insert = $con->query($sql);


                    // If All Required Votes Takes to Decide get Most Diagnose and Set it as The Status or Result
                    if($result['votes_taken'] == $votes_required) {
                        $sql = "SELECT diagnose, COUNT(*) AS magnitude FROM voting_for_infection 
                                WHERE infected_id = '$infected_id'
                                GROUP BY diagnose ORDER BY magnitude DESC LIMIT 1;";

                        $result['votes_result'] = $con->query($sql)->fetchAll()[0]['diagnose'];
                        $result['votes_result_num'] = $con->query($sql)->fetchAll()[0]['magnitude'];

                        $infected_status = $result['votes_result'];
                        
                        // Update Status and Probability of Infection after AI's Respond
                        $sql = "UPDATE infected_patients SET status = '$infected_status', prob_of_infection = '0' WHERE ID = '$infected_id'";
                        $update = $con->query($sql);

                    }

                    // Check if Row Inserted Successfully
                    if($insert) {
                        // If Inserted Show Success Response with Row ID
                        $result['success'] = 'OK';
                        if($update == 0)
                            $result['row_id'] = $con->lastInsertId();
                        else
                            $result['row_id'] = $con->query("SELECT * FROM voting_for_infection WHERE infected_id = '$infected_id' 
                                                            AND doctor_id = '$doctor_id'")->fetchAll()[0]['ID'];

                        $result['votes_taken'] = $con->query("SELECT * FROM voting_for_infection WHERE infected_id = '$infected_id'")->rowCount();

                    }
                    else
                        $result['error'] = 'Something Went Wrong';

                }
            }
    

        } elseif ($action == 'delete') {

            // Check if The Request Has a row_id Parameter and It's a Numerical Value
            if(isset($POST['row_id']) && is_numeric($POST['row_id'])) {
                
                // Delete Row From Database
                $sql = "DELETE FROM voting_for_infection WHERE ID = ".$_POST['row_id'];
                $delete = $con->query($sql);

                // If More Than 0 Record Was Deleted then Ok, Else Record Wasn't Found
                if($delete->rowCount() > 0) {
                    $result['success'] = 'Ok';
                } else {
                    $result['error'] = 'Record Not Found';
                }

            } else {
                $result['error'] = 'row_id Parameter is Missing or Invalid';
            }

        } else {
            $result['error'] = 'Invalid Request for Infected Patients';
        }
    }