<?php
	session_start();
	include("connection.php");
	if(isset($_POST['submit'])){
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$_SESSION["timelimit"] = time();
		$_SESSION["user"] = $_POST['user'];

		$sql = "select * from login where username = '$username' and password = '$password'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);

		if($count==1){
			header("Location: main.php");
		}
		else{
			echo '<script>
					window.location.href = "index.php";
					alert("Login failed. Invalid username or password")
				</script>';
		}
	}
?>


