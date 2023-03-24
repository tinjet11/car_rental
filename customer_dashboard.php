<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
  <link rel="stylesheet" href="mainpage.css">

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
        <option value="0">Customer id</option>
        <option value="1">Customer name</option>
        <option value="2">IC No</option>
      </select>
      <table id="customer_table">
        <thead>
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
          $sql = "SELECT * FROM customer";
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
              <td><?php echo $c_id; ?></td>
              <td><?php echo $customername; ?></td>
              <td><?php echo $ic; ?></td>
              <td><?php echo $gender; ?></td>
              <td><?php echo $birthdate; ?></td>
              <td><?php echo $phone_number; ?></td>
              <td><?php echo $email; ?></td>
              <td><?php echo $address; ?></td>
              <td><a href="change_customer.php?c_id=<?php echo $c_id ?>" role="button" aria-disabled="true">edit</a>
                <a href="delete_customer.php?c_id=<?php echo $c_id ?>" role="button" aria-disabled="true">delete
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
      table = document.getElementById("customer_table");
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