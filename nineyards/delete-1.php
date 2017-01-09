<?php

		require_once 'config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	    if (mysqli_connect_error()) {
	  			die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
	 		}	

	 	$IDDelete = $_POST['id']; 

	      if(isset($_POST['submitDel'])){
	 		$result = $mysqli->query("DELETE FROM PRODUCTS WHERE productID='". $IDDelete ."'");
	 		header("Location: shop.php");
	     } else if(isset($_POST['submitSold'])) {
	        $result = $mysqli->query("UPDATE PRODUCTS SET sold='1' WHERE productID='". $IDDelete ."'");
	        header("Location: shop.php");
	     }
	     
?>


