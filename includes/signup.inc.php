<?php
if (isset($_POST['signup-submit'])) {
    require 'dbconnect.inc.php';

    $username = $_POST['username'];
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $address = $_POST['street'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password-repeat'];
    $Dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $accountType = $_POST['accountType'];

    $dateObj=new DateTime($_POST['dob']);
    $ageLimit=new DateTime('-18 years');

    if ($accountType == "Swimmer" || $accountType == "Coach" || $accountType == "Parent") {
        if ($dateObj > $ageLimit) {
            header("Location: ../register.php?error=tooYoung");
            exit();
        }
    }

    if (empty($firstname) || empty($lastname)  || empty($postcode) || empty($city) || empty($address) || empty($email) || empty($password) || empty($passwordRepeat) || empty($Dob) || empty($mobile) || empty($accountType) || empty($country)
  || empty($username)) {
        header("Location: ../register.php?error=emptyfields&fname=".$firstname."&lname=".$lastname."&postcode=".$postcode.
    "&city=".$city."&street=".$address."&email=".$email."&Dob=".$Dob."&mobile=".$mobile. "&accountType=" .$accountType. "&country=" .$country);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $firstname) && !preg_match("/^[a-zA-Z]*$/", $lastname) && !preg_match("/^[a-zA-Z]*$/", $city)) {
        header("Location: ../register.php?error=invalidmailfnamelnamecity&street=".$address);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=invalidmail&fname=".$firstname."&lname=".$lastname."&postcode=".$postcode.
    "&City=".$city."&address=".$address);
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
        header("Location: ../register.php?error=invalidfname&lname=".$lastname."&postcode=".$postcode.
    "&City=".$city."&address=".$address);
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
        header("Location: ../register.php?error=invalidlnamee&fname=".$firstname."&postcode=".$postcode.
    "&city=".$city."&street=".$address);
        exit();
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $city)) {
        header("Location: ../register.php?error=invalidcity&fname=".$firstname."&lname=".$lastname."&postcode=".$postcode."&street=".$address);
        exit();
    } elseif ($password !== $passwordRepeat) {
        header("Location: ../register.php?error=passwordcheck&fname=".$firstname."&lname=".$lastname."&postcode=".$postcode."&street=".$address);
        exit();
    } elseif (strlen($username) > 50 || strlen($firstname) > 50 || strlen($lastname) > 50 || strlen($email) > 50
  || strlen($address) > 50 || strlen($city) > 50 || strlen($postcode) > 8 || strlen($country) > 50) {
        header("Location: ../register.php?error=characterstoolong");
        exit();
    } elseif (is_integer($mobile)) {
        header("Location: ../updateUser.php?error=wrongdatatype");
        exit();
    } else {
        $sql = "SELECT EMAIL FROM USERS WHERE EMAIL= ?";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=sqlerror01");
            exit();
        } else {
            //checks if email entered on register page is already in use
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../register.php?error=emailtaken".$email);
                exit();
            } else {
                //inputs data entered from the register page into the database
                $sql = "INSERT INTO users (USERNAME, FNAME, LNAME, DOB, EMAIL, MOBILE, STREET, CITY, POSTCODE, COUNTRY, PASSWORD, ACCOUNTTYPE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($con);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../register.php?error=sqlerror02");
                    exit();
                } else {
                    //Uses BCrypt to hash users password
                    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ssssssssssss", $username, $firstname, $lastname, $Dob, $email, $mobile, $address, $city, $postcode, $country, $hashedpassword, $accountType);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../register.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../register.php");
    exit();
}
