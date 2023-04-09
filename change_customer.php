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

            <h1>Update Customer Information </h1>
            <form method="post" enctype="multipart/form-data">

                <div id="found_div">
                    <label for="customerid">Customer ID:</label>
                    <input type="text" id="customerid" name="customerid" required>

                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first-name" required>

                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last-name" required>

                    <label for="ic-no">IC No:</label>
                    <input type="text" id="ic-no" name="ic-no" required>

                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>

                    <label for="contact">Contact:</label>
                    <input type="tel" id="contact" name="contact" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="address">Address:</label>
                    <textarea id="address" name="address" required></textarea>

                    <button type="submit" name="change">Submit</button>
                    <a href="customer_dashboard.php">Back</a>
                </div>
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
            window.location.replace("http://localhost/car_rental/customer_dashboard.php");
        }

        <?php
        //Using GET method to get the customer id
        $c_id = $_GET["c_id"];

        //open connection
        $conn = new mysqli("localhost", "root", "", "comp1044_database");

        $sql = "SELECT * FROM customer where customer_id = '$c_id' ";
        $result = $conn->query($sql);

        //fetch result
        $DataRows = $result->fetch_assoc();

        //customer data
        $f_name = $DataRows["First_name"];
        $l_name = $DataRows["Last_name"];
        $ic = $DataRows["IC_NO"];
        $gender = $DataRows["Gender"];
        $phone = $DataRows["Phone_Number"];
        $email = $DataRows["Email"];
        $address = $DataRows["Address"];

        //display customer data in the form
        echo "document.getElementById('customerid').value = '$c_id';";
        echo "document.getElementById('first-name').value =' $f_name';";
        echo "document.getElementById('last-name').value = '$l_name' ;";
        echo "document.getElementById('ic-no').value = '$ic';";
        echo "document.getElementById('gender').value = '$gender';";
        echo "document.getElementById('contact').value = '$phone';";
        echo "document.getElementById('email').value = '$email';";
        echo "document.getElementById('address').value ='$address';";

        //close connection
        $conn->close();

        ?>
        <?php
        //function to obtain birthdate given an IC number
        function getBirthdate($icNumber)
        {
            // Extract birthdate from IC number
            $birthdateStr = substr($icNumber, 0, 6);

            // Convert birthdate string to DateTime object
            $day = substr($birthdateStr, 4, 6);
            $month = substr($birthdateStr, 2, 2);

            if (substr($birthdateStr, 0, 2) < 10) {
                $year = '20' . substr($birthdateStr, 0, 2);
            } else {
                $year = '19' . substr($birthdateStr, 0, 2);
            }

            $birthdate = new DateTime("$year-$month-$day");

            // Return birthdate as a string in "YYYY-MM-DD" format
            return $birthdate->format('Y-m-d');
        }


        //This part of code is update customer information
        if (isset($_POST["change"])) {

            //open connection
            $conn = new mysqli("localhost", "root", "", "comp1044_database");

            //retrieve all new data from the form using POST method
            $customerid = $_POST["customerid"];
            $First_name = $_POST["first-name"];
            $Last_name = $_POST["last-name"];
            $IC_No = $_POST["ic-no"];
            $Gender = $_POST["gender"];
            $Birthdate = getBirthdate($IC_No);
            $Phone_Number = $_POST["contact"];
            $Email = $_POST["email"];
            $Address = $_POST["address"];

            //update customer information with new data using SQL UPDATE statement
            $sql  = "UPDATE customer SET First_name= '$First_name',Last_name='$Last_name', IC_NO='$IC_No', Gender='$Gender',
            Birthdate='$Birthdate',Phone_Number= '$Phone_Number', Email='$Email', Address ='$Address'
            WHERE customer_id = '$customerid'";

            if ($conn->query($sql) === TRUE) {
                echo 'alert("Change Successful");';
                echo 'redirect();';
            } else {
                echo 'alert("Error");';
            }

            //close connection
            $conn->close();
        }
        ?>
    </script>
</body>

</html>