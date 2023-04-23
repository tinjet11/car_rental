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
        <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
        <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation Dashboard</a></li>

        <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer Dashboard</a></li>
        <li><a href="staff_dashboard.php"><i class="fa-sharp fa-solid fa-eye"></i>Admin Dashboard</a></li>
        <li><a href="vehicle_dashboard.php"><i class="fa-sharp fa-solid fa-database"></i>Vehicle Dashboard</a></li>
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

      <h1>Edit Staff</h1>
      <form method="post" enctype="multipart/form-data">

        <label for="staff_Id">Staff ID:</label>
        <input type="text" id="staff_id" name="staff_id" readonly>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="role">Role:</label>
        <select type="text" id="role" name="role" required>
          <option>Select Staff Role</option>
          <option>Normal Staff</option>
          <option>HR</option>
          <option>Manager</option>
        </select>


        <button type="submit" id="change" name="change">Submit</button>
        <a href="staff_dashboard.php">Back</a>

      </form>

      <script>
        //prevent form resubmission
        if (window.history.replaceState) {
          window.history.replaceState(null, null, window.location.href);
        }



        //redirect to specific page after action
        function redirect() {
          window.location.replace("staff_dashboard.php");
        }



        <?php

        if ($role != "HR" && $role != "Manager") {
          echo "alert('Access Denied');";
          echo "redirect();";
        }

        //Using GET method to get the staff id
        $sid = $_GET["s_id"];

        //open connection
        $conn = new mysqli("localhost", "root", "", "comp1044_database");

        //select staff data from database
        $sql = "SELECT username,name,role FROM admin WHERE staff_id = '$sid'";

        $result = $conn->query($sql);

        //fetch data
        $values = $result->fetch_assoc();

        //staff data
        $user = $values["username"];
        $name = $values["name"];
        $role = $values["role"];

        //display the data to the form
        echo "document.getElementById('staff_id').value = '$sid';";
        echo "document.getElementById('username').value = '$user';";
        echo "document.getElementById('name').value ='$name';";
        echo "document.getElementById('role').value = '$role' ;";


        ?>

        <?php

        if (isset($_POST["change"])) {

          //retrieve all new data from the form using POST method
          $sid = isset($_POST["staff_id"]) ? $_POST["staff_id"] : "";
          $user = isset($_POST["username"]) ? $_POST["username"] : "";
          $name = isset($_POST["name"]) ? $_POST["name"] : "";
          $role = isset($_POST["role"]) ? $_POST["role"] : "";

          // check if all required fields are filled
          if ($sid != "" && $user != "" && $name != "" && $role != "") {

            //update the staff data using sql UPDATE statement
            $sql = " UPDATE admin SET username = '$user',name = '$name',role = '$role' WHERE staff_id = '$sid';";

            if ($conn->query($sql) == true) {
              echo 'alert("Update Successful");';
              echo 'redirect();';
            } else {
              echo 'alert("Error: Problem Updating Data");';
            }
          } else {
            echo 'alert("Error: Please fill all required fields.");';
          }
        }

        //close connection
        $conn->close();


        ?>
      </script>
</body>

</html>