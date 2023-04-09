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
  $sort = "staff_id ASC";
  $display_sort = "Staff ID with Ascending Order";

  if (isset($_POST["apply"])) {
    if ($_POST["sort"] == 1) {
      $sort = "staff_id DESC";
      $display_sort = "Staff ID with Descending Order";
    } else {
      $sort = "staff_id ASC";
      $display_sort = "Staff ID with Ascending Order";
    }
  }
  ?>
  <div class="container">

    <div class="sidebar" id="sidebar">
      <h2>Menu</h2>
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
      <ul>
        <li><a href="main.php"><i class="fa-solid fa-house"></i>Home</a></li>
        <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
        <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation Dashboard</a></li>

        <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer Dashboard</a></li>
        <li><a href="staff_dashboard.php"><i class="fa-sharp fa-solid fa-eye"></i>Admin Dashboard</a></li>
        <li><a href="vehicle_dashboard.php"><i class="fa-sharp fa-solid fa-database"></i>Vehicle Dashboard</a></li>
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
      <div id="table-container">
        <div class="title">
          <h2>Staff Dashboard</h2>
        </div>
        <div id="searchbar">

          <input type="text" id="search" onkeyup="filter()" placeholder="Type Staff ID..." autocomplete="off">
          <select id="key" onchange="key_placeholder()">
            <option value="0" selected>Search by:</option>
            <option value="0">Staff ID</option>
            <option value="1">Staff Name</option>
            <option value="2">Role</option>
          </select>

          <form method="post" style="margin-left: 30px;">
            <select id="sort" name="sort">
              <option value="0" selected>Sort by:</option>
              <option value="0">Staff ID Ascending</option>
              <option value="1">Staff ID Descending</option>
            </select>

            <button name="apply">Apply Sorting</button>
          </form>
        </div>
        <span>
          <p1>Table sort by: <?php echo $display_sort; ?></p1>
        </span>

        <?php
        if ($role == "HR" || $role == "Manager") {
          $addlink = "<td><a href='add_staff.php'>New Staff</a></td>";
        }else{
          $addlink = "";
        }
        ?>

        <table id="table">
          <thead>
           <?php echo $addlink; ?>
            <tr>
              <th>Staff ID</th>
              <th>Name</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "comp1044_database");
            $sql = "SELECT staff_id,username,name,role FROM admin ORDER BY $sort;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $s_id = $row["staff_id"];
              $name = $row["name"];
              $roles = $row["role"];

              if ($role == "HR" || $role == "Manager") {
                $editlink = "window.location.href='edit_staff.php?s_id=$s_id'";
                $deletelink = "window.location.href='delete_staff.php?s_id=$s_id'";
              }else{
                $editlink = "alert('Access Denied')";
                $deletelink = "alert('Access Denied')";
              }
            ?>
              <tr>
                <td data-label="Staff ID"><?php echo $s_id; ?></td>

                <td data-label="Name"><?php echo $name; ?></td>
                <td data-label="Role"><?php echo $roles; ?></td>

                <td data-label="Action">
                  <button onclick="<?php echo $editlink; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button onclick="<?php echo $deletelink; ?>"><i class="fa-solid fa-trash"></i></button>
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
    window.print();
    //prevent form resubmission
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
    //change the input placeholder while user select search key
    function key_placeholder() {
      select = document.getElementById("key").value;
      if (select == "0") {
        document.getElementById("search").placeholder = "Type Staff ID...";
      } else if (select == "1") {
        document.getElementById("search").placeholder = "Type Staff Name...";
      } else if (select == "2") {
        document.getElementById("search").placeholder = "Type Staff Role...";
      }
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