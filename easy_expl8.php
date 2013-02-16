<?php

set_time_limit(0);

require 'autoload.php';

$text = \Easy\TrueType::create('Copyright (C) 2013 Florent Brusciano', \Easy\Text::TEXT_MACOS_FONT_PATH . '/Arial Black.ttf')
        ->setSize(5)
        ->setColor(Easy\Color::White())
        ->setPosition(Easy\Position::create(40, 190));

$path = '/Users/florent/Pictures/Florent portable';
foreach (new DirectoryIterator($path) as $file) {
    if ($file->isDot())
        continue;

    if (($image = Easy\Image::createFrom($file->getPathname())) === FALSE)
        continue;

    \Easy\Transformation::thumbnail($image, 200)
            ->addText($text)
            ->save('./thumb/' . $file->getFilename());
}
?>