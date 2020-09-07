<?php $title = 'My Profile'; include("includes/header.inc.php");  ?>

<article class="main_content">
  <div class="container" style="padding-bottom:15%;">
    <?php
    require 'includes/dbconnect.inc.php';
    if (isset($_SESSION['userid'])) :
      $sql = "SELECT USERNAME, FNAME, LNAME, MOBILE, EMAIL, DOB, STREET, CITY, COUNTRY, POSTCODE, ACCOUNTTYPE, PARENTID, TRAINERID FROM USERS WHERE USERID = ?";
      $stmt = mysqli_stmt_init($con);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerrorDetails01");
        exit();
      }else
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['userid']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
          if ($row = mysqli_fetch_assoc($result)) :
            $username = $row['USERNAME'];
            $fname = $row['FNAME'];
            $lname = $row['LNAME'];
            $mobile = $row['MOBILE'];
            $email = $row['EMAIL'];
            $dob = $row['DOB'];
            $street = $row['STREET'];
            $city = $row['CITY'];
            $country = $row['COUNTRY'];
            $postcode = $row['POSTCODE'];
            $accountType = $row['ACCOUNTTYPE'];
            $parentID = $row['PARENTID'];
            $trainerID = $row['TRAINERID'];


      ?>
    <form class="forms" method="post" action="updateUser.php?id=<?php echo $_SESSION['userid'];?>">
      <h1> My Profile </h1>
      <div class="details">
        <div class="txt">
          <div class="row" style="padding-left: 23%;">
            <div class="col">
              <p>
                <b>Welcome back! </b><?php echo $username; ?>
              </p>
            </div>
          </div>

          <div class="row" style="padding-top: 0%">
            <div class="col">
              <p>
                <b>First Name: </b><?php echo $fname; ?>
              </p>
            </div>
            <div class="col">
              <b>Last Name: </b><?php echo $lname; ?>
            </div>
          </div>

          <div class="row" style="padding-top: 0%">
            <div class="col">
              <p>
                <b>Email: </b><?php echo $email; ?>
              </p>
            </div>
            <div class="col">
              <b>Mobile: </b>0<?php echo $mobile; ?>
            </div>
          </div>

          <div class="row" style="padding-top: 0%">
            <div class="col">
              <p>
                <b>Date of Birth: </b><?php echo $dob; ?>
              </p>
            </div>
            <div class="col">
              <b>Street: </b><?php echo $street; ?>
            </div>
          </div>

          <div class="row" style="padding-top: 0%">
            <div class="col">
              <p>
                <b>City: </b><?php echo $city; ?>
              </p>
            </div>
            <div class="col">
              <b>Country: </b><?php echo $country; ?>
            </div>
          </div>
          <div class="row" style="padding-top: 0%">
            <div class="col">
              <p>
                <b>Postcode: </b><?php echo $postcode; ?>
              </p>
            </div>
            <div class="col">
              <b>Account Type: </b><?php echo $accountType; ?>
            </div>
          </div>

          <div class="row" style="padding-top: 0%">
            <?php
            $sql2 = "SELECT USERNAME, FNAME, LNAME FROM USERS WHERE USERID = ?";
            $stmt2 = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt2, $sql2)) {
              header("Location: ../index.php?error=sqlerrorDetails01");
              exit();
            }else
              mysqli_stmt_bind_param($stmt2, "s", $row['TRAINERID']);
              mysqli_stmt_execute($stmt2);
              $result2 = mysqli_stmt_get_result($stmt2);
              if (mysqli_num_rows($result2) > 0) :
                if ($rows = mysqli_fetch_assoc($result2)) :
                  $coachusername = $rows['USERNAME'];
                  $coachfname = $rows['FNAME'];
                  $coachlname = $rows['LNAME'];
            ?>
            <div class="col">
              <p>
                <b>Coach Username: </b><?php echo $coachusername; ?>
              </p>
            </div>
            <div class="col">
              <p>
                <b>Coach Name: </b><?php echo $coachfname, " ", $coachlname; ?>
              </p>
            </div>
              <?php
            endif;
          endif;
          if (mysqli_num_rows($result2) <= 0) :
            ?>
            <div class="col">
              <p>
                <b>Coach Username:</b> N/A
              </p>
            </div>
            <div class="col">
              <p>
                <b>Coach Name</b> N/A
              </p>
            </div>
          <?php
          endif;
          ?>
          </div>
        </div>
      </div>
        <?php
        if ($_SESSION['accountType'] != "Child") {
          echo   '<div class="row" style="padding-bottom: 1%; padding-left: 0%;">
                    <div class="col">
                      <a class="btn btn-outline-dark my-2 my-sm-0" name="time-update"  id="time-update" type="button" href="updateUser.php?id='; echo $_SESSION['userid']; echo'">Edit Details</a>
                    </div>
                  </div>';
        }
        ?>
        
      </form>
        <div class="row" style="padding-left:0%; padding-top:2%;">
          <div class="col">
            <p>
              <b>Your Child Accounts</b>
            </p>
          </div>
        </div>
        <div class="row" style="padding-top:0%; ">
          <div class="col">
            <form class="forms" method="post" action="updateUser.php?id=<?php echo $Cuserid;?>">
              <table>
                <tr>
                  <th>Username</th>
                  <th>First Name</th>
                  <th>Surname</th>
                  <th>Email</th>
                  <th>Date of Birth</th>
                  <th></th>
                </tr>
                <?php

                $sql = "SELECT USERID, USERNAME, FNAME, LNAME, MOBILE, EMAIL, DOB, STREET, CITY, COUNTRY, POSTCODE, ACCOUNTTYPE, PARENTID, TRAINERID FROM USERS WHERE PARENTID = ?";
                $stmt = mysqli_stmt_init($con);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                  header("Location: ../index.php?error=sqlerrorDetails01");
                  exit();
                }else
                  mysqli_stmt_bind_param($stmt, "s", $_SESSION['userid']);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_array($result)) :
                      $Cuserid = $row['USERID'];
                      $Cusername = $row['USERNAME'];
                      $Cfname = $row['FNAME'];
                      $Clname = $row['LNAME'];
                      $Cmobile = $row['MOBILE'];
                      $Cemail = $row['EMAIL'];
                      $Cdob = $row['DOB'];
                      $Cstreet = $row['STREET'];
                      $Ccity = $row['CITY'];
                      $Ccountry = $row['COUNTRY'];
                      $Cpostcode = $row['POSTCODE'];
                      $CaccountType = $row['ACCOUNTTYPE'];
                      $CparentID = $row['PARENTID'];
                      $CtrainerID = $row['TRAINERID'];
                ?>
                <tr>
                  <td> <?php echo $Cusername?></td>
                  <td> <?php echo $Cfname?></td>
                  <td><?php echo $Clname ?></td>
                  <td><?php echo $Cemail ?></td>
                  <td><?php echo $Cdob ?></td>
                  <td>
                    <a class="btn btn-outline-dark my-2 my-sm-0" name="time-update2" id="time-update2" type="button" href="updateUser.php?id=<?php echo $Cuserid;?>" style="margin-left: 5%;">Edit Details</a>
                  </td>
                </tr>
                    <?php
                  endwhile;
                ?>
              </table>
            </form>
          </div>
        </div>
        <?php
        if (isset($_GET['error'])) {
          if ( $_GET['error'] == "emptyfields") {
            echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%; text-align: center;">
                    Please check you have entered data into every field
                  </div>';
          }
          if ( $_GET['error'] == "sqlerror") {
            echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%; text-align: center;">
                    Failed to register
                  </div>';
          }
        }
        else if (isset($_GET['update'])){
          echo  '<div class="alert alert-success" role="alert" style="margin-top: 2%;  text-align: center;">
                  User updated successfully!
                </div>';
        }
        else if (isset($_GET['delete'] )){
          echo  '<div class="alert alert-success" role="alert" style="margin-top: 2%; text-align: center;">
                  User deleted successfully!
                </div>';
        }
        ?>
      </div>
    <?php
    endif;
  endif;
    ?>
</article>

<?php include("includes/footer.inc.php"); ?>
