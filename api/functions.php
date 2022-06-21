<?php

    // Function to Sanitize Strings Before Insert to Database
    function sanitize($str, $html_tags_replace = 1) {
        $search  = array('\\', "'", '"');
        $replace = array('\\\\', "\'", '\"');
        $str = trim($str);
        $str = str_replace($search, $replace, $str);
        if($html_tags_remove == 1)
            $str = htmlspecialchars($str);
            
        return $str;
    }

    // Date Validation Function
    function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function settings($elm, $val = NULL) {
        $file = __DIR__."/settings.json";
        $json = file_get_contents($file);
        $arr = json_decode($json, TRUE);

        if($val !== NULL) {
            $arr[$elm] = $val;
            file_put_contents($file, json_encode($arr));
        }

        return $arr[$elm];
    }

    // function roles() {
        
    // }