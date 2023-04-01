<!DOCTYPE html>
<html>
<script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

        <form method="post">
        <h1>Delete Vehicle</h1>
          <label for="reservation-id">Customer ID:</label>
          <input type="text" id="vehicle-id" name="vehicle-id" readonly>

          <button name="Delete"> Delete</button>
          <a href="vehicle_dashboard.php"> Back </a>
        </form>



        <script>
          //prevent form resubmission
          if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
          }

          function redirect() {
            window.location.replace("http://localhost/car_rental/vehicle_dashboard.php");
          }
          <?php

          $v_id = $_GET["v_id"];
          echo "document.getElementById('vehicle-id').value = '$v_id';";
          $conn = new mysqli("localhost", "root", "", "car_rental");
          if (isset($_POST["Delete"])) {
            if ($conn->query("DELETE FROM vehicle WHERE vehicle_id = '$v_id'") == TRUE) {
              $change = $conn->affected_rows;
              if ($change == 1) {
                echo "<body>$v_id is deleted</body>";
                echo 'redirect();';
              } else {
                echo "<body> $v_id does not exist </body>";
              }
            } else {

              echo "$v_id could not be deleted";
            }
          }
          $conn->close();
          ?>
        </script>

</html>