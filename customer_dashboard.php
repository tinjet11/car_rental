<!DOCTYPE html>
<html>

<head>
    <style>
 
  table {
    border-collapse: collapse;
    width: 100%;
  }
  
  th, td {
    text-align: center;
    padding: 8px;
    border-bottom: 1px solid #ddd;
  }
  
  tr:hover {
    background-color: #f5f5f5;
  }
  
  th {
    background-color: #4CAF50;
    color: white;
  }
  
  td:nth-child(2), td:nth-child(8) {
    text-align: center;
  }
  
  td:nth-child(1), td:nth-child(2) {
    font-weight: bold;
  }

    </style>
</head>

<body>


    <table>
        <thead>
            <tr>
                <th>Customer ID</th> 
                <th>Customer Name</th>
                <th>IC NO</th> 
                <th>Gender</th> 
                <th>Birthdate</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>              
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            <?php

            $conn = new mysqli("localhost", "root", "", "car_rental");

                //query to select firstname and lastname from customer database
                $sql = "SELECT * FROM customer";
                $result = $conn->query($sql);
                while ($DataRows = $result->fetch_assoc()) {
                $c_id = $DataRows["customer_id"];
                $customername =  $DataRows["First_name"] .' '. $DataRows["Last_name"];
                $ic = $DataRows["IC_NO"];
                $gender = $DataRows["Gender"];
                $birthdate = $DataRows["Birthdate"];
                $phone_number = $DataRows["Phone_Number"];
                $email = $DataRows["Email"];
                $address = $DataRows["Address"];

            ?>
                <tr>
                    <td><?php echo $c_id ;?></td>
                    <td><?php echo $customername ;?></td>
                    <td><?php echo $ic ;?></td>
                    <td><?php echo $gender;?></td>
                    <td><?php echo $birthdate;?></td>
                    <td><?php echo $phone_number ;?></td>
                    <td><?php echo $email ;?></td>
                    <td><?php echo $address ;?></td>
                    <td><a href="change_customer.php?c_id=<?php echo $c_id ?>" role="button" aria-disabled="true">edit</a>
                    <a href="delete_customer.php?c_id=<?php echo $c_id ?>" role="button" aria-disabled="true">delete</td>
                </tr>
            <?php  } ?>


        </tbody>
    </table>

    <script type="text/javascript">
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>