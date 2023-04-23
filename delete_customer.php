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

            <h1>Delete Customer</h1>
            <form method="post">

                <label for="reservation-id">Customer ID:</label>
                <input type="text" id="customer-id" name="customer-id" readonly>

                <button name="delete">Delete</button>
                <a href="customer_dashboard.php">Back</a>

            </form>

        </div><!-- end of main content-->

    </div><!-- end of container-->

    <script type="text/javascript">
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        //redirect to specific page after action
        function redirect() {
            window.location.replace("customer_dashboard.php");
        }

        <?php
        //Using GET method to get the customer id
        $c_id = $_GET["c_id"];

        //display customer id in the form
        echo "document.getElementById('customer-id').value = '$c_id';";

        if (isset($_POST["delete"])) {
            //open connection
            $conn = new mysqli("localhost", "root", "", "comp1044_database");

            //delete only one specific record from database
            $sql  = "DELETE FROM customer WHERE customer_id = '$c_id' ";

            if ($conn->query($sql) === TRUE) {

                $NumRowsDeleted = $conn->affected_rows;

                if ($NumRowsDeleted == 1) {
                    echo 'alert("Delete Successful");';
                } else {
                    echo "alert('Customer not found');";
                }
            } else {
                echo "alert('error');";
            }

            //close connection
            $conn->close();
            echo 'redirect();';
        }
        ?>
    </script>
</body>

</html>