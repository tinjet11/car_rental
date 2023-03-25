<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="mainpage.css">
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    table thead th {
      position: sticky;
      z-index: -1;
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

    /* Style for the search input */
    #search {
      padding: 10px;
      width: 300px;
      border: none;
      border-radius: 5px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
      font-size: 16px;
      color: #333;
      background-color: #f5f5f5;
    }

    /* Style for the search dropdown */
    #key {
      padding: 10px;
      border: none;
      border-radius: 5px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
      font-size: 16px;
      color: #333;
      background-color: #f5f5f5;
      margin-left: 10px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="sidebar">
      <h2>Menu</h2>
      <ul>
        <li><a href="main.php"><i class="fa-solid fa-house"></i>Home</a></li>
        <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation_Dashboard</a></li>
        <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
        <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer_Dashboard</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
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
        <option value="3">Vehicle id</option>
      </select>

      <form method="post">
      <select id="sort" name="sort">
        <option value="0" selected>Sort by:</option>
        <option value="0">Reservation id Ascending</option>
        <option value="1">Booking Date Ascending</option>
        <option value="2">Booking Date Descending</option>
      
      </select>
      <button name ="apply">Apply</button>
      </form>

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
          //default
          $sort = "reservation_id ASC";
          
          if(isset($_POST["apply"])){
            if($_POST["sort"] == 1){
             $sort = "booking_datetime ASC";
            }elseif($_POST["sort"] == 2){
              $sort = "booking_datetime DESC";
            }else{
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

    function toggleSidebar() {
      var sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('collapsed');
    }

    window.addEventListener('resize', function(event) {
      var width = window.innerWidth;
      var sidebar = document.querySelector('.sidebar');
      var toggleBtn = document.querySelector('.toggle-sidebar-btn');
      if (width <= 768 && !sidebar.classList.contains('collapsed')) {
        sidebar.classList.add('collapsed');
        toggleBtn.style.display = 'block';
      } else if (width > 768 && sidebar.classList.contains('collapsed')) {
        sidebar.classList.remove('collapsed');
        toggleBtn.style.display = 'none';
      }
    });
  </script>
</body>

</html>