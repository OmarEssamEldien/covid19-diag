<?php

    // Infected Patients
    // Table Columns
    $columns = array('patient_id', 'date_of_recovery', 'doctor_id', 'alive');
                        
    $required_columns = array('infected_id', 'alive');
                        
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
            if(isset($POST['patient_id']) && is_numeric($POST['patient_id'])) {
                $where .= " AND patient_id = ".$POST['patient_id'];
            }
            if(isset($POST['doctor_id']) && is_numeric($POST['doctor_id'])) {
                $where .= " AND doctor_id = ".$POST['doctor_id'];
            }

            // Fetch Data to Result array
            $cols = $columns;

            $cols = "ID, ".implode(", ", $cols).", (SELECT username FROM users WHERE users.ID = doctor_id) as doctor"
                                                .", (SELECT username FROM users WHERE users.ID = patient_id) as patient";

            // Fetch Data From Database
            $sql = "SELECT $cols FROM recovered_patients WHERE 1 $where";
            $result['data'] = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            // If Data is Not Empty then Ok, Else Data Not Found 404 :)
            if(!empty($result['data'])) {
                $result['success'] = 'Ok';
            } else {
                $result['error'] = 'No Data Were Found';
            }

        } elseif($action == 'add') {
            // Required Fields That Must be Sent in The Request
            $fields = $required_columns;

            $post_fields = array_keys($POST);
            $missing_fields = array_diff($fields, $post_fields);

            // Check if Any Field is missing
            if(!empty( $missing_fields )) {
                $result['error'] = 'Some Required Fields are Missing';
                $result['details'] = implode(", ", $missing_fields);
            } else {

                // Set Fields in Variables
                $infected_id  = sanitize($POST['infected_id']);
                $recovery_date = (!empty($POST['recovery_date']) && validateDate($POST['recovery_date'])) ? $POST['recovery_date'] : date("Y-m-d");
                $doctor_id  = !empty($POST['doctor_id']) ? sanitize($POST['doctor_id']) : NULL;
                $alive = ($POST['alive'] == 1) ? 1 : 0;

                if(!is_numeric($infected_id) || $con->query("SELECT * FROM infected_patients WHERE ID = '$infected_id'")->rowCount() == 0) {
                    $result['error'] = 'Invalid Infected Patient ID';
                } elseif($doctor_id != NULL && $con->query("SELECT * FROM users WHERE ID = '$doctor_id' AND role_id = 3")->rowCount() == 0 ) {
                    $result['error'] = 'Invalid Doctor ID';
                } else {

                    $record = $con->query("SELECT * FROM infected_patients WHERE ID = '$infected_id'")->fetchAll()[0];
                    $patient_id = $record['patient_id'];
                    $doctor_id = (is_numeric($doctor_id)) ? $doctor_id : $record['doctor_id'];
                    $infection_date = $record['infection_date'];
                    $covid_type = $record['status'];

                    // Insert Data into Database if No Errors Were Found
                    $sql = "INSERT INTO recovered_patients 
                                   (patient_id, date_of_recovery, infection_date, doctor_id, covid_type, alive)
                            VALUES ('$patient_id', '$recovery_date', '$infection_date', '$doctor_id', '$covid_type', $alive);";
                    
                    $insert = $con->query($sql);

                    // Check if Row Inserted Successfully
                    if($insert->rowCount() > 0) {
                        // If Inserted Show Success Response with Row ID
                        $result['success'] = 'OK';
                        $result['row_id'] = $con->lastInsertId();

                        // Remove Patient From Infected Table
                        $sql = "DELETE FROM infected_patients WHERE ID = '$infected_id'";
                        $con->query($sql);
                    }
                    else
                        $result['error'] = 'Something Went Wrong';

                }
            }
    

        } elseif ($action == 'delete') {

            // Check if The Request Has a row_id Parameter and It's a Numerical Value
            if(isset($POST['row_id']) && is_numeric($POST['row_id'])) {
                
                // Delete Row From Database
                $sql = "DELETE FROM recovered_patients WHERE ID = ".$_POST['row_id'];
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