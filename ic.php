<?php
//This file is to return the availability of car in that particular booking date 
//return true/false
$ic = "0";
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Get the data from the request body
  $data = json_decode(file_get_contents("php://input"), true);

  // Check if the data is valid
  if ($data && isset($data["icno"])) {
    $ic = $data["icno"];
  }
}

//open connection
$conn = new mysqli("localhost", "root", "", "comp1044_database");

//default customer id
//if response with this default id, mean customer not found
$cid = 'C0000';

$sql = "SELECT customer_id FROM customer where IC_NO = '$ic';";
$result = $conn->query($sql);

if ($DataRows = $result->fetch_assoc()) {
  $cid = $DataRows["customer_id"];
}

//close connection
$conn->close();

$response = ['msg' => $cid];
header('Content-Type: application/json');
echo json_encode($response);
exit();
