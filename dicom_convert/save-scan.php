<?php

    $types = array("jpg", "jpeg", "png");

    if(!empty($_POST['imgBase64']) && is_array($_POST['imgBase64']) && !empty($_POST['img_type']) && in_array($_POST['img_type'], $types)) {
        foreach($_POST['imgBase64'] as $img) {
            $type = $_POST['img_type'];
            $img = str_replace('data:image/'.$type.';base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            //saving
            $fileName = (!empty($_POST['filename'])) ? $_POST['filename'].'.'.$type : uniqid().".".$type;
            if(file_put_contents("../uploads/ct_scans/".$fileName, $fileData)) {
                echo 'ok';
            }
        }
    }

    // if(!empty($_POST['imgBase64']) && !empty($_POST['type']) && in_array($_POST['type'], $types) && !empty($_POST['filename'])) {
    //     $img = $_POST['imgBase64'];
    //     $type = $_POST['type'];
    //     $img = str_replace('data:image/'.$type.';base64,', '', $img);
    //     $img = str_replace(' ', '+', $img);
    //     $fileData = base64_decode($img);
    //     //saving
    //     $fileName = $_POST['filename'].'.'.$type;
    //     file_put_contents($fileName, $fileData);
    // } 
