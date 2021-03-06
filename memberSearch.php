<?php $title = 'Member'; include("includes/header.inc.php");  require 'includes/dbconnect.inc.php'; ?>

<article class="main_content">
  <div class="container" style="padding-bottom:15%;">
    <form class="forms" action="memberSearch.php" method="post">
      <div class="search">
        <div class="row" style="padding-top:0%;">
          <div class="col" style="text-align:left; padding-left: 0%;padding-right: 0%;">
            <input class="form-control mr-sm-2" id="search" name="search" type="search" placeholder="Search" aria-label="Search">
          </div>
          <div class="col" style="text-align:left; padding-left: 0%;padding-right: 0%;">
            <button class="btn btn-outline-dark my-2 my-sm-0" name="submit-search" type="submit">Search</button>
          </div>
        </div>
      </div>
    </form>
    <div class="details">
      <div class="row">
        <?php
          $keyword = $_POST['search'];
          $id = $_SESSION['userid'];
          if (isset($_POST['submit-search'])):
            $search = mysqli_real_escape_string($con, $_POST['search']);
            $sql = "SELECT USERID, USERNAME, FNAME, LNAME, EMAIL, DOB, ACCOUNTTYPE, TRAINERID FROM USERS WHERE USERNAME LIKE '%$search%' AND USERID != '$id' AND ACCOUNTTYPE != 'Admin'
            OR FNAME LIKE '%$search%' AND USERID != '$id' AND ACCOUNTTYPE != 'Admin'
            OR LNAME LIKE '%$search%' AND USERID != '$id'AND ACCOUNTTYPE != 'Admin'
            OR ACCOUNTTYPE LIKE '%$search%' AND USERID != '$id' AND ACCOUNTTYPE != 'Admin'";

            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              header("Location: ../index.php?error=sqlerrorDetails01");
              exit();
            }
            else
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              if(mysqli_num_rows($result) > 0):
                while($row = mysqli_fetch_array($result)):
                  $selectedID = $row['USERID'];
                  $username = $row['USERNAME'];
                  $fname = $row['FNAME'];
                  $lname = $row['LNAME'];
                  $email = $row['EMAIL'];
                  $dob = $row['DOB'];
                  $accountType = $row['ACCOUNTTYPE'];
                  $trainerID = $row['TRAINERID'];
           ?>
        <div class="col-sm-6" style="padding-bottom: 2%;">
          <div class="card">
            <div class="card-body">
              <img class="card-img-top" src="https://via.placeholder.com/600x600.jpeg" alt="Card image cap">
              <h5 class="card-title" style="padding-top: 3%;"><b><?php echo $username; ?></b></h5>
              <p class="card-text">
                Name: <?php echo $fname, " ", $lname; ?> <br/>
                Date of Birth: <?php echo $dob; ?><br/>
                Account Type: <?php echo $accountType ?>
              </p>
              <a class="btn btn-outline-dark my-2 my-sm-0" href="profile.php?id=<?php echo $selectedID; ?>">View Profile</a>
            </div>
          </div>
        </div>
        <?php
          endwhile;
      endif;
        ?>

      </div>
    </div>
    <?php
    if (mysqli_num_rows($result) <= 0) :
    ?>
      <div class="alert alert-danger" role="alert"  style="margin-top: 2%">
        No matching results!
      </div>
    <?php
      endif;
    endif;
     ?>
  </div>
</article>

<?php include("includes/footer.inc.php"); ?>
