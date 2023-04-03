<?php
include 'session.php';
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="reservation.css">
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
                <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation_Dashboard</a></li>
                <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
                <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer_Dashboard</a></li>
                <li><a href="staff_dashboard.php"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
                <li><a href="vehicle_dashboard.php"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
            </ul>
        </div><!-- end of sidebar -->

        <div class="main_content" id="main_content">
            <div class="header" id="header">
                <button class="openbtn" id="openbtn" onclick="openNav()">☰ </button>
                Premier Car Rental Agency
                <div class="dropdown" style="float:right;">
                    <button class="dropbtn"><i class="fa-solid fa-user"></i></button>
                    <div class="dropdown-content">
                        <a href="profile.php"><i class="fa fa-home"></i> Profile </a>
                        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
                    </div>
                </div>
            </div><!-- end of header-->

            <h1>New Reservation</h1>
            <form method="post" id="reservation_form" enctype="multipart/form-data">

                <label for="vehicle">Vehicle Type:</label>
                <select id="vehicle" name="vehicle" required>
                    <option value="">Select a vehicle Model</option>
                    <?php
                    //open connection
                    $conn = new mysqli("localhost", "root", "", "car_rental");

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

                <?php
                //current time with current timezone 
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $current_time = date('Y-m-d H:i');
                ?>

                <label for="pickup">Pickup Time:</label>
                <input type="datetime-local" id="pickup" name="pickup" min="<?php echo $current_time ?>" required>

                <label for="duration">Duration (in days):</label>
                <input type="number" min="1" id="duration" name="duration" required>

                <button type="submit" name="submit" id="submit">Check availability</button>

                <label for="return">Return Time:</label>
                <input type="text" id="return" name="return" readonly>

                <label for="r_id">Reservation id:</label>
                <input type="text" id="r_id" name="r_id" readonly>

                <!--Customer Information field -->
                <div id="customer_info">

                    <!-- Customer Type -->
                    <div id="customer-type">
                        <label for="c-type">Customer-type:</label>
                        <select id="c-type">
                            <option value="">Select a customer type</option>
                            <option value="new-c">New Customer</option>
                            <option value="exist-c">Existing Customer</option>
                        </select>
                    </div>
                    <!-- Existing Customer  -->
                    <div id="exist-c">
                        <label for="ic">IC No:</label>
                        <input type="text" id="ic" name="ic" placeholder="010831-13-5673" required>

                        <button id="search" name="search" style="float:right;">Search</button>
                    </div>

                    <div id="exist-ic">
                        <label for="c_id">Customer id:</label>
                        <input type="text" id="customerid" name="customerid" readonly>
                        <button id="reserve_exist" name="reserve_exist" style="float:right;">Reserve</button>
                    </div>

                    <!-- New Customer -->
                    <div id="new-c">
                        <label for="c_id">Customer id:</label>
                        <input type="text" id="c_id" name="c_id" readonly>

                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first-name" required>

                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name="last-name" required>

                        <label for="ic-no">IC No:</label>
                        <input type="text" id="ic-no" name="ic-no" placeholder="010831-13-5673" required>

                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>

                        <label for="contact">Contact:</label>
                        <input type="tel" id="contact" name="phone_number" placeholder="012-345-6789" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea>

                        <button id="reserve" name="reserve" style="float:right;">Reserve</button>

                    </div>

                </div><!-- end of Customer Information Field-->
            </form><!-- end of form-->
        </div><!-- end of main content-->
    </div><!-- end of container-->

    <script>
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

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

        //This part of code is to insert information into `reservation` table and `customer` table when the customer is new customer
        if (isset($_POST["reserve"])) {
            //open connection
            $conn = new mysqli("localhost", "root", "", "car_rental");

            //reservation information
            $reservationid = $_POST["r_id"];
            $vehicleid = $_POST["vehicle"];
            $customerid = $_POST["c_id"];
            $staffid = $_SESSION['staffid'];
            $bookingdatetime = $_POST["pickup"];
            $duration = $_POST["duration"];
            $returndatetime = $_POST["return"];

            // insert reservation information into table 
            $sql = "INSERT INTO reservation(reservation_id,vehicle_id,customer_id,staff_id,booking_datetime,duration,return_datetime) 
    VALUES('$reservationid','$vehicleid','$customerid','$staffid','$bookingdatetime','$duration','$returndatetime')";

            //Customer information
            $First_name = $_POST["first-name"];
            $Last_name = $_POST["last-name"];
            $IC_No = $_POST["ic-no"];
            $Gender = $_POST["gender"];
            $Birthdate = getBirthdate($IC_No);
            $Phone_Number = $_POST["phone_number"];
            $Email = $_POST["email"];
            $Address = $_POST["address"];
            // insert customer information into table 
            $sql1  = "INSERT INTO customer(customer_id, First_name, Last_name, IC_NO, Gender, Birthdate, Phone_Number, Email, Address)
    VALUES('$customerid', '$First_name', '$Last_name', '$IC_No', '$Gender', '$Birthdate', '$Phone_Number', '$Email', '$Address')";

            if ($conn->query($sql) === TRUE && $conn->query($sql1) === TRUE) {
                echo "alert('Successful Add reservation and customer');";
            } else {
                echo "alert('Error');";
            }

            //close connection
            $conn->close();
        }
        ?>

        <?php
        //This part of code is to insert information into `reservation` table only when the customer is existing customer
        if (isset($_POST["reserve_exist"])) {
            //open connection
            $conn = new mysqli("localhost", "root", "", "car_rental");

            $reservationid = $_POST["r_id"];
            $vehicleid = $_POST["vehicle"];
            $customerid = $_POST["customerid"];
            $staffid = $_SESSION['staffid'];
            $bookingdatetime = $_POST["pickup"];
            $duration = $_POST["duration"];
            $returndatetime = $_POST["return"];

            $sql = "INSERT INTO reservation(reservation_id,vehicle_id,customer_id,staff_id,booking_datetime,duration,return_datetime) 
                VALUES('$reservationid','$vehicleid','$customerid','$staffid','$bookingdatetime','$duration','$returndatetime')";
            if ($conn->query($sql) == TRUE) {
                echo "alert('Successful Add reservation for existing customer');";
            } else {
                echo "alert('Error');";
            }

            //close connection
            $conn->close();
        }


        ?>
        document.getElementById('search').addEventListener('click', search_ic);

        function search_ic() {
            event.preventDefault();
            const ic = document.getElementById('ic').value;
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Define the URL to send the request to
            var url = "ic.php";

            // Define the data to send in the request body
            var data = {
                icno: ic,
            };

            // Define the callback function to handle the response
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {

                    var response = JSON.parse(xhr.responseText);
                    var msg = response.msg;

                    if (msg != "C0000") {
                        alert("Customer Exist");
                        document.getElementById("exist-ic").style.display = "block";
                        document.getElementById("customerid").value = msg;

                    } else {
                        alert("Customer Not Exist");
                        document.getElementById("exist-ic").style.display = "none";
                    }
                }
            };

            // Open the request and set the HTTP method and headers
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/json");

            // Send the request with the data in the request body
            xhr.send(JSON.stringify(data));
        }

        document.getElementById('submit').addEventListener('click', check_availability);

        function check_availability() {
            event.preventDefault();
            const pickupTime = new Date(document.getElementById('pickup').value);
            const current = new Date();

            //cannot choose pickup date which is already past
            if (pickupTime < current) {
                alert("cannot choose date which is past already");
            } else {
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

                //default rid as it is new reservation
                var rid = 'R0000';

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


            <?php
            //open connection
            $conn = new mysqli("localhost", "root", "", "car_rental");

            //get the last reservation id from database;    
            $sql = "SELECT reservation_id from reservation ORDER BY reservation_id DESC LIMIT 1 ";
            $result = $conn->query($sql);
            $DataRows = $result->fetch_assoc();
            $last_reservation_id = $DataRows["reservation_id"];

            //get the last customer id from database;    
            $sql = "SELECT  customer_id from customer ORDER BY customer_id DESC LIMIT 1 ";
            $result = $conn->query($sql);
            $DataRows = $result->fetch_assoc();
            $last_customer_id = $DataRows["customer_id"];

            //close connection
            $conn->close();
            ?>

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
                    //generate reservation id
                    document.getElementById('r_id').value = generate_reservation_id('<?php echo $last_reservation_id ?>');
                    document.getElementById('return').value = formatted.toString();
                    document.getElementById("customer_info").style.display = "block";
                    document.getElementById("customer-type").style.display = "block";
                }



            } else {
                //isNaN return true if the value is not number 
                if (isNaN(duration)) {
                    alert("Invalid/Missing input");
                    document.getElementById('return').value = "Invalid/Missing input";
                    document.getElementById("customer_info").style.display = "none";
                } else {
                    alert("booking not available");
                    document.getElementById('return').value = "Booking Not Available";
                    document.getElementById("customer_info").style.display = "none";
                }
            }
        }

            const customertypeselect = document.getElementById('c-type');

            customertypeselect.addEventListener('change', function() {

                if (customertypeselect.value == "new-c") {
                    //generate customer id
                    document.getElementById('c_id').value = generate_customer_id('<?php echo $last_customer_id ?>');
                    document.getElementById("new-c").style.display = "block";
                    document.getElementById("exist-c").style.display = "none";

                    // Get the div element
                    const div1 = document.getElementById("new-c");

                    // Get all the input elements in the div
                    const inputs1 = div1.getElementsByTagName("input");

                    // Loop through each input element and remove the "required" attribute if it's not readonly
                    for (let i = 0; i < inputs1.length; i++) {
                        if (!inputs1[i].readOnly) {
                            inputs1[i].setAttribute("required", "");
                        }
                    }
                    document.getElementById("gender").setAttribute("required", "");
                    document.getElementById("address").setAttribute("required", "");
                    document.getElementById("ic").removeAttribute("required");

                } else {
                    document.getElementById("exist-c").style.display = "block";
                    document.getElementById("new-c").style.display = "none";
                    // Get the div element
                    const div = document.getElementById("new-c");

                    // Get all the input elements in the div
                    const inputs = div.getElementsByTagName("input");

                    // Loop through each input element and remove the "required" attribute if it's not readonly
                    for (let i = 0; i < inputs.length; i++) {
                        if (!inputs[i].readOnly) {
                            inputs[i].removeAttribute("required");
                        }
                    }
                    document.getElementById("gender").removeAttribute("required");
                    document.getElementById("address").removeAttribute("required");
                    document.getElementById("ic").setAttribute("required", "");
                }
            });

            //generate the lastest reservation id
            function generate_reservation_id(last_id) {
                // Current reservation id
                const currentCode = last_id;

                // Extract numerical part
                const currentNum = parseInt(currentCode.match(/\d+/)[0]);

                // Generate next number
                const nextNum = currentNum + 1;

                // Pad with leading zeros
                const paddedNum = nextNum.toString().padStart(currentCode.match(/\d+/)[0].length, "0");

                // Concatenate prefix and padded number to generate next reservation code
                const nextCode = "R" + paddedNum;

                return nextCode;
            }

            //generate the lastest customer id
            function generate_customer_id(last_id) {
                // Current customer id
                const currentCode = last_id;

                // Extract numerical part
                const currentNum = parseInt(currentCode.match(/\d+/)[0]);

                // Generate next number
                const nextNum = currentNum + 1;

                // Pad with leading zeros
                const paddedNum = nextNum.toString().padStart(currentCode.match(/\d+/)[0].length, "0");

                // Concatenate prefix and padded number to generate next reservation code
                const nextCode = "C" + paddedNum;

                return nextCode;
            }

    </script>
</body>

</html>