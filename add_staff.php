 <?php
  include 'session.php';
  ?>

 <!DOCTYPE html>
 <html>
 <link rel="stylesheet" href="mainpage.css">
 <link rel="stylesheet" href="form.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
 <script src="sidebar.js"></script>
 </head>

 <body>

   <!-- Container -->
   <div class="container">

     <!-- Sidebar -->
     <div class="sidebar" id="sidebar">
       <h2>Menu</h2>
       <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
       <ul>
         <li><a href="main.php"><i class="fa-solid fa-house"></i>Home</a></li>
         <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation_Dashboard</a></li>
         <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
         <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer_Dashboard</a></li>
         <li><a href="staff_dashboard.php"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
         <li><a href="vehicle_dashboard.php"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
       </ul>
     </div><!-- end of sidebar -->

     <!-- Main content -->
     <div class="main_content" id="main_content">

       <!-- Header -->
       <div class="header" id="header">
         <button class="openbtn" id="openbtn" onclick="openNav()">☰ </button>
         Premier Car Rental Agency
         <div class="dropdown" style="float:right;">
           <button class="dropbtn"><i class="fa-solid fa-user"></i></button>
           <div class="dropdown-content">
             <a href="profile.php"><i class="fa fa-home"></i> Profile </a>
             <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
           </div>
         </div>

       </div><!-- end of header-->
       
       <!-- Table container -->
       <div id="table-container">

         <form method="post" enctype="multipart/form-data">
           <h1>Add New Staff:</h1>
           <label for="Staff_ID">Staff ID:</label>
           <input type="text" id="Staff_ID" name="Staff_ID" required>

           <label for="username">Username:</label>
           <input type="text" id="username" name="username" required>

           <label for="password">Password:</label>
           <input type="text" id="password" name="password" required>

           <label for="name">Name:</label>
           <input type="text" id="name" name="name" required>

           <label for="role">Role:</label>
           <input type="text" id="role" name="role" required>

           <button type="submit" id="change" name="change">Submit</button>
           <a href="staff_dashboard.php">Back</a>

         </form>

       </div><!-- end of table container-->

       <script>
         //prevent form resubmission
         if (window.history.replaceState) {
           window.history.replaceState(null, null, window.location.href);
         }

         //redirect to specific page after action
         function redirect() {
           window.location.replace("http://localhost/car_rental/staff_dashboard.php");
         }

         <?php
          //open connection
          $conn = new mysqli("localhost", "root", "", "car_rental");

          //select the lastest staff id from database
          $sql = "SELECT  staff_id from admin ORDER BY staff_id DESC LIMIT 1 ";
          $result = $conn->query($sql);
          $DataRows = $result->fetch_assoc();
          $last_staff_id = $DataRows["staff_id"];

          //close connection
          $conn->close();
          ?>

         //generate new staff id
         function generate_staff_id(last_id) {
           // Current staff id
           const currentCode = last_id;

           // Extract numerical part
           const currentNum = parseInt(currentCode.match(/\d+/)[0]);

           // Generate next number
           const nextNum = currentNum + 1;

           // Pad with leading zeros
           const paddedNum = nextNum.toString().padStart(currentCode.match(/\d+/)[0].length, "0");

           // Concatenate prefix and padded number to generate next staff id
           const nextCode = "S" + paddedNum;

           return nextCode;
         }

         // display the staff id in the form
         document.getElementById('Staff_ID').value = generate_staff_id('<?php echo $last_staff_id ?>');

         <?php

          //open connection
          $conn = new mysqli("localhost", "root", "", "car_rental");
          if (isset($_POST["change"])) {

            $id = isset($_POST["Staff_ID"]) ? $_POST["Staff_ID"] : "";
            $user = isset($_POST["username"]) ? $_POST["username"] : "";
            $pass = isset($_POST["password"]) ? $_POST["password"] : "";
            $name = isset($_POST["name"]) ? $_POST["name"] : "";
            $role = isset($_POST["role"]) ? $_POST["role"] : "";

            // check if all required fields are filled
            if ($id != "" && $user != "" && $pass != "" && $name != "" && $role != "") {

              //insert new staff data into database
              $sql = "INSERT INTO admin(staff_id,username,password,name,role) VALUES('$id','$user','$pass','$name','$role')";

              if ($conn->query($sql) == true) {
                echo 'alert("Add Successful");';
                echo 'redirect();';
              } else {
                echo 'alert("Error: Problem Adding New Data");';
              }
            } else {
              echo 'alert("Error: Please fill all required fields.");';
            }
          }

          //close connection
          $conn->close()
          ?>
       </script>
 </body>

 </html>