<!DOCTYPE html>
<html>

<head>  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="mainpage.css">
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th,
    td {
      text-align: center;
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    th {
      background-color: #4CAF50;
      color: white;
    }

    td:nth-child(2),
    td:nth-child(8) {
      text-align: center;
    }

    td:nth-child(1),
    td:nth-child(2) {
      font-weight: bold;
    }

    #search {
      background-image: url('/css/searchicon.png');
      /* Add a search icon to input */
      background-position: 10px 12px;
      /* Position the search icon */
      background-repeat: no-repeat;
      /* Do not repeat the icon image */
      width: 100%;
      /* Full-width */
      font-size: 16px;
      /* Increase font-size */
      padding: 12px 20px 12px 40px;
      /* Add some padding */
      border: 1px solid #ddd;
      /* Add a grey border */
      margin-bottom: 12px;
      /* Add some space below the input */
    }
    .i {
    margin-right: 100px;
     }
  </style>
</head>

<body>
<div class="wrapper">
        <div class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="main.html"><i class="fa-solid fa-house"></i>   Home</a></li>
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
            

  <input type="text" id="search" onkeyup="filter()" placeholder="Search" autocomplete="off">
  <select id="key">
    <option value="0" selected>Search by:</option>
    <option value="0">Reservation id</option>
    <option value="2">Customer name</option>
  </select>

  <table id="reservation_table">
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

      $conn = new mysqli("localhost", "root", "", "car_rental");

      $sql = "SELECT * from reservation";
      $result = $conn->query($sql);

      while ($DataRows = $result->fetch_assoc()) {
        $r_id = $DataRows["reservation_id"];
        $c_id = $DataRows["customer_id"];
        $v_id = $DataRows["vehicle_id"];
        $booking_datetime = $DataRows["booking_datetime"];
        $return_datetime = $DataRows["return_datetime"];
        $duration = $DataRows["duration"];

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
          $status = "Pending";
        } else if ($current_time <= $return_datetime && $current_time >= $booking_datetime) {
          $status = "Ongoing";
        } else {
          $status = "Past";
        }

      ?>
        <tr>
          <td><?php echo $r_id; ?></td>
          <td><?php echo $c_id; ?></td>
          <td><?php echo $customername; ?></td>
          <td><?php echo $v_id; ?></td>
          <td><?php echo $vehicle_description; ?></td>
          <td><?php echo $booking_datetime; ?></td>
          <td><?php echo $return_datetime; ?></td>
          <td><?php echo $duration; ?></td>
          <td><?php echo 'RM ' . $amount; ?></td>
          <td><?php echo $status; ?></td>
          <td><a href="change_reservation.php?r_id=<?php echo $r_id ?>" role="button" aria-disabled="true">edit</a>
            <a href="cancel_reservation.php?r_id=<?php echo $r_id ?>" role="button" aria-disabled="true">delete
          </td>
          <td>
            <a href="pickup.php?r_id=<?php echo $r_id ?>" role="button" aria-disabled="true">pickup
              <a href="return.php?r_id=<?php echo $r_id ?>" role="button" aria-disabled="true">return
          </td>

        </tr>
      <?php  } ?>


    </tbody>
  </table>
        </div>
</div>

  <script type="text/javascript">
    //prevent form resubmission
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }



    function filter() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("search");
      filter = input.value.toUpperCase();
      table = document.getElementById("reservation_table");
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