<?php
include 'session.php';
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="mainpage.css">
  <link rel="stylesheet" href="dashboard.css">

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
        <div class="title">
          <h2>Staff Dashboard</h2>
        </div>
        <table id="table">
          <thead>
            <tr>
              <th>Staff ID</th>
              <th>Username</th>
              <th>Name</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $conn = new mysqli("localhost", "root", "", "car_rental");
          $sql = "SELECT staff_id,username,name,role FROM admin";
          $result = $conn->query($sql);
          while ($validdata = $result->fetch_assoc()) {
            $s_id = $validdata["staff_id"];
            $username = $validdata["username"];
            $name = $validdata["name"];
            $role = $validdata["role"];
          ?>
            <tr>
              <td data-label="Staff ID"><?php echo $s_id; ?></td>
              <td data-label="UserName"><?php echo $username; ?></td>
              <td data-label="Name"><?php echo $name; ?></td>
              <td data-label="Role"><?php echo $role; ?></td>

              <td data-label="Action">
                <button onclick="window.location.href='edit_staff.php?s_id=<?php echo $s_id ?>'"><i class="fa-solid fa-pen-to-square"></i></button>
                <button onclick="window.location.href='delete_staff.php?s_id=<?php echo $s_id ?>'"><i class="fa-solid fa-trash"></i></button>
              </td>
            </tr>
          <?php }
          $conn->close();
          ?>
          <tr>
            <td>
              <a href="add_staff.php">Add</a>
            </td>
          </tr>
          </tbody>
        </table>