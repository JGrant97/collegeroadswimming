<?php
session_start();
require 'dbconnect.inc.php';

//Race Times
if (isset($_POST['race-time-submit'])) {
    $Time = $_POST['time'];
    $Date = $_POST['date'];
    $USERID = $_POST['userid'];

    if (empty($Time) || empty($Date)) {
        header("Location: ../squad.php.php?error=emptyfields&time=".$Time."&date=".$Date);
        exit();
    } elseif ($Date > date("Y-m-d")) {
        header("Location: ../squad.php?error=invaliddate");
        exit();
    } else {
        $valsql = "SELECT USERID FROM USERS WHERE USERID= ? AND TRAINERID = ?";
        $valstmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($valstmt, $valsql)) {
            header("Location: ../squad.php?error=sqlerror01");
            exit();
        } else {
            //checks if userid entered is real
            mysqli_stmt_bind_param($valstmt, "ss", $USERID, $_SESSION['userid']);
            mysqli_stmt_execute($valstmt);
            mysqli_stmt_store_result($valstmt);
            $resultCheck = mysqli_stmt_num_rows($valstmt);
            if ($resultCheck <= 0) {
                header("Location: ../squad.php?error=userNotFoundORinsquad");
                exit();
            } else {
                $sql = "INSERT INTO RACETIMES (USERID, LAPDATE, LAPTIME) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($con);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../squad.php.php?error=sqlerror02");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "sss", $USERID, $Date, $Time);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../squad.php?timeUpload=success");
                    exit();
                }
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}

//add squad memebers
if (isset($_POST['add-team-member'])) {
    $USERID = $_POST['id'];
    $CoachID = $_SESSION['userid'];


    $sql = "UPDATE USERS SET TRAINERID = ? WHERE USERID = ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../squad.php?error=sqlerror02");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $CoachID, $USERID);
        mysqli_stmt_execute($stmt);
        header("Location: ../squad.php?squadRemove=success");
        exit();
    }
}

//remove squad memebers
if (isset($_POST['remove-team-member'])) {
    $USERID = $_POST['id'];

    $sql = "UPDATE USERS SET TRAINERID = NULL WHERE USERID = ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../squad.php?error=sqlerror02");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $USERID);
        mysqli_stmt_execute($stmt);
        header("Location: ../squad.php?squadRemove=success");
        exit();
    }
}

//admin remove user
elseif (isset($_POST['delete-submit'])) {
    require 'dbconnect.inc.php';

    $id = $_POST['id'];
    $userid = $_POST['userid'];

    $sql = "DELETE FROM trainingtimes WHERE USERID = ?";
    $sql2 = "DELETE FROM racetimes WHERE USERID = ?";
    $sql3 = "DELETE FROM users WHERE USERID = ? OR PARENTID = ?";

    $stmt = mysqli_stmt_init($con);
    $stmt2 = mysqli_stmt_init($con);
    $stmt3 = mysqli_stmt_init($con);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../members.php?error=sqlerror06");
        exit();
    }
    if (!mysqli_stmt_prepare($stmt2, $sql2)) {
        header("Location: ../members.php?error=sqlerror07");
        exit();
    }
    if (!mysqli_stmt_prepare($stmt3, $sql3)) {
        header("Location: ../members.php?error=sqlerror08");
        exit();
    }
    if ($id !== $_SESSION['userid']) {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_param($stmt2, "s", $id);
        mysqli_stmt_execute($stmt2);

        mysqli_stmt_bind_param($stmt3, "ss", $id, $id);
        mysqli_stmt_execute($stmt3);
        header("Location: ../members.php?delete=success");
        exit();
    }


    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt2);
    mysqli_stmt_close($stmt3);
    mysqli_close($con);
}
