<?php

require 'autoload.php';

define('THUMB_ORIGINAL', './Gallery/images/original/');

$filename = THUMB_ORIGINAL . '2012-05-07 11.57.39.jpg';

// Loading the image
if (($image = Easy\Image::createfrom($filename)) === FALSE)
    throw new Exception('Unable to load ' . $filename);

// Create the thumbnail
// Adding the text
// Apply the filter on the thumnail
// Create the logo
// Define a position
// Merging the thumnail and the logo 
Easy\Transformation::inlay(
	$thumb = Easy\Preset::PRESET_NEGATE()->process(
		Easy\Transformation::thumbnail($image, 400)->addText(
			\Easy\Text::create('Very nice castle !!!')
				->setSize(5)
				->setColor(Easy\Color::Gray())
				->setPosition(\Easy\Position::create(10, 20))
		)
	), 
	$logo = Easy\Transformation::resizeByPercent($image, 0.05), 
	$thumb->BOTTOM_RIGHT->offsetY($logo->getHeight() * -1 - 50)->offsetX($logo->getWidth() * -1)
)->show();
?>