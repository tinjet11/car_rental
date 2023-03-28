<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="mainpage.css">
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
            <h1>Change Reservation</h1>
            <form method="post" id="reservation_form" enctype="multipart/form-data">
                <!--
        <div id="search_div">
            <label for="reservation-id">Reservation ID:</label>
            <input type="text" id="reservation-id" name="reservation-id">

            <button name="search" id="search">Search</button>

        </div>
    -->

                <div id="found_div">
                    <label for="r_id">Reservation id:</label>
                    <input type="text" id="r_id" name="r_id" readonly>

                    <label for="c_id">Customer id:</label>
                    <input type="text" id="c_id" name="c_id" readonly>

                    <label for="vehicle">Vehicle Type:</label>
                    <select id="vehicle" name="vehicle">
                        <option value="">Select a vehicle Model</option>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "car_rental");

                        $sql = "SELECT vehicle_id, model,color FROM Vehicle";
                        $result = $conn->query($sql);

                        while ($DataRows = $result->fetch_assoc()) {
                            $vehicle_id = $DataRows["vehicle_id"];
                            $model = $DataRows["model"];
                            $color = $DataRows["color"];
                        ?>
                            <option value="<?php echo $vehicle_id ?>"><?php echo $model ?> (<?php echo $color ?>)</option>

                        <?php }
                        $conn->close(); ?>
                    </select>

                    <label for="pickuptime">Original Pickup time:</label>
                    <input type="text" id="pickuptime" name="pickuptime" readonly>

                    <label for="return">Original Return Time:</label>
                    <input type="text" id="returntime" name="returntime" readonly>

                    <label for="duration">Original Duration (in days):</label>
                    <input type="number" min="1" id="oriduration" name="oriduration" readonly>
                </div>

                <div id="check_div">

                    <label for="pickup">New Pickup Time:</label>
                    <input type="datetime-local" id="pickup" name="pickup">

                    <label for="duration">New Duration (in days):</label>
                    <input type="number" min="1" id="duration" name="duration">

                    <label for="return">New Return Time:</label>
                    <input type="text" id="return" name="return" readonly>


                    <button type="submit" name="submit" id="submit">Check availability</button>
                </div>

                <div id="reserve_div">
                    <hr>
                    <p1>Click the reserve button to make changes to reservation</p1>
                    <button type="submit" name="reserve" id="reserve">Reserve</button>
                </div>

            </form>
        </div><!-- end of main content-->
    </div><!-- end of container-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function redirect() {
            window.location.replace("http://localhost/car_rental/reservation_dashboard.php");
        }

        <?php

        //This part of code is to insert information into `reservation` table only when the customer is existing customer
        $r_id = $_GET["r_id"];

        $conn = new mysqli("localhost", "root", "", "car_rental");


        $sql = "SELECT * FROM reservation where reservation_id = '$r_id' ";
        $result = $conn->query($sql);

        $DataRows = $result->fetch_assoc();
        $vehicleid =  $DataRows["vehicle_id"];
        $customerid = $DataRows["customer_id"];
        //$staff_id = $_POST[""];
        $staffid = "S0001";
        $bookingdatetime =  $DataRows["booking_datetime"];
        $duration = $DataRows["duration"];
        $returndatetime = $DataRows["return_datetime"];

        echo "document.getElementById('pickuptime').value = new Date('$bookingdatetime');";
        echo "document.getElementById('oriduration').value = '$duration' ;";
        echo "document.getElementById('vehicle').value = '$vehicleid';";
        echo "document.getElementById('r_id').value = '$r_id';";
        echo "document.getElementById('c_id').value = '$customerid';";
        echo "document.getElementById('returntime').value = new Date('$returndatetime');";
        echo "document.getElementById('found_div').style.display = 'block';";
        echo "document.getElementById('check_div').style.display = 'block';";

        $conn->close();

        ?>

        <?php

        if (isset($_POST["reserve"])) {

            $conn = new mysqli("localhost", "root", "", "car_rental");

            $reservationid = $_POST["r_id"];
            $vehicleid = $_POST["vehicle"];
            $customerid = $_POST["c_id"];
            //$staff_id = $_POST[""];
            $staffid = "S0001";
            $bookingdatetime = $_POST["pickup"];
            $duration = $_POST["duration"];
            $returndatetime = $_POST["return"];

            $sql  = "UPDATE reservation SET vehicle_id='$vehicleid' ,customer_id='$customerid',
                    staff_id='$staffid',booking_datetime='$bookingdatetime',duration='$duration',
                    return_datetime='$returndatetime' where reservation_id = '$reservationid'";

            if ($conn->query($sql) === TRUE) {
                echo 'alert("Change Successful");';
            } else {
                echo 'alert("Error");';
            }
            $conn->close();
            echo 'redirect();';
        }

        ?>


        $(function() {
            $('#submit').on('click', function(event) {
                event.preventDefault();
                const pickupTime = new Date(document.getElementById('pickup').value);
                const current = new Date();
                if(pickupTime < current){
                    alert("cannot choose date which is past already");
                }
                else{
                const duration = parseInt(document.getElementById('duration').value);
                const returnTime = new Date(pickupTime.getTime() + duration * 24 * 60 * 60 * 1000);
                const vid = document.getElementById('vehicle').value;
        

                const momentObj1 = moment(pickupTime);

                // Format the moment object as a string
                const p_t = momentObj1.format('YYYY-MM-DD HH:mm:ss');

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
                    pickup: p_t, // convert to Unix timestamp
                    return: r_t, // convert to Unix timestamp
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
            });
        });




        function calculateReturnTime(available) {
            const pickupTime = new Date(document.getElementById('pickup').value);
            const duration = parseInt(document.getElementById('duration').value);
            const returnTime = new Date(pickupTime.getTime() + duration * 24 * 60 * 60 * 1000);
            const vid = document.getElementById('vehicle').value;
            if (returnTime.getHours() < 12) {
                returnTime.setHours(12, 0, 0, 0);
            } else {
                returnTime.setHours(18, 0, 0, 0);
            }


            // if slot available, display the return time and display customer information form
            // else, display "booking not available" and hide the customer information form
            if (available == true) {
                alert("Slot available");

                //change the datetime format back to sql format
                // Parse a datetime string into a moment object
                const momentObj = moment(returnTime);

                // Format the moment object as a string
                const formatted = momentObj.format('YYYY-MM-DD HH:mm:ss');

                document.getElementById('return').value = formatted.toString();
                document.getElementById("reserve_div").style.display = "block";



            } else {
                alert("booking not available");
                document.getElementById('return').value = "Booking Not Available";
            }
        }

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
    </script>
</body>

</html>