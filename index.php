<?php
// session_start();
// include("connection.php");
//include("login.php");

?>

<html>

<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            text-align: center;
            font-family: Verdana;
            background-image: url(background.jpg);
            background-size: cover;
        }

        .loginbox {
            width: 320px;
            height: 420px;
            background: #fff;
            color: #fff;
            top: 0%;
            left: 50%;
            position: absolute;
            transform: translate(-50%, 50%);
            box-sizing: border-box;
            background: transparent;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 80%;
            position: static;
            border: 5px solid black;
        }

        h1 {
            margin: 0;
            padding: 0 0 20px;
            text-align: center;
            font-size: 22px;
            color: #000;
            text-decoration: underline;
        }

        .loginbox p {
            margin: 0;
            padding: 0;
            font-weight: bold;
            color: #000;
        }

        .loginbox input {
            width: 100%;
            margin-bottom: 20px;
        }

        .loginbox input[type="text"],
        input[type="username"] {
            border: none;
            border-bottom: 1px solid #fff;
            background: transparent;
            outline: none;
            height: 40px;
        }

        .loginbox input[type="text"],
        input[type="password"] {
            border: none;
            border-bottom: 1px solid #fff;
            background: transparent;
            outline: none;
            height: 40px;
        }

        .loginbox input[type="submit"] {
            border: none;
            outline: none;
            height: 40px;
            background: #fb2525;
            color: #fff;
            font-size: 18px;
            border-radius: 20px;
        }

        .loginbox input[type="submit"]:hover {
            cursor: pointer;
            background: #ffc107;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="loginbox">
        <img src="avatar.jpg" class="avatar">
        <br>
        <br>
        <h1>Staff Login</h1>
        <form name="form" action="index.php" method="POST">
            <p>Username</p>
            <input type="username" id="user" name="user" required></br></br>
            <p>Password</p>
            <input type="password" id="pass" name="pass" required></br></br>
            <input type="submit" id="btn" value="Login" name="submit" />
        </form>
    </div>
    <script>
        <?php

        //include("connection.php");
        $conn = new mysqli("localhost", "root", "", "car_rental");
        if (isset($_POST['submit'])) {
            $username = $_POST['user'];
            $password = $_POST['pass'];



            $sql = "SELECT username,password,staff_id FROM admin WHERE username = '$username' and password = '$password'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            session_start();
            $_SESSION["timelimit"] = time();
            $_SESSION["staffid"] = $row["staff_id"];


            if ($count == 1) {
                header("Location: main.php");
            } else {
                echo '
					window.location.href = "index.php";
					alert("Login failed. Invalid username or password")
				';
            }
            $conn->close();
        }


        ?>
    </script>
</body>

</html>