<?php
  session_start();
  if((time() - $_SESSION['timelimit']) > 1000)
  {
    header("location:logout.php");
    session_destroy();
  }
  else
  {
    $_SESSION['timelimit'] = time();
    //echo "<p align='left'>Welcome ".$_SESSION['staffid']. "</h1>";
    $staffid = $_SESSION['staffid'];
  }
?>