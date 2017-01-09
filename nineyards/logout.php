<?php
	//Need to start a session in order to access it to be able to end it
	session_start();
	
	if (isset($_SESSION['logged_user'])) {
		$olduser = $_SESSION['logged_user'];
		unset($_SESSION['logged_user']);
		header("Location: login.php");
	} else {
		$olduser = false;
		header("Location: login.php");
	}
?>

