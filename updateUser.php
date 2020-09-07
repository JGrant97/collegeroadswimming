<?php $title = 'Update Account'; include("includes/header.inc.php");  require 'includes/dbconnect.inc.php';?>

<article class="main_content">
  <div class="container">
    <form class="forms" action="includes/updateUser.inc.php" method="post" style="padding-bottom:15%">
      <?php
      if (isset($_SESSION['userid'])) :
        $sql = "SELECT USERID, USERNAME, FNAME, LNAME, MOBILE, EMAIL, DOB, STREET, CITY, COUNTRY, POSTCODE, ACCOUNTTYPE, PARENTID, TRAINERID FROM USERS WHERE USERID = ?";
        $stmt = mysqli_stmt_init($con);
      //  $id = intval($_GET['id']);
        if(isset($_GET['id']))
        {
          $id = intval($_GET['id']);
        }
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../index.php?error=sqlerrorDetails01");
          exit();
        }else
          mysqli_stmt_bind_param($stmt, "s", $id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) :
            //  $Cuserid = $row['USERID'];
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
              $userid = $_SESSION['userid'];
      ?>
      <h1> Update Account Details </h1>
      <div class="row">
        <div class="col">
          <input type="text" id="username" name="username" class="form-control" placeholder="Username" maxlength="50" value="<?php echo $username; ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" id="fname" name="fname" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $fname; ?>" required>
        </div>
        <div class="col">
          <input type="text" id="lname" name="lname" class="form-control" placeholder="Last name" maxlength="50" value="<?php echo $lname; ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" id="dob" name="dob" class="form-control" placeholder="Date of birth" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $dob ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" id="street" name="street" class="form-control" placeholder="Street name and number" maxlength="50" value="<?php echo $street; ?>" required>
        </div>
        <div class="col">
          <input type="text" id="city" name="city" class="form-control" placeholder="City" maxlength="50" value="<?php echo $city; ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" id="country" name="country" class="form-control" placeholder="United Kingdom" value="United Kingdom" readonly>
        </div>
        <div class="col">
          <input type="text" id="postcode" name="postcode" class="form-control" placeholder="Postcode" maxlength="8" value="<?php echo $postcode; ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="Mobile number e.g. 07" maxlength="12" value="<?php echo "0",$mobile; ?>" required>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="hidden" name="userid" value="<?php echo $userid; ?>">
        </div>
        <?php
        if ($accountType == "Child") {
          echo '  <div class="col">
                    <select class="form-control" id="accountType" name="accountType" required>
                      <option selected hidden>Child</option>
                    </select>
                  </div>';
        }
        elseif($accountType == "Parent" || $accountType == "Swimmer") {
          echo '  <div class="col">
                    <select class="form-control" id="accountType" name="accountType" required>
                      <option selected hidden>'; echo $accountType;  echo '</option>
                      <option>Swimmer</option>
                      <option>Parent</option>
                    </select>
                  </div>';
        }elseif ($accountType == "Coach" || $accountType == "Admin" ) {
          echo '  <div class="col">
                    <select class="form-control" id="accountType" name="accountType" required>
                      <option selected hidden>'; echo $accountType;  echo '</option>
                    </select>
                  </div>';
          }
        ?>
      </div>
      <div class="row">
        <div class="col">
          <input type="password" id="password" name="password" class="form-control" placeholder="New Password">
        </div>
        <div class="col">
          <input type="password" id="password-repeat" name="password-repeat" class="form-control" placeholder="Repeat New Password">
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
        if ( $_GET['error'] == "tooYoung") {
          echo '<div class="alert alert-danger" role="alert"  style="margin-top: 2%">
                  You are too young! Please get a parent to make an account first before making your own!
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
      else if (isset($_GET['delete'] )){
        echo  '<div class="alert alert-success" role="alert" style="margin-top: 2%">
                User deleted successfully!
              </div>';
      }
      ?>
      <button type="submit" class="btn btn-secondary" name="delete-submit" style="margin-top: 1%">Delete Account</button>
      <button type="submit" class="btn btn-secondary" name="signup-submit" style="margin-top: 1%">Submit</button>
      <?php
      endif;
    endif;
      ?>
    </form>
  </div>
</article>

<?php include("includes/footer.inc.php"); ?>
