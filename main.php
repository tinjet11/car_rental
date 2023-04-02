<?php
include 'session.php';
?>

<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="mainpage.css">
  <link rel="stylesheet" href="dashboard.css">
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
            <a href="profile.php"><i class="fa fa-home"></i> Profile </a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
          </div>
        </div>

      </div><!-- end of header-->
      <div class="card-bigcontainer">
        <?php
        $conn = new mysqli("localhost", "root", "", "car_rental");
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        // Prepare the statement
        $stmt = $conn->prepare("SELECT * FROM vehicle");
        $stmt->execute();
        $result = $stmt->get_result();
        $vehicle_num = $result->num_rows;

        $stmt = $conn->prepare("SELECT * FROM customer");
        $stmt->execute();
        $result = $stmt->get_result();
        $customer_num = $result->num_rows;

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $current_time = date('Y-m-d H:i:s');
        $current_month = date('m');
        $current_year = date('Y');

        $stmt = $conn->prepare("SELECT * FROM reservation WHERE booking_datetime > '$current_time'");
        $stmt->execute();
        $result = $stmt->get_result();
        $upcomingReservation_num = $result->num_rows;

        $stmt = $conn->prepare("SELECT vehicle_id,duration FROM reservation WHERE month(booking_datetime) = '$current_month' AND year(booking_datetime) = '$current_year'");
        $stmt->execute();
        $result = $stmt->get_result();
        $reservation_num_of_currentmonth = $result->num_rows;
        $revenue = 0;
        while ($reserverow = $result->fetch_assoc()) {
          $stmt =  $conn->prepare("SELECT price FROM Vehicle WHERE vehicle_id= ?");
          $stmt->bind_param("s", $reserverow["vehicle_id"]);
          $stmt->execute();
          $vehicleresult =  $stmt->get_result();
          $vehiclerow = $vehicleresult->fetch_assoc();
          $revenue += $vehiclerow["price"] * $reserverow["duration"];
        }
        ?>
        <div class="card-body color1">
          <div class="float-left">
            <h3>
              <span class="count"><?php echo $vehicle_num; ?></span>
            </h3>
            <p>Total vehicle</p>
          </div>
          <div class="float-right">
            <i class="fa-solid fa-car"></i>
          </div>
        </div>
        <div class="card-body color2">
          <div class="float-left">
            <h3>
              <span class="count"><?php echo $customer_num; ?></span>
            </h3>
            <p>Customers</p>
          </div>
          <div class="float-right">
            <i class="fa-solid fa-user-group"></i>
          </div>
        </div>
        <div class="card-body color3">
          <div class="float-left">
            <h3>
              <span class="count"><?php echo $upcomingReservation_num; ?></span>
            </h3>
            <p>Upcoming Reservation</p>
          </div>
        </div>
        <div class="card-body color1">
          <div class="float-left">
            <h3>
              <span class="count">RM <?php echo $revenue; ?></span>
            </h3>
            <p>Total Revenue This Month</p>
           
          </div>
        </div>
        <div class="card-body color2">
          <div class="float-left">
            <h3>
              <span class="count"><?php echo $reservation_num_of_currentmonth; ?></span>
            </h3>
            <p>Total reservation this month</p>
          </div>
        </div>
      </div>

      <table id="table">
        <thead>
          <tr id="mainheader">
            <th colspan="12">
              Incoming reservation
            </th>
          </tr>
          <tr>
            <th>Reservation ID</th> <!--reservation -->
            <th>Customer ID</th> <!--reservation -->
            <th>Customer Name</th> <!--customer -->
            <th>Vehicle ID</th> <!--reservation -->
            <th>Vehicle Type</th> <!--vehicle -->
            <th>Booking Datetime</th> <!--reservation -->
            <th>Return Datetime</th> <!--reservation -->
            <th>Duration</th> <!--reservation -->
            <th>Amount to Pay</th> <!--vehicle -->
            <th>Status</th>
            <th>Action</th>
            <th>Pickup/return</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $conn = new mysqli("localhost", "root", "", "car_rental");
          $current_time = date('Y-m-d H:i:s');

          $sql = "SELECT * FROM reservation WHERE booking_datetime > '$current_time' ORDER BY booking_datetime ASC LIMIT 5;";

          $result = $conn->query($sql);

          while ($DataRows = $result->fetch_assoc()) {
            $r_id = $DataRows["reservation_id"];
            $c_id = $DataRows["customer_id"];
            $v_id = $DataRows["vehicle_id"];
            $booking_datetime = $DataRows["booking_datetime"];
            $return_datetime = $DataRows["return_datetime"];
            $duration = $DataRows["duration"];
            $exact_pt = $DataRows["exact_pickup_datetime"];
            $exact_rt = $DataRows["exact_return_datetime"];

            //query to select firstname and lastname from customer database
            $sql1 = "SELECT First_name, Last_name FROM customer where customer_id = '$c_id'";
            $result1 = $conn->query($sql1);
            $DataRows1 = $result1->fetch_assoc();

            $customername =  $DataRows1["First_name"] . ' ' . $DataRows1["Last_name"];

            $sql2 = "SELECT model,color,price FROM Vehicle WHERE vehicle_id='$v_id'";
            $result2 = $conn->query($sql2);

            $DataRows2 = $result2->fetch_assoc();
            $amount = (int)($DataRows2["price"]) * $duration;
            $vehicle_description = $DataRows2["model"] . '(' . $DataRows2["color"] . ')';
            date_default_timezone_set('Asia/Kuala_Lumpur');

            $current_time = date('Y-m-d H:i:s');

            if ($current_time < $booking_datetime) {
              $status = "<p class='status pending'> Pending </p>";
            } else if ($current_time <= $return_datetime && $current_time >= $booking_datetime) {
              $status = "<p class='status ongoing'> Ongoing </p>";
            } else {
              $status = "<p class='status completed'> Completed </p>";
            }

          ?>
            <tr>
              <td data-label="Reservation ID"><?php echo $r_id; ?></td>
              <td data-label="Customer ID"><?php echo $c_id; ?></td>
              <td data-label="Customer Name"><?php echo $customername; ?></td>
              <td data-label="Vehicle ID"><?php echo $v_id; ?></td>
              <td data-label="Vehicle Type"><?php echo $vehicle_description; ?></td>
              <td data-label="Booking Datetime"><?php echo $booking_datetime; ?></td>
              <td data-label="Return Datetime"><?php echo $return_datetime; ?></td>
              <td data-label="Duration"><?php echo $duration; ?></td>
              <td data-label="Amount to pay"><?php echo 'RM ' . $amount; ?></td>
              <td data-label="Status"><?php echo $status; ?></td>
              <td data-label="Action">
                <button onclick="window.location.href='change_reservation.php?r_id=<?php echo $r_id ?>'"><i class="fa-solid fa-pen-to-square"></i></button>
                <button onclick="window.location.href='cancel_reservation.php?r_id=<?php echo $r_id ?>'"><i class="fa-solid fa-trash"></i></button>
              </td>

              <td data-label="Pickup/Return">
                <button onclick="window.location.href='<?php echo $plink ?>'"><i class="fa-solid fa-truck-pickup"></i></button>
                <button onclick="window.location.href='<?php echo $rlink ?>'"><i class="fa-solid fa-rotate-left"></i></button>

              </td>
            </tr>
          <?php  } ?>


        </tbody>
      </table>

      <table id="table">
        <thead>
          <tr id="mainheader">
            <th colspan="12">
              New Customer
            </th>
          </tr>
          <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>IC NO</th>
            <th>Gender</th>
            <th>Birthdate</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $conn = new mysqli("localhost", "root", "", "car_rental");

          //query to select firstname and lastname from customer database
          $sql = "SELECT * FROM customer ORDER BY customer_id DESC LIMIT 5";
          $result = $conn->query($sql);
          while ($DataRows = $result->fetch_assoc()) {
            $c_id = $DataRows["customer_id"];
            $customername =  $DataRows["First_name"] . ' ' . $DataRows["Last_name"];
            $ic = $DataRows["IC_NO"];
            $gender = $DataRows["Gender"];
            $birthdate = $DataRows["Birthdate"];
            $phone_number = $DataRows["Phone_Number"];
            $email = $DataRows["Email"];
            $address = $DataRows["Address"];

          ?>
            <tr>
              <td data-label="Customer ID"><?php echo $c_id; ?></td>
              <td data-label="Customer Name"><?php echo $customername; ?></td>
              <td data-label="IC"><?php echo $ic; ?></td>
              <td data-label="Gender"><?php echo $gender; ?></td>
              <td data-label="Birthdate"><?php echo $birthdate; ?></td>
              <td data-label="Phone Number"><?php echo $phone_number; ?></td>
              <td data-label="Email"><?php echo $email; ?></td>
              <td data-label="Address"><?php echo $address; ?></td>
              <td data-label="Action">
                <button onclick="window.location.href='change_customer.php?c_id=<?php echo $c_id ?>'"><i class="fa-solid fa-pen-to-square"></i></button>
                <button onclick="window.location.href='delete_customer.php?c_id=<?php echo $c_id ?>'"><i class="fa-solid fa-trash"></i></button>
              </td>
            </tr>
          <?php  } ?>


        </tbody>
      </table>
      </table>


    </div><!-- end of main content-->
  </div><!-- end of container-->



</body>

</html>