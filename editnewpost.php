<?php
require_once("include/db.php");
$ID = $_GET["id"];
if (isset($_POST["publish"])) {
    $PostTitle = $_POST["PostTitle"];
    $category = $_POST["category"];
    $PostContent = $_POST["PostContent"];
    $Target = "/xampp/htdocs/html/ccwebsite/upload/" . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $Target);

$admin_name = "tinjet";
date_default_timezone_set("Asia/Kuala_Lumpur");
$CurrentTime = time();
$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

$sql  = "UPDATE posts SET title=:posttitle ,category=:category ,image =:image ,post=:postcontent,author=:adminName,datetime=:dateTime  WHERE  id = $ID";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':posttitle', $PostTitle);
$stmt->bindValue(':category', $category);
$stmt->bindValue(':image', $_FILES["image"]["name"]);
$stmt->bindValue(':postcontent', $PostContent);
$stmt->bindValue(':adminName', $admin_name);
$stmt->bindValue(':dateTime', $DateTime);
$Execute = $stmt->execute();
}

global $ConnectingDB;
$sql = "SELECT id, category FROM category";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
    $Id = $DataRows["id"];
    $CategoryName = $DataRows["category"];
}





$sql1 = "SELECT  title, category, image, post  FROM posts WHERE id= $ID ";
$stmt1 = $ConnectingDB->query($sql1);
$oridata = $stmt1->fetch();
  
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="bootstrap/bootstrap/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>

<body>

    <nav class="navbar navbar-light" style="background-color: #e3f3fd;">
    </nav>

    <!--Nav Bar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Page</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#"><i class="fa fa-user" aria-hidden="true"></i>My Profile</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Dashboard</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Posts</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Categories</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Manage Admins</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Comments</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Live Blog</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    </nav>

    <!--Manage Categories -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Add New Post</a>
        </div>
    </nav>

    <nav class="navbar navbar-light" style="background-color: #ffffff;">
    </nav>

    <!-- add New post -->
    <form class="mx-auto col-10" action="editnewpost.php?id=<?php echo $ID; ?>" method="post" enctype="multipart/form-data">
        <div class="card bg-secondary text-light mb-3">
            <div class="card-body bg-dark">
      

                <h6 class="card-title" style="color: #E0A800;">Post Title: <span><?php echo $oridata["title"]; ?></span></h6>
                <input type="text" name="PostTitle" style="margin-bottom: 10px;" class="form-control" placeholder="Type title here">

                <h6 class="card-title" style="color: #E0A800;">Choose category: <span><?php echo $oridata["category"]; ?></span> </h6>
                <input type="text" name="category" style="margin-bottom: 10px;" list="datalistOptions" class="form-control" placeholder="Choose Category here">
                <datalist id="datalistOptions">
                        <option value="<?php echo $CategoryName ?>"></option>
                </datalist>




                <h6 class="card-title" style="color:#E0A800;;">Select image: <span><?php echo $oridata["image"];?></span></h6>
                <input type="file" name="image" style="margin-bottom: 10px;" class="form-control" accept="image/*">

                <h6 class="card-title" style="color: #E0A800;">Post: <span><?php echo $oridata["post"]; ?></span></h6>
                 
                <input type="text" name="PostContent" style="margin-bottom: 10px;height: 150px;" class="form-control">
         
                <div class="row gx-5">
                   
                    <a href="listpost.php"  class="btn btn-warning btn-lg col-md-6 ms-auto"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back To Dashboard</a>
                    <button type="submit" name="publish" class="btn btn-success btn-lg col-md-6 ms-auto"><i class="fa fa-check" aria-hidden="true"></i>Publish</button>

    </form>
    
    </div>
    </div>
    </div>


</body>

</html>