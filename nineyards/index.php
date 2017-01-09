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
			var $window = $(window);
		    $('section[data-type="background"]').each(function(){
		        var $bg = $(this); // assigning the object
		    
		        $(window).scroll(function() {
		            var yPos = -($window.scrollTop() / $bg.data('speed')); 
		            
		            // Put together our final background position
		            var coords = '50% '+ yPos + 'px';

		            // Move the background
		            $bg.css({ backgroundPosition: coords });
		        }); 
		    });
		

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

	<!-- backdrop -->
    <section id="banner" data-type="background" data-speed="10">
		<article>Nine Yards</article>
	</section>

	<h1 class="title">About Nine Yards</h1>
	<hr>
	<div class="transbox">
		<p class="about">
			Nine Yards is a social enterprise that employs female acid attack survivors in India – we produce home decor and fashion products out of donated Indian saris.
			<br>
			<br>
			At Nine Yards, we aspire to give these ladies the opportunity to not earn their own livelihoods, but also to find and embrace their own sense of dignity and self-worth.
		</p>
	</div>

	<hr>
	<div class="transbox-left">
		<p class="about">
			<span class="emphasis">Acid Attack</span> is one of the most violent acts against women in socio-economic strata of South Asia. Perpetrators of this throw acid on the victims’ faces, burning them, damaging skin and dissolving the bones, resulting in permanent disfiguration and often blindness.
			<br>
			<br>
			Around <span class="emphasis">68%</span> of acid attacks against women in South Asia occur due to refusal of marriage proposals, refusal of sexual advances or domestic violence. As a result acid-attacks are termed as “crimes of passion.” Perpetrators of this act throw acid on the victims’ faces, burning them, damaging skin and dissolving the bones, resulting in permanent disfiguration and often blindness.
		</p>
	</div>
	<div class="icon"><a class="tooltip inactive" href="meet-the-ladies.html"><img src="img/woman.png" alt="Meet"><span>Meet the Ladies</span></a></div>
	<div class="icon"><a class="tooltip inactive" href="social-media.html"><img src="img/like.png" alt="Social"><span>Connect with Us</span></a></div>
	<div class="icon"><a class="tooltip" href="donate.php"><img src="img/letter.png" alt="Donate"><span>Make a Donation</span></a></div>

	<div class="push"></div>

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