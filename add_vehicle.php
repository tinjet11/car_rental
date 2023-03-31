<!DOCTYPE html>
<html>
<script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="form.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
          <h2>Add New Vehicle</h2>
        </div>
        

<h1>Enter New Data:</h1>
<form method="post" enctype="multipart/form-data">

    <label for="Vehicle_ID">Vehicle ID:</label>
    <input type="text" id="Vehicle_ID" name="Vehicle_ID" required>

    <label for="Vehicle_Model">Vehicle Model:</label>
    <input type="text" id="Vehicle_Model" name="Vehicle_Model" required>

    <label for="Vehicle_Type">Vehicle Type:</label>
    <select type="text" id="Vehicle_Type" name="Vehicle_Type" required>
      <option>Luxurious</option>
      <option>Sports</option>
      <option>Classics</option>
    </select>

    <label for="Vehicle_Color">Vehicle Color:</label>
    <input type="text" id="Vehicle_Color" name="Vehicle_Color" required>

    <label for="Price">Price:</label>
    <input type="int" id="Price" name="Price" required>

    <button type="submit" id="change" name="change">Submit</button>

    
    <button style="position:relative; right: 350px; bottom: 40px;"><a href="addeditdeletecars.php">Back</a></button>
</form>
<?php
$conn = new mysqli("localhost", "root", "", "car_details");
if (isset($_POST["change"])){
        $vid = isset($_POST["Vehicle_ID"]) ? $_POST["Vehicle_ID"] : "";
        $vm = isset($_POST["Vehicle_Model"]) ? $_POST["Vehicle_Model"] : "";
        $vt = isset($_POST["Vehicle_Type"]) ? $_POST["Vehicle_Type"] : "";
        $vc = isset($_POST["Vehicle_Color"]) ? $_POST["Vehicle_Color"] : "";
        $p = isset($_POST["Price"]) ? $_POST["Price"] : "";
        
        // check if all required fields are filled
        if ($vid != "" && $vm != "" && $vt != "" && $vc != "" && $p != "") {
            $sql = "INSERT INTO car_detail(Vehicle_ID,Vehicle_Model,Vehicle_Type,Vehicle_Color,Price) VALUES('$vid','$vm','$vt','$vc','$p')";
        if ($conn->query($sql) == true){
            echo'alert("Add Successful");';
}
else{
    echo 'alert("Error: Problem Adding New Data");';
}
}
else {  
      echo 'alert("Error: Please fill all required fields.");';
        }   
}
$conn->close()
?>
</html>