<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="form.css">
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

            <h1>Cancel Reservation</h1>
            <form method="post">
                <label for="reservation-id">Reservation ID:</label>
                <input type="text" id="reservation-id" name="reservation-id" readonly>

                <button name="cancel">Cancel</button>
            </form>
        </div><!-- end of main content-->
    </div><!-- end of container-->







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
            window.location.replace("http://localhost/car_rental/reservation_dashboard.php");
        }

        <?php
        $r_id = $_GET["r_id"];

        echo "document.getElementById('reservation-id').value = '$r_id';";

        if (isset($_POST["cancel"])) {
            $conn = new mysqli("localhost", "root", "", "car_rental");

            $r_id = $_POST["reservation-id"];
            $sql  = "DELETE FROM reservation WHERE reservation_id = '$r_id' ";

            if ($conn->query($sql) === TRUE) {
                $NumRowsDeleted = $conn->affected_rows;
                if ($NumRowsDeleted == 1) {
                    echo 'alert("Delete Successful");';
                } else {
                    echo "alert('Reservation not found');";
                }
            } else {
                echo "alert('error');";
            }

            $conn->close();
            echo 'redirect();';
        }
        ?>
    </script>
</body>

</html>