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
        <li><a href="#"><i class="fa-sharp fa-solid fa-database"></i>Staff_Dashboard</a></li>
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
          <h2>Delete Staff</h2>
        </div>
       

<h1> </h1> 
<?php $s_id = $_GET["s_id"] ?>
<form method="post"><h1>Would you like to Delete this Staff ID:</h1><h1 style="color: wheat;"><?php echo $s_id; ?></h1><button name ="Delete"> Delete</button><button style="position:relative; bottom: 40px;right: 350px"><a href = "staff_dashboard.php"> Back </a></button></form>

<?php
 $conn = new mysqli("localhost", "root", "", "staff_database");
if (isset($_POST["Delete"])){
    if ($conn->query("DELETE FROM staff_details WHERE staff_Id = '$s_id'") == TRUE){
        $change = $conn->affected_rows;
        if($change == 1){
            echo "<body>$s_id is deleted</body>";
        }
        else{
            echo "<body> $s_id does not exist </body>";
        }
    }
    else{

        echo "$s_id could not be deleted";
    }
}
$conn->close();
?>
</html>