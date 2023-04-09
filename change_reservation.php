<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="reservation.css">
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

            <h1>Change Reservation</h1>

            <div id="container">

                <table id="table">
                    <thead>
                        <!-- Table header -->
                        <tr>
                            <th>Vehicle ID</th>
                            <th>Booking Datetime</th>
                            <th>Return Datetime</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        //open connection
                        $conn = new mysqli("localhost", "root", "", "comp1044_database");

                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $current_time = date('Y-m-d H:i:s');

                        //select all the data from reservation table with $sort order 
                        $sql = "SELECT * from reservation WHERE ('$current_time' <= return_datetime AND '$current_time' >= booking_datetime) OR booking_datetime > '$current_time' ORDER BY booking_datetime ASC";
                        $result = $conn->query($sql);

                        while ($DataRows = $result->fetch_assoc()) {
                            $v_id = $DataRows["vehicle_id"];
                            $booking_datetime = $DataRows["booking_datetime"];
                            $return_datetime = $DataRows["return_datetime"];
                            $duration = $DataRows["duration"];

                            // if current time is before the booking datetime
                            // set status pending, still can change or cancel reservation    
                            if ($current_time < $booking_datetime) {
                                $status = "<p class='status pending'> Pending </p>";
                            }
                            // if current time is between the booking datetime and return datetime
                            // set status ongoing, then cannot change & cancel the reservation
                            else if ($current_time <= $return_datetime && $current_time >= $booking_datetime) {
                                $status = "<p class='status ongoing'> Ongoing </p>";
                            }
                            // else set status Completed, then cannot change & cancel the reservation
                            else {
                                $status = "<p class='status completed'> Completed </p>";
                            }


                        ?>
                            <tr>
                                <td data-label="Vehicle ID"><?php echo $v_id; ?></td>
                                <td data-label="Booking Datetime"><?php echo $booking_datetime; ?></td>
                                <td data-label="Return Datetime"><?php echo $return_datetime; ?></td>
                                <td data-label="Duration"><?php echo $duration; ?></td>
                                <td data-label="Status"><?php echo $status; ?></td>
                            </tr>
                        <?php  }
                        $conn->close(); ?>
                    </tbody>
                </table>


                <form method="post" id="reservation_form" enctype="multipart/form-data">

                    <div id="found_div">
                        <label for="r_id">Reservation ID:</label>
                        <input type="text" id="r_id" name="r_id" readonly>

                        <label for="c_id">Customer ID:</label>
                        <input type="text" id="c_id" name="c_id" readonly>

                        <label for="vehicle">Vehicle Type:</label>
                        <select id="vehicle" name="vehicle" onchange="filter()" required>
                            <option value="">Select a vehicle Model</option>
                            <?php
                            //open connection
                            $conn = new mysqli("localhost", "root", "", "comp1044_database");

                            $sql = "SELECT vehicle_id, model,color FROM Vehicle";
                            $result = $conn->query($sql);
                            // retrieve the details of vehicle 
                            while ($DataRows = $result->fetch_assoc()) {
                                $vehicle_id = $DataRows["vehicle_id"];
                                $model = $DataRows["model"];
                                $color = $DataRows["color"];
                                $details = $model . "(" . $color . ")"
                            ?>
                                <option value="<?php echo $vehicle_id ?>"><?php echo $details ?></option>
                            <?php }
                            //close connection
                            $conn->close(); ?>
                        </select>


                        <label for="pickuptime">Original Pickup time:</label>
                        <input type="text" id="pickuptime" name="pickuptime" readonly>

                        <label for="return">Original Return Time:</label>
                        <input type="text" id="returntime" name="returntime" readonly>

                        <label for="duration">Original Duration (in days):</label>
                        <input type="number" min="1" id="oriduration" name="oriduration" readonly>
                    </div>

                    <!-- Select New pickup and Duration Container -->
                    <div id="check_div">
                        <?php
                        //current time with current timezone 
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $current_time = date('Y-m-d H:i');
                        ?>

                        <label for="pickup">New Pickup Time:</label>
                        <input type="datetime-local" id="pickup" name="pickup" min="<?php echo $current_time ?>">

                        <label for="duration">New Duration (in days):</label>
                        <input type="number" min="1" id="duration" name="duration">

                        <label for="return">New Return Time:</label>
                        <input type="text" id="return" name="return" readonly>

                        <button type="submit" name="submit" id="submit">Check availability</button>
                        <a href="reservation_dashboard.php">Back</a>
                    </div>

                    <!-- Reservation button container -->
                    <div id="reserve_div">

                        <br>
                        <hr>
                        <p1>Click the reserve button to make changes to reservation</p1>
                        <button type="submit" name="reserve" id="reserve">Reserve</button>
                    </div>

                </form>
            </div>
        </div><!-- end of main content-->
    </div><!-- end of container-->


    <script type="text/javascript">
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function redirect() {
            window.location.replace("http://localhost/car_rental/reservation_dashboard.php");
        }

        <?php
        //This part of code is to get specific reservation data from the database and display in the form

        //Using GET method to get the reservation id
        $r_id = $_GET["r_id"];

        //open connection
        $conn = new mysqli("localhost", "root", "", "comp1044_database");

        //select reservation data using SQL select statement
        $sql = "SELECT * FROM reservation where reservation_id = '$r_id' ";
        $result = $conn->query($sql);

        $DataRows = $result->fetch_assoc();

        //reservation data
        $vehicleid =  $DataRows["vehicle_id"];
        $customerid = $DataRows["customer_id"];
        $staffid = "S0001";
        $bookingdatetime =  $DataRows["booking_datetime"];
        $duration = $DataRows["duration"];
        $returndatetime = $DataRows["return_datetime"];

        //display the data in the form
        echo "document.getElementById('pickuptime').value = new Date('$bookingdatetime');";
        echo "document.getElementById('oriduration').value = '$duration' ;";
        echo "document.getElementById('vehicle').value = '$vehicleid';";
        echo "document.getElementById('r_id').value = '$r_id';";
        echo "document.getElementById('c_id').value = '$customerid';";
        echo "document.getElementById('returntime').value = new Date('$returndatetime');";
        echo "document.getElementById('found_div').style.display = 'block';";
        echo "document.getElementById('check_div').style.display = 'block';";

        //close connection
        $conn->close();

        ?>

        <?php

        if (isset($_POST["reserve"])) {

            //open connection
            $conn = new mysqli("localhost", "root", "", "comp1044_database");

            //reservation information
            $reservationid = $_POST["r_id"];
            $vehicleid = $_POST["vehicle"];
            $customerid = $_POST["c_id"];
            $staffid = $_SESSION['staffid'];
            $bookingdatetime = $_POST["pickup"];
            $duration = $_POST["duration"];
            $returndatetime = $_POST["return"];

            //update the database with new reservation information
            $sql  = "UPDATE reservation SET vehicle_id='$vehicleid' ,customer_id='$customerid',
                    staff_id='$staffid',booking_datetime='$bookingdatetime',duration='$duration',
                    return_datetime='$returndatetime' where reservation_id = '$reservationid'";

            if ($conn->query($sql) === TRUE) {
                echo 'alert("Change Successful");';
            } else {
                echo 'alert("Error");';
            }

            //close connection
            $conn->close();
            echo 'redirect();';
        }

        ?>


        document.getElementById('submit').addEventListener('click', check_availability);

        function check_availability() {
            event.preventDefault();
            const pickupTime = new Date(document.getElementById('pickup').value);
            const current = new Date();

            if (pickupTime.getHours() > 18 || pickupTime.getHours() < 8) {
                alert("Time chosen not within working hour.Try Again");
            } else {
                const duration = parseInt(document.getElementById('duration').value);
                const returnTime = new Date(pickupTime.getTime() + duration * 24 * 60 * 60 * 1000);
                const vid = document.getElementById('vehicle').value;

                const momentObj1 = moment(pickupTime);

                // Format the moment object as a string
                const p_t = momentObj1.format('YYYY-MM-DD HH:mm:ss');

                //If returntime before 12pm,set return time to 12pm
                //else set return time to 6pm
                if (returnTime.getHours() < 12) {
                    returnTime.setHours(12, 0, 0, 0);
                } else {
                    returnTime.setHours(18, 0, 0, 0);
                }

                const momentObj2 = moment(returnTime);

                // Format the moment object as a string
                const r_t = momentObj2.format('YYYY-MM-DD HH:mm:ss');

                // Create a new XMLHttpRequest object
                var xhr = new XMLHttpRequest();

                // Define the URL to send the request to
                var url = "available.php";

                var rid = '<?php echo $r_id; ?>';

                // Define the data to send in the request body
                var data = {
                    vehicle: vid,
                    reservation: rid,
                    pickup: p_t,
                    return: r_t,
                };

                // Define the callback function to handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // var response = xhr.responseText;
                        // alert(response);

                        var response = JSON.parse(xhr.responseText);
                        var msg = response.msg;

                        if (msg) {
                            calculateReturnTime(true);
                        } else {
                            calculateReturnTime(false);
                        }
                    }
                };

                // Open the request and set the HTTP method and headers
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-Type", "application/json");

                // Send the request with the data in the request body
                xhr.send(JSON.stringify(data));
            }
        }



        //calculate ReturnDateTime based on new duration and new pickup datetime
        function calculateReturnTime(available) {
            const pickupTime = new Date(document.getElementById('pickup').value);
            const duration = parseInt(document.getElementById('duration').value);
            const returnTime = new Date(pickupTime.getTime() + duration * 24 * 60 * 60 * 1000);
            const vid = document.getElementById('vehicle').value;

            //If returntime before 12pm,set return time to 12pm
            //else set return time to 6pm
            if (returnTime.getHours() < 12) {
                returnTime.setHours(12, 0, 0, 0);
            } else {
                returnTime.setHours(18, 0, 0, 0);
            }

            // if slot available, display the return time and display customer information form
            // else, display "booking not available" and hide the customer information form
            if (available == true) {


                //change the datetime format back to sql format
                // Parse a datetime string into a moment object
                const momentObj = moment(returnTime);

                // Format the moment object as a string
                const formatted = momentObj.format('YYYY-MM-DD HH:mm:ss');

                //check is the user input is empty or not
                if (formatted.toString() == "Invalid date" || vid == "") {
                    alert("Invalid/Missing input");
                    document.getElementById('return').value = "Invalid/Missing input";
                    document.getElementById("customer_info").style.display = "none";
                } else {
                    alert("Slot available");
                    document.getElementById('return').value = formatted.toString();
                    document.getElementById("reserve_div").style.display = "block";
                }
            } else {
                alert("booking not available");
                document.getElementById('return').value = "Booking Not Available";
            }
        }

        // function to filter the table content while searching
        function filter() {
            // Declare variables
            var filter, table, tr, td, i, txtValue;

            filter = document.getElementById("vehicle").value.toUpperCase();
            table = document.getElementById("table");
            tr = table.getElementsByTagName("tr");


            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>

</html>