<?php $title = 'Race  Times'; include("includes/header.inc.php");   require 'includes/dbconnect.inc.php'; ?>

<article class="main_content">
  <div class="container" style="padding-bottom: 2.3%;">
    <h1 style="padding-top: 2%"> Race Times</h1>
    <div class="row">
      <div class="col">
        <table>
          <tr>
            <th>Day</th>
            <th>Time (Seconds)</th>
            <th>Date</th>
          </tr>
          <?php
          $USERID = $_SESSION['userid'];

          $sql = "SELECT * FROM RACETIMES WHERE USERID=$USERID";
          $result = mysqli_query($con, $sql);
          if (mysqli_num_rows($result) > 0) :
            while ($row = mysqli_fetch_array($result)) :
              $dayOfweek = date('l', strtotime($row['LAPDATE']));
          ?>
          <tr>
            <td><?php echo $dayOfweek;?></td>
            <td> <?php echo $row['LAPTIME'];?>
            </td>
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
