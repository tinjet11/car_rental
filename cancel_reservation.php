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
        <label for="reservation-id">Reservation ID:</label>
        <input type="text" id="reservation-id" name="reservation-id" readonly>

        <button name="cancel">Cancel</button>
    </form>

    <script type="text/javascript">
        //prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        function redirect(){
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