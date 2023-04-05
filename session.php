<?php
  session_start();
  if((time() - $_SESSION['timelimit']) > 1000) //If time is greater than 1000 seconds then the session will be destroyed and user will be redirected to logout.php
  {
    header("location:logout.php");
    session_destroy(); //Removes all session data
  }
  else
  {
    $_SESSION['timelimit'] = time();
    //echo "<p align='left'>Welcome ".$_SESSION['staffid']. "</h1>";
    $staffid = $_SESSION['staffid'];
    $name = $_SESSION["name"];
  }
?>
