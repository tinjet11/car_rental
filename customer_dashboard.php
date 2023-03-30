<?php
include 'session.php';
?>

<html>

<head>
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
          <h2>Customer Dashboard</h2>
        </div>
        <div id="searchbar">
          <input type="text" id="search" onkeyup="filter()" placeholder="Default:Customer ID" autocomplete="off">
          <select id="key">
            <option value="0" selected>Search by:</option>
            <option value="0">Customer id</option>
            <option value="1">Customer name</option>
            <option value="2">IC No</option>
          </select>

          <form method="post">
            <select id="sort" name="sort">
              <option value="0" selected>Sort by:</option>
              <option value="0">Customer id Ascending</option>
              <option value="1">Customer id Descending</option>
              <option value="2">Name Ascending</option>
              <option value="3">Name Descending</option>

            </select>
            <button name="apply">Apply</button>
          </form>
        </div>

        <table id="table">
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
            //default
            $sort = "customer_id ASC";

            if (isset($_POST["apply"])) {
              if ($_POST["sort"] == 1) {
                $sort = "customer_id DESC";
              } elseif ($_POST["sort"] == 2) {
                $sort = "Last_name ASC";
              } elseif ($_POST["sort"] == 3) {
                $sort = "Last_name DESC";
              } else {
                $sort = "customer_id ASC";
              }
            }

            $conn = new mysqli("localhost", "root", "", "car_rental");

            //query to select firstname and lastname from customer database
            $sql = "SELECT * FROM customer ORDER BY $sort";
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
                <td data-label="Action"><a href="change_customer.php?c_id=<?php echo $c_id ?>" role="button" aria-disabled="true">edit</a>
                  <a href="delete_customer.php?c_id=<?php echo $c_id ?>" role="button" aria-disabled="true">delete
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
      } //end for loop
    }
  </script>
</body>

</html>