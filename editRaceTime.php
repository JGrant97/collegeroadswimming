<?php $title = 'Edit Race Times'; include("includes/header.inc.php");   require 'includes/dbconnect.inc.php'; ?>

<article class="main_content">
  <div class="container" style="padding-bottom: 2.3%;">
    <h1 style="padding-top: 2%"> Edit Race Times</h1>
    <div class="row" style="height: 30%;" >
      <div class="col">
        <form action="includes/registerTimes.inc.php" method="post" style="padding-bottom:3%;">
          <?php
          if (isset($_SESSION['userid'])) :
            if(isset($_GET['id']))
            {
              $id = intval($_GET['id']);
            }
            $sql = "SELECT * FROM racetimes WHERE RACETIMEID  = ? ORDER BY LAPDATE ASC";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              header("Location:../collegeroadswimming/editRaceTime.php?error=sqlerror01");
              exit();
            }else
              mysqli_stmt_bind_param($stmt, "s", $id);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) :
                  $laptime = $row['LAPTIME'];
                  $date = $row['LAPDATE'];
                  $dayOfweek = date('l', strtotime($date));

            ?>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="material-icons">alarm</i>
              </span>
            </div>
            <input type="number" name="time" id="time" class="form-control" aria-label="Time" value="<?php echo $laptime;?>" aria-describedby="basic-addon1" placeholder="Lap Time" required>
            <div class="input-group-prepend" style="margin-left: 1%">
              <span class="input-group-text" id="basic-addon1">
                <i class="material-icons">date_range</i>
              </span>
            </div>
            <input type="text" id="date" name="date" class="form-control" placeholder="Lap Date" value="<?php echo $date; ?>" onfocus="(this.type='date')" onblur="(this.type='text')" required>
          </div>
          </br>
          <div>
            <h6>Please enter time in seconds</h6>
            <input type="hidden" name="id" id="id" class="form-control" aria-label="id" value="<?php echo $id;?>" aria-describedby="basic-addon1"  required>
            <button type="submit" class="btn btn-outline-dark my-2 my-sm-0" id="edit-race-submit" name="edit-race-submit" >Add New Times</button>
          </div>
          <?php
        endif;
      endif;
       ?>
        </form>
      </div>
    </div>
    <?php
    if (isset($_GET['error'])) {
      if ( $_GET['error'] == "emptyfields" || $_GET['error'] == "sqlerror") {
        echo '<div class="alert alert-danger" role="alert" style="margin-top: 2%;  text-align: center;">
                Time failed to upload
              </div>';
      }
    }

    else if (isset($_GET['success'])){
      echo  '<div class="alert alert-success" role="alert" style="margin-top: 2%;  text-align: center;">
              Time successfully uploaded
            </div>';
    }
    ?>
  </div>
</article>

<?php include("includes/footer.inc.php"); ?>
