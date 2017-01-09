<?php session_start(); ?>

<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/simpleCart.js"></script>
	<script src = "js/editable.js"></script>
	<script src = "js/form.js"></script>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src = "http://www.appelsiini.net/download/jquery.jeditable.js"></script>
    

	<title>Nine Yards</title>
	<script>
		$(document).ready(function(){
			(function($) {

			  	$.fn.menumaker = function(options) {
			      
			      	var cssmenu = $(this), settings = $.extend({
			        	title: "Menu",
			        	format: "dropdown",
			        	sticky: false
			      	}, options);

			      	return this.each(function() {
			        	cssmenu.prepend('<div id="menu-button">' + settings.title + '</div>');
			        	$(this).find("#menu-button").on('click', function(){
			          		$(this).toggleClass('menu-opened');
			          		var mainmenu = $(this).next('ul');
			          		if (mainmenu.hasClass('open')) { 
			            		mainmenu.hide().removeClass('open');
			          		}
			          		else {
			            		mainmenu.show().addClass('open');
			            		if (settings.format === "dropdown") {
			              		mainmenu.find('ul').show();
			            	}
			          	}
			        });

			        cssmenu.find('li ul').parent().addClass('has-sub');

			        multiTg = function() {
			          	cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
			          	cssmenu.find('.submenu-button').on('click', function() {
			            	$(this).toggleClass('submenu-opened');
			            	if ($(this).siblings('ul').hasClass('open')) {
			              		$(this).siblings('ul').removeClass('open').hide();
			            	}
			            	else {
			              		$(this).siblings('ul').addClass('open').show();
			            	}
			          	});
			        };

			        if (settings.format === 'multitoggle') multiTg();
			        else cssmenu.addClass('dropdown');

			        if (settings.sticky === true) cssmenu.css('position', 'fixed');

			        resizeFix = function() {
			          	if ($( window ).width() > 768) {
			            	cssmenu.find('ul').show();
			          	}

			          	if ($(window).width() <= 768) {
			            	cssmenu.find('ul').hide().removeClass('open');
			          	}
			        };
			        
			        resizeFix();
			        return $(window).on('resize', resizeFix);
			      });
			  	};
			})(jQuery);

		(function($){
			$(document).ready(function(){
				$("#cssmenu").menumaker({
			   		title: "Menu",
			   		format: "multitoggle"
				});
			});
		})(jQuery);

		simpleCart.bind("afterAdd", function(item) {
			document.getElementById("add-"+item.get("productid")).style.display = "none";
			document.getElementById("added-"+item.get("productid")).style.display = "block";
		});

		simpleCart.bind("afterAdd", function(item) {
			document.getElementById("cart-add-"+item.get("productid")).style.display = "none";
			document.getElementById("cart-added-"+item.get("productid")).style.display = "block";
		});
	})
	</script>
