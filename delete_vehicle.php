<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <link rel="stylesheet" href="form.css">
  <link rel="stylesheet" href="mainpage.css">
  <script src="sidebar.js"></script>
</head>

<body>
  <!-- Container -->
  <div class="container">

    <!-- Sidebar -->
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

    <!-- Main content -->
    <div class="main_content" id="main_content">

      <!-- Header -->
      <div class="header" id="header">
        <button class="openbtn" id="openbtn" onclick="openNav()">☰ </button>
        Premier Car Rental Agency
        <div class="dropdown" style="float:right;">
          <button class="dropbtn"><i class="fa-solid fa-user"></i>
            <p><?php echo $name; ?></p>
          </button>
          <div class="dropdown-content">
            <a href="profile.php"><i class="fa fa-home"></i> Profile </a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
          </div>
        </div>

      </div><!-- end of header-->

      <h1>Delete Vehicle</h1>
      <form method="post">

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
        //redirect to specific page after action
        function redirect() {
          window.location.replace("http://localhost/car_rental/vehicle_dashboard.php");
        }
        <?php
        //Using GET method to get the vehicle id
        $v_id = $_GET["v_id"];

        //display vehicle id in the form
        echo "document.getElementById('vehicle-id').value = '$v_id';";

        if (isset($_POST["Delete"])) {

          //open connection
          $conn = new mysqli("localhost", "root", "", "comp1044_database");

          $sql  = $conn->query("DELETE FROM vehicle WHERE vehicle_id = '$v_id'");

          if ($conn->query($sql) === TRUE) {

            $change = $conn->affected_rows;

            if ($change == 1) {
              echo "alert('Delete Sucessful');";
              echo 'redirect();';
            } else {
              echo "alert('Error')";
            }
          } else {
            echo "alert('Error')";
          }
        }

        //close connection
        $conn->close();
        ?>
      </script>
</body>

</html>