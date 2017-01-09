<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Add Product</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>

<body>
	<?php
		//Initialize Variables
		//Check for session variable
		if (isset($_SESSION['admin_enabled'])){
			$admin = $_SESSION['admin_enabled'];
		} else {
			$admin = NULL;
		}

		//Establish SQL connection
		require_once 'config.php';
		$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		
		//If Connection Failed
		if ( $mysqli->connect_errno ) {
			echo "Failed to connect to MySQL: " . $mysqli->connect_error;
		
		//If Connection Successful
		} else {

		    //Check for uploaded file 
		    if ( ! empty( $_FILES['new_photo'] ) ) {
				$new_photo = $_FILES['new_photo'];
				$originalName = $new_photo['name']; 
				preg_match("/[.][^.]+/", $originalName, $ext);
				preg_match("/[^.]+/", $originalName, $file);
				$thumbnail = "$file[0]"."_thumbnail"."$ext[0]";

				
				//If file uploaded without errors
				if ( $new_photo['error'] == 0 ) {
					$tempName = $new_photo['tmp_name'];
					move_uploaded_file( $tempName, "img/products/small/$originalName");
					copy ("img/products/small/$originalName","img/products/large/$originalName");
					copy ("img/products/small/$originalName","img/products/$thumbnail");
					
					//Add to PRODUCTS
					$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
					$description = filter_input( INPUT_POST, 'description', FILTER_SANITIZE_STRING );
					$price = filter_input( INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT );
					$mysqli->query("INSERT INTO PRODUCTS (name, price, description) VALUES ('$name','$price','$description')");

					//Retrieve photo_id
					$pid = $mysqli->insert_id;
					
					/*	//TODO: Implement resizing from course code
					$_SESSION['photos'][] = $originalName;
					require_once 'resize.php';
					save_thumbnail( "images/$originalName", "thumbnails/$originalName", 200 );
					*/
					
					//Add to PHOTOS
					$caption = filter_input( INPUT_POST, 'caption', FILTER_SANITIZE_STRING );
					$mysqli->query("INSERT INTO PHOTOS (url, productID, caption) VALUES ('$originalName','$pid','$name')");
					
					//Add to 0 or more CATEGORIZATIONS
					if (isset($_POST['categories'])){
						foreach ($_POST['categories'] as $categoryID){
							$mysqli->query("INSERT INTO CATEGORIZATIONS (productID, categoryID) VALUES ('$pid','$categoryID')");
						}
					}
					
					//Save success message
					$file_message = "$originalName success";

				//If file uploaded with errors
				} else {

					//Save error message
					$file_message="$originalName error";
				}
			}
		}
	?>


		<?php
		//ADMIN OPTION: Upload Form, replaces login form
		//if (isset($admin)){
		if (TRUE){

			if(isset($_SESSION['logged_user'])) {
				print("<span class='view'><a href='#upload_form' class='deladdButton'> Add new product</a></span>");
			
            
			echo "<div id='upload_form' class='modalDialog'>
			      <div>
			      <a href='#close' title='Close' class='close'>X</a>
			       <div class='top item_name'> <p>Upload new product</p> </div>
			      <div class='form-text'>
				  <form action='shop.php' method='post' enctype='multipart/form-data'>
					<input type='file' name='new_photo'><br>
					<label for='name'>Product Name:</label><br>
					<input type='text' name='name'><br>
					<label for='description'>Product Description:</label><br>
					<input type='text' name='description'><br>
					<label for='price'>Price:</label><br>
					<input type='number' name='price' min='0'><br>
					<label>Upload To:</label><br>";
					//get categories
					$categories = $mysqli->query("SELECT categoryID, title FROM CATEGORIES");
					//Create options to add product to categories
					while ($categorizations = $categories->fetch_assoc()){
						print("<input type=checkbox name='categories[]' value='{$categorizations[ 'categoryID' ]}'>{$categorizations[ 'title' ]}<br>");
					}
					echo "<input type='submit' value='Upload Product'><br> </form> </div> </div> </div>";
				}
		}

		//Close connection
		$mysqli->close();
	?>

</body>
</html>