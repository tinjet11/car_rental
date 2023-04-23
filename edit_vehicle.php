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

      <h1>Edit Vehicle</h1>
      <form method="post" enctype="multipart/form-data">

        <label for="Vehicle_ID">Vehicle ID:</label>
        <input type="text" id="Vehicle_ID" name="Vehicle_ID" readonly>

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

      <script>
        //prevent form resubmission
        if (window.history.replaceState) {
          window.history.replaceState(null, null, window.location.href);
        }

        //redirect to specific page after action
        function redirect() {
          window.location.replace("vehicle_dashboard.php");
        }

        <?php
        //Using GET method to get the vehicle id
        $vid = $_GET["v_id"];

        //open connection
        $conn = new mysqli("localhost", "root", "", "comp1044_database");

        //select vehicle data from database
        $sql = $conn->query("SELECT model,type,color,price FROM vehicle WHERE vehicle_id = '$vid'");

        //fetch data 
        $values = $sql->fetch_assoc();

        //vehicle data
        $vm = $values["model"];
        $vt = $values["type"];
        $vc = $values["color"];
        $p = $values["price"];

        //display the vehicle data in the form
        echo "document.getElementById('Vehicle_ID').value = '$vid';";
        echo "document.getElementById('Vehicle_Model').value ='$vm';";
        echo "document.getElementById('Vehicle_Type').value = '$vt' ;";
        echo "document.getElementById('Vehicle_Color').value = '$vc';";
        echo "document.getElementById('Price').value = '$p';";

        ?>

        <?php
        if (isset($_POST["change"])) {

          //retrieve all new data from the form using POST method
          $vid = isset($_POST["Vehicle_ID"]) ? $_POST["Vehicle_ID"] : "";
          $vm = isset($_POST["Vehicle_Model"]) ? $_POST["Vehicle_Model"] : "";
          $vt = isset($_POST["Vehicle_Type"]) ? $_POST["Vehicle_Type"] : "";
          $vc = isset($_POST["Vehicle_Color"]) ? $_POST["Vehicle_Color"] : "";
          $p = isset($_POST["Price"]) ? $_POST["Price"] : "";

          // check if all required fields are filled
          if ($vid != "" && $vm != "" && $vt != "" && $vc != "" && $p != "") {

            //Update the vehicle with new data using SQL UPDATE statement
            $sql = " UPDATE vehicle SET model = '$vm',type = '$vt',color = '$vc',price = '$p' WHERE vehicle_id = '$vid';";

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
        $conn->close()
        ?>
      </script>

</html>