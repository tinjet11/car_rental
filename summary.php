<?php
include 'session.php';
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="mainpage.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="form.css">
    <script src="sidebar.js"></script>
    <style>
        @media print {
            @page {
                size: landscape;
            }

            * {
                page-break-before: avoid;
                page-break-after: avoid;
            }

            #summary-title {
                margin-top: 100px;
            }

            .header {
                display: none;
            }

            @page {
                margin-top: 0;
                margin-bottom: 0;
            }


            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
            }


        }

        .receipt {
            border: 2px solid black;
            padding: 10px;
            margin: 10px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            display: flex;
            box-shadow: none;
        }

        .column-title {
            font-weight: bold;
            margin-right: 10px;
        }

        .left-column {
            border-right: 2px solid black;
            padding-right: 10px;
            margin-right: 10px;
        }

        .left-column .row{
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            margin-bottom: 5px;
        }

        #summary-title {
            text-align: center;
            color: black;
            font-size: 30px;
        }

        .table {
            border-collapse: collapse;
            width: 155%;
            border: 2px solid #ddd;
            box-shadow: none;

        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: transparent;
        }
    </style>


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

            <div class="content">
                <?php
                $conn = new mysqli("localhost", "root", "", "comp1044_database");
                $rid = $_GET["r_id"];
                $sql = "SELECT reservation.booking_datetime,reservation.return_datetime,reservation.staff_id,reservation.vehicle_id,  
                 reservation.customer_id,customer.First_name,customer.Last_name,customer.IC_NO,customer.Phone_Number,reservation.duration,
                 vehicle.price,vehicle.model,vehicle.color FROM ((reservation INNER JOIN vehicle ON reservation.vehicle_id = vehicle.vehicle_id)
                 INNER JOIN customer ON reservation.customer_id = customer.customer_id) WHERE reservation.reservation_id = '$rid';";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                ?>

                <h4 id="summary-title">Reservation Summary</h4>
                <div class="receipt">
                    <div class="left-column">
                        <div class="row">
                            <div class="column-title">Reservation ID: </div>
                            <div class="column"><?php echo $rid; ?></div>
                        </div>
                        <div class="row">
                            <div class="column-title">Staff ID: </div>
                            <div class="column"><?php echo $row["staff_id"]; ?></div>
                        </div>
                        <div class="row">
                            <div class="column-title">Customer ID: </div>
                            <div class="column"><?php echo $row["customer_id"]; ?></div>
                        </div>
                        <div class="row">
                            <div class="column-title">Customer Name: </div>
                            <div class="column"><?php echo $row["First_name"] . " " . $row["Last_name"]; ?></div>
                        </div>
                        <div class="row">
                            <div class="column-title">Customer IC: </div>
                            <div class="column"><?php echo $row["IC_NO"]; ?></div>
                        </div>
                        <div class="row">
                            <div class="column-title">Phone Number: </div>
                            <div class="column"><?php echo $row["Phone_Number"]; ?></div>
                        </div>
                        <div class="row">
                            <div class="column-title">Pickup DateTime: </div>
                            <div class="column"><?php echo $row["booking_datetime"]; ?></div>
                        </div>
                        <div class="row">
                            <div class="column-title">Return DateTime: </div>
                            <div class="column"><?php echo $row["return_datetime"]; ?></div>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="row" style="margin-left:200px;">
                            <h3>Vehicle Details</h3>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="table">Vehicle ID: </th>
                                    <td><?php echo $row["vehicle_id"]; ?></td>
                                </tr>
                                <tr>
                                    <th scope="table">Vehicle Description: </th>
                                    <td><?php echo $row["model"] . "(" . $row["color"] . ")"; ?></td>
                                </tr>
                                <tr>
                                    <th scope="table">Price per day: </th>
                                    <td>RM <?php echo $row["price"]; ?></td>
                                </tr>
                                <tr>
                                    <th scope="table">Duration: </th>
                                    <td><?php echo $row["duration"]; ?> days</td>
                                </tr>
                                <tr>
                                    <th scope="table">Amount: </th>
                                    <?php $amount = $row["price"] * $row["duration"]; ?>
                                    <td>RM <?php echo $amount; ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>


            </div>



            <script>
                function printReservation() {
                    const originalOverflow = document.body.style.overflow;
                    document.body.style.overflow = "hidden"; // hide scrollbars temporarily
                    window.print();
                    document.body.style.overflow = originalOverflow; // restore scrollbars
                }
                printReservation()
            </script>