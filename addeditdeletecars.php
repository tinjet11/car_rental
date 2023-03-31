
<!DOCTYPE html>
<html>
<head>
<script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="dashboard.css">

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
          <h2>Vehicle Dashboard</h2>
        </div>
        

<table> 
<tr><td>ID</td>
    <td>Model</td>
    <td>Type</td>
    <td>Color</td>
    <td>Price</td></tr>
<?php
$conn = new mysqli("localhost","root","","car_details");
$sql = "SELECT Vehicle_ID,Vehicle_Model,Vehicle_Type,Vehicle_Color,Price FROM car_detail";
$result = $conn->query($sql);
while($validdata = $result->fetch_assoc()){
    $id = $validdata["Vehicle_ID"];
    $model = $validdata["Vehicle_Model"];
    $type = $validdata["Vehicle_Type"];
    $color= $validdata["Vehicle_Color"];
    $price = $validdata["Price"];
    echo" <tr><td>".$id."</td><td>".$model."</td><td>".$type."</td><td>".$color."</td><td>".$price."</td><td><a href = \"edit_vehicle.php?v_id=$id\">Edit</a></td><td><a href = \"delete_vehicle.php?v_id=$id\" role = \"button\">Delete</a></td></tr>";}

$conn->close();
?>
<tr><td><a href="add_vehicle.php">Add</a></td></tr>
</table>
</html>