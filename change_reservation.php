<!DOCTYPE html>
<html>

<head>
    <script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        form {
            display: flex;
            flex-direction: column;
            max-width: 500px;
            margin: 0 auto;
            border: 2px solid #ccc;
            padding: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input,
        textarea {
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
            border: none;
            border-bottom: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            align-self: flex-end;
            width: 100px;
            float: right;
        }

        button:hover {
            background-color: #3e8e41;
        }

        select {
            padding: 12px;
            width: 100%;
            font-size: 16px;
            line-height: 1.3;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-repeat: no-repeat;
            background-position: right 8px center;
            cursor: pointer;
            margin-bottom: 10px;
        }

        select:hover,
        select:focus {
            border-color: #999;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
        }

        #search_div {
            display: block;
        }

        #found_div {
            display: block;
        }

        #check_div {
            display: none;
        }

        #reserve_div {
            display: none;
        }
    </style>
</head>

<body>
    <form method="post" id="reservation_form" enctype="multipart/form-data">
        <h1>Change Reservation</h1>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        
        function redirect(){
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

                var rid = '<?php echo $r_id;?>';

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
    </script>
</body>

</html>