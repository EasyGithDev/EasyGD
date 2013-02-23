<?php

set_time_limit(0);

require 'autoload.php';

$text = \Easy\TrueType::create('Copyright (C) 2013 Florent Brusciano', \Easy\Text::TEXT_MACOS_FONT_PATH . '/Arial Black.ttf')
	->setSize(5)
	->setColor(Easy\Color::White())
	->setPosition(Easy\Position::create(40, 190));

$path = __DIR__ . '/images/original/';
foreach (new \Easy\ImageFilterIterator(new DirectoryIterator($path)) as $file) {

    if (($image = Easy\Image::createFrom($file->getPathname())) === FALSE)
	continue;


    \Easy\Transformation::thumbnail($image, 50)
	    ->save(__DIR__ . '/images/thumb/50/' . $file->getFilename(), 100, FALSE);

    \Easy\Transformation::thumbnail($image, 100)
	    ->save(__DIR__ . '/images/thumb/100/' . $file->getFilename(), 100, FALSE);

    \Easy\Transformation::thumbnail($image, 200)
	    ->addText($text)
	    ->save(__DIR__ . '/images/thumb/200/' . $file->getFilename(), 100, FALSE);

    \Easy\Transformation::thumbnail($image, 400)
	    ->save(__DIR__ . '/images/thumb/400/' . $file->getFilename(), 100, FALSE);
}
?>