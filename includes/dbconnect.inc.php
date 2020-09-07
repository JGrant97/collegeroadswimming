<?php
  //connect to mysql database
  //$con = mysqli_connect('localhost', 'username', 'password') or die("Connection Failed" .
  //mysqli_error($con));

  $servername = "localhost";
  $username = "jackg97";
  $password = "uZZYTPHHsctPz47o";
  $databasename = "swimclub";

  $con =  mysqli_connect($servername, $username, $password, $databasename);
  // Check connection
  if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
  }
