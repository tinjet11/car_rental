<?php
  session_start();
  if((time() - $_SESSION['timelimit']) > 10)
  {
    header("location:logout.php");
  }
  else
  {
    $_SESSION['timelimit'] = time();
    //echo "<p align='left'>Welcome ".$_SESSION["user"]. "</h1>";
  }
?>
<html>
<header>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <style>
      *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        list-style: none;
        text-decoration: none;
        font-family: sans-serif;
      }

      body{
         background-color: #f3f5f9;
      }

      .wrapper{
        display: flex;
        position: relative;
      }

      .wrapper .sidebar{
        width: 250px;
        height: 100%;
        background: #301934;
        padding: 30px 0px;
        position: fixed;
      }

      .wrapper .sidebar h2{
        color: #fff;
        text-transform: uppercase;
        text-align: center;
        margin-bottom: 30px;
        font-size:25;
      }

      .wrapper .sidebar ul li{
        padding: 15px;
        border-bottom: 1px solid #bdb8d7;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        border-top: 1px solid rgba(255,255,255,0.05);
      }    

      .wrapper .sidebar ul li a{
        color: #bdb8d7;
        display: block;
      }

      .wrapper .sidebar ul li a .fas{
        width: 25px;
      }

      .wrapper .sidebar ul li:hover{
        background-color: #594f8d;
      }
          
      .wrapper .sidebar ul li:hover a{
        color: #fff;
      }

      .wrapper .main_content{
        width: 100%;
        margin-left: 250px;
        position: center;
      }

      .wrapper .main_content .header{
        padding: 20px;
        background: #fff;
        color: #717171;
        border-bottom: 2px solid #808080;
        text-align: center;
        font-size: 25px;
        font-weight: bold;
      }

      .wrapper .main_content .info{
        margin: 20px;
        color: #717171;
        line-height: 25px;
      }

      .wrapper .main_content .info div{
        margin-bottom: 20px;
      }
      .wrapper .main_content .text{
        float: right;
        margin-right: lem;
        font-size: 15px;
      }
  </style>
</header>
<div class="wrapper">
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="main.html"><i class="fa-solid fa-house"></i>   Home</a></li>
            <li><a href="nr.html"><i class="fa-sharp fa-solid fa-file"></i>   New Reservation</a></li>
            <li><a href="ur.html"><i class="fa-sharp fa-solid fa-pen-to-square"></i>   Update Reservation</a></li>
            <li><a href="dr.html"><i class="fa-sharp fa-solid fa-trash"></i>   Cancel Reservation</a></li>
            <li><a href="uc.html"><i class="fa-sharp fa-solid fa-file-pen"></i>   Update Customer Details</a></li>
            <li><a href="#"><i class="fa-solid fa-car"></i>   Check Car Reservations</a></li>
            <li><a href="#"><i class="fa-sharp fa-solid fa-eye"></i>   Cars Available</a></li>
            <li><a href="#"><i class="fa-sharp fa-solid fa-database"></i>   Check Car Database</a></li>
        </ul> 
    </div>
    <div class="main_content">
      <div class="header">Premier Car Rental Agency 
        <div class="text">
          <a href="logout.php">
          Logout
          </a>
        </div>
        <div class="info">
        </div>
      </div>
    </div>
<body>
</body>
</html>