</head>
<body>
	<div class="wrapper">
	<!-- menu bar -->
	<div id='cssmenu'>




		<ul>
			<li class="cart"><a href="cart.php"><img src="img/shopping_cart.png" onmouseover="this.src='img/shopping_cart_full.png'" onmouseout="this.src='img/shopping_cart.png'" class="cart-container" alt="Cart"></a></li>
			<li><a href='contact.php'>Contact</a></li>
			<li><a href='shop.php'>Shop</a>
   				<ul>
		         	<li><a href='shop.php?category_id=1'>Home Decor</a></li>
		         	<li><a href='shop.php?category_id=2'>Fashion</a></li>
		         	<li><a href='shop.php?category_id=2'>Accessories</a></li>
     	 		</ul>
   			</li>
   			<li><a href='gallery.php'>Gallery</a></li>
   			<li><a href='donate.php'>Donate</a></li>
   			<li><a href='about.html'>About</a>
      			<ul>
         			<li><a href='meet-the-ladies.html'>Meet the Ladies</a></li>
         			<li><a href='timeline.html'>Timeline</a></li>
         			<li><a href='social-media.html'>Connect with Us</a></li>
      			</ul>
   			</li>
   			<li class="logo"><a href="index.php"><img src="img/logo.png" class="logo-container" alt="Logo"></a></li>
		</ul>
	</div>

	<?php
		if(isset($_SESSION['logged_user'])) {
			print("<div class='logout'>Welcome back, Admin!
				<span class='view'><a href='logout.php' class='box-button'> Log out</a></span></div>");
		}
	?>

	<h1 class="title">For Sale</h1>
	<hr>
	<?php
		require_once 'config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		if (mysqli_connect_error()) {
  			die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
 		}
		

		function getCheckedAdd() {
        	$a = $_POST['add-albums'];
        	return $a;
        }
        function getCheckedDelete() {
        	$a = $_POST['delete-albums'];
        	return $a;
        }
        //Validate inputs to prevent malicious attacks
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

		if(isset($_GET['category_id'])) {
			$categoryID = $_GET['category_id'];
			$result = $mysqli->query("SELECT * FROM CATEGORIZATIONS INNER JOIN CATEGORIES
						ON CATEGORIES.categoryID = CATEGORIZATIONS.categoryID WHERE CATEGORIZATIONS.categoryID = $categoryID");
			if ($result->num_rows === 0) {
				print('<h2 class="title">This category currently does not have any products.</h2>');
				if(isset($_SESSION['logged_user'])) {
					print('<div id="wrap">');
			        print("<div class='admin'><p>Admin Controls: </p>");
			    	print("<span class='view'><a href='#upload_form' class='box-button'> Add New Product</a></span>");
			    	print('</div>');
		        }
			}
			else {
				$products = $mysqli->query("SELECT * FROM PRODUCTS INNER JOIN CATEGORIZATIONS 
						ON PRODUCTS.productID = CATEGORIZATIONS.productID WHERE PRODUCTS.sold = 0 AND CATEGORIZATIONS.categoryID = $categoryID");
				if ($products->num_rows === 0) {
					print('<h2 class="title">This category currently does not have any products.</h2>');
					if(isset($_SESSION['logged_user'])) {
						print('<div id="wrap">');
				        print("<div class='admin'><p>Admin Controls: </p>");
				    	print("<span class='view'><a href='#upload_form' class='box-button'> Add New Product</a></span>");
				    	print('</div>');
			        }
				}
				else {
					print('<div id="wrap">');
					if(isset($_SESSION['logged_user'])) {
						print("<div class='admin'><p>Admin Controls: </p>");
					    print("<span class='view'><a href='#upload_form' class='box-button'> Add New Product</a></span>");
					    print('</div>');
				    }
					while($row = $products->fetch_assoc()) {
						print("<div class='simpleCart_shelfItem'>");
						print("<div class='photo'>");
						print("<div class='photo-content'>");
							$name = $row['name'];
							$price = $row['price'];
							$maker = $row['makerID'];
							$id = $row['productID'];
							$imgSql = $mysqli->query("SELECT * FROM PHOTOS WHERE PHOTOS.productID = $id");
								$img = $imgSql->fetch_assoc();
								$imgurl = $img['url'];
								$caption = $img['caption'];
							$photoName = explode(".", $imgurl);
							$description = $row['description'];
						    $thumbnailurl = $photoName[sizeof($photoName)-2] . "_thumbnail." . $photoName[sizeof($photoName)-1];
							print("<div class='overlay-top'>
										<p><span class='item_name'>$name</span><br>
										<span class='item_price'>$$price</span></p>
										<span class='item_quantity' style='display:none'>1</span>
										<span class='item_productid' style='display:none'>$id</span>
									</div>");
								print("<div class='overlay-bottom'>
											<p>
											<span class='view'><a href='#$id'><img src='img/view.png' alt='View'></a></span>
											<span class='add'><a id='add-$id' class='item_add' href='javascript:;'>Add to Cart</a>
				    						<span id='added-$id' style='display:none'>Item Added!</span></span>
				    						<span class='open'><a href='product.php?product_id=$id'><img src='img/open.png' alt='Open'></a></span></p>
										</div>");
								print("<a href='product.php?product_id=$id'><img class='item_image' src='img/products/$thumbnailurl' alt='$id'></a>");
							print('</div>');
							print('</div>');
							print('</div>');

							print("<div id='$id' class='modalDialog'>");
			       			print('<div>');
						    print('<a href="#close" title="Close" class="close">X</a>');
				            print("<div class='simpleCart_shelfItem'>");
								print("<div class='top item_name'>
										<p>$name</p>
									</div>");
								print("<div class='box'>
										<img src='img/products/small/$imgurl' alt='$id'>
									</div>");

								if (isset($_SESSION['logged_user'])) { //logged in, allow editing features
									print("<div class='box-text'>
										<p>Price: <span class='item_price'>$<span class='edit' id='price-". $id ."'> $price </span></span><br><br>
										<span class='description'>Description: <span class='edit' id='description-". $id ."'> $description </span> </span><br><br>
										<span class='item_quantity' style='display:none'>1</span>
										<span class='item_productid' style='display:none'>$id</span>
										<span class='item_image' style='display:none'>img/products/$thumbnailurl</span>");
									print("<div class='image-container'><a id='cart-add-$id' href='javascript:;' class='item_add'><img src='img/shopping_cart_add.png' alt='Add'></a>");
									print("<img id='cart-added-$id' src='img/shopping_cart_added.png' style='display:none' alt='Added'></div>");
							        print("</div>");
							        print("<div class='modal-button-container'>");
							        print('<form method="post" action="delete.php">
	                                <input type="hidden" name="id" value="'. $id .'" />
									<input type="submit" name="submitDel" class="modal-delete-submit" value="Delete" />
								    </form>');
								    print('<form method="post" action="delete.php">
	                                <input type="hidden" name="id" value="'. $id .'" />
									<input type="submit" name="submitSold" class="modal-sold-submit" value="Set as Sold" />
								    </form>');
								    print("</div>");
							        print("</div>");
							        print("</div>");
							        print("</div>");
						        }
						        else { //not logged in display product as usual
						        	print("<div class='box-text'>
										<p>Price: <span class='item_price'>$$price</span><br><br>
										<span class='description'>Description: $description </span><br><br>
										<span class='item_quantity' style='display:none'>1</span>
										<span class='item_productid' style='display:none'>$id</span>
										<span class='item_image' style='display:none'>img/products/$thumbnailurl</span>");
									print("<a id='cart-add-$id' href='javascript:;' class='item_add'><img src='img/shopping_cart_add.png' alt='Add'></a>");
									print("<img id='cart-added-$id' src='img/shopping_cart_added.png' style='display:none' alt='Added'>");
							        print("</div>");
							        print("</div>");
							        print("</div>");
						        	print("<div class='box-button'>  <a href='#' class='myButton'>Delete</a> </div>"); 
						            print("</div>");
						        }
						    }
					print('</div>');
				}
			}
		}
		else {
			$result = $mysqli->query("SELECT * FROM PRODUCTS WHERE PRODUCTS.sold = 0");
			print('<div id="wrap">');
				if(isset($_SESSION['logged_user'])) {
					print("<div class='admin'><p>Admin Controls: </p>");
				    print("<span class='view'><a href='#upload_form' class='box-button'> Add New Product</a></span>");
			    	print('</div>');
			    }
				while($row = $result->fetch_assoc()) {
					print("<div class='simpleCart_shelfItem'>");
					print("<div class='photo'>");
					print("<div class='photo-content'>");
						$name = $row['name'];
						$price = $row['price'];
						$maker = $row['makerID'];
						$id = $row['productID'];
						$imgSql = $mysqli->query("SELECT * FROM PHOTOS WHERE PHOTOS.productID = $id");
							$img = $imgSql->fetch_assoc();
							$imgurl = $img['url'];
							$caption = $img['caption'];
						$photoName = explode(".", $imgurl);
						$description = $row['description'];
					    $thumbnailurl = $photoName[sizeof($photoName)-2] . "_thumbnail." . $photoName[sizeof($photoName)-1];
						print("<div class='overlay-top'>
									<p><span class='item_name'>$name</span><br>
									<span class='item_price'>$$price</span></p>
									<span class='item_quantity' style='display:none'>1</span>
									<span class='item_productid' style='display:none'>$id</span>
								</div>");
							print("<div class='overlay-bottom'>
										<p>
										<span class='view'><a href='#$id'><img src='img/view.png' alt='View'></a></span>
										<span class='add'><a id='add-$id' class='item_add' href='javascript:;'>Add to Cart</a>
			    						<span id='added-$id' style='display:none'>Item Added!</span></span>
			    						<span class='open'><a href='product.php?product_id=$id'><img src='img/open.png' alt='Open'></a></span></p>
									</div>");
							print("<a href='product.php?product_id=$id'><img class='item_image' src='img/products/$thumbnailurl' alt='$id'></a>");
						print('</div>');
						print('</div>');
						print('</div>');

						print("<div id='$id' class='modalDialog'>");
		       			print('<div>');
					    print('<a href="#close" title="Close" class="close">X</a>');
			            print("<div class='simpleCart_shelfItem'>");
							print("<div class='top item_name'>
									<p>$name</p>
								</div>");
							print("<div class='box'>
									<img src='img/products/small/$imgurl' alt='$id'>
								</div>");

							if (isset($_SESSION['logged_user'])) { //logged in, allow editing features
								print("<div class='box-text'>
									<p>Price: <span class='item_price'>$<span class='edit' id='price-". $id ."'> $price </span></span><br><br>
									<span class='description'>Description: <span class='edit' id='description-". $id ."'> $description </span> </span><br><br>
									<span class='item_quantity' style='display:none'>1</span>
									<span class='item_productid' style='display:none'>$id</span>
									<span class='item_image' style='display:none'>img/products/$thumbnailurl</span>");
								print("<div class='image-container'><a id='cart-add-$id' href='javascript:;' class='item_add'><img src='img/shopping_cart_add.png' alt='Add'></a>");
								print("<img id='cart-added-$id' src='img/shopping_cart_added.png' style='display:none' alt='Added'></div>");
						        print("</div>");
						        print("<div class='modal-button-container'>");
						        print('<form method="post" action="delete.php">
                                <input type="hidden" name="id" value="'. $id .'" />
								<input type="submit" name="submitDel" class="modal-delete-submit" value="Delete" />
							    </form>');
							    print('<form method="post" action="delete.php">
                                <input type="hidden" name="id" value="'. $id .'" />
								<input type="submit" name="submitSold" class="modal-sold-submit" value="Set as Sold" />
							    </form>');
							    print("</div>");
						        print("</div>");
						        print("</div>");
						        print("</div>");
					        } 
					        else { //not logged in display product as usual
					        	print("<div class='box-text'>
									<p>Price: <span class='item_price'>$$price</span><br><br>
									<span class='description'>Description: $description </span><br><br>
									<span class='item_quantity' style='display:none'>1</span>
									<span class='item_productid' style='display:none'>$id</span>
									<span class='item_image' style='display:none'>img/products/$thumbnailurl</span>");
								print("<a id='cart-add-$id' href='javascript:;' class='item_add'><img src='img/shopping_cart_add.png' alt='Add'></a>");
								print("<img id='cart-added-$id' src='img/shopping_cart_added.png' style='display:none' alt='Added'>");
						        print("</div>");
						        print("</div>");
						        print("</div>");
					        	print("<div class='box-button'>  <a href='#' class='myButton'>Delete</a> </div>"); 
					            print("</div>");
					        }
				}
				print('</div>');
		}
	?>

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
					move_uploaded_file( $tempName, "img/products/large/$originalName");
					//copy ("img/products/small/$originalName","img/products/large/$originalName");
					//Make thumbnail and small version for zoom
					require_once 'resize.php';
					save_thumbnail( "img/products/large/$originalName", "img/products/$thumbnail", 400 );
					save_small( "img/products/large/$originalName", "img/products/small/$originalName", 0.5 );
					//Add to PRODUCTS
					$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
					$description = filter_input( INPUT_POST, 'description', FILTER_SANITIZE_STRING );
					$price = filter_input( INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT );
					$mysqli->query("INSERT INTO PRODUCTS (name, price, description) VALUES ('$name','$price','$description')");

					//Retrieve photo_id
					$pid = $mysqli->insert_id;
					
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
	//ADMIN OPTION: Upload Form
	if (TRUE){
		if(isset($_SESSION['logged_user'])) {
			echo("<div id='upload_form' class='modalDialog'>
	      	<div>
	      		<a href='#close' title='Close' class='close'>X</a>
	      		<div class='top'> 
		      		<p>Upload New Product</p> 
		      	</div>
		      	<div class='admin-form-container'>
			  		<form action='shop.php' method='post' enctype='multipart/form-data'>
					<p><label for='new_photo'>Product Image:</label><br>
						<input id='formFile' type='file' name='new_photo'>
					</p><br>
					<p><label for='name'>Product Name:</label><br>
						<input id='formName' type='text' name='name'>
					</p><br>
					<p><label for='description'>Product Description:</label><br>
						<input id='formDescription' type='text' name='description'>
					<p><br>
					<p><label for='price'>Price:</label><br>
						<input id='formPrice' type='number' name='price' value='0' min='0'>
					<p><br>
					<p><label for='categories[]'>Upload To:</label><br>");
					//Get categories in database
					$categories = $mysqli->query("SELECT categoryID, title FROM CATEGORIES");
					//Create options to add product to categories
					while ($categorizations = $categories->fetch_assoc()){
						print("<input id='formCategory' type=checkbox name='categories[]' value='{$categorizations[ 'categoryID' ]}'>
							{$categorizations[ 'title' ]}<br>");
					}
					echo("<br><p>
							<input id ='newProductSubmit' type='submit' class='submit' value='Upload Product'>
						</p><br>
						</form>
			</div>
			</div>
			</div>");
		}
	}
	//Close connection
	$mysqli->close();
	?>

	<div class="push"></div>
	</div>

	<!-- footer -->
	<div class="footer">
		<div class="footer-menu">
		    <p><a href="index.php">Home</a></p>
		    <p><a href="donate.php">Donate</a></p>
		    <p><a href="gallery.php">Gallery</a></p>
		    <p><a href="shop.php">Shop</a></p>
		    <p><a href="contact.php">Contact Us</a></p>
		    <p><a href="about.html">About Us</a></p>
		    <p><a href="social-media.html" >Social Media</a></p>
		    <p><br></p>
		    <p><a href="login.php">Admin Login</a></p>	    
		    <p><br></p>
		    <p><br></p>    
		</div>
		<div class="footer-copyright">
			<p>2015 &copy; Nine Yards</p>
		</div>
	</div>
</body>
</html>