<?php

if (isset($_SESSION['userid']) || $title == "Home" || $title == "Register" || $title == "About") {

    $time = $_SERVER['REQUEST_TIME']; 
    //in seconds
    $timeout_duration = 600;

    if (isset($_SESSION['LAST_ACTIVITY']) &&
        ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration  && isset($_SESSION['userid'])) {
        session_unset();
        session_destroy();
        session_start();
        
        header("Location: ../collegeroadswimming/index.php?error=sessionExpired");
        exit();
    }

    $_SESSION['LAST_ACTIVITY'] = $time;
    
} else {
    header("Location: ../collegeroadswimming/index.php?error=notLoggedin");
    exit();
}
