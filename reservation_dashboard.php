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
        <li><a href="#"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
      </ul>
    </div><!-- end of sidebar-->

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
          <h2>Reservation Dashboard</h2>
        </div>
        <div id="searchbar">

          <input type="text" id="search" onkeyup="filter()" placeholder="(Default:Reservation ID)" autocomplete="off">
          <select id="key">
            <option value="0" selected>Search by:</option>
            <option value="0">Reservation id</option>
            <option value="2">Customer name</option>
            <option value="3">Vehicle id</option>
          </select>

          <form method="post">
            <select id="sort" name="sort">
              <option value="0" selected>Sort by:</option>
              <option value="0">Reservation id Ascending</option>
              <option value="1">Booking Date Ascending</option>
              <option value="2">Booking Date Descending</option>
            </select>

            <button name="apply">Apply</button>
          </form>
        </div>
        <table id="table">



          <thead>
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
            //default
            $sort = "reservation_id ASC";

            if (isset($_POST["apply"])) {
              if ($_POST["sort"] == 1) {
                $sort = "booking_datetime ASC";
              } elseif ($_POST["sort"] == 2) {
                $sort = "booking_datetime DESC";
              } else {
                $sort = "reservation_id ASC";
              }
            }

            $conn = new mysqli("localhost", "root", "", "car_rental");

            $sql = "SELECT * from reservation ORDER BY $sort;";
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

              //if the car has already been pickup, disable the link
              if (is_null($exact_pt)) {
                $plink =  "pickup.php?r_id=" . $r_id;
                $rlink =  "#";
              } else {
                $plink = "#";
              }

              //if the car havent been pickup, disabled the return link
              //if the car has already been returned, disable the link
              if (is_null($exact_rt)) {
                $rlink =  "return.php?r_id=" . $r_id;
              } else {
                $rlink = "#";
              }


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
                $change_link = "change_reservation.php?r_id=".$r_id;
                $cancel_link = "cancel_reservation.php?r_id=".$r_id;
              } else if ($current_time <= $return_datetime && $current_time >= $booking_datetime) {
                $status = "<p class='status ongoing'> Ongoing </p>";
                $change_link = "#";
                $cancel_link = "#";
              } else {
                $status = "<p class='status completed'> Completed </p>";
                $change_link = "#";
                $cancel_link = "#";
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
                  <button onclick="window.location.href='<?php echo $change_link ?>'"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button onclick="window.location.href='<?php echo $cancel_link ?>'"><i class="fa-solid fa-trash"></i></button>
                </td>

                <td data-label="Pickup/Return">
                  <button onclick="window.location.href='<?php echo $plink ?>'"><i class="fa-solid fa-truck-pickup"></i></button>
                  <button onclick="window.location.href='<?php echo $rlink ?>'"><i class="fa-solid fa-rotate-left"></i></button>
                  
                </td>
              </tr>
            <?php  } ?>


          </tbody>
        </table>
      </div>
    </div><!-- end of main content-->
  </div><!-- end of container-->

  <script>
    //prevent form resubmission
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }

    function filter() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("search");
      filter = input.value.toUpperCase();
      table = document.getElementById("table");
      tr = table.getElementsByTagName("tr");
      select = document.getElementById("key").value;

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[select];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>
</body>

</html>