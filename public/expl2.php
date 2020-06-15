<?php

require '../autoload.php';

use Easy\Color;
use Easy\Dimension;
use Easy\Image;


/*
 * 
 * How to create a dimension
 * 
 */
$dimension = Dimension::create(300, 300);
echo $dimension->width, ' ', $dimension->height;
$dimension->width(300)->height(100);
echo $dimension->width, ' ', $dimension->height;

/*
 * 
 * How to create a truetype image
 * 
 */
// (new Image())->create($dimension)->show();


/*
 * 
 * How to create, set the mime type and show an image
 * 
 */
// (new Image())->create($dimension)->setType(IMAGETYPE_JPEG)->show();


/*
 * 
 * How to test, create, and show an image
 * 
 */
// if(($image = (new Image())->create($dimension)) !== FALSE) $image->show();


/*
 * 
 * 3 way to create a color
 * 
 */

// Create a color with hexadecimal code
$color = Color::create('#83d01e');
// How to create a color from a preset
$color = Color::create(Color::Yellow);
// How to create a preseted color 
$color = Color::Yellow();

/*
 * 
 * How to fill an image with a background color 
 * 
 */
// (new Image())->create($dimension)->fill(Color::create('#83d01e'))->show();
// (new Image())->create($dimension, Color::Gray())->show();
