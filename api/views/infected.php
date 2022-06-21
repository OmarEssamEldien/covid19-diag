<?php

    // Infected Patients
    // Table Columns
    $columns = array('patient_id', 'infection_date', 'doctor_id', 'status', 'diseases', 'notes');
    $required_columns = array('patient_id', 'infection_date', 'doctor_id');
                        
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
                $where .= " AND infected_patients.doctor_id = ".$POST['doctor_id'];
            }
            if(isset($POST['infected_id']) && is_numeric($POST['infected_id'])) {
                $where .= " AND infected_patients.ID = ".$POST['infected_id'];
            }
            if(isset($POST['voting_required']) && $POST['voting_required'] == 1) {
                $where .= " AND status = 'Doctors to Decide' ";
            }

            // Fetch Data to Result array
            $cols = $columns;

            $cols = "ID, ".implode(", ", $cols).", (SELECT username FROM users WHERE users.ID = doctor_id) as doctor"
                                                .", (SELECT username FROM users WHERE users.ID = patient_id) as patient";

            // Fetch Data From Database
            $sql = "SELECT $cols, (SELECT TIMESTAMPDIFF(YEAR, dob, CURDATE()) FROM users WHERE ID = patient_id) AS patient_age FROM infected_patients WHERE 1 $where";
            $result['data'] = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            
            $http = (@$_SERVER['HTTPS'] == "on") ? 'https' : 'http';
            $link = pathinfo("$http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]")['dirname']."/";
            $link = explode("/api/", $link)[0];
            $ct_scans_url = "$link/uploads/ct_scans/";
            for($i = 0; $i < count($result['data']); $i++) {
                $sql = "SELECT * FROM patient_ct_scans WHERE infected_id = ".$result['data'][$i]['ID'];
                $result['data'][$i]['ct_scans'] = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                $result['data'][$i]['ct_scans_urls'] = array();
                $num_of_imgs = $result['data'][$i]['ct_scans'][0]['num_of_imgs'];
                if(!empty($result['data'][$i]['ct_scans'][0]))
                for($x = 0; $x < $num_of_imgs; $x++) {
                    $date = date("Ymd", strtotime($result['data'][$i]['ct_scans'][0]['date']));
                    $dcm_file = __DIR__."/../../uploads/ct_scans/" . $result['data'][$i]['patient_id']."_".$date."_".($x+1) . ".dcm";
                    $jpg_file = "$dcm_file.jpg";
                    $url_file = $ct_scans_url . $result['data'][$i]['patient_id']."_".$date."_".($x+1) . ".dcm.png";
                    if(!file_exists($jpg_file) && file_exists($dcm_file)) {
                        if(function_exists('popen')) {
                            // Dicom Images Convertor to JPG Type
                            require_once __DIR__.'/../../dicom_convertor/DicomConvert.php'; 
                            $d = new DicomConvert($dcm_file);
                            $outputFile = $d->dcm_to_jpg();
                        }
                    }
                    $result['data'][$i]['ct_scans_urls'][] = $url_file;
                }
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

            $post_fields = array_keys($POST);
            $missing_fields = array_diff($fields, $post_fields);

            // Check if Any Field is missing
            if(!empty( $missing_fields )) {
                $result['error'] = 'Some Required Fields are Missing';
                $result['details'] = implode(", ", $missing_fields);
            } else {

                // Set Fields in Variables
                $patient_id             = sanitize($POST['patient_id']);
                $infection_date         = !empty($POST['infection_date']) ? $POST['infection_date'] : date("Y-m-d");
                $doctor_id              = sanitize($POST['doctor_id']);
                $diseases               = (empty($POST['diseases'])) ? '' : sanitize($POST['diseases']);
                $notes                  = (empty($POST['notes'])) ? '' : sanitize($POST['notes']);


                if(!is_numeric($patient_id) || $con->query("SELECT * FROM users WHERE ID = '$patient_id' AND role_id = 4")->rowCount() == 0) {
                    $result['error'] = 'Invalid Patient ID';
                } elseif(!is_numeric($doctor_id) || $con->query("SELECT * FROM users WHERE ID = '$doctor_id' AND role_id = 3")->rowCount() == 0) {
                    $result['error'] = 'Invalid Doctor ID';
                } elseif(!validateDate($infection_date)) {
                    $result['error'] = 'Invalid Infection Date';
                } else {

                    // Insert Data into Database if No Errors Were Found
                    $sql = "INSERT INTO infected_patients 
                                   (patient_id, infection_date, doctor_id, status, prob_of_infection, active_id, diseases, notes)
                            VALUES ('$patient_id', '$infection_date', '$doctor_id', 'undiagnosed', 0, 0, '$diseases', '$notes');";

                    $insert = $con->query($sql);

                    // Check if Row Inserted Successfully
                    if($insert->rowCount() > 0) {
                        // If Inserted Show Success Response with Row ID
                        $result['success'] = 'OK';
                        $result['row_id'] = $con->lastInsertId();
                    }
                    else
                        $result['error'] = 'Something Went Wrong';

                }
            }
    

        } elseif ($action == 'delete') {

            // Check if The Request Has a row_id Parameter and It's a Numerical Value
            if(isset($POST['row_id']) && is_numeric($POST['row_id'])) {
                
                // Delete Row From Database
                $sql = "DELETE FROM infected_patients WHERE ID = ".$_POST['row_id'];
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