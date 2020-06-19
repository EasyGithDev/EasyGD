<?php

require '../vendor/autoload.php';

use Easygd\Color;
use Easygd\Dimension;
use Easygd\Image;

/*
 * 
 * How to create a dimension
 * 
 */

$dimension = (new Dimension)->create(300, 300);


/*
 * 
 * 3 way to create a color
 * 
 */

// Create a color with hexadecimal code
$color = (new Color())->create('#83d01e');

// How to create a color from a preset
$color = (new Color())->create(Color::Yellow);

// How to create a preseted color 
$color = Color::Yellow();

/*
 * 
 * How to fill an image with a background color 
 * 
 */
(new Image())->create($dimension, $color)->show();
