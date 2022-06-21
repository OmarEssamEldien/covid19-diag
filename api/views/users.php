<?php

    // Users
    // Table Columns
    $columns = array('username', 'gender', 'dob', 'job', 'address', 'email', 'phone_num', 'password', 'governorate',
                        'social_status', 'ssn', 'no_of_kids', 'coordinates', 'role_id', 'vaccination_type', 'img');
                        
    $required_columns = array('username', 'gender', 'dob', 'email', 'governorate', 'phone_num', 'password', 'ssn', 'role_id');

    $all_governorates = file_get_contents(__DIR__."/../../json/governorates.json");

    $all_governorates = json_decode($all_governorates, TRUE);
                        
    // Set POST Request Params in array
    $POST = $_POST;

    // Check if Parameter Action is Sent in Request
    if(!isset($POST['action'])) {
        $result['error'] = 'Action Parameter is Missing';
    } else {
        $action = $POST['action'];
        // Check Required Action
        if($action == 'login') {

            // Check if Email or Password are Missing
            if(!isset($POST['email']) || !isset($POST['password'])) {
                $result['error'] = 'Email or Password are missing';
            } else {
                
                $email = sanitize($POST['email']);
                $password = $POST['password'];

                // Fetch Data From Database
                $sql = "SELECT users.ID, password , role_id, user_roles.role FROM users 
                        INNER JOIN user_roles ON user_roles.ID = users.role_id 
                        WHERE email = '$email'";

                $data = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                
                // Check if there's any record matching the query
                if(count($data) > 0) {

                    // Verify Password
                    if( password_verify($password, $data[0]['password']) ) {

                        $user_id  = $data[0]['ID'];

                        while(empty($token) || $con->query("SELECT token FROM users WHERE token = '$token'")->rowCount() > 0) {
                            $token = md5(base64_encode(sha1(uniqid(time()))));
                        }
                        $time = time() + 60 * 60; // Hour
                        $sql = "UPDATE users SET token = '$token', token_expire = '$time' WHERE ID = '$user_id'";
                        $update = $con->query($sql);

                        $result['success']  = 'Ok';
                        $result['token']    = $token;
                        $result['user_id']  = $data[0]['ID'];
                        $result['role_id']  = $data[0]['role_id'];
                        $result['user_role'] = $data[0]['role'];

                    } else {
                        $result['error'] = 'Wrong Email or Password';
                    }

                } else {
                    $result['error'] = 'Wrong Email or Password';
                }
            }

        } elseif($action == 'check_login') {

            // Check if Email or Password are Missing
            if(!isset($POST['token']) || !isset($POST['user_id'])) {
                $result['error'] = 'token or user_id is missing';
            } else {
                
                $token = sanitize($POST['token']);
                $user_id = sanitize($POST['user_id']);

                // Fetch Data From Database
                $sql = "SELECT users.ID, users.username, role_id, user_roles.role FROM users 
                        INNER JOIN user_roles ON user_roles.ID = users.role_id 
                        WHERE token = '$token' AND users.ID = '$user_id'";

                $data = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                
                // Check if there's any record matching the query
                if(count($data) > 0) {

                    // Check token not Expired
                    if( $data[0]['token_expire'] <= time() ) {

                        $user_id  = $data[0]['ID'];
                        $time = time() + 60 * 60; // Hour
                        $sql = "UPDATE users SET token_expire = '$time' WHERE ID = '$user_id'";
                        $update = $con->query($sql);

                        $result['success']  = 'Ok';
                        $result['token']    = $token;
                        $result['user_id']  = $data[0]['ID'];
                        $result['username']  = $data[0]['username'];
                        $result['role_id']  = $data[0]['role_id'];
                        $result['user_role'] = $data[0]['role'];

                    } else {
                        $result['error'] = 'Session Expired';
                    }

                } else {
                    $result['error'] = 'Invalid token or user_id';
                }
            }

        } elseif($action == 'fetch') {

            // if(!empty($_USER) && $_USER['role_id'] == 1) {
            //     $result['error'] = 'Access Denied';
            // }
            // Check if Request looking for any Specific Rows
            $where = '';
            if(isset($POST['user_id']) && is_numeric($POST['user_id'])) {
                $where .= " AND users.ID = ".$POST['user_id'];
            }
            if(isset($POST['role_id']) && is_numeric($POST['role_id'])) {
                $where .= " AND users.role_id = ".$POST['role_id'];
            }
            if(isset($POST['gender']) && ($POST['gender'] == 'F' || $POST['gender'] == 'M')) {
                $where .= " AND users.gender = '".$POST['gender']."'";
            }
            if(isset($POST['governorate'])) {
                $where .= " AND users.governorate = '".sanitize($POST['governorate'])."'";
            }
            if(isset($POST['ssn']) && is_numeric($POST['ssn'])) {
                $ssn = $POST['ssn'];
                $where .= " AND users.ssn LIKE '$ssn%'";
            }
            if(isset($POST['query'])) {
                $keyword = sanitize($POST['query']);
                $where .= " AND ( users.username LIKE '%$keyword%' OR users.email LIKE '%$keyword%' OR users.email LIKE '%$keyword%'
                                 OR users.ssn LIKE '%$keyword%' OR users.job LIKE '%$keyword%' OR users.address LIKE '%$keyword%' 
                                 OR users.social_status LIKE '%$keyword%')";
            }

            // Fetch Data to Result array
            $cols = $columns;
            // Remove Password Column For Security Reasons
            if (($key = array_search('password', $cols)) !== false) {
                unset($cols[$key]);
            }
            $cols = "ID, ".implode(", ", $cols);

            // Fetch Data From Database
            $sql = "SELECT $cols, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age FROM users WHERE 1 $where";
            $result['data'] = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $http = (@$_SERVER['HTTPS'] == "on") ? 'https' : 'http';
            $link = pathinfo("$http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]")['dirname']."/";
            $uploads_base_url = explode("/api/", $link)[0]."/uploads/users/";
            foreach($result['data'] as $k => $row) {
                $result['data'][$k]['img'] = ($result['data'][$k]['img'] != '') ? $uploads_base_url.$result['data'][$k]['img'] : '';
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
            $required_columns = array('username', 'gender', 'email', 'phone_num', 'password', 'ssn', 'role_id');

            $post_fields = array_keys($POST);
            $missing_fields = array_diff($fields, $post_fields);

            // Check if Any Field is missing
            if(!empty( $missing_fields )) {
                $result['error'] = 'Some Required Fields are Missing';
                $result['details'] = implode(", ", $missing_fields);
            } else {

                // Set Fields in Variables
                $username       = $POST['username'];
                $gender         = $POST['gender'];
                $email          = $POST['email'];
                $phone_num      = $POST['phone_num'];
                $password       = $POST['password'];
                $ssn            = $POST['ssn'];
                $role_id        = $POST['role_id'];
                $governorate    = $_POST['governorate'];

                // Not Required Fields
                $dob            = !empty($POST['dob']) ? $POST['dob'] : '';
                $job            = !empty($POST['job']) ? sanitize($POST['job']) : '';
                $address        = !empty($POST['address']) ? sanitize($POST['address']) : '';
                $social_status  = !empty($POST['social_status']) ? sanitize($POST['social_status']) : '';
                $no_of_kids     = !empty($POST['no_of_kids']) ? $POST['no_of_kids'] : '';
                $coordinates    = !empty($POST['coordinates']) ? $POST['coordinates'] : '';
                $vaccine        = !empty($POST['vaccination_type']) ? sanitize($POST['vaccination_type']) : '';

                // Validate Each Field
                if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) {
                    $result['error'] = 'Username Shouldn\'t Contain any Special Characters';

                } elseif(strlen($username) < 3 || strlen($username) > 30) {
                    $result['error'] = 'Username Should be Between 3 ~ 30 Characters at Least';

                } elseif (!filter_var ($email, FILTER_SANITIZE_EMAIL) || strpos($email, '@') === FALSE) {
                    $result['error'] = 'Email is Invalid';

                } elseif(strlen($email) < 6 || strlen($email) > 100) {
                    $result['error'] = 'Email Should be Between 6 ~ 100 Characters at Least';

                } elseif (preg_match('/[^a-zA-Z\d@0-9_\-.]/', $email)) {
                    $result['error'] = 'Email Shouldn\'t Contain any Special Characters';

                } elseif(strlen($password) < 6) {
                    $result['error'] = 'Password Should Contain 6 Characters at Least';

                } elseif(empty($phone_num) || !is_numeric($phone_num) || strlen($phone_num) < 8 || strlen($phone_num) > 15) {
                    $result['error'] = 'Invalid Phone Number';

                } elseif($con->query("SELECT ID FROM users WHERE username = '$username'")->rowCount() > 0) {
                    $result['error'] = 'Username already Registered';

                } elseif($con->query("SELECT ID FROM users WHERE email = '$email'")->rowCount() > 0) {
                    $result['error'] = 'Email already Registered';

                } elseif($con->query("SELECT ID FROM users WHERE ssn = '$ssn'")->rowCount() > 0) {
                    $result['error'] = 'SSN already Registered';

                } elseif(!in_array($governorate, $all_governorates)) {
                    $result['error'] = "Invalid Governorate '$governorate'";
                    $result['governorates'] = $all_governorates;

                } elseif(!empty($dob) && !validateDate($dob) || (time()-strtotime($dob))/(3600*24*365.25) > 120 || (time()-strtotime($dob))/(3600*24*365.25) <= 0 ) {
                    $result['error'] = 'Invalid Date of Birth';

                } elseif($gender != 'F' && $gender != 'M') {
                    $result['error'] = 'Invalid Gender (F, M)';

                } elseif(empty($ssn) || !is_numeric($ssn) || strlen($ssn) != 14) {
                    $result['error'] = 'Invalid SSN Number';

                } elseif(!empty($no_of_kids) && (!is_numeric($no_of_kids) || $no_of_kids < 0)) {
                    $result['error'] = 'Invalid Number of Kids';

                } elseif(!empty($coordinates) && count(explode(",", $coordinates)) != 2) {
                    $result['error'] = 'Invalid Coordinates, Should Contain 2 Numbers Separated by coma ","';

                } elseif(empty($role_id) || !is_numeric($role_id) || $con->query("SELECT role FROM user_roles WHERE ID = '$role_id'")->rowCount() == 0) {
                    $result['error'] = 'Invalid role_id';

                } else {

                    $img = '';
                    if(isset($_FILES['img'])) {
                        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                        $ext = strtolower($ext);
                        if(in_array($ext, array("jpg", "jpeg", "png"))) {
                            $filename = uniqid(time()).".$ext";
                            $location = __DIR__."/../../uploads/users/$filename";
                            if(move_uploaded_file($_FILES['img']['tmp_name'], $location)) {
                                $img = $filename;
                            } else {
                                $result['error'] = 'Failed to upload User Picture';
                            }
                        } else {
                            $result['error'] = 'Invalid Type for User Picture.'.$ext;
                        }
                    }

                    // Hash Password
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    // Check non Required cols
                    $dob = ($dob == '') ? "NULL" : "'$dob'";
                    $no_of_kids = ($no_of_kids == '') ? 0 : $no_of_kids;

                    // Insert Data into Database if No Errors Were Found
                    $sql = "INSERT INTO users 
                                   (username, gender, dob, job, address, governorate, email, phone_num, password, social_status, 
                                   ssn, no_of_kids, coordinates, role_id, vaccination_type, img)
                            VALUES ('$username', '$gender', $dob, '$job', '$address', '$governorate', '$email', '$phone_num', '$password', '$social_status',
                                    '$ssn', $no_of_kids, '$coordinates', '$role_id', '$vaccine', '$img');";
                    
                        
                    $insert = $con->query($sql);
                    // Check if User Inserted Successfully
                    if($insert->rowCount() > 0) {
                        // If Inserted Show Success Response with User ID
                        $result['success'] = 'OK';
                        $result['user_id'] = $con->lastInsertId();
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

            // Check if user_id Parameter is missing
            if(empty( $POST['user_id'] ) || !is_numeric($POST['user_id'])) {

                $result['error'] = 'user_id Parameter is Missing or Invalid';

            // Check if No Fields is sent to update
            } elseif(count( $missing_fields ) == count( $fields )) {
                $result['error'] = 'Nothing to Update';
                $result['details'] = "Send Some Parameters to update: ".implode(", ", $missing_fields);

            } else {

                $user_id        = $POST['user_id'];

                $fields_to_update = array_intersect($post_fields, $fields);
                $i = 0;
                $sql = "UPDATE users SET ";
                foreach($fields_to_update as $key=>$field)  {
                    if($i++ != 0) {
                        $sql .= ", ";
                    }
                    $sql .= $field." = :".$field;
                }
                $sql .= " WHERE ID = $user_id";

                $update = $con->prepare($sql);
                foreach($fields_to_update as $field) {

                    // Set Fields in Variables
                    $value = $POST[$field];

                    // Validate Field
                    if($field == 'username') {

                        $username = $POST['username'];
                        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) {
                            $result['error'] = 'Username Shouldn\'t Contain any Special Characters';
        
                        } elseif(strlen($username) < 3 || strlen($username) > 30) {
                            $result['error'] = 'Username Should be Between 3 ~ 30 Characters at Least';
        
                        } elseif($con->query("SELECT ID FROM users WHERE username = '$username' AND ID != '$user_id'")->rowCount() > 0) {
                            $result['error'] = 'Username already Registered';
                        }

                    } elseif ($field == 'email') {

                        $email = $POST['email'];
                        if (!filter_var ($email, FILTER_SANITIZE_EMAIL) || strpos($email, '@') === FALSE) {
                            $result['error'] = 'Email is Invalid';
        
                        } elseif(strlen($email) < 6 || strlen($email) > 100) {
                                           $result['error'] = 'Email Should be Between 6 ~ 100 Characters at Least';
                       
                        } elseif (preg_match('/[^a-zA-Z\d@0-9_\-.]/', $email)) {
                            $result['error'] = 'Email Shouldn\'t Contain any Special Characters';
        
                        } elseif($con->query("SELECT ID FROM users WHERE email = '$email' AND ID != '$user_id'")->rowCount() > 0) {
                            $result['error'] = 'Email already Registered';
        
                        }

                    } elseif ($field == 'password') {

                        // Hash Password
                        $password = $POST['password'];
                        if(strlen($password) > 0 && strlen($password) < 6) {
                            $result['error'] = 'Password Should Contain 6 Characters at Least';
                        }

                        $value = password_hash($password, PASSWORD_DEFAULT);

                    } elseif ($field == 'phone_num') {
                        $phone_num = $POST['phone_num'];
                        if(empty($phone_num) || !is_numeric($phone_num) || strlen($phone_num) < 8 || strlen($phone_num) > 15) {
                            $result['error'] = 'Invalid Phone Number';
        
                        }
                    } elseif ($field == 'ssn') {
                        $ssn = $POST['ssn'];
                        if(empty($ssn) || !is_numeric($ssn) || strlen($ssn) != 14) {
                            $result['error'] = 'Invalid SSN Number';
        
                        } elseif($con->query("SELECT ID FROM users WHERE ssn = '$ssn' AND ID != '$user_id'")->rowCount() > 0) {
                            $result['error'] = 'SSN already Registered';
                        }
                    } elseif ($field == 'dob') {
                        $dob = $POST['dob'];
                        if(!validateDate($dob) || (time()-strtotime($dob))/(3600*24*365.25) > 120 || (time()-strtotime($dob))/(3600*24*365.25) <= 0 ) {
                            $result['error'] = 'Invalid Date of Birth';
        
                        }
                    } elseif ($field == 'gender') {
                        $gender = $POST['gender'];
                        if($gender != 'F' && $gender != 'M') {
                            $result['error'] = 'Invalid Gender (F, M)';
        
                        }
                    } elseif ($field == 'no_of_kids') {
                        $no_of_kids = $POST['no_of_kids'];
                        if(!is_numeric($no_of_kids) || $no_of_kids < 0) {
                            $result['error'] = 'Invalid Number of Kids';
        
                        }
                    } elseif ($field == 'coordinates') {
                        $coordinates = $POST['coordinates'];
                        if(empty($coordinates) || count(explode(",", $coordinates)) != 2) {
                            $result['error'] = 'Invalid Coordinates, Should Contain 2 Numbers Separated by coma ","';
        
                        }
                    } elseif($field == 'role_id') {
                        $role_id = $POST['role_id'];
                        if(empty($role_id) || !is_numeric($role_id) || $con->query("SELECT role FROM user_roles WHERE ID = '$role_id'")->rowCount() == 0) {
                            $result['error'] = 'Invalid role_id';
        
                        }
                    } elseif($field == 'governorate') {
                        $governorate = $POST['governorate'];
                        if(!in_array($governorate, $all_governorates)) {
                            $result['error'] = 'Invalid Governorate';
                        } 
                    } else {
                        $value = sanitize($value);
                    }

                    if(!empty($result['error'])) {
                        break;
                    }

                    $update->bindValue($field, $value);
                }
                
                $img = '';
                if(isset($_FILES['img'])) {
                    $ext = pathinfo($_FILES['img']['name'][$i], PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if(in_array($ext, array("jpg", "jpeg", "png"))) {
                        $filename = time().".$ext";
                        $location = __DIR__."/../../uploads/users/$filename";
                        if(!move_uploaded_file($_FILES['img']['tmp_name'], $location)) {
                            $result['error'] = 'Failed to upload User Picture';
                            $img = $filename;
                            $update->bindValue('img', $img);
                        }
                    } else {
                        $result['error'] = 'Invalid Type for User Picture';
                    }
                }

                if(empty($result['error'])) {
                    $update->execute();

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

            // Check if The Request Has a user_id Parameter and It's a Numerical Value
            if(isset($POST['user_id']) && is_numeric($POST['user_id'])) {
                
                // Delete User From Database
                $sql = "DELETE FROM users WHERE ID = ".$_POST['user_id'];
                $delete = $con->query($sql);

                // If More Than 0 Record Was Deleted then Ok, Else Record Wasn't Found
                if($delete->rowCount() > 0) {
                    $result['success'] = 'Ok';
                } else {
                    $result['error'] = 'Record Not Found';
                }

            } else {
                $result['error'] = 'user_id Parameter is Missing or Invalid';
            }

        } else {
            $result['error'] = 'Invalid Request for Users';
        }
    }