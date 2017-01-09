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
	<script src="js/jquery.elevateZoom-3.0.8.min.js"></script>
	<link rel="stylesheet" href="css/style.css" type="text/css">
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
			document.getElementById("cart-single-add-"+item.get("productid")).style.display = "none";
			document.getElementById("cart-single-added-"+item.get("productid")).style.display = "block";
		});

		$("#zoom").elevateZoom({
			zoomType: "inner",
			cursor: "crosshair"
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

	<?php
		require_once 'config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
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

		if(isset($_GET['product_id'])) {
			$productID = $_GET['product_id'];
			$result = $mysqli->query("SELECT * FROM PRODUCTS 
				WHERE productID = $productID");
			if ($result->num_rows === 0) {
				print('<h2>Error: This product does not exist!</h2>');
			}
			else {
				$row = $result->fetch_assoc();
				if ($row['sold'] === 1) {
					print("<div class='This product is no longer available!'>");
				}
				else {
					$id = $row['productID'];
					$name = $row['name'];
					$price = $row['price'];
					$makerID = $row['makerID'];
					$imgSql = $mysqli->query("SELECT * FROM PHOTOS WHERE PHOTOS.productID = $id");
					$img = $imgSql->fetch_assoc();
					$imgurl = $img['url'];
					$caption = $img['caption'];
					$dateSql = $mysqli->query("SELECT EXTRACT(YEAR FROM created) AS year,
						EXTRACT(MONTH FROM created) AS month,
						EXTRACT(DAY FROM created) AS day
						FROM PRODUCTS WHERE productID = $productID");
					$date = $dateSql->fetch_assoc();
					$created = $date['year']."-".$date['month']."-".$date['day'];
					$description = $row['description'];
					if ($description === '') {
						$description = "<i>No description provided.</i>";
					}
					$photoName = explode(".", $imgurl);
					$thumbnailurl = $photoName[sizeof($photoName)-2] . "_thumbnail." . $photoName[sizeof($photoName)-1];
					print("<div class='simpleCart_shelfItem'>");
					print("<h1 class='title item_name'>$name</h1><hr>");
					print("<div id='wrap'>");
					print("<div class='one-photo'>
							<div class='photo-container'>
							<img id='zoom' src='img/products/small/$imgurl' data-zoom-image='img/products/large/$imgurl' alt='$id'>
						</div>");
					print("<div class='photo-caption'>");
					print("<p><span class='title'>Price: </span><span class='item_price'>$$price</span><br><br>");
					print("<span class='title'>Description: </span>$description<br><br>");
					print("<span class='item_quantity' style='display:none'>1</span>
									<span class='item_productid' style='display:none'>$id</span>
									<span class='item_image' style='display:none'>img/products/$thumbnailurl</span>");
					$categorySql = $mysqli->query("SELECT categoryID FROM CATEGORIZATIONS INNER JOIN PRODUCTS
						ON PRODUCTS.productID = CATEGORIZATIONS.productID WHERE CATEGORIZATIONS.productID = $id");
					if ($categorySql->num_rows === 0) {
						print("This product does not belong in any categories.</p>");
					}
					else {
						print("<span class='title'>Found In:</span></p>");
						print("<ul>");
						while ($category = $categorySql->fetch_row()) {
							$category = $mysqli->query("SELECT * FROM CATEGORIES WHERE categoryID = $category[0]")->fetch_row();
							
							print("<li><a class='album-link' href='shop.php?categoryID=$category[0]'>$category[1]</a></li>");
						}
						print("</ul>");
					}
					print("<a id='cart-single-add-$id' href='javascript:;' class='item_add'><img src='img/shopping_cart_add.png'></a>");
					print("<img id='cart-single-added-$id' src='img/shopping_cart_added.png' style='display:none'>");
			        print("</div>");
			        print("</div>");
			        print("</div>");
			        print("</div>");
			    }
		    }
		}
		else {
			print('<h2 class="title">No product to show.</h2>');
		}
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