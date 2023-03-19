<!DOCTYPE html>
<html>

<head>
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

        input {
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
        }

        button:hover {
            background-color: #3e8e41;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>Cancel Reservation</h1>
    <form method="post">
        <label for="reservation-id">Customer ID:</label>
        <input type="text" id="customer-id" name="customer-id" readonly>

        <button name="delete">delete</button>
    </form>

    <script type="text/javascript">
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        function redirect(){
        window.location.replace("http://localhost/car_rental/customer_dashboard.php");
        }

        <?php
         $c_id = $_GET["c_id"];

         echo "document.getElementById('customer-id').value = '$c_id';";

        if (isset($_POST["delete"])) {
            $conn = new mysqli("localhost", "root", "", "car_rental");

            $c_id = $_POST["customer-id"];
            $sql  = "DELETE FROM customer WHERE customer_id = '$c_id' ";

            if ($conn->query($sql) === TRUE) {
                $NumRowsDeleted = $conn->affected_rows;
                if ($NumRowsDeleted == 1) {
                    echo 'alert("Delete Successful");';
                } else {
                    echo "alert('Customer not found');";
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