<?php $title = 'Profile'; include("includes/header.inc.php");  ?>

<article class="main_content">
  <div class="container" style="padding-bottom:15%;">
    <?php
    require 'includes/dbconnect.inc.php';
    if (isset($_SESSION['userid'])) :
      $id = intval($_GET['id']);

      $sql = "SELECT USERID, USERNAME, FNAME, LNAME, MOBILE, EMAIL, DOB, STREET, CITY, COUNTRY, POSTCODE, ACCOUNTTYPE, PARENTID, TRAINERID FROM USERS WHERE USERID = ?";
      $stmt = mysqli_stmt_init($con);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../index.php?error=sqlerrorDetails01");
          exit();
      } else {
          mysqli_stmt_bind_param($stmt, "s", $id);
      }
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
            $trainerID = $row['TRAINERID']
      ?>
    <form class="forms" method="post" action="includes/squad.inc.php">
      <h1> <?php echo $username,"'s" ?> Profile </h1>
      <div class="details">
        <div class="txt">
          <div class="row" style="padding-top:0%;">
            <div class="col">
              <p>
                <b>Username: </b><?php echo $username; ?>
              </p>
            </div>
            <div class="col">
              <b>Account Type: </b><?php echo $accountType; ?>
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
              <p>
                <b>Date of Birth: </b><?php echo $dob; ?>
              </p>
            </div>
          </div>
          <?php if ($_SESSION['accountType'] == "Coach" || $_SESSION['accountType'] == "Admin") {
          echo    '<div class="row" style="padding-top: 0%">
                    <div class="col">
                      <p>
                        <b>Mobile: </b>';
          echo "0",$mobile;
          echo '
                      </p>
                    </div>
                    <div class="col">
                      <p>
                        <b>Email: </b>';
          echo $email;
          echo '
                      </p>
                    </div>
                  </div>';
          echo    '<div class="row" style="padding-top: 0%">
                    <div class="col">
                      <p>
                        <b>Street: </b>';
          echo $street;
          echo '
                      </p>
                    </div>
                    <div class="col">
                      <p>
                        <b>City: </b>';
          echo $city;
          echo '
                      </p>
                    </div>
                  </div>';
          echo    '<div class="row" style="padding-top: 0%">
                    <div class="col">
                      <p>
                        <b>Country: </b>';
          echo $country;
          echo '
                      </p>
                    </div>
                    <div class="col">
                      <p>
                        <b>Postcode: </b>';
          echo $postcode;
          echo '
                      </p>
                    </div>
                  </div>';
          if ($_SESSION['accountType'] == "Coach") {
              echo'  <div class="row" style="padding-bottom: 10%; padding-left:15%;">
                        <div class="col">
                          <button class="btn btn-outline-dark my-2 my-sm-0" name="add-team-member" type="submit" value="AddTime" style="margin-left: 20%;">Add to Squad</button>
                        </div>
                      </div>';
                        
          }
          if ($_SESSION['accountType'] == "Admin") {
            echo'  <div class="row" style="padding-bottom: 10%;">';
            echo'  <div class="col">
                      <button class="btn btn-outline-dark my-2 my-sm-0" name="add-team-member" type="submit" value="AddTime" style="margin-left: 20%;">Add to Squad</button>
                   </div>';

              echo '<div class="col">
                      <button class="btn btn-outline-dark my-2 my-sm-0" id="delete-submit" name="delete-submit" type="submit">Delete User</button>
                    </div>
                  </div>';
          }  
      }
      ?>
            <div class="row" style="padding-top: 0%">
              <div class="col">
                <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $id; ?>" >
              </div>
            </div>
          </div>
        </div>
      </form>
        <div class="row" style="padding-top:2%;">
          <div class="col">
            <p>
              <b><?php echo $username,"'s"; ?> Training Times</b>
            </p>
            <table>
              <tr>
                <th>Day</th>
                <th>Time (Seconds)</th>
                <th>Date</th>
              </tr>
              <?php

                $sql = "SELECT * FROM TRAININGTIMES WHERE USERID = ? AND YEARWEEK(LAPDATE) = YEARWEEK(NOW())";
                $stmt = mysqli_stmt_init($con);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sqlerrorDetails01");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $id);
                }
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  if (mysqli_num_rows($result) > 0) :
                  while ($row = mysqli_fetch_array($result)) :
                    $dayOfweek = date('l', strtotime($row['LAPDATE']));
              ?>
              <tr>
                <td><?php echo $dayOfweek;?></td>
                <td> <?php echo $row['LAPTIME'];?></td>
                <td><?php echo $row['LAPDATE']; ?></td>
              </tr>
              <?php
            endwhile;
          else: echo "<tr>
                        <td></td>
                        <td>No Times yet</td>
                        <td></td>
                      </tr>";
          endif;
           ?>
            </table>
          </div>
          <div class="col">
            <p>
              <b>Your Training Times</b>
            </p>
            <table>
              <tr>
                <th>Day</th>
                <th>Time (Seconds)</th>
                <th>Date</th>
              </tr>
              <?php
              $USERID = $_SESSION['userid'];

              $sql = "SELECT * FROM TRAININGTIMES WHERE USERID=? AND YEARWEEK(LAPDATE) = YEARWEEK(NOW())";
              $stmt = mysqli_stmt_init($con);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                  header("Location: ../index.php?error=sqlerrorDetails01");
                  exit();
              } else {
                  mysqli_stmt_bind_param($stmt, "s", $USERID);
              }
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) :
                while ($row = mysqli_fetch_array($result)) :
                  $dayOfweek = date('l', strtotime($row['LAPDATE']));


              ?>
              <tr>
                <td><?php echo $dayOfweek;?></td>
                <td> <?php echo $row['LAPTIME'];?></td>
                <td><?php echo $row['LAPDATE']; ?></td>
              </tr>
              <?php
            endwhile;
          else: echo "<tr>
                        <td></td>
                        <td>No Times yet</td>
                        <td></td>
                      </tr>";
          endif;
           ?>
            </table>
          </div>
        </div>
        <div class="row" style="padding-top:2%;">
          <div class="col">
            <p>
              <b><?php echo $username,"'s"; ?> Race Times</b>
            </p>
            <table>
              <tr>
                <th>Day</th>
                <th>Time (Seconds)</th>
                <th>Date</th>
                <?php if ($_SESSION['accountType'] == "Coach" || $_SESSION['accountType'] == "Admin") {
               echo '<th></th>';
           }?>
              </tr>
              <?php
                                
                $sql = "SELECT * FROM RACETIMES WHERE USERID = ?";
                $stmt = mysqli_stmt_init($con);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sqlerrorDetails01");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $id);
                }
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  if (mysqli_num_rows($result) > 0) :
                  while ($row = mysqli_fetch_array($result)) :
                    $dayOfweek = date('l', strtotime($row['LAPDATE']));
                    $dateID = $row['RACETIMEID'];

              ?>
              <tr>
                <td><?php echo $dayOfweek;?></td>
                <td> <?php echo $row['LAPTIME'];?></td>
                <td><?php echo $row['LAPDATE']; ?></td>
                <?php if ($_SESSION['accountType'] == "Coach" || $_SESSION['accountType'] == "Admin") {
                  echo'<td>
                        <a class="btn btn-outline-dark my-2 my-sm-0" href="editRaceTime.php?id=';
                  echo $dateID;
                  echo'" style="margin-left: 30%;">Edit</a>
                      </td>';
              }
                  ?>
              </tr>
              <?php
            endwhile;
          else: echo "<tr>
                        <td></td>
                        <td>No Times yet</td>
                        <td></td>
                        </tr>";
        endif;
           ?>
            </table>
          </div>
          <div class="col">
            <p>
              <b>Your Race Times</b>
            </p>
            <table>
              <tr>
                <th>Day</th>
                <th>Time (Seconds)</th>
                <th>Date</th>
              </tr>
              <?php
              $USERID = $_SESSION['userid'];

              $sql = "SELECT * FROM RACETIMES WHERE USERID=?";
              $stmt = mysqli_stmt_init($con);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                  header("Location: ../index.php?error=sqlerrorDetails01");
                  exit();
              } else {
                  mysqli_stmt_bind_param($stmt, "s", $USERID);
              }
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) :
                while ($row = mysqli_fetch_array($result)) :
                  $dayOfweek = date('l', strtotime($row['LAPDATE']));
              ?>
              <tr>
                <td><?php echo $dayOfweek;?></td>
                <td> <?php echo $row['LAPTIME'];?></td>
                <td><?php echo $row['LAPDATE']; ?></td>
              </tr>
              <?php
            endwhile;
          else: echo "<tr>
                        <td></td>
                        <td>No Times yet</td>
                        <td></td>
                      </tr>";
          endif;
           ?>
            </table>
          </div>
        </div>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
                echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%; text-align: center;">
                    Please check you have entered data into every field
                  </div>';
            }
            if ($_GET['error'] == "sqlerror") {
                echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%; text-align: center;">
                    Failed to register
                  </div>';
            }
        } elseif (isset($_GET['update'])) {
            echo  '<div class="alert alert-success" role="alert" style="margin-top: 2%;  text-align: center;">
                  User updated successfully!
                </div>';
        } elseif (isset($_GET['delete'])) {
            echo  '<div class="alert alert-success" role="alert" style="margin-top: 2%; text-align: center;">
                  User deleted successfully!
                </div>';
        }
        ?>
      
    <?php
    endif;
  endif;
    ?>
  </div>
</article>

<?php include("includes/footer.inc.php"); ?>
