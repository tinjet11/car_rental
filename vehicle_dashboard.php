<?php
include 'session.php';
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="mainpage.css">
  <link rel="stylesheet" href="dashboard.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="sidebar.js"></script>
</head>

<body>
<?php
  //default
  $sort = "vehicle_id ASC"; //Data stored in vehicle_id will be sorted in ascending order
  $display_sort = "Vehicle ID with Ascending Order";

  if (isset($_POST["apply"])) { //checks if the apply button is clicked in the form
    if ($_POST["sort"] == 1) { 
      $sort = "vehicle_id DESC"; //If the value of sort = 1, the sort variable is updated to vehicle_id sorted in descending order
      $display_sort = "Vehicle ID with Descending Order";
    }else if($_POST["sort"] == 2){
      $sort = "Price ASC"; //If value of sort = 2, the sort variable is updated to price sorted in ascending order
      $display_sort = "Price From Low to High";
    }else if($_POST["sort"] == 3){
      $sort = "price DESC"; //If the value of sort = 3, the sort variable is updated to price sorted in descending order
      $display_sort = "Price From High to Low";
    }else {
      $sort = "vehicle_id ASC"; //Else the vehicle_id will be sorted in ascending order
      $display_sort = "Vehicle ID with Ascending Order";
    }
  }
  ?>
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
        <div id="searchbar">

          <input type="text" id="search" onkeyup="filter()" placeholder="Type Vehicle ID..." autocomplete="off">
          <select id="key" onchange="key_placeholder()">
            <option value="0" selected>Search by:</option>
            <option value="0">Vehicle ID</option>
            <option value="1">Vehicle Model</option>
            <option value="2">Vehicle Type</option>
            <option value="3">Vehicle Color</option>
          </select>

          <form method="post" style="margin-left: 30px;">
            <select id="sort" name="sort">
              <option value="0" selected>Sort by:</option>
              <option value="0">Vehicle ID Ascending</option>
              <option value="1">Vehicle ID Descending</option>
              <option value="2">Price From Low to High</option>
              <option value="3">Price From High to Low</option>
            </select>

            <button name="apply">Apply Sorting</button>
          </form>
        </div>
        <span>
          <p1>Table sort by: <?php echo $display_sort; ?></p1>
        </span>
        <table id="table">
          <thead>
            <td><a href="add_vehicle.php">New Vehicle</a></td>
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
            //open connection
            $conn = new mysqli("localhost", "root", "", "car_rental");

            //select vehicle data from database 
            $sql = "SELECT vehicle_id,model,type,color,price FROM vehicle ORDER BY $sort";
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

     //change the input placeholder while user select search key
    function key_placeholder() {
      select = document.getElementById("key").value;
      if (select == "0") {
        document.getElementById("search").placeholder = "Type Vehicle ID...";
      } else if (select == "1") {
        document.getElementById("search").placeholder = "Type Vehicle Model...";
      }else if (select == "2") {
        document.getElementById("search").placeholder = "Type Vehicle Type...";
      } else if (select == "3") {
        document.getElementById("search").placeholder = "Type Vehicle Color...";
      }
    }

    // function to filter the table content while searching
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