<?php include 'session.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <style>
  table {
  border-collapse: collapse;
  width: 100%;
  max-width: 1000px;
  margin: 0 auto;
  margin-top: 10px;
  font-size: 14px;
  color: #333;
 
}

table thead tr th {
  background-color: #1C4E80;
  color: #fff;
  text-align: left;
  padding: 10px;
  font-weight: bold;
  font-size: 16px;
}

table tbody tr:nth-child(odd) {
  background-color: #f5f5f5;
}

table tbody tr:hover {
  background-color: #A5D8DD;
}

table td {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

table td.highlight {
  color: #1C4E80;
  font-weight: bold;
}

table td.warning {
  color: #F44336;
  font-weight: bold;
}

@media (max-width: 767px) {
  table thead {
    display: none;
  }

  table tbody tr {
    display: block;
    margin-bottom: 10px;
    border: 1px solid #ddd;
  }

  table tbody td:before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    margin-right: 10px;
    text-transform: uppercase;
  }
}

#search {
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-right: 10px;
}

#key, #sort {
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-right: 10px;
}

button {
  background-color: #1C4E80;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
}

button:hover {
  background-color: #133A94;
}

form {
  display: inline-block;
}


#table-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 10px;
}

#searchbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}


  </style>
  <link rel="stylesheet" href="mainpage.css">

</head>

<body>
  <div class="wrapper">
    <div class="sidebar">
      <h2>Menu</h2>
      <ul>
        <li><a href="main.php"><i class="fa-solid fa-house"></i>Home</a></li>
        <li><a href="reservation_dashboard.php"><i class="fa-sharp fa-solid fa-file"></i>Reservation_Dashboard</a></li>
        <li><a href="reservation.php"><i class="fa-sharp fa-solid fa-file"></i>New Reservation</a></li>
        <li><a href="customer_dashboard.php"><i class="fa-solid fa-car"></i>Customer_Dashboard</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-eye"></i>Admin_Dashboard</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-database"></i>Vehicle_Dashboard</a></li>
      </ul>
    </div>
    <div class="main_content">
      <div class="header">Premier Car Rental Agency
        <div class="text">
          <a href="logout.php">
            Logout
          </a>
        </div>
        <div class="info">
        </div>
      </div>
      
      <div id="table-container">
      <div id="searchbar">
      <input type="text" id="search" onkeyup="filter()" placeholder="Search" autocomplete="off">
      <select id="key">
        <option value="0" selected>Search by:</option>
        <option value="0">Customer id</option>
        <option value="1">Customer name</option>
        <option value="2">IC No</option>
      </select>

      <form method="post">
      <select id="sort" name="sort">
        <option value="0" selected>Sort by:</option>
        <option value="0">Customer id Ascending</option>
        <option value="1">Customer id Descending</option>
        <option value="2">Name Ascending</option>
        <option value="3">Name Descending</option>
      
      </select>
      <button name ="apply">Apply</button>
      </form>
      </div>
      
      <table id="customer_table">
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
           //default
           $sort = "customer_id ASC";
          
           if(isset($_POST["apply"])){
             if($_POST["sort"] == 1){
              $sort = "customer_id DESC";
             }elseif($_POST["sort"] == 2){
              $sort = "Last_name ASC";
             }
             elseif($_POST["sort"] == 3){
               $sort = "Last_name DESC";
             }else{
               $sort = "customer_id ASC";
             }
           }

          $conn = new mysqli("localhost", "root", "", "car_rental");

          //query to select firstname and lastname from customer database
          $sql = "SELECT * FROM customer ORDER BY $sort";
          $result = $conn->query($sql);
          while ($DataRows = $result->fetch_assoc()) {
            $c_id = $DataRows["customer_id"];
            $customername =  $DataRows["First_name"] . ' ' . $DataRows["Last_name"];
            $ic = $DataRows["IC_NO"];
            $gender = $DataRows["Gender"];
            $birthdate = $DataRows["Birthdate"];
            $phone_number = $DataRows["Phone_Number"];
            $email = $DataRows["Email"];
            $address = $DataRows["Address"];

          ?>
            <tr>
              <td><?php echo $c_id; ?></td>
              <td><?php echo $customername; ?></td>
              <td><?php echo $ic; ?></td>
              <td><?php echo $gender; ?></td>
              <td><?php echo $birthdate; ?></td>
              <td><?php echo $phone_number; ?></td>
              <td><?php echo $email; ?></td>
              <td><?php echo $address; ?></td>
              <td><a href="change_customer.php?c_id=<?php echo $c_id ?>" role="button" aria-disabled="true">edit</a>
                <a href="delete_customer.php?c_id=<?php echo $c_id ?>" role="button" aria-disabled="true">delete
              </td>
            </tr>
          <?php  } ?>


        </tbody>
      </table>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    //prevent form resubmission
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }



    function filter() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("search");
      filter = input.value.toUpperCase();
      table = document.getElementById("customer_table");
      tr = table.getElementsByTagName("tr");
      select = document.getElementById("key").value;

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[select];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>
</body>

</html>