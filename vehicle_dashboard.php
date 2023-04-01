<!DOCTYPE html>
<html>

<head>
  <script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
          <h2>Vehicle Dashboard</h2>
        </div>


        <table id="table">
          <thead>
            <tr>
              <th>Vehicle ID</th>
              <th>Model</th>
              <th>Type</th>
              <th>Color</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "car_rental");
            $sql = "SELECT vehicle_id,model,type,color,price FROM vehicle";
            $result = $conn->query($sql);
            while ($validdata = $result->fetch_assoc()) {
              $v_id = $validdata["vehicle_id"];
              $model = $validdata["model"];
              $type = $validdata["type"];
              $color = $validdata["color"];
              $price = $validdata["price"];
            ?>
              <tr>
                <td data-label="Vehicle ID"><?php echo $v_id; ?></td>
                <td data-label="Vehicle Model"><?php echo $model; ?></td>
                <td data-label="Vehicle Type"><?php echo $type; ?></td>
                <td data-label="Vehicle Color"><?php echo $color; ?></td>
                <td data-label="Vehicle Price ">RM <?php echo $price; ?></td>
                <td data-label="Action">
                  <button onclick="window.location.href='edit_vehicle.php?v_id=<?php echo $v_id ?>'"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button onclick="window.location.href='delete_vehicle.php?v_id=<?php echo $v_id ?>'"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
            <?php }
            $conn->close();
            ?>
            <tr>
              <td>
                <a href="add_vehicle.php">Add</a>
              </td>
            </tr>
          </tbody>
        </table>

</html>