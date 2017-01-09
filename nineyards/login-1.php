<?php
    session_start();
    require_once 'config.php';
    
    $username = $password = $errorMsg = "";



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['username']) && isset($_POST['password'])) {

            $username = test_input($_POST['username']);
            $password = test_input($_POST['password']);
            $hashed_password = hash("sha256",$password);
            
            $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);

            $SQL = 'SELECT * FROM USERS 
                WHERE USERS.username = :username AND USERS.password = :password';

            $login = $dbh->prepare($SQL);
	        $login->bindParam(':username', $username);
	        $login->bindParam(':password', $hashed_password);
	        $login->execute(); 

            if ($login->rowCount() === 0) {
                $errorMsg = '<br>Login Failed. Try Again. <br> <br> <br>';
            }
            elseif ($login->rowCount() === 1) {
                $row = $login->fetch(PDO::FETCH_ASSOC);
                $_SESSION['logged_user'] = $row['username'];
                header("Location: shop.php");
                
            }
        }
    }
    
    //Validate inputs to prevent malicious attacks
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

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
		print("<h1 class='title'>You Are Currently Signed In!</h1>
		<hr>
		<div class='form-container'>
			<form id='logout' action='logout.php' method='post'>
		        <p>
		        	You can choose to: <input type='submit' id='submit' class='submit' name='submit' value='Logout'>
		        </p>
		    </form>
	    </div>");
	}
	else {
		//not logged in, display login
		print("<h1 class='title'>Welcome, Admin! Please Sign In:</h1>
		<hr>
		<div class='form-container'>
			<form id='login' action='login.php' method='post'>
			<p><span class='error'>$errorMsg</span></p>
				<p>
		        	<label>Username<br> <input type='text' name='username' id='username'></label><br><br>
		        </p>
		        <p>	
		        	<label>Password<br> <input type='password' name='password' id='password'></label>
		        </p><br>
		        <p>
		        	<input type='submit' id='submit' class='submit' name='submit' value='Login'>
		        </p>
		    </form>
	    </div>");
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