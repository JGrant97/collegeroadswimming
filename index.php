<?php $title = 'Home'; include("includes/header.inc.php"); ?>

<article class="main_content" style="background-image:   linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
url('assets/swimbgcolour.jpg'); background-size: cover; background-position: center; color: white;">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-4">Welcome!</h1>
        <p class="lead">This website is for the college road swimming club</p>
        <hr class="my-4">
        <p>To find out more click the button below</p>
        <a class="btn btn-secondary btn-lg" href="about.php" role="button">Learn more</a>
        <?php
        if (isset($_GET['error'])) {
          if ( $_GET['error'] == "notLoggedin") {
              echo '<div class="alert alert-danger" role="alert"  style="margin-top: 15%; text-align: center;">
                      You can not access this page until you log in!
                    </div>';
            }
            elseif ( $_GET['error'] == "notAuthorised") {
                echo '<div class="alert alert-danger" role="alert"  style="margin-top: 15%; text-align: center;">
                        You do not have permission to access that page
                      </div>';
              }
            
            elseif ( $_GET['error'] == "sessionExpired") {
                echo '<div class="alert alert-danger" role="alert"  style="margin-top: 15%; text-align: center;">
                        You have been logged out due to inactivity!
                      </div>';
              }
          }
          else if (isset($_GET['delete'])){
            echo  '<div class="alert alert-success" role="alert" style="margin-top: 15%; text-align: center;">
                    User deleted successfully!
                  </div>';
          }
         ?>
      </div>
    </div>
</article>

<?php include("includes/footer.inc.php"); ?>
