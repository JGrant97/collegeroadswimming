<?php $title = 'Register Child'; include("includes/header.inc.php"); ?>

<article class="main_content">

  <?php
  require 'includes/dbconnect.inc.php';
  if (isset($_SESSION['userid'])) :
    $sql = "SELECT  MOBILE, STREET, CITY, COUNTRY, POSTCODE, TRAINERID FROM USERS WHERE USERID = ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerrorDetails01");
      exit();
    }else
      mysqli_stmt_bind_param($stmt, "s", $_SESSION['userid']);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) :
          $mobile = $row['MOBILE'];
          $street = $row['STREET'];
          $city = $row['CITY'];
          $country = $row['COUNTRY'];
          $postcode = $row['POSTCODE'];
    ?>

  <div class="container">
    <form class="forms" action="includes/signupChild.inc.php" method="post" style="padding-bottom:15%">
      <h1> Child Account Registration </h1>
      <div class="row">
        <div class="col">
          <input type="text" autocomplete="off" id="username" name="username" class="form-control" placeholder="Username" maxlength="50" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" autocomplete="off" id="fname" name="fname" class="form-control" placeholder="First name" maxlength="50" required>
        </div>
        <div class="col">
          <input type="text" autocomplete="off" id="lname" name="lname" class="form-control" placeholder="Last name" maxlength="50" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" autocomplete="off" id="dob" name="dob" class="form-control" placeholder="Date of birth" onfocus="(this.type='date')" onblur="(this.type='text')" required>
        </div>
        <div class="col">
          <input type="email" autocomplete="off" id="email" name="email" class="form-control" placeholder="Email" maxlength="50" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" autocomplete="off" id="street" name="street" class="form-control" placeholder="Street name and number" maxlength="50" value="<?php echo $street; ?>" readonly>
        </div>
        <div class="col">
          <input type="text" autocomplete="off" id="city" name="city" class="form-control" placeholder="City" maxlength="50" value="<?php echo $city; ?>" readonly>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" autocomplete="off" id="country" name="country" class="form-control" placeholder="United Kingdom" value="United Kingdom" readonly>
        </div>
        <div class="col">
          <input type="text" autocomplete="off" id="postcode" name="postcode" class="form-control" placeholder="Postcode" maxlength="50" value="<?php echo $postcode; ?>" readonly>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="tel" autocomplete="off" id="mobile" name="mobile" class="form-control" placeholder="Mobile number e.g. 07" maxlength="12" value="<?php echo "0",$mobile; ?>" readonly>
        </div>
        <div class="col">
          <select class="form-control" id="accountType" name="accountType" >
            <option>Child</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="password" autocomplete="off" id="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col">
          <input type="password" autocomplete="off" id="password-repeat" name="password-repeat" class="form-control" placeholder="Repeat Password" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="hidden" id="parentID" name="parentID" class="form-control"  value="<?php echo $_SESSION['userid'];?>" >
        </div>
      </div>
      <?php
      if (isset($_GET['error'])) {
        if ( $_GET['error'] == "emptyfields") {
          echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%">
                  Please check you have entered data into every field
                </div>';
        }
        if ( $_GET['error'] == "sqlerror") {
          echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%">
                  Failed to register
                </div>';
        }
        if ( $_GET['error'] == "emailtaken") {
          echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%">
                  This email is already in use!
                </div>';
        }
        if ( $_GET['error'] == "tooOld") {
          echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%">
                  You are too old! Please make your own adult account!
                </div>';
        }
        if ( $_GET['error'] == "characterstoolong") {
          echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%">
                  Some charecters entered are too long!
                </div>';
        }
        if ( $_GET['error'] == "wrongdatatype") {
          echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%">
                  Please ensure you have entered the correct data types for each field!
                </div>';
        }
      }

      else if (isset($_GET['signup'])){
        echo  '<div class="alert alert-success" role="alert" style="margin-top: 2%">
                User registered successfully!
              </div>';
      }
      ?>
      <button type="submit" class="btn btn-secondary" name="signup-submit" style="margin-top: 1%">Submit</button>
    </form>
  </div>
  <?php
endif;
endif;
   ?>
</article>

<?php include("includes/footer.inc.php"); ?>
