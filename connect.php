<?php

    $db_host = 'localhost';
    $db_name = 'covid19';
    $db_user = 'root';
    $db_pass = '';

    $dsn = 'mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8;';
    
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try {
        $con = new PDO($dsn, $db_user, $db_pass, $option);
        
    } catch (PDOException $e){
        if(isset($result) && is_array($result)) {
            $result['error'] = "Failed to Connect to Database.";
            $result = json_encode($result);
            echo $result;
        }
        else
            echo "<div class='text-danger'>Failed to Connect to Database.</div>";
            
        die();
    }