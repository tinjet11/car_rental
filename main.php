<?php
include 'session.php';
?>

<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="mainpage.css">
  <!--<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      list-style: none;
      text-decoration: none;
      font-family: sans-serif;
    }

    body {
      background-color: #FFFFFF;
    }

    .container {
      display: flex;
      flex-direction: row;
    }


    .sidebar {
      width: 0px;
      height: 100%;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background: #133A94;
      overflow-x: hidden;
      padding-top: 60px;
      transition: .2s;
      ;
    }



    .sidebar h2 {
      color: #fff;
      text-transform: uppercase;
      text-align: center;
      margin-bottom: 30px;
      font-size: 25;
    }

    .sidebar ul li {
      padding: 15px;
      border-bottom: 1px solid #bdb8d7;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sidebar ul li a {
      color: #FFFFFF;
      display: block;
    }

    i {
      padding-right: 10px;
    }

    .sidebar ul li a .fas {
      width: 25px;
    }

    .sidebar ul li:hover {
      background-color: #A5D8DD;
    }

    .sidebar ul li:hover a {
      color: #fff;
    }

    .main_content {
      width: 100%;
      max-width: 100%;
      margin-left: 0px;
      position: center;
      transition: margin-left .5s;
      flex-grow: 1;
      /* Allow content to grow and fill available space */
    }

    .main_content .header {
      padding: 20px;
      background: linear-gradient(90deg, hsla(222, 77%, 33%, 1) 0%, hsla(0, 100%, 78%, 1) 100%);
      color: #fdfff5;
      border-bottom: 2px solid #808080;
      text-align: center;
      font-size: 25px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .main_content .info {
      margin: 20px;
      color: #112A46;
      line-height: 25px;
    }

    .main_content .info div {
      margin-bottom: 20px;
    }

    .main_content .text {
      float: right;
      margin-right: lem;
      font-size: 15px;
      color: #112A46;
    }

    .text a {
      color: #fdfff5;
    }


    .sidebar .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
    }

    .openbtn {
      font-size: 20px;
      cursor: pointer;
      background-color: #111;
      color: white;
      padding: 10px 15px;
      border: none;
      float: left;
    }

    .openbtn:hover {
      background-color: #444;
    }
  </style>
  -->
</head>

<body>
  <div class="container">

    <div class="sidebar" id="sidebar">
      <h2>Menu</h2>
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
      <ul>

        <li><a href="main.php"><i class="fa-solid fa-house"></i>Home</a></li>
        <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation_Dashboard</a></li>
        <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
        <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer_Dashboard</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
      </ul>
    </div><!-- end of sidebar -->

    <div class="main_content" id="main_content">

      <div class="header" id="header">
        <button class="openbtn" id="openbtn" onclick="openNav()">☰ </button>
        Premier Car Rental Agency
        <div class="text">
          <a href="logout.php">
            Logout
          </a>
        </div>
        <div class="info">
        </div>

      </div><!-- end of header-->
<p>23</p>
    </div><!-- end of main content-->
  </div><!-- end of container-->

  <script>
    /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
    function openNav() {
      document.getElementById("sidebar").style.width = "250px";
      document.getElementById("main_content").style.marginLeft = "250px";
      // document.getElementById("header").style.width= "87%";
      document.getElementById("openbtn").style.display = "none";
    }

    /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
    function closeNav() {
      document.getElementById("sidebar").style.width = "0";
      document.getElementById("main_content").style.marginLeft = "0";
      //document.getElementById("header").style.width= "100%";
      document.getElementById("openbtn").style.display = "block";

    }

    window.addEventListener('resize', () => {
      if (window.innerWidth > 768) {
        document.getElementById("sidebar").style.width = "250px";
        document.getElementById("main_content").style.marginLeft = "250px";
      } else {
        document.getElementById("sidebar").style.width = "0";
        document.getElementById("main_content").style.marginLeft = "0";
      }
    });
  </script>
</body>

</html>