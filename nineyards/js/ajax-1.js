/*

1. The main usage of interactivity with Javascript will be done with JQuery functions. 
The main idea is to display a hover parameter on each image and make each of them clickable. 
Anytime someone hovers over an image, it should show a caption, a button to get more information 
and image should also be clickable. When the user is redirected to another page, there will 
be a JQuery button to also display information about the ladies that developed the project. 
9Y idea is to not look charitable and focus on the product, but they also want to show the
beautiful stories behind each product. That’s a way to show some more specific information 
with ajax calls when someone clicks the determined button.

2. Moreover, it will be necessary to make the editing process very simple. The best way
to do that is using an interaction with PHP and JS.  By this way, we can make the changing
process easy to deal with and also make some changes last forever and not only for the 
specific user with Cookies. Using some HTML5 properties, it will be easy to edit texts,
change photos and provide new information.

3. Also, using the library D3.js, we intend to build an interactive map that could be accessed 
by any part of the website. By the display of the map, all the colored countries would be 
available to click on and the function would redirect them to a page with all the products 
from that determined country or region and also a brief explanation about the country and 
the stories related. Also, every time someone buys an item from a different region of the world, 
each product page will be able to display a map with all the countries that already have bought
similar products or from that same country. We believe that this design solution could create 
an empathy impact between different regions around the world.

*/



//
//
//

// Image-Information Interaction
//
//
///
//
//

$(document).on("click", "#imageToStory", function() {

	//Gallery Image was clicked

  /*
  Change the position of the image to the left
  Show expansion box with more information about the woman and the story
  Display a close button
  */

});
$(document).on("click", "#closeStory", function() {

	 //Shop Image was clicked
  
  /*
  Change the position of the image to the left
  Show expansion box with more information, price details and shopping button
  Display a close button
  */

});

$(document).on("click", "#imageToPlus", function() {

	 //Shop Image was clicked
  /*
  Change the position of the image to the left
  Show expansion box with more information, price details and shopping button
  Display a close button
  */


});

$(document).on("click", "#closePlus", function() {

	 //Close button was clicked
   /*
   Close the expanded box showed when the shop image was clicked
   Change back the position of the image
   */

});

$(document).on("click", "#shoppingButton", function() {

	 //Shopping Button was clicked
   /*
   Redirected to the box/page provided by PAYPAL API
   */

});

//
//
//

// general use function
//
//
///
//
//

$(document).on("keyup", "#informationCheck", function() {
    /*
	Only allows to click the send button on the email form if all the text items are ok.
	*/

});

//
//
//


//When admin is logged in 
//
//
///
//
//

$(document).on("click", "#finishEdit", function() {

	//finish editing button was clicked

   /*
   The changes are sent via an ajax call to actually change the caption/text in the database.
   Ajax.php is called to implement the changes.
   */

});
$(document).on("click", "#editText", function() {
    
    /*
	When clicked, it allows the logged user to directly change the text of the images.

	Changes the text field to editable.
	*/

});
$(document).on("click", "#editCaption", function() {
    /*
	When clicked, it allows the logged user to directly change the caption of the images.

	Changes the caption field to editable.
	*/


});



<?php /* PHP-HTML Interaction - 

-Add product
Form to add another product to the database
If all the items are correct $informationCheck let the user adds the product to the shop list.

-Add gallery
Form to add another gallery story to the database
If all the items are correct $informationCheck let the user adds the product to the gallery list.

-Send email Form
Form to send an email to the main admin and get in contact.
*/
?>


//

//

//


<script> D3.js - 

/*General Map that will be displayed in the index page.

1. Gets the information from the database for each country related to the acid attack case.
Append a circle for each case in each of the countries, showing a geographical perspective.

2.
User clicks image.
More information is displayed.
SVG element that will be displayed showing the related country for the image clicked at the Gallery or Shop database
*/
</script>

