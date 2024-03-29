<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
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
            <h1>Return Form</h1>
            <form method="post">

                <label for="reservation-id">Reservation ID:</label>
                <input type="text" id="reservation-id" name="reservation-id">

                <button name="submit">Return</button>
                <a href="reservation_dashboard.php">Back</a>
            </form>

        </div><!-- end of main content-->
    </div><!-- end of container-->

    <script type="text/javascript">
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function redirect() {
            window.location.replace("reservation_dashboard.php");
        }


        <?php
        $r_id = $_GET["r_id"]; //Line of code is retrieved using the GET variable

        echo "document.getElementById('reservation-id').value = '$r_id';"; //Outputs the javascript code of document.getElementById method
        date_default_timezone_set("Asia/Kuala_Lumpur"); 
        $currentDateTime = date('Y-m-d H:i:s');


        if (isset($_POST["submit"])) { //Checks if the submit button is clicked
            $conn = new mysqli("localhost", "root", "", "comp1044_database");

            $r_id = $_POST["reservation-id"]; //Retrieves value from reservtion-id and set it in $r_id variable
            $sql  = "UPDATE reservation SET exact_return_datetime = '$currentDateTime' WHERE reservation_id = '$r_id';"; //SQL UPDATE statement to update the reservation table with current datetime in the relevant reservation_id column

            if ($conn->query($sql) === TRUE) {
                echo 'alert("Return Successful");'; //Alert if successful
            } else {
                echo 'alert("Error");';
            }
            $conn->close();
            echo 'redirect();';
        }
        ?>
    </script>
</body>

</html>