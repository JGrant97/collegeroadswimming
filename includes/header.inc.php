<?php
  session_start();
  include("includes/isloggedin.inc.php");
  include("includes/permissions.inc.php");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="style/style.css">
    <title><?php echo $title; ?></title>
  </head>
<body>
  <div class="content">
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li <?php if ($title == 'Home') {
                  echo 'class="nav-item active"';
              } else {
                  echo 'class="nav-item"';
              }?>>
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li <?php if ($title == 'Member') {
                echo 'class="nav-item active"';
            } else {
                echo 'class="nav-item"';
            }?>>
              <a class="nav-link" href="members.php">Club Members</a>
            </li>
            <li <?php if ($title == 'About') {
                  echo 'class="nav-item active"';
              } else {
                  echo 'class="nav-item"';
              }?>>
              <a class="nav-link" href="about.php">About us</a>
            </li>
          </ul>
          <form class="form-inline" action="includes/login.inc.php" method="post">
            <ul class="navbar-nav">
              <li class="input-group">
                <?php
                if (isset($_SESSION['userid'])) {
                    echo  ' <li ';
                    if ($title == 'My Profile' || $title == 'My Swimming Times') {
                        echo 'class="nav-item dropdown active"';
                    } else {
                        echo 'class="nav-item dropdown"';
                    }
                    echo '>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              My Profile
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a ';
                    if ($title == 'My Profile') {
                        echo 'class="dropdown-item active"';
                    } else {
                        echo 'class="dropdown-item"';
                    }
                    echo ' href="myprofile.php">My Profile</a>

                              <a ';
                    if ($title == 'Weekly Training Times') {
                        echo 'class="dropdown-item active"';
                    } else {
                        echo 'class="dropdown-item"';
                    }
                    echo' href="weeklyTrainingTimes.php">Weekly Training Times</a>

                              <a ';
                    if ($title == 'Race  Times') {
                        echo 'class="dropdown-item active"';
                    } else {
                        echo 'class="dropdown-item"';
                    }
                    echo' href="raceTimes.php">Race Times</a>';

                    if ($_SESSION['accountType'] == "Coach" || $_SESSION['accountType'] == "Admin") {
                        echo  '<a ';
                        if ($title == 'Squad') {
                            echo 'class="dropdown-item active"';
                        } else {
                            echo 'class="dropdown-item"';
                        }
                        echo' href="squad.php">Squad</a>';
                    }

                    if ($_SESSION['accountType'] != "Child") {
                        echo  '<a ';
                        if ($title == 'Register Child') {
                            echo 'class="dropdown-item active"';
                        } else {
                            echo 'class="dropdown-item"';
                        }
                        echo' href="registerChild.php">Register Child</a>';
                    }

                    echo '<div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="includes/logout.inc.php">Log out</a>
                            </div>
                          </li>';
                } else {
                    echo '<div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="material-icons">perm_identity</i></span>
                        </div>
                        <input type="text" autocomplete="off" class="form-control" id="email" name="email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                        <div class="input-group-prepend" style="margin-left: 1%" >
                          <span class="input-group-text" id="basic-addon2"><i class="material-icons">security</i></span>
                        </div>
                      <input type="password" autocomplete="off" id="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" style="margin-right: 1%">
                      <button type="submit" id="login-submit" name="login-submit" class="btn btn-secondary"  style="margin-right: 1%">Sign in</button>
                      <a type="button" href="register.php" role="button" class="btn btn-secondary">Register</a>';
                }
                ?>
                </li>
            </ul>
          </form>
        </div>
      </nav>
    </header>
  <section>
