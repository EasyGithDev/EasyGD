<?php

require 'autoload.php';

$dimension = Easy\Dimension::create(300, 300);

/*
 * 
 * How to create a text
 * 
 */
$text = Easy\Text::create('Hello World');

/*
 * 
 * How to create a position
 * 
 */
$position = Easy\Position::create(100, 125);


/*
 * 
 * How to add a GD text into an image
 * 
 */

$image = Easy\Image::create($dimension, Easy\Color::Blue())->addText(
	$text->setColor(Easy\Color::Silver())
		->setSize(3)
		->setPosition($position)
);

$image->show();

/*
 * 
 * How to draw a string vertically into an image
 * 
 */
$image = Easy\Image::create(Easy\Dimension::create(100, 100))->addText(
	Easy\Text::create('gd library')
		->setSize(3)
		->setColor(Easy\Color::White())
		->setdrawtype(Easy\Text::TEXT_DRAW_VERTICAL)
		->setPosition(Easy\Position::create(40, 80))
);
//$image->show();


/*
 * 
 * How to add a TrueType text into an image
 * 
 */

$text = Easy\TrueType::create('Hello True World', \Easy\Text::TEXT_MACOS_FONT_PATH . '/Arial Black.ttf')
	->setColor(Easy\Color::Silver())
	->setSize(16)
	->setAngle(45)
	->setPosition(Easy\Position::create(100, 175));

$image = Easy\Image::create($dimension, Easy\Color::create('#f2f2f2'))
	->addText($text)
	->addText(
	$text->setColor(Easy\Color::Maroon())
	->setPosition(Easy\Position::create(98, 173))
);

//$image->show();


/*
 * 
 * How to add a FreeType text into an image
 * 
 */

$image = Easy\Image::create($dimension, Easy\Color::create('#f2f2f2'))
	->addText(
	Easy\FreeType::create('Hello Free World', \Easy\Text::TEXT_MACOS_FONT_PATH . '/Arial Black.ttf')
	->setColor(Easy\Color::Silver())
	->setSize(16)
	->setAngle(45)
	->setPosition(Easy\Position::create(100, 175))
);

//$image->show();


/*
 * 
 * How to apply an alpha color to a text into an image
 * 
 */
$image = Easy\Image::create(Easy\Dimension::create(250, 100))
	->fill(Easy\Color::create('#f2f2f2'))
	->addText(
	Easy\Text::create('Alpha Color')
	->setColor(
		Easy\Color::create('#FF0000')
		->setAlpha(90)
	)
	->setSize(5)
	->setPosition(Easy\Position::create(55, 35))
);
//$image->show();
?>