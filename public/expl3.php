<?php

require '../vendor/autoload.php';

use Easygd\Color;
use Easygd\Dimension;
use Easygd\FreeType;
use Easygd\Image;
use Easygd\Position;
use Easygd\Text;
use Easygd\TrueType;

/*
 * 
 * How to add a GD text into an image
 * 
 */

(new Image)->create((new Dimension)->create(300, 300), Color::Blue())->addText(
	(new Text())->create('Hello World')
		->setColor(Color::Silver())
		->setSize(3)
		->setPosition((new Position)->create(200, 125))
)->show();

/*
 * 
 * How to draw a string vertically into an image
 * 
 */
// (new Image())->create((new Dimension())->create(200, 200))->addText(
// 	(new Text())->create('gd library')
// 		->setSize(5)
// 		->setColor(Color::White())
// 		->setdrawtype(Text::TEXT_DRAW_VERTICAL)
// 		->setPosition((new Position())->create(40, 100))
// )->show();


/*
 * 
 * How to have the font list
 * 
 */

$list = Text::getFontList(Text::TEXT_UNIX_FONT_PATH);
// echo '<pre>', print_r($list, 1), '</pre>';

/*
 * 
 * How to use "TrueType text" into an image
 * 
 */
// (new Image())->create((new Dimension())->create(300, 300), (new Color())->create('#f2f2f2'))
// 	->addText(
// 		(new TrueType('Hello True World', Text::TEXT_UNIX_FONT_PATH . '/truetype/dejavu/DejaVuSans.ttf'))
// 			->setColor(Color::Silver())
// 			->setSize(16)
// 			->setAngle(45)
// 			->setPosition((new Position())->create(100, 175))

// 	)
// 	->addText(
// 		(new Text('hello world'))
// 			->setColor(Color::Maroon())
// 			->setPosition((new Position())->create(98, 173))
// 	)
// 	->show();

/*
 * 
 * How to use "FreeType text" with a line break into an image
 * 
 */

// (new Image())->create((new Dimension())->create(300, 300), (new Color())->create('#f2f2f2'))
// 	->addText(
// 		FreeType::create('Hello ' . PHP_EOL . 'Free World', Text::TEXT_MACOS_FONT_PATH . '/Tahoma.ttf')
// 			->setColor(Color::Silver())
// 			->setSize(16)
// 			->setAngle(45)
// 			->setPosition((new Position())->create(100, 175))
// 	)
// 	->show();

/*
 * 
 * How to apply an alpha color to a text into an image
 * 
 */
// (new Image)->create((new Dimension())->create(300, 300), Color::White())
// 	->addText(
// 		(new Text())->create('Alpha Color')
// 			->setColor(
// 				(new Color())->create('#FF0000')->setAlpha(95)
// 			)
// 			->setSize(5)
// 			->setPosition((new Position())->create(55, 35))
// 	)
// 	->show();


/*
 * 
 * How to view the font list as an image
 * 
 */

// $position = (new Position())->create(5, 5);
// $text = TrueType::create('', Text::TEXT_MACOS_FONT_PATH . '/' . $list[0]);
// $image = (new Image())->create((new Dimension())->create(1024, 768), Color::White());

// $i = 1;
// foreach ($list as $v) {
// 	if (($i % 40) == 0) {
// 		$position->offsetX(300);
// 		$i = 1;
// 	}
// 	$position->setY($i * 18);
// 	$text->setFontfile(Text::TEXT_MACOS_FONT_PATH . '/' . $v);
// 	$text->setText($v);
// 	$text->setPosition($position);
// 	$image->addText($text);
// 	$i++;
// }
// $image->show();
