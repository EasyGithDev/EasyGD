<?php

use Easygd\Color;
use Easygd\Image;
use Easygd\ImageFilterIterator;
use Easygd\Position;
use Easygd\Text;

require '../vendor/autoload.php';

$text = (new Text)->create('Copyright (C) 2013 Florent Brusciano')
	->setFontType(Text::TEXT_FONT_TRUETYPE)
	->setFontfile(Text::TEXT_UNIX_FONT_PATH . '/truetype/dejavu/DejaVuSans.ttf')
	->setSize(5)
	->setColor(Color::White())
	->setPosition((new Position())->create(40, 190));

$path = __DIR__ . '/images/original/';

foreach (new ImageFilterIterator(new DirectoryIterator($path)) as $file) {

	if (($image = (new Image)->load($file->getPathname())) === false) {
		continue;
	}

	$thumb1 = $image->thumbnail(100)->src();
	$thumb2 = $image->thumbnail(200)->addText($text)->src();
	$thumb3 = $image->thumbnail(400)->src();
?>

	<img src="<?php echo $thumb1 ?>" />
	<img src="<?php echo $thumb2 ?>" />
	<img src="<?php echo $thumb3 ?>" />
	<br />
<?php
}
