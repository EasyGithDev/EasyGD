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
 * How to have the font list
 * 
 */

$list = \Easy\Text::getFontList(\Easy\Text::TEXT_MACOS_FONT_PATH);
//echo '<pre>', print_r($list, 1), '</pre>';


/*
 * 
 * How to use "TrueType text" into an image
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
 * How to use "FreeType text" with a line break into an image
 * 
 */

$image = Easy\Image::create($dimension, Easy\Color::create('#f2f2f2'))
	->addText(
	Easy\FreeType::create('Hello ' . PHP_EOL . 'Free World', \Easy\Text::TEXT_MACOS_FONT_PATH . '/Tahoma.ttf')
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
$image = Easy\Image::create(Easy\Dimension::create(250, 100), Easy\Color::Silver())
	->addText(
	Easy\Text::create('Alpha Color')
	->setColor(
		Easy\Color::create('#FF0000')
		->setAlpha(95)
	)
	->setSize(5)
	->setPosition(Easy\Position::create(55, 35))
);
//$image->show();


/*
 * 
 * How to view the font list as an image
 * 
 */

$position = \Easy\Position::create(5, 5);
$text = Easy\TrueType::create('', \Easy\Text::TEXT_MACOS_FONT_PATH . '/' . $list[0]);
$image = Easy\Image::create(Easy\Dimension::create(800, 600), Easy\Color::White());

$i = 1;
foreach ($list as $v) {
    if ($i == 55) {
	$position->setX(300);
	$i = 1;
    }
    $position->setY($i * 15);
    $text->setFontfile(\Easy\Text::TEXT_MACOS_FONT_PATH . '/' . $v);
    $text->setText($v);
    $text->setPosition($position);
    $image->addText($text);
    $i++;
}
//$image->show();
?>