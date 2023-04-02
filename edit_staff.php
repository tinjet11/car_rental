<?php
include 'session.php';
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="mainpage.css">
<link rel="stylesheet" href="form.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<script src="sidebar.js"></script>
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
        <li><a href="staff_dashboard.php"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
        <li><a href="vehicle_dashboard.php"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
      </ul>
    </div><!-- end of sidebar -->

    <div class="main_content" id="main_content">

      <div class="header" id="header">
        <button class="openbtn" id="openbtn" onclick="openNav()">☰ </button>
        Premier Car Rental Agency
        <div class="dropdown" style="float:right;">
          <button class="dropbtn"><i class="fa-solid fa-user"></i></button>
          <div class="dropdown-content">
            <a href="#"><i class="fa fa-home"></i> Profile </a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
          </div>
        </div>

      </div><!-- end of header-->
      <div id="table-container"> 
        <form method="post" enctype="multipart/form-data">
        <h1>Edit Staff</h1>

          <label for="staff_Id">Staff ID:</label>
          <input type="text" id="staff_id" name="staff_id" readonly>


          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required>

          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>

          <label for="role">Role:</label>
          <input type="text" id="role" name="role" required>

        
          <button type="submit" id="change" name="change">Submit</button>


          <a href="staff_dashboard.php">Back</a>
        </form>

        <script>
          //prevent form resubmission
          if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
          }

          function redirect() {
            window.location.replace("http://localhost/car_rental/staff_dashboard.php");
          }
          <?php


          //This part of code is fetch vehicle information from database
          $sid = $_GET["s_id"];


          $conn = new mysqli("localhost", "root", "", "car_rental");
          $value = $conn->query("SELECT username,name,role FROM admin WHERE staff_id = '$sid'");
          $values = $value->fetch_assoc();
          $user = $values["username"];
          $name = $values["name"];
          $role = $values["role"];
          echo "document.getElementById('staff_id').value = '$sid';";
          echo "document.getElementById('username').value = '$user';";
          echo "document.getElementById('name').value ='$name';";
          echo "document.getElementById('role').value = '$role' ;";

          $conn->close();
          ?>

          <?php
          $conn = new mysqli("localhost", "root", "", "car_rental");
          if (isset($_POST["change"])) {
            $sid = isset($_POST["staff_id"]) ? $_POST["staff_id"] : "";
            $user = isset($_POST["username"]) ? $_POST["username"] : "";
            $name = isset($_POST["name"]) ? $_POST["name"] : "";
            $role = isset($_POST["role"]) ? $_POST["role"] : "";

            // check if all required fields are filled
            if ($sid != "" && $user != "" && $name != "" && $role != "") {
              $sql = " UPDATE admin SET username = '$user',name = '$name',role = '$role' WHERE staff_id = '$sid';";
              if ($conn->query($sql) == true) {
                echo 'alert("Update Successful");';
                echo 'redirect();';
              } else {
                echo 'alert("Error: Problem Updating Data");';
              }
            } else {
              echo 'alert("Error: Please fill all required fields.");';
            }
          }
          $conn->close()
          ?>
        </script>
</body>

</html>