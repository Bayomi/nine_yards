<?php session_start(); ?>
<?php
	// Form validaion - Contact

    // Initialize the input variables
    $name = $email = $subject = $message = '';
    $nameErr = $emailErr = $subjectErr = $messageErr = '';
    $success = false;

    if(isset($_POST['submit'])){
        // Name
        if (empty($_POST['name'])){
            $nameErr = 'Please enter your name';
        }

        else{
            if (preg_match("/[$+;=?@#|<>.^*()%!0-9]/", $_POST['name'])){
                $nameErr = 'Enter only valid non-special/numeric characters';
            }

            else{
                $name = test_input($_POST['name']);
            }
        }

        // Email
        if (empty($_POST['email'])){
            $emailErr = 'Please enter your email address';
        }

        else{
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $emailErr = 'Please enter a valid email address ie. test@user.com';
            }

            else{
                $email = test_input($_POST['email']);
            }
        }

        // Subject and Message allowed all characters - needs to be sanitized only.
        if (empty($_POST['subject'])){
            $subjectErr = 'Please enter the subject for this contact';
        }

        else{
            $subject = test_input($_POST['subject']);
        }

        if (empty($_POST['message'])){
            $messageErr = 'Please explain in more detail the nature of this contact';
        }

        else{
            $message = test_input($_POST['message']);
        }

        // If validation is successful, email the form information
        if (empty($nameErr) and empty($emailErr) and empty($subjectErr) and empty($messageErr)){
            $success = true;
            $to = 'nineyardstest@gmail.com';
            $subject = $name . ': ' . $subject;
            mail($to, $subject, $message);
        }
    }

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
			print("<div class='logout'>Welcome back, Admin!
				<span class='view'><a href='logout.php' class='box-button'> Log out</a></span></div>");
		}
	?>

	<h1 class="title">Contact Roshni</h1>
	<hr>
	<div class="form-container">
		<form id="form" method="post" action="contact.php">
			<p><span class="error">* Indicates required field</span></p>
            <span class="success">
                <?php
                // Save errors and display them
                if ($success == true){
                    $notice = 'Success! Nine Yards has received your inquiry. We will be reaching you shortly';
                    echo '<br>';
                    echo '<p>';
                    echo $notice;
                    echo '</p>';
                }
                ?>
            </span><br>
	        <p>
	            <label for="name">Your Name<span class="error">*</span></label><br>
	            <input type="text" name="name" id="name" placeholder="John Doe"
	            value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
	        </p>
	        <span class='display-error'>
            	<?php 
            		if (!empty($nameErr)){
            			echo '<p>';
            			echo $nameErr;
            			echo '</p>';
            			echo '<br>';
            		}
            	?>
	        </span><br>
	        <p>
	        	<label for="email">Your Email<span class="error">*</span></label><br>
	        	<input type="text" name="email" id="email" placeholder="test@example.com"
	        	value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
	        </p>
	        <span class='display-error'>
            	<?php 
            		if (!empty($emailErr)){
            			echo '<p>';
            			echo $emailErr;
            			echo '</p>';
            			echo '<br>';
            		}
            	?>
	        </span><br>
	        <p>
	        	<label for="subject">Subject<span class="error">*</span></label><br>
	        	<input type="text" name="subject" id="subject" placeholder="Subject"
	        	value="<?php if(isset($_POST['subject'])){echo $_POST['subject'];} ?>">
	        </p>
	        <span class='display-error'>
            	<?php 
            		if (!empty($subjectErr)){
            			echo '<p>';
            			echo $subjectErr;
            			echo '</p>';
            			echo '<br>';
            		}
            	?>
	        </span><br>
	    	<p>
	    		<label for="message">Message<span class="error">*</span></label><br>
	    		<textarea name="message" id="message" placeholder="What's on your mind?"><?php if(isset($_POST['message'])){print(trim($_POST['message']));}?></textarea>
	    	</p>
	    	<span class='display-error'>
            	<?php 
            		if (!empty($messageErr)){
            			echo '<p>';
            			echo $messageErr;
            			echo '</p>';
            			echo '<br>';
            		}
            	?>
	        </span><br>
	    	<p>
	    		<input id="submit" class="submit" name="submit" type="submit" value="Send">
	    	</p>
		</form>
	</div>

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