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
          <h2>Add New Staff</h2>
        </div>
        

<h1>Enter New Staff:</h1>
<form method="post" enctype="multipart/form-data">

    <label for="Staff_ID">Staff ID:</label>
    <input type="text" id="Staff_ID" name="Staff_ID" required>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="text" id="password" name="password" required>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="role">Role:</label>
    <select type="int" id="role" name="role" value =<?php echo"$role"?> required>
    <option>Branch Manager</option>
    <option>Manager</option>
    <option>Sales Rep</option>
    </select>

    <button type="submit" id="change" name="change">Submit</button>

    
    <button style="position:relative; right: 350px; bottom: 40px;"><a href="staff_dashboard.php">Back</a></button>
</form>
<?php
$conn = new mysqli("localhost", "root", "", "staff_database");
if (isset($_POST["change"])){
        $id = isset($_POST["Staff_ID"]) ? $_POST["Staff_ID"] : "";
        $user = isset($_POST["username"]) ? $_POST["username"] : "";
        $pass = isset($_POST["password"]) ? $_POST["password"] : "";
        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $role = isset($_POST["role"]) ? $_POST["role"] : "";
        
        // check if all required fields are filled
        if ($id != "" && $user != "" && $pass != "" && $name != "" && $role != "") {
            $sql = "INSERT INTO staff_details(staff_Id,username,password,name,role) VALUES('$id','$user','$pass','$name','$role')";
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