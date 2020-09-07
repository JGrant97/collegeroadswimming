<?php $title = 'Register'; include("includes/header.inc.php"); ?>

<article class="main_content">
  <div class="container">
    <form class="forms" action="includes/signup.inc.php" method="post" style="padding-bottom:15%">
      <h1> Account Registration </h1>
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
          <input type="email" autocomplete="off" id="email" name="email" class="form-control" placeholder="E-mail" maxlength="50" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" autocomplete="off" id="street" name="street" class="form-control" placeholder="Street name and number" maxlength="50" required>
        </div>
        <div class="col">
          <input type="text" autocomplete="off" id="city" name="city" class="form-control" placeholder="City" maxlength="50" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" autocomplete="off" id="country" name="country" class="form-control" placeholder="United Kingdom" value="United Kingdom" readonly>
        </div>
        <div class="col">
          <input type="text" autocomplete="off" id="postcode" name="postcode" class="form-control" placeholder="Postcode" maxlength="8" required>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="tel" autocomplete="off" id="mobile" name="mobile" class="form-control" placeholder="Mobile number e.g. 07" maxlength="12" required>
        </div>
        <div class="col">
          <select class="form-control" id="accountType" name="accountType" required>
            <option disabled value="" selected hidden>Account Type</option>
            <option>Swimmer</option>
            <option>Parent</option>
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
      ?>
      <button type="submit" class="btn btn-secondary" name="signup-submit" style="margin-top: 1%">Submit</button>
    </form>
  </div>
</article>

<?php include("includes/footer.inc.php"); ?>
