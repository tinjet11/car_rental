<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Verdana;
    }

    html,
    body {
      height: 100%;
    }

    body {
      display: grid;
      place-items: center;
      background: linear-gradient(90deg, hsla(222, 77%, 33%, 1) 0%, hsla(0, 100%, 78%, 1) 100%);
      text-align: center;
    }

    .content {
      width: 500px;
      height: auto;
      padding: 40px 30px;
      background: #133A94;
      border-radius: 10px;
      box-shadow: -3px -3px 7px #ffffff73,
        2px 2px 5px rgba(94, 104, 121, 0.288);
    }

    .content .text {
      font-size: 33px;
      font-weight: 600;
      margin-bottom: 35px;
      color: #FFFFFF;
    }

    .field {
      height: 50px;
      width: 100%;
      display: flex;
      position: relative;
    }

    .field input {
      height: 100%;
      width: 100%;
      padding-left: 45px;
      outline: none;
      border: none;
      font-size: 18px;
      background: #dde1e7;
      color: #595959;
      border-radius: 25px;
      box-shadow: inset 2px 2px 5px #BABECC,
        inset -5px -5px 10px #ffffff73;
    }

    .field span {
      position: absolute;
      color: #FFFFFF;
      width: 50px;
      line-height: 50px;
    }

    button {
      margin: 15px 0;
      width: 100%;
      height: 50px;
      font-size: 18px;
      line-height: 50px;
      font-weight: 600;
      color: #FFFFFF;
      border-radius: 25px;
      border: none;
      outline: none;
      cursor: pointer;
      color: #595959;
      box-shadow: 2px 2px 5px #BABECC,
        -5px -5px 10px #ffffff73;
    }

    button:focus {
      color: #3498db;
      box-shadow: inset 2px 2px 5px #BABECC,
        inset -5px -5px 10px #ffffff73;
    }

    h1 {
      padding: 20px;
      color: #fdfff5;
      text-align: center;
      font-size: 25px;
      font-weight: bold;

    }
  </style>
</head>

<body>
  <div>
    <h1>Premier Car Rental Agency</h1>
    <div class="content">
      <div class="text">
        Staff Login
      </div>
      <form name="form" id="login-form" action="login.php" method="POST">
        <div class="field">
          <input type="username" id="user" name="user" placeholder="Username" required>
          <span class="fa-solid fa-user"></span>
        </div>
        <br>
        <div class="field">
          <input type="password" id="pass" name="pass" placeholder="Password" required>
          <span class="fa-solid fa-lock"></span>
        </div>
        <button type="submit" id="btn" name="submit">Sign in</button>
      </form>
    </div>
  </div>
  <script>
    //prevent form resubmission
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
    <?php

    $conn = new mysqli("localhost", "root", "", "comp1044_database");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['submit'])) {
      $username = $_POST['user'];
      $password = $_POST['pass'];

      // Prepare the statement
      $stmt = $conn->prepare("SELECT username, password, staff_id, name FROM admin WHERE username = ? and password = ?");
      $stmt->bind_param("ss", $username, $password);
      $stmt->execute();
      $result = $stmt->get_result();

      // Process the result
      $row = $result->fetch_assoc();
      $count = $result->num_rows;
      session_start();
      $_SESSION["timelimit"] = time();
      $_SESSION["staffid"] = $row["staff_id"];
      $_SESSION["name"] = $row["name"];

      if ($count == 1) {
        header("Location: main.php");
        exit();
      } else {
        echo '
                alert("Login failed. Invalid username or password");
              ';
        exit();
      }
    }
    $conn->close();


    ?>
  </script>
</body>

</html>