<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
                <div class="text">
                    <a href="logout.php">
                        Logout
                    </a>
                </div>
                <div class="info">
                </div>

            </div><!-- end of header-->
            <h1>Update Customer Information </h1>   
            <form method="post" enctype="multipart/form-data">

                <div id="found_div">
                    <label for="customerid">Customer id:</label>
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
                </div>
            </form>
        </div><!-- end of main content-->
    </div><!-- end of container-->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
        function openNav() {
            document.getElementById("sidebar").style.width = "250px";
            document.getElementById("main_content").style.marginLeft = "250px";
            // document.getElementById("header").style.width= "87%";
            document.getElementById("openbtn").style.display = "none";
        }

        /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
        function closeNav() {
            document.getElementById("sidebar").style.width = "0";
            document.getElementById("main_content").style.marginLeft = "0";
            //document.getElementById("header").style.width= "100%";
            document.getElementById("openbtn").style.display = "block";

        }

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                document.getElementById("sidebar").style.width = "250px";
                document.getElementById("main_content").style.marginLeft = "250px";
            } else {
                document.getElementById("sidebar").style.width = "0";
                document.getElementById("main_content").style.marginLeft = "0";
            }
        });
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function redirect() {
            window.location.replace("http://localhost/car_rental/customer_dashboard.php");
        }
        <?php


        //This part of code is fetch customer information from database
        $c_id = $_GET["c_id"];

        $conn = new mysqli("localhost", "root", "", "car_rental");
        $sql = "SELECT * FROM customer where customer_id = '$c_id' ";

        $result = $conn->query($sql);

        $DataRows = $result->fetch_assoc();
        $f_name = $DataRows["First_name"];
        $l_name = $DataRows["Last_name"];
        $ic = $DataRows["IC_NO"];
        $gender = $DataRows["Gender"];
        $phone = $DataRows["Phone_Number"];
        $email = $DataRows["Email"];
        $address = $DataRows["Address"];

        echo "document.getElementById('customerid').value = '$c_id';";
        echo "document.getElementById('first-name').value =' $f_name';";
        echo "document.getElementById('last-name').value = '$l_name' ;";
        echo "document.getElementById('ic-no').value = '$ic';";
        echo "document.getElementById('gender').value = '$gender';";
        echo "document.getElementById('contact').value = '$phone';";
        echo "document.getElementById('email').value = '$email';";
        echo "document.getElementById('address').value ='$address';";

        $conn->close();


        ?>
        <?php
        //function to obtain birthdate given an ic number
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


        //This part of code is edit customer information
        if (isset($_POST["change"])) {

            $conn = new mysqli("localhost", "root", "", "car_rental");

            //Customer information
            $customerid = $_POST["customerid"];
            $First_name = $_POST["first-name"];
            $Last_name = $_POST["last-name"];
            $IC_No = $_POST["ic-no"];
            $Gender = $_POST["gender"];
            $Birthdate = getBirthdate($IC_No);
            $Phone_Number = $_POST["contact"];
            $Email = $_POST["email"];
            $Address = $_POST["address"];


            $sql  = "UPDATE customer SET First_name= '$First_name',Last_name='$Last_name', IC_NO='$IC_No', Gender='$Gender',
            Birthdate='$Birthdate',Phone_Number= '$Phone_Number', Email='$Email', Address ='$Address'
             WHERE customer_id = '$customerid'";

            if ($conn->query($sql) === TRUE) {
                echo 'alert("Change Successful");';
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