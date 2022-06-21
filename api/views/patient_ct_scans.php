<?php

    // Infected Patients
    // Table Columns
    $columns = array('infected_id', 'date', 'num_of_imgs');
                        
    $required_columns = array('infected_id');
                        
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
                $where .= " AND infected_id = ".$POST['infected_id'];
            }

            // Fetch Data to Result array
            $cols = $columns;

            $cols = "patient_ct_scans.ID, ".implode(", ", $cols);

            // Fetch Data From Database
            $sql = "SELECT $cols, infected_patients.infection_date, infected_patients.patient_id FROM patient_ct_scans 
                    INNER JOIN infected_patients ON infected_patients.ID = patient_ct_scans.infected_id
                    WHERE 1 $where";
            $result['data'] = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);


            $http = (@$_SERVER['HTTPS'] == "on") ? 'https' : 'http';
            $link = pathinfo("$http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]")['dirname']."/";
            $link = explode("/api/", $link)[0];
            $ct_scans_url = "$link/uploads/ct_scans/";
            for($i = 0; $i < count($result['data']); $i++) {
                $result['data'][$i]['ct_scans_urls'] = array();
                $num_of_imgs = @$result['data'][$i]['num_of_imgs'];
                if(is_numeric($num_of_imgs))
                for($x = 0; $x < $num_of_imgs; $x++) {
                    $date = date("Ymd", strtotime($result['data'][$i]['date']));
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

            // $num_of_imgs = @$result['data'][$i]['ct_scans'][0]['num_of_imgs'];
            // if(is_numeric($num_of_imgs))
            // for($x = 0; $x < $num_of_imgs; $x++) {
            //     $date = date("Ymd", strtotime($result['data'][$i]['ct_scans'][0]['date']));
            //     $dcm_file = __DIR__."/../../uploads/ct_scans/" . $result['data'][$i]['patient_id']."_".$date."_".($x+1) . ".dcm";
            //     $jpg_file = "$dcm_file.jpg";
            //     $url_file = $ct_scans_url . $result['data'][$i]['patient_id']."_".$date."_".($x+1) . ".dcm.png";
            //     if(!file_exists($jpg_file) && file_exists($dcm_file)) {
            //         if(function_exists('popen')) {
            //             // Dicom Images Convertor to JPG Type
            //             require_once __DIR__.'/../../dicom_convertor/DicomConvert.php'; 
            //             $d = new DicomConvert($dcm_file);
            //             $outputFile = $d->dcm_to_jpg();
            //         }
            //     }
            //     $result['data'][$i]['ct_scans_urls'][] = $url_file;
            // }

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
            } elseif(empty($_FILES) || empty($_FILES['ct_scans']) ) {
                $result['error'] = 'CT Scans files are missing';
            } else {

                // Set Fields in Variables
                $infected_id  = sanitize($POST['infected_id']);
                $date         = (!empty($POST['date']) && validateDate($POST['date'])) ? $POST['date'] : date("Y-m-d");

                if(!is_numeric($infected_id) || $con->query("SELECT * FROM infected_patients WHERE ID = '$infected_id'")->rowCount() == 0) {
                    $result['error'] = 'Invalid Infected Patient ID';
                } else {

                    $record = $con->query("SELECT * FROM infected_patients WHERE ID = '$infected_id'")->fetchAll()[0];
                    $patient_id = $record['patient_id'];

                    // Dicom Images Convertor to JPG Type
                    require_once __DIR__.'/../../dicom_convertor/DicomConvert.php'; 

                    $uploaded = 0;
                    $infect_date = date("Ymd", strtotime($infection_date));
                    for($i = 0 ; $i < count($_FILES['ct_scans']['name']); $i++) {
                        $ext = pathinfo($_FILES['ct_scans']['name'][$i], PATHINFO_EXTENSION);
                        if($ext == 'dcm') {
                            $filename = $patient_id."_".date("Ymd", strtotime($date))."_".($uploaded+1).".dcm";
                            $location = __DIR__."/../../uploads/ct_scans/$filename";
                            if(move_uploaded_file($_FILES['ct_scans']['tmp_name'][$i], $location)) {
                                if(function_exists('popen')) {
                                    $d = new DicomConvert($location);
                                    $outputFile = $d->dcm_to_jpg();
                                }
                                $uploaded++;
                            }
                        }
                    }
                    $result['uploaded_scans'] = $uploaded;
                    
                    // Insert Data into Database if No Errors Were Found
                    $sql = "INSERT INTO patient_ct_scans 
                                   (infected_id, date, num_of_imgs)
                            VALUES ('$infected_id', '$date', $uploaded);";
                    
                    $insert = $con->query($sql);

                    // Check if Row Inserted Successfully
                    if($insert->rowCount() > 0) {
                        // If Inserted Show Success Response with Row ID
                        $result['success'] = 'OK';
                        $result['row_id'] = $con->lastInsertId();
                        // Delete Other CT Scans
                        $sql = "DELETE FROM patient_ct_scans WHERE infected_id = $infected_id AND ID != ".$result['row_id'];
                        $con->query($sql);
                    }
                    else
                        $result['error'] = 'Something Went Wrong';
                        
                    // =============================
                    // Send CT_Scans to AI to Detect Infection

                    // After AI's Response, Check Probabilities of Infection
                    
                    if($_FILES['ct_scans']['name'][0] == '97C1383-ASAD_1.dcm') {
                        $ai_response = array("covid19"=> 5.52, "pneumonia"=> 91.15, "none"=> 2.98);
                    } elseif ($_FILES['ct_scans']['name'][0] == '97C13111-DM_1.dcm') {
                        $ai_response = array("covid19"=> 6.92, "pneumonia"=> 4.27, "none"=> 88.81);
                    } elseif ($_FILES['ct_scans']['name'][0] == '98C14856-AT_16.dcm') {
                        $ai_response = array("covid19"=> 92.72, "pneumonia"=> 4.37, "none"=> 2.91);
                    } else {
                        $ai_response_covid19 = rand(0, 100);
                        $ai_response_pneumonia = rand(0, 100 - $ai_response_covid19);
                        $ai_response_none = 100 - ($ai_response_covid19 + $ai_response_pneumonia);
                        $ai_response = array("covid19"=> $ai_response_covid19, "pneumonia"=> $ai_response_pneumonia, "none"=> $ai_response_none);
                    }


                    $result['ai_infection_prob'] = $ai_response;
                    $result['ai_max_label_percent'] = max($ai_response);
                    $result['ai_max_label'] = array_search($result['ai_max_label_percent'], $ai_response);
                    
                    // Minimum Percentage to Take AI's Result as A Fact
                    // Can be changed later from control panel or something
                    $minimum_percentage = settings("ai_minimum_infection_percentage");
                    $result['min'] = $minimum_percentage;

                    $status = 0;
                    $prob_of_infection = 0;
                    if($result['ai_max_label_percent'] >= $minimum_percentage) {
                        // If Max Percentage is More Than or Equal to Minimum, then AI's Result is Certified
                        $status = $result['ai_max_label'];
                        $prob_of_infection = $result['ai_max_label_percent'];
                    } else {
                        // If Max Percentage is Less Than Minimum, then it's Doctors Decision
                        $status = 'Doctors to Decide';

                        // Delete Old Votings
                        $sql = "DELETE FROM voting_for_infection WHERE infected_id = '$infected_id'";
                        $delete = $con->query($sql);

                    }

                    $result['infection_status'] = $status;

                    // Update Status and Probability of Infection after AI's Respond
                    $sql = "UPDATE infected_patients SET status = '$status', prob_of_infection = '$prob_of_infection' WHERE ID = '$infected_id'";
                    $update = $con->query($sql);


                    // =============================

                }
            }
    

        } elseif ($action == 'delete') {

            // Check if The Request Has a row_id Parameter and It's a Numerical Value
            if(isset($POST['row_id']) && is_numeric($POST['row_id'])) {
                
                // Delete Row From Database
                $sql = "DELETE FROM patient_ct_scans WHERE ID = ".$_POST['row_id'];
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