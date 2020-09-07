<?php $title = 'Weekly Training Times'; include("includes/header.inc.php");   require 'includes/dbconnect.inc.php'; ?>

<article class="main_content">
  <div class="container" style="padding-bottom: 2.3%;">
    <h1 style="padding-top: 2%"> This Weeks Training Times</h1>
    <div class="row">
      <div class="col">
        <form action="includes/registerTimes.inc.php" method="post">
          <table>
            <tr>
              <th>Day</th>
              <th>Time (Seconds)</th>
              <th>Date</th>
              <th></th>
            </tr>
            <?php
            $USERID = $_SESSION['userid'];

            $sql = "SELECT * FROM TRAININGTIMES WHERE USERID=$USERID AND YEARWEEK(LAPDATE) = YEARWEEK(NOW()) ORDER BY LAPDATE ASC";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) :
              while ($row = mysqli_fetch_array($result)) :
                $dayOfweek = date('l', strtotime($row['LAPDATE']));
                $dateID = $row['TRAININGTIMEID'];
            ?>
            <tr>
              <td><?php echo $dayOfweek;?></td>
              <td> <?php echo $row['LAPTIME'];?></td>
              <td><?php echo $row['LAPDATE']; ?></td>
              <td>
                <a class="btn btn-outline-dark my-2 my-sm-0" href="editWeeklyTrainingTimes.php?id=<?php echo $dateID;?>" style="margin-left: 30%;">Edit</formnovalidate>
              </td>
            </tr>
            <?php
          endwhile;
        else: echo "<tr>
                      <td></td>
                      <td>No Times yet</td>
                      <td></td>
                      <td></td>
                    </tr>";
        endif;
         ?>
          </table>
        </form>
      </div>
    </div>

    <div class="row" style="height: 30%;" >
      <div class="col">
        <form action="includes/registerTimes.inc.php" method="post" style="padding-bottom:3%;">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="material-icons">alarm</i>
              </span>
            </div>
            <input type="number" name="time" id="time" class="form-control" aria-label="Time" aria-describedby="basic-addon1" placeholder="Lap Time" required>
            <div class="input-group-prepend" style="margin-left: 1%">
              <span class="input-group-text" id="basic-addon1">
                <i class="material-icons">date_range</i>
              </span>
            </div>
            <input type="text" id="date" name="date" class="form-control" placeholder="Lap Date" onfocus="(this.type='date')" onblur="(this.type='text')" required>
          </div>
          <br/>
          <div>
            <h6>Please enter time in seconds</h6>
            <button class="btn btn-outline-dark my-2 my-sm-0" name="training-time-submit" type="submit" value="AddTime">Add Time</button>
          </div>
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
