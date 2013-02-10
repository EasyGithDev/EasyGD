<?php

require 'autoload.php';

$dimension = Easy\Dimension::create(300, 300);

/*
 * 
 * How to create a truetype image
 * 
 */
//Easy\Image::create($dimension)->show();


/*
 * 
 * How to create, set the mime type and show an image
 * 
 */
//Easy\Image::create($dimension)->setImagetype(IMAGETYPE_JPEG)->show();


/*
 * 
 * How to test, create, and show an image
 * 
 */
//if(($image = Easy\Image::create($dimension)) !== FALSE) $image->show();


/*
 * 
 * How to create a color with hexadecimal code
 * 
 */
//$color = Easy\Color::create('#83d01e');

/*
 * 
 * How to create a color from a preset
 * 
 */
//$color = Easy\Color::create(\Easy\Color::Yellow);


/*
 * 
 * How to create a preseted color 
 * 
 */
//$color = Easy\Color::Yellow();


/*
 * 
 * How to fill an image with a color 
 * 
 */
//Easy\Image::create($dimension)->fill(Easy\Color::create('#83d01e'))->show();
Easy\Image::create($dimension, Easy\Color::Gray())->show();
?>