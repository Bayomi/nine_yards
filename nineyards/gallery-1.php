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
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src = "http://www.appelsiini.net/download/jquery.jeditable.js"></script>
     <script src = "js/editable.js"></script>
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

	<h1 class="title">Previously Sold Items</h1>
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

		$result = $mysqli->query("SELECT * FROM PRODUCTS WHERE PRODUCTS.sold = 1");
		
		print('<div id="wrap">');

		while($row = $result->fetch_assoc()) {
			print('<div class="photo">');
			print('<div class="photo-content">');
				$name = $row['name'];
				$maker = $row['makerID'];
				$id = $row['productID'];
				$imgSql = $mysqli->query("SELECT * FROM PHOTOS WHERE PHOTOS.productID = $id");
					$img = $imgSql->fetch_assoc();
					$imgurl = $img['url'];
					$caption = $img['caption'];
				$photoName = explode(".", $imgurl);
				$imgthumbnail = $photoName[sizeof($photoName)-2] . "_thumbnail." . $photoName[sizeof($photoName)-1];
				$description = $row['description'];
				print("<div class='overlay-top'>
						<p>$name<br>
						No Longer Available.</p>
					</div>");
				print("<a href='#$id'> <img src='img/products/$imgthumbnail' alt='$id'></a>");
			print('</div>');
			print('</div>');

            print("<div id='$id' class='modalDialog'>");
   			print('<div>');
		    print('<a href="#close" title="Close" class="close">X</a>');

			print("<div class='top'><p>$name</p></div>");
			print("<div class='box'><img src='img/products/small/$imgurl' alt='$id'></div>");
			print("<div class='box-text'><p class='description'>Description: $description </p><br><br>");
			
            
		    print('</div>');
		    if (isset($_SESSION['logged_user'])) {
				print("<div class='modal-button-container'>");
				    print('<form method="post" action="delete.php">
                        <input type="hidden" name="id" value="'. $id .'" />
						<input type="submit" name="submitDel" class="modal-delete-submit" value="Delete" />
					    </form>');
			    print("</div>");
	        }
            print('</div>');
            print('</div>');
		}

		print('</div>');
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