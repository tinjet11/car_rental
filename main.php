<?php
  session_start();
  if((time() - $_SESSION['timelimit']) > 1000)
  {
    header("location:logout.php");
  }
  else
  {
    $_SESSION['timelimit'] = time();
    echo "<p align='left'>Welcome ".$_SESSION['staffid']. "</h1>";
  }
?>

<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="mainpage.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="main.php"><i class="fa-solid fa-house"></i>Home</a></li>
                <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation_Dashboard</a></li>
                <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
                <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer_Dashboard</a></li>
                <li><a href="#"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
                <li><a href="#"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
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
    </div>
</body>

</html>

