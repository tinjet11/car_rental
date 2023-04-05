<?php
//This file is to return the availability of car in that particular booking date 
//return true/false

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") { //Checks if the request method is POST

    // Get the data from the request body
    $data = json_decode(file_get_contents("php://input"), true);
  
    // Check if the data is valid
    if ($data && isset($data["vehicle"]) && isset($data["pickup"]) && isset($data["return"])&& isset( $data["reservation"]))  {
     
     
        $vid = $data["vehicle"]; //Extract the data and store it as separate variables
        $rid = $data["reservation"];
      $pickupTime = $data["pickup"];
      $returnTime = $data["return"];
  
      // Do something with the data
      // For example, store it in a database
    }
  }



$available = true;
$conn = new mysqli("localhost", "root", "", "comp1044_database"); //creating mysqli object to connect to database

$sql = "SELECT booking_datetime,return_datetime FROM reservation where vehicle_id = '$vid' AND reservation_id NOT IN ('$rid'); "; //SQL query to retrieve the booking and return datetime for all reservations which doesn't match the current reservation ID.
$result = $conn->query($sql); //Result store in variable
while ($DataRows =$result->fetch_assoc()) { //While loop that iterates over each row in the SQL query result. "fetch_assoc()" method retrieves the next row and stores it in the relavant variables.
    $b_dt = $DataRows["booking_datetime"]; 
    $r_dt = $DataRows["return_datetime"];

    if ($pickupTime <= $b_dt) { //Checks if the pickup time is before or equal to the booking datetime
        if ($returnTime >= $b_dt) { //Checks if the return time is after or equal ot he booking datetime
            $available = false; 
        }
    }

    if ($pickupTime >= $b_dt && $pickupTime <= $r_dt) { //Checks if the requested pickup time is after or equal to the booking datetime of the reservation and before or equal to the reservation
        $available = false;
    }
}
$conn->close();

$response = ['msg' => $available];
header('Content-Type: application/json');
echo json_encode($response);
exit();