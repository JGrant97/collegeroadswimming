<?php
session_start();
require 'dbconnect.inc.php';

//training times
if (isset($_POST['training-time-submit'])) {
    $Time = $_POST['time'];
    $Date = $_POST['date'];
    $USERID = $_SESSION['userid'];
    $date_now = new DateTime();

    if (empty($Time) || empty($Date)) {
        header("Location: ../weeklyTrainingTimes.php?error=emptyfields&time=".$Time."&date=".$Date);
        exit();
    } elseif ($Date > date("Y-m-d")) {
        header("Location: ../weeklyTrainingTimes.php?error=invaliddate");
        exit();
    } else {
        $sql = "INSERT INTO TRAININGTIMES (USERID, LAPDATE, LAPTIME) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../weeklyTrainingTimes.php?error=sqlerror02");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $USERID, $Date, $Time);
            mysqli_stmt_execute($stmt);
            header("Location: ../weeklyTrainingTimes.php?timeUpload=success");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}

//edit training time
elseif (isset($_POST['edit-day-submit'])) {
    $Time = $_POST['time'];
    $Date = $_POST['date'];
    $USERID = $_SESSION['userid'];
    $id = $_POST['id'];


    if (empty($Time) || empty($Date)) {
        header("Location: ../editWeeklyTrainingTimes.php?error=emptyfields&time=".$Time."&date=".$Date);
        exit();
    } elseif ($Date > date("Y-m-d")) {
        header("Location: ../editWeeklyTrainingTimes.php?error=invaliddate");
        exit();
    } else {
        $sql = "UPDATE trainingtimes SET LAPTIME = ?, LAPDATE = ? WHERE UserID = ? AND TRAININGTIMEID = ?";

        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../editWeeklyTrainingTimes.php?error=sqlerror021");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ssss", $Time, $Date, $USERID, $id);
            mysqli_stmt_execute($stmt);
            header("Location: ../weeklyTrainingTimes.php?update=success");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}

//edit race time
elseif (isset($_POST['edit-race-submit'])) {
    $Time = $_POST['time'];
    $Date = $_POST['date'];
    $USERID = $_SESSION['userid'];
    $id = $_POST['id'];


    if (empty($Time) || empty($Date)) {
        header("Location: ../squad.php?error=emptyfields&time=".$Time."&date=".$Date);
        exit();
    } elseif ($Date > date("Y-m-d")) {
        header("Location: ../squad.php?error=invaliddate");
        exit();
    } else {
        $sql = "UPDATE racetimes SET LAPTIME = ?, LAPDATE = ? WHERE RACETIMEID = ?";

        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../members.php?error=sqlerror021");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $Time, $Date, $id);
            mysqli_stmt_execute($stmt);
            header("Location: ../members.php?update=success");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
