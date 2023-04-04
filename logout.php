<?php
	session_start(); // Initializes a new session/ resume a existing session
	session_destroy(); // Destroys all data in session
	header('Location: login.php'); // Redirects user to login page
?>
