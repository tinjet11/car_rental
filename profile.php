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
                <h1>Edit Profile</h1>
                <form method="post" enctype="multipart/form-data">

                    <label for="staff_Id">Staff ID:</label>
                    <input type="text" id="staff_id" name="staff_id" readonly>


                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>


                    <div class="form-group">
                        <label for="password">Password:</label>
                        <div class="input-checkbox">
                            <input type="password" id="password" name="password" required>
                            <input type="checkbox" id="show-password" onclick="showHidePassword()">
                        </div>
                    </div>


                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

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
                window.location.replace("main.php");
            }

            <?php
            //open connection
            $conn = new mysqli("localhost", "root", "", "comp1044_database");

            //select staff data from database
            $value = $conn->query("SELECT * FROM admin WHERE staff_id = '$staffid'");
            $values = $value->fetch_assoc();

            $user = $values["username"];
            $pass = $values["password"];
            $name = $values["name"];


            //display the data to the form
            echo "document.getElementById('staff_id').value = '$staffid';";
            echo "document.getElementById('username').value = '$user';";
            echo "document.getElementById('password').value = '$pass';";
            echo "document.getElementById('name').value ='$name';";


            //close connection
            $conn->close();
            ?>

            <?php
            $conn = new mysqli("localhost", "root", "", "comp1044_database");
            if (isset($_POST["change"])) { //Checks if the change button is clicked
                $sid = isset($_POST["staff_id"]) ? $_POST["staff_id"] : ""; //Retrieves data of staff_id
                $user = isset($_POST["username"]) ? $_POST["username"] : ""; //Retrieves data of username
                $pass = isset($_POST["password"]) ? $_POST["password"] : ""; //Retrieves data of password
                $name = isset($_POST["name"]) ? $_POST["name"] : ""; //Retrieves data of name
                $role = isset($_POST["role"]) ? $_POST["role"] : ""; //Retrieves data of role

                // check if all required fields are filled
                if ($sid != "" && $user != "" && $pass != "" && $name != "") {
                    $sql = " UPDATE admin SET username = '$user',password= '$pass', name = '$name' WHERE staff_id = '$sid';"; //SQL statement to update the admin table
                    if ($conn->query($sql) == true) {
                        echo 'alert("Update Successful");'; //Alert to inform that the update is successful
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

            function showHidePassword() {
                var passwordField = document.getElementById("password");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                } else {
                    passwordField.type = "password";
                }
            }
        </script>


</body>

</html>