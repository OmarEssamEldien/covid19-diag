<?php

//API For Table : user_emergency_contact

$columns = array('user_id', 'address','name','phone_num');

// Set POST Request as Params in array
    $POST = $_POST;

if(!isset($POST['action'])) {
        $result['error'] = 'Action Parameter is Missing';
    } else {
    	$action = $POST['action'];
        // Check Required Action
        if($action == 'fetch') {

            // Check if Request has user_id
            if(!isset($POST['user_id']) || !is_numeric($POST['user_id'])) {
                
                $result['error'] = 'user_id Parameter is Missing';

            } else {

                $user_id = $_POST['user_id'];

                // Check if Request looking for any Specific Rows
                $where = '';
                if(isset($POST['contact_id']) && is_numeric($POST['contact_id'])) {
                    $where .= " AND user_emergency_contact.ID = ".$POST['contact_id'];
                }

                // Fetch Data From Database
                $sql = "SELECT * FROM user_emergency_contact WHERE user_emergency_contact.user_id = '$user_id' $where";
                $result['data'] = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                // If Data is Not Empty then Ok, Else Data Not Found 404 :)
                if(!empty($result['data'])) {
                    $result['success'] = 'Ok';
                } else {
                    $result['error'] = 'No Data Were Found';
                }

            }
            
        } elseif($action == 'add') {
            // Required Fields That Must be Sent in The Request
            $fields = $columns;

            $post_fields = array_keys($POST);
            $missing_fields = array_diff($fields, $post_fields);

            // Check if Any Field is missing
            if(!empty( $missing_fields )) {
                $result['error'] = 'Some Required Fields are Missing';
                $result['details'] = implode(", ", $missing_fields);
            } else {

                // Set Fields in Variables
                
                $address        = sanitize($POST['address']);
                $user_id       	= sanitize($POST['user_id']);
                $name       	= $POST['name'];
                $phone_num      = $POST['phone_num'];

                // Validate Each Field

                if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name)) {
                    $result['error'] = 'Name Shouldn\'t Contain any Special Characters';
                
                } elseif(empty($phone_num) || !is_numeric($phone_num) || strlen($phone_num) < 8 || strlen($phone_num) > 15) {
                    $result['error'] = 'Invalid Phone Number';

                } elseif($con->query("SELECT ID FROM users WHERE ID = '$user_id'")->rowCount() == 0) {
                    $result['error'] = 'Invalid User ID';

                } elseif($con->query("SELECT ID FROM user_emergency_contact WHERE name = '$name' AND user_id = '$user_id'")->rowCount() > 0) {
                    $result['error'] = 'Name already Registered';

                } elseif($con->query("SELECT ID FROM user_emergency_contact WHERE address = '$address' AND user_id = '$user_id'")->rowCount() > 0) {
                    $result['error'] = 'Address already in database';

                } elseif($con->query("SELECT ID FROM user_emergency_contact WHERE phone_num = '$phone_num' AND user_id = '$user_id'")->rowCount() > 0) {
                    $result['error'] = 'Phone number already in database';

                } else {

                	// Insert Data into Database if No Errors Were Found
                    $sql = "INSERT INTO user_emergency_contact 
                                   (address, name, phone_num, user_id)
                            VALUES ('$address', '$name', '$phone_num', '$user_id');";
                    
                    $insert = $con->query($sql);
                    
                    // Check if User Inserted Successfully
                    if($insert->rowCount() > 0) {
                    
                        // If Inserted Show Success Response with User ID
                        $result['success'] = 'OK';
                        $result['contact_id'] = $con->lastInsertId();
                    }
                    else
                        $result['error'] = 'Something Went Wrong';

                }
            }

        } elseif ($action == 'edit') {

            // Required Fields That Must be Sent in The Request
            $fields = $columns;

            $post_fields = array_keys($POST);
            $missing_fields = array_diff($fields, $post_fields);

            // Check if contact_id Parameter is missing
            if(empty( $POST['contact_id'] ) || !is_numeric($POST['contact_id'])) {

                $result['error'] = 'contact_id Parameter is Missing or Invalid';


            // Check if Any Field is missing
            } elseif(!empty( $missing_fields )) {
                $result['error'] = 'Some Required Fields are Missing';
                $result['details'] = implode(", ", $missing_fields);

            } else {

                // Set Fields in Variables
				
                $id       	    = $POST['contact_id'];
				$address        = sanitize($POST['address']);
                $user_id       	= $POST['user_id'];
                $name       	= $POST['name'];
                $phone_num      = $POST['phone_num'];


				// Validate Each Field
                if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name)) {
                    $result['error'] = 'Name Shouldn\'t Contain any Special Characters';
                
                } elseif(empty($phone_num) || !is_numeric($phone_num) || strlen($phone_num) < 8 || strlen($phone_num) > 15) {
                    $result['error'] = 'Invalid Phone Number';

                } elseif($con->query("SELECT ID FROM user_emergency_contact WHERE name = '$name' AND user_id = '$user_id' AND ID != '$id'")->rowCount() > 0) {
                    $result['error'] = 'Name already Registered';

                } elseif($con->query("SELECT ID FROM user_emergency_contact WHERE address = '$address' AND user_id = '$user_id' AND ID != '$id'")->rowCount() > 0) {
                    $result['error'] = 'Address already in database';

                } elseif($con->query("SELECT ID FROM user_emergency_contact WHERE phone_num = '$phone_num' AND user_id = '$user_id'  AND ID != '$id'")->rowCount() > 0) {
                    $result['error'] = 'Phone number already in database';

                } else {
                    // Update Database Record if No Errors Were Found
                    $sql = "UPDATE user_emergency_contact 
                            
                            SET address = '$address', name = '$name', phone_num = '$phone_num'

                            WHERE ID = '$id'; ";

                    $update = $con->query($sql);
                    // Check if User Updated Successfully
                    if($update) {
                        // If Updated Show Success Response
                        $result['success'] = 'OK';
                    }
                    else
                        $result['error'] = 'Something Went Wrong';

                }
            }

        } elseif ($action == 'delete') {

            // Check if The Request Has a contact_id Parameter and It's a Numerical Value
            if(isset($POST['contact_id']) && is_numeric($POST['contact_id'])) {
                
                // Delete User From Database
                $sql = "DELETE FROM user_emergency_contact WHERE ID = ".$_POST['contact_id'];
                $delete = $con->query($sql);

                // If More Than 0 Record Was Deleted then Ok, Else Record Wasn't Found
                if($delete->rowCount() > 0) {
                    $result['success'] = 'Ok';
                } else {
                    $result['error'] = 'Record Not Found';
                }

            } else {
                $result['error'] = 'contact_id Parameter is Missing or Invalid';
            }

        } else {
            $result['error'] = 'Invalid Request for Users';
        }
    }