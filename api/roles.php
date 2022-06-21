<?php

    include_once "connect.php";

    // Each Constant Has Array of Roles Numbers for User Roles who has the Privilege

    define("FETCH_USERS", array(1));
    define("ADD_USERS", array(1));
    define("UPDATE_USERS", array(1));
    define("FETCH_OWN_DATA", array(1, 4));
    define("UPDATE_OWN_DATA", array(1, 4));