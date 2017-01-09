<?php

        require_once 'config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		if (mysqli_connect_error()) {
  			die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
 		}

 		$pieces = explode("-", $_POST['id']);
 		$part = $pieces[0];
 		$id=$pieces[1];
        $capsname = $_POST['value'];
        $capsname = test_input($capsname);
        $floatvar = number_format(floatval($capsname), 2);
        
        if($part == 'price'){
        	if($floatvar != 0){
	        	$result = $mysqli->query("UPDATE PRODUCTS SET ". $part ."='". $floatvar . "' WHERE productID='". $id ."'");
	        	print $floatvar;
            } else{
            	$queryString = "SELECT ". $part ." FROM PRODUCTS WHERE productID='". $id ."'";
            	$result = $mysqli->query($queryString);
            	$row = $result->fetch_row(); 
            	$keepLastResult = $row[0];
            	print $keepLastResult;
	            echo '<script language="javascript">';
				echo 'alert("Invalid Input")';
				echo '</script>';
            }
        } else{
        	$result = $mysqli->query("UPDATE PRODUCTS SET ". $part ."='". $capsname . "' WHERE productID='". $id ."'");
        	print $capsname;
        }

        function test_input($data) {
	        $data = trim($data);
	        $data = stripslashes($data);
	        $data = htmlspecialchars($data);
	        return $data;
        }

?>