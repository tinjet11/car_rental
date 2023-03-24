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
<header>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="mainpage.css">
</header>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="main.php"><i class="fa-solid fa-house"></i>   Home</a></li>
                <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>reservation_dashboard</a></li>
                <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
                <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>customer_dashboard</a></li>
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
</body>

</html>

