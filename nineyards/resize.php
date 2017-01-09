<?php
/*
 * Saves a thumbnail of the given image
 * 
 * Parameters
 * $source: the path and file name relative to the current directory
 * $thumbPathAndFile: the path and file name of the thumbnail to be created (relative to the current directory)
 * $thumbWidth: the width of the thumbnail being created
 */

/*
Cropping functionality adapted from:
Image Cropper by Sven Koschnicke
stackoverflow.com/questions/3255773/php-crop-image-to-fix-width-and-height-without-losing-dimension-ratio
*/

function save_thumbnail( $source, $thumbPathAndFile, $thumb_width ) {
	//Create a new image from the given image
	$img = imagecreatefromjpeg( $source );
	
	//Calculate the dimensions
	$width = imagesx($img);
	$height = imagesy($img);
	
	//Set crop dimensions
	if ($width > $height) {
	  $y = 0;
	  $x = ($width - $height) / 2;
	  $size = $height;
	} else {
	  $x = 0;
	  $y = ($height - $width) / 2;
	  $size = $width;
	}

	//Create a new image
	$new_img = imagecreatetruecolor($thumb_width, $thumb_width);

	//Copy and resize the original into the new
	imagecopyresampled($new_img, $img, 0, 0, $x, $y, $thumb_width, $thumb_width, $size, $size);

	//Save the image to the given path
	$return = imagejpeg($new_img, $thumbPathAndFile);

	//Free up memory
	imageDestroy($img);
	imageDestroy($new_img);
	
	//Return the success/failure status
	return $return;
}

function save_small( $source, $smallFile, $percentage ) {
	//Create a new image from the given image
	$img = imagecreatefromjpeg( $source );
	
	//Calculate the dimensions
	$width = imagesx($img);
	$height = imagesy($img);
	
	$new_width = $width * $percentage;
	$new_height = $height * $percentage;

	//Create a new image
	$new_img = imagecreatetruecolor($new_width, $new_height);

	//Copy and resize the original into the new
	imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	//Save the image to the given path
	$return = imagejpeg($new_img, $smallFile);

	//Free up memory
	imageDestroy($img);
	imageDestroy($new_img);
	
	//Return the success/failure status
	return $return;
}
?>


