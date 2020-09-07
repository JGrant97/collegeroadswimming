<?php
if (isset($_POST['login-submit'])) {
    session_start();

    require 'dbconnect.inc.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['fname'] = $firstname;
    $_SESSION['lname'] = $lastname;


    //checks if both fields contain information
    if (empty($email) || empty($password)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM USERS WHERE EMAIL= ?;";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror03");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $passwordcheck = password_verify($password, $row['PASSWORD']);
                if ($passwordcheck == false) {
                    session_unset();
                    session_destroy();
                    header("Location: ../index.php?error=wrongpasswordoremail");
                    exit();
                } elseif ($passwordcheck == true) {
                    $_SESSION['userid'] =  $row['USERID'];
                    $_SESSION['fname'] =  $row['FNAME'];
                    $_SESSION['fname'] = $row['LNAME'];
                    $_SESSION['accountType'] = $row['ACCOUNTTYPE'];

                    header("Location: ../index.php?login=success");
                    exit();
                }
            } else {
                header("Location: ../index.php?error=nouser");
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
