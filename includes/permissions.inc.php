<?php

if ($title == "Register Child" && $_SESSION['accountType'] == "Child"
|| $title =="Update Account" &&  $_SESSION['accountType'] == "Child"
|| $title =="Squad" &&  $_SESSION['accountType'] == "Parent"
|| $title =="Squad" &&  $_SESSION['accountType'] == "Swimmer"
|| $title =="Squad" &&  $_SESSION['accountType'] == "Child"
|| $title =="Edit Training Times" &&  $_SESSION['accountType'] == "Child"
|| $title =="Edit Training Times" &&  $_SESSION['accountType'] == "Parent"
|| $title =="Edit Training Times" &&  $_SESSION['accountType'] == "Swimmer"
|| $title =="Edit Race Times" &&  $_SESSION['accountType'] == "Child"
|| $title =="Edit Race Times" &&  $_SESSION['accountType'] == "Parent"
|| $title =="Edit Race Times" &&  $_SESSION['accountType'] == "Swimmer") {
    header("Location: ../collegeroadswimming/index.php?error=notAuthorised");
    exit();
} else {
     //do nothing
 }
