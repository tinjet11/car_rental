<?php
include 'session.php';
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="mainpage.css">
<link rel="stylesheet" href="form.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
        <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation_Dashboard</a></li>
        <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
        <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer_Dashboard</a></li>
        <li><a href="staff_dashboard.php"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
        <li><a href="vehicle_dashboard.php"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
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

      <!-- Table container -->
      <div id="table-container">

        <form method="post" enctype="multipart/form-data">
          <h1>Add new vehicle</h1>
          <label for="Vehicle_ID">Vehicle ID:</label>
          <input type="text" id="Vehicle_ID" name="Vehicle_ID" required>

          <label for="Vehicle_Model">Vehicle Model:</label>
          <input type="text" id="Vehicle_Model" name="Vehicle_Model" required>

          <label for="Vehicle_Type">Vehicle Type:</label>
          <select type="text" id="Vehicle_Type" name="Vehicle_Type" required>
            <option>Luxurious Car</option>
            <option>Sports Car</option>
            <option>Classics Car</option>
          </select>

          <label for="Vehicle_Color">Vehicle Color:</label>
          <input type="text" id="Vehicle_Color" name="Vehicle_Color" required>

          <label for="Price">Price:</label>
          <input type="text" id="Price" name="Price" required>

          <button type="submit" id="change" name="change">Submit</button>
          <a href="vehicle_dashboard.php">Back</a>

        </form>

      </div><!-- end of table container-->

      <script>
        //prevent form resubmission
        if (window.history.replaceState) {
          window.history.replaceState(null, null, window.location.href);
        }

        //redirect to specific page after action
        function redirect() {
          window.location.replace("http://localhost/car_rental/vehicle_dashboard.php");
        }

        <?php
        //open connection
        $conn = new mysqli("localhost", "root", "", "comp1044_database");

        //select the lastest vehicle id from database
        $sql = "SELECT  vehicle_id from vehicle ORDER BY vehicle_id DESC LIMIT 1 ";
        $result = $conn->query($sql);
        $DataRows = $result->fetch_assoc();

        $count = $result->num_rows; // Returns the number of rows in the result
        if ($count == 0) {
          $last_vehicle_id = "V0001";
        } else {
          $last_vehicle_id = $DataRows["vehicle_id"];
        }
       

        //close connection
        $conn->close();

        ?>

        //generate new vehicle id
        function generate_vehicle_id(last_id) {
          // Current vehicle id
          const currentCode = last_id;

          // Extract numerical part
          const currentNum = parseInt(currentCode.match(/\d+/)[0]);

          // Generate next number
          const nextNum = currentNum + 1;

          // Pad with leading zeros
          const paddedNum = nextNum.toString().padStart(currentCode.match(/\d+/)[0].length, "0");

          // Concatenate prefix and padded number to generate next vehicle id
          const nextCode = "V" + paddedNum;

          return nextCode;
        }

        // display the vehicle id in the form
        if('<?php echo $last_vehicle_id; ?>' == "V0001"){
          document.getElementById('Vehicle_ID').value =  "V0001";
        }else{
        document.getElementById('Vehicle_ID').value = generate_vehicle_id('<?php echo $last_vehicle_id ?>');
        }
        <?php

        //open connection
        $conn = new mysqli("localhost", "root", "", "comp1044_database");

        if (isset($_POST["change"])) {

          $vid = isset($_POST["Vehicle_ID"]) ? $_POST["Vehicle_ID"] : "";
          $vm = isset($_POST["Vehicle_Model"]) ? $_POST["Vehicle_Model"] : "";
          $vt = isset($_POST["Vehicle_Type"]) ? $_POST["Vehicle_Type"] : "";
          $vc = isset($_POST["Vehicle_Color"]) ? $_POST["Vehicle_Color"] : "";
          $p = isset($_POST["Price"]) ? $_POST["Price"] : "";

          // check if all required fields are filled
          if ($vid != "" && $vm != "" && $vt != "" && $vc != "" && $p != "") {

            //insert new vehicle data into database
            $sql = "INSERT INTO vehicle(vehicle_id,model,type,color,price) VALUES('$vid','$vm','$vt','$vc','$p')";

            if ($conn->query($sql) == true) {
              echo 'alert("Add Successful");';
              echo 'redirect();';
            } else {
              echo 'alert("Error: Problem Adding New Data");';
            }
          } else {
            echo 'alert("Error: Please fill all required fields.");';
          }
        }

        //close connection
        $conn->close()
        ?>
      </script>
</body>

</html>