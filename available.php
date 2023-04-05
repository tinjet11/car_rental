<?php
//This file is to return the availability of car in that particular booking date 
//return true/false

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if the data is valid
    if ($data && isset($data["vehicle"]) && isset($data["pickup"]) && isset($data["return"]) && isset($data["reservation"])) {


        $vid = $data["vehicle"];
        $rid = $data["reservation"];
        $pickupTime = $data["pickup"];
        $returnTime = $data["return"];

    }
}



$available = true;
$conn = new mysqli("localhost", "root", "", "comp1044_database");

$sql = "SELECT booking_datetime,return_datetime FROM reservation where vehicle_id = '$vid' AND reservation_id NOT IN ('$rid'); ";
$result = $conn->query($sql);
while ($DataRows = $result->fetch_assoc()) {
    $b_dt = $DataRows["booking_datetime"];
    $r_dt = $DataRows["return_datetime"];

    if ($pickupTime <= $b_dt) {
        if ($returnTime >= $b_dt) {
            $available = false;
        }
    }

    if ($pickupTime >= $b_dt && $pickupTime <= $r_dt) {
        $available = false;
    }
}
$conn->close();

$response = ['msg' => $available];
header('Content-Type: application/json');
echo json_encode($response);
exit();
