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
          <button class="dropbtn"><i class="fa-solid fa-user"></i>
            <p><?php echo $name; ?></p>
          </button>
          <div class="dropdown-content">
            <a href="profile.php"><i class="fa fa-home"></i> Profile </a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
          </div>
        </div>

      </div><!-- end of header-->
      <div class="card-bigcontainer">
        <?php
        $conn = new mysqli("localhost", "root", "", "car_rental"); // Connection to database
        if ($conn->connect_error) { // Check for error connecting to database
          die("Connection failed: " . $conn->connect_error);
        }
        // Prepare the statement
        $stmt = $conn->prepare("SELECT * FROM vehicle"); // Prepares SQL statement to select all rows from vehicle table
        $stmt->execute(); // Execute the SQL statement
        $result = $stmt->get_result(); // Retrieves result from executed statement
        $vehicle_num = $result->num_rows; // Counts the rows in result

        $stmt = $conn->prepare("SELECT * FROM customer"); // Prepares SQL statement to select all rows from vehicle table
        $stmt->execute(); // Execute the SQL statement
        $result = $stmt->get_result(); // Retrieves result from executed statement
        $customer_num = $result->num_rows; // Counts the rows in result

        date_default_timezone_set('Asia/Kuala_Lumpur'); // Sets default timezone 
        $current_time = date('Y-m-d H:i:s'); // Formats current date and time
        $current_month = date('m'); // Gets current month
        $current_year = date('Y'); // Gets current year

        $stmt = $conn->prepare("SELECT * FROM reservation WHERE booking_datetime > '$current_time'"); // Prepares SQL statement to select all rows from vehicle table
        $stmt->execute(); // Execute the SQL statement
        $result = $stmt->get_result(); // Retrieves result from executed statement
        $upcomingReservation_num = $result->num_rows; // Counts the rows in result

        $stmt = $conn->prepare("SELECT vehicle_id,duration FROM reservation WHERE month(booking_datetime) = '$current_month' AND year(booking_datetime) = '$current_year'"); // SQL statement to retrieve vehicleid and duration from reservation table but only for the rows that match the month and year and booking datetime.
        $stmt->execute(); // Query is executed
        $result = $stmt->get_result(); // Retrieves result from executed statement
        $reservation_num_of_currentmonth = $result->num_rows; // Number of rows in result is stored 
        $revenue = 0; // Revenue variable set to 0
        while ($reserverow = $result->fetch_assoc()) { // Loop retrieves each row from the result 
          $stmt =  $conn->prepare("SELECT price FROM Vehicle WHERE vehicle_id= ?"); // SQL statement to retrieve price from vehicle table where vehicleid matches vehicleid in current row
          $stmt->bind_param("s", $reserverow["vehicle_id"]); // Binds vechicleid value from current row to a prepared statement
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

          $sql = "SELECT * FROM reservation WHERE booking_datetime > '$current_time' ORDER BY booking_datetime ASC LIMIT 5;"; // SQL Query to select all reservations from database that have a booking_datime greater than current time. Ordered by booking_datetime in ascending order and limited to 5 results.

          $result = $conn->query($sql);

          while ($DataRows = $result->fetch_assoc()) {
            $r_id = $DataRows["reservation_id"]; //Extract the data and assigned to variables
            $c_id = $DataRows["customer_id"];
            $v_id = $DataRows["vehicle_id"];
            $booking_datetime = $DataRows["booking_datetime"];
            $return_datetime = $DataRows["return_datetime"];
            $duration = $DataRows["duration"];
            $exact_pt = $DataRows["exact_pickup_datetime"];
            $exact_rt = $DataRows["exact_return_datetime"];

            //query to select firstname and lastname from customer database
            $sql1 = "SELECT First_name, Last_name FROM customer where customer_id = '$c_id'"; // SQL Query to select First Name and Last Name from Customer 
            $result1 = $conn->query($sql1);
            $DataRows1 = $result1->fetch_assoc();

            $customername =  $DataRows1["First_name"] . ' ' . $DataRows1["Last_name"]; // Customer name is received by concatenating the first and last name

            $sql2 = "SELECT model,color,price FROM Vehicle WHERE vehicle_id='$v_id'"; // SQL query that selects the model, color, and price of the vehicle
            $result2 = $conn->query($sql2);

            $DataRows2 = $result2->fetch_assoc();
            $amount = (int)($DataRows2["price"]) * $duration;
            $vehicle_description = $DataRows2["model"] . '(' . $DataRows2["color"] . ')';
            date_default_timezone_set('Asia/Kuala_Lumpur');

            $current_time = date('Y-m-d H:i:s');

            if ($current_time < $booking_datetime) { // If current time is before booking datetime then the reservation will be in pending status
              $status = "<p class='status pending'> Pending </p>";
            } else if ($current_time <= $return_datetime && $current_time >= $booking_datetime) { // Else if current time is between booking and return datetime then the reservation will be in ongoing status
              $status = "<p class='status ongoing'> Ongoing </p>";
            } else {
              $status = "<p class='status completed'> Completed </p>"; // Else then it will be in Completed status
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
                <div>
                  <button onclick="window.location.href='change_reservation.php?r_id=<?php echo $r_id ?>'"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button onclick="window.location.href='cancel_reservation.php?r_id=<?php echo $r_id ?>'"><i class="fa-solid fa-trash"></i></button>
                </div>
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