<?php $title = 'Squad'; include("includes/header.inc.php");   require 'includes/dbconnect.inc.php'; ?>

<article class="main_content">
  <div class="container" style="padding-bottom: 2.3%;">
    <h1 style="padding-top: 2%"> Your Squad</h1>
    <div class="row">
      <div class="col">
        <form action="includes/squad.inc.php" method="post">
          <table>
            <tr>
              <th>UserID</th> 
              <th>Username</th>
              <th>Name</th>
              <th>Mobile</th>
              <th>E-mail</th>
              <th></th>
            </tr>
            <?php
            if (isset($_SESSION['userid'])) :

              $sql = "SELECT USERID, USERNAME, FNAME, LNAME, MOBILE, EMAIL, DOB, STREET, CITY, COUNTRY, POSTCODE, ACCOUNTTYPE, PARENTID, TRAINERID FROM USERS WHERE TRAINERID = ? ORDER BY USERID ASC";
              $stmt = mysqli_stmt_init($con);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?error=sqlerrorDetails01");
                exit();
              }else
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['userid']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) :
                  while ($row = mysqli_fetch_array($result)) :
                      $userid = $row['USERID'];
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
            ?>
            <tr>
              <td><?php echo $userid; ?></td>
              <td><?php echo $username;?></td>
              <td> <?php echo $fname, " ",$lname ;?></td>
              <td><?php echo "0",$mobile; ?></td>
              <td><?php echo $email; ?></td>
              <td style="padding-left: 4%;">
                <a class="btn btn-outline-dark my-2 my-sm-0" href="profile.php?id=<?php echo $userid; ?>">View Profile</a>
                <input class="btn btn-outline-dark my-2 my-sm-0" id="remove-team-member" name="remove-team-member" value="Remove" type="Submit" formnovalidate="" style="margin-left: 2%">
              </td>
            </tr>
            <?php
                endwhile;
              endif;
              else: echo "<tr>
                            <td></td>
                            <td>No Member yet</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>";
              endif;
            ?>
          </table>
          <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $userid; ?>" >
        </from>
      </div>
    </div>
    <?php
      if (mysqli_num_rows($result) > 0) :
     ?>
    <div class="row" style="height: 30%;" >
      <div class="col">
        <form action="includes/squad.inc.php" method="post" style="padding-bottom:3%;">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="material-icons">people</i>
              </span>
            </div>
            <input type="number" name="userid" id="userid" class="form-control" aria-label="Time" aria-describedby="basic-addon2" placeholder="UserID" required>
            <div class="input-group-prepend" style="margin-left: 1%">
              <span class="input-group-text" id="basic-addon2">
                <i class="material-icons">alarm</i>
              </span>
            </div>
            <input type="number" name="time" id="time" class="form-control" aria-label="Time" aria-describedby="basic-addon3" placeholder="Race Time" required>
            <div class="input-group-prepend" style="margin-left: 1%">
              <span class="input-group-text" id="basic-addon3">
                <i class="material-icons">date_range</i>
              </span>
            </div>
            <input type="text" id="date" name="date" class="form-control" placeholder="Race Date" onfocus="(this.type='date')" onblur="(this.type='text')" required>
          </div>
          <br/>
          <div>
            <h6>Please enter time in seconds</h6>
            <button class="btn btn-outline-dark my-2 my-sm-0" name="race-time-submit" type="submit" value="AddTime">Add Time</button>
          </div>
        </form>
      </div>
    </div>
    <?php
    endif;
    if (isset($_GET['error'])) {
      if ( $_GET['error'] == "emptyfields" || $_GET['error'] == "sqlerror") {
        echo '<div class="alert alert-danger" role="alert" style="margin-top: 2%; text-align: center;">
                Time failed to upload
              </div>';
      }
      if ( $_GET['error'] == "userNotFound") {
        echo '<div class="alert alert-danger" role="alert" style="margin-top: 2%; text-align: center;">
                There is no user for that userID
              </div>';
      }
    }

    else if (isset($_GET['timeUpload'])){
      echo  '<div class="alert alert-success" role="alert" style="margin-top: 2%; text-align: center;">
              Time successfully uploaded
            </div>';
    }
     ?>
  </div>
</article>

<?php include("includes/footer.inc.php"); ?>
