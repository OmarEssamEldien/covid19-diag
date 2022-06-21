<?php

    // Allow Access for Testing 
    header('Access-Control-Allow-Origin: *');

    // Turn Of Error Reporting
    error_reporting(0);

    // Set Timezone To Egypt (Cairo) Time
    date_default_timezone_set("Africa/Cairo");

    // Set Header Content Type as Json
    header("Content-type: application/json; charset=utf8");

    // Get Request From URI to Retrieve Required Data
    $request_uri = $_SERVER['REQUEST_URI'];
    $request_uri = explode("/", $request_uri);
    $request = @$request_uri[count($request_uri)-1];
    $request = explode("?", $request)[0];

    // Scan Directory of Views and Set names of Requests to an array called $views
    $views = scandir("views");
    $views = array_diff($views, array(".", ".."));
    $views = array_values($views);
    for($i = 0; $i < count($views); $i++) {
        $views[$i] = str_replace(".php", "", $views[$i]);
    }

    // Initialize result array to convert as JSON at the end of the request
    $result = array();

    if(isset($_POST['api_section'])) {
        $request = $_POST['api_section'];
    }

    // Check if Requested View in $views array
    if(in_array($request, $views)) {
        // Include Connect File to Connect to Database
        include "connect.php";
        // Include Functions File to be Used in Views
        include "functions.php";

        try {

            // Update Token Expire Time if was sent
            if ( !empty (getallheaders()['token']) ) {
                
                $token = sanitize(getallheaders()['token']);
                $_USER = @$con->query("SELECT users.ID, token, token_expire, password , role_id, user_roles.role FROM users 
                                        INNER JOIN user_roles ON user_roles.ID = users.role_id 
                                        WHERE token = '$token'")->fetchAll()[0];

                if(empty($_USER)) {
                    $result['error'] = "Invalid Access Token";
                } elseif ($_USER['token_expire'] < time()) {
                    $result['error'] = "Access Token Expired";
                    $result['login_required'] = true;
                } else {

                    $result['token']    = $_USER['token'];
                    $result['user_id']  = $_USER['ID'];
                    $result['role_id']  = $_USER['role_id'];
                    $result['user_role'] = $_USER['role'];

                    $time = time() + 60 * 60; // Hour
                    $sql = "UPDATE users SET token_expire = '$time' WHERE token = '$token'";
                    $update = $con->query($sql);
                }
            }
            
            if(empty($result['error'])) {
                // Include Required View
                include "./views/$request.php";
            }


        } catch(\Throwable $e) {
            $sql = (isset($sql)) ? $sql : '';
            // If Error Happened Log it in Errors File
            $sql = preg_replace('/\s+/', ' ', $sql);
            $error = "Error: ".$e->getMessage()."\r\n"
                    ."File: ".$e->getFile()."\r\n"
                    ."Line: ".$e->getLine()."\r\n"
                    ."SQL: ".$sql."\r\n"
                    ."Date: ".date("Y-m-d H:i:s")."\r\n"
                    ."==================================\r\n";

            file_put_contents("errors.txt", $error, FILE_APPEND);

            $result['error'] = 'Something Went Wrong - Contact Backend Developer';
        }

        $result['success'] = (isset($result['success'])) ? true : false;

    } else {

        $result['sections'] = $views;

        $result['error'] = 'Invalid Request';
    }

    // Convert $result array to JSON and Print It
    $result = json_encode($result, JSON_NUMERIC_CHECK);
    echo $result;

    // Copyright © 2022 To Omar Essam - CSI.EDU.EG //