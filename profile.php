<?php
include 'session.php';
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="form.css">

    <script src="sidebar.js"></script>
</head>

<body>
    <div class="container">

        <div class="sidebar" id="sidebar">
            <h2>Menu</h2>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
            <ul>
                <li><a href="main.php"><i class="fa-solid fa-house"></i>Home</a></li>
                <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation Dashboard</a></li>
                <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
                <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer_Dashboard</a></li>
                <li><a href="staff_dashboard.php"><i class="fa-sharp fa-solid fa-eye"></i>Admin Dashboard</a></li>
                <li><a href="vehicle_dashboard.php"><i class="fa-sharp fa-solid fa-database"></i>Vehicle Dashboard</a></li>
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
                <form method="post" enctype="multipart/form-data">
                    <h1>Edit Profile</h1>

                    <label for="staff_Id">Staff ID:</label>
                    <input type="text" id="staff_id" name="staff_id" readonly>


                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="role">Role:</label>
                    <input type="text" id="role" name="role" required>

                        <button type="submit" id="change" name="change">Submit</button>
                        <a href="main.php">Back</a>
             
                </form>


            </div><!-- end of main content-->
        </div><!-- end of container-->

        <script>

            //prevent form resubmission
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

            function redirect() {
                window.location.replace("http://localhost/car_rental/main.php");
            }
            <?php


            //This part of code is fetch vehicle information from database
            $sid = $staffid;


            $conn = new mysqli("localhost", "root", "", "car_rental");
            $value = $conn->query("SELECT * FROM admin WHERE staff_id = '$sid'");
            $values = $value->fetch_assoc();
            $user = $values["username"];
            $pass = $values["password"];
            $name = $values["name"];
            $role = $values["role"];
            echo "document.getElementById('staff_id').value = '$sid';";
            echo "document.getElementById('username').value = '$user';";
            echo "document.getElementById('password').value = '$pass';";
            echo "document.getElementById('name').value ='$name';";
            echo "document.getElementById('role').value = '$role' ;";

            $conn->close();
            ?>

            <?php
            $conn = new mysqli("localhost", "root", "", "car_rental");
            if (isset($_POST["change"])) {
                $sid = isset($_POST["staff_id"]) ? $_POST["staff_id"] : "";
                $user = isset($_POST["username"]) ? $_POST["username"] : "";
                $pass = isset($_POST["password"]) ? $_POST["password"] : "";
                $name = isset($_POST["name"]) ? $_POST["name"] : "";
                $role = isset($_POST["role"]) ? $_POST["role"] : "";

                // check if all required fields are filled
                if ($sid != "" && $user != "" && $pass != "" && $name != "" && $role != "") {
                    $sql = " UPDATE admin SET username = '$user',password= '$pass', name = '$name',role = '$role' WHERE staff_id = '$sid';";
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
            $conn->close()
            ?>
        </script>


</body>

</html>