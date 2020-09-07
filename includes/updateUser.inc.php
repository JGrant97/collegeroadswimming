<?php
if (isset($_POST['signup-submit'])) {
    require 'dbconnect.inc.php';

    $id = $_POST['id'];
    $username = $_POST['username'];
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $address = $_POST['street'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password-repeat'];
    $Dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $accountType = $_POST['accountType'];

    $dateObj=new DateTime($_POST['dob']);
    $ageLimit=new DateTime('-18 years');

    if ($accountType == "Child") {
        if ($dateObj < $ageLimit) {
            header("Location: ../updateUser.php?error=tooOld");
            exit();
        }
    } elseif ($accountType == "Swimmer" || $accountType == "Coach" || $accountType == "Parent" || $accountType == "Admin") {
        if ($dateObj > $ageLimit) {
            header("Location: ../updateUser.php?error=tooYoung");
            exit();
        }
    }


    if (empty($firstname) || empty($lastname)  || empty($postcode) || empty($city) || empty($address) || empty($Dob) || empty($mobile) || empty($accountType) || empty($country)
  || empty($username)) {
        header("Location: ../updateUser.php?error=emptyfields&fname=".$firstname."&lname=".$lastname."&postcode=".$postcode.
    "&city=".$city."&street=".$address."&Dob=".$Dob."&mobile=".$mobile. "&accountType=" .$accountType. "&country=" .$country);
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $firstname) && !preg_match("/^[a-zA-Z]*$/", $lastname) && !preg_match("/^[a-zA-Z]*$/", $city)) {
        header("Location: ../updateUser.php?error=invalidmailfnamelnamecity&street=".$address);
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
        header("Location: ../updateUser.php?error=invalidfname&lname=".$lastname."&postcode=".$postcode.
    "&City=".$city."&address=".$address);
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
        header("Location: ../updateUser.php?error=invalidlnamee&fname=".$firstname."&postcode=".$postcode.
    "&city=".$city."&street=".$address);
        exit();
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $city)) {
        header("Location: ../updateUser.php?error=invalidcity&fname=".$firstname."&lname=".$lastname."&postcode=".$postcode."&street=".$address);
        exit();
    } elseif ($password !== $passwordRepeat) {
        header("Location: ../updateUser.php?error=passwordcheck&fname=".$firstname."&lname=".$lastname."&postcode=".$postcode."&street=".$address);
        exit();
    } elseif (strlen($username) > 50 || strlen($firstname) > 50 || strlen($lastname) > 50 || strlen($email) > 50
  || strlen($address) > 50 || strlen($city) > 50 || strlen($postcode) > 8 || strlen($country) > 50) {
        header("Location: ../updateUser.php?error=characterstoolong");
        exit();
    } elseif (is_integer($mobile)) {
        header("Location: ../updateUser.php?error=wrongdatatype");
        exit();
    } else {
        if (is_null($password)) {
            //inputs data entered from the register page into the database
            $sql = "UPDATE users SET USERNAME = ?, FNAME = ?, LNAME = ?, DOB = ?, MOBILE = ?, STREET = ?, CITY = ?,
      POSTCODE = ?,  COUNTRY = ?, ACCOUNTTYPE =? WHERE UserID = ?";

            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../updateUser.php?error=sqlerror021");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "sssssssssss", $username, $firstname, $lastname, $Dob, $mobile, $address, $city, $postcode, $country, $accountType, $id);
                mysqli_stmt_execute($stmt);
                header("Location: ../myprofile.php?update=success");
                exit();
            }
        } elseif ($password == $passwordRepeat) {
            //inputs data entered from the register page into the database
            $sql = "UPDATE users SET USERNAME = ?, FNAME = ?, LNAME = ?, DOB = ?, MOBILE = ?, STREET = ?, CITY = ?,
      POSTCODE = ?,  COUNTRY = ?, PASSWORD = ?, ACCOUNTTYPE =? WHERE USERID = ?";

            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../updateUser.php?error=sqlerror022");
                exit();
            } else {
                //Uses BCrypt to hash users password
                $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "ssssssssssss", $username, $firstname, $lastname, $Dob, $mobile, $address, $city, $postcode, $country, $hashedpassword, $accountType, $id);
                mysqli_stmt_execute($stmt);
                header("Location: ../myprofile.php?update=success");
                exit();
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
} elseif (isset($_POST['delete-submit'])) {
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
        header("Location: ../updateUser.php?error=sqlerror06");
        exit();
    }
    if (!mysqli_stmt_prepare($stmt2, $sql2)) {
        header("Location: ../updateUser.php?error=sqlerror07");
        exit();
    }
    if (!mysqli_stmt_prepare($stmt3, $sql3)) {
        header("Location: ../updateUser.php?error=sqlerror08");
        exit();
    }
    if ($userid === $id) {
        mysqli_stmt_bind_param($stmt1, "s", $id);
        mysqli_stmt_execute($stmt1);

        mysqli_stmt_bind_param($stmt2, "s", $id);
        mysqli_stmt_execute($stmt2);

        mysqli_stmt_bind_param($stmt3, "ss", $id, $id);
        mysqli_stmt_execute($stmt3);

        session_start();

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header("Location: ../index.php?delete=success");

        exit();
    } elseif ($id !== $_SESSION['userid']) {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_param($stmt2, "s", $id);
        mysqli_stmt_execute($stmt2);

        mysqli_stmt_bind_param($stmt3, "ss", $id, $id);
        mysqli_stmt_execute($stmt3);
        header("Location: ../myprofile.php?delete=success");
        exit();
    }


    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt2);
    mysqli_stmt_close($stmt3);
    mysqli_close($con);
}
