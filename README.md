EasyGD
======

EasyGD - a PHP framework for use GD easier


# The basic stuff 


####How to load and show an image

    Easy\Image::createfrom($filename)->show();
	

####How to load, change the mime type and show an image

    Easy\Image::createfrom($filename)->setImagetype(IMAGETYPE_JPEG)->show();


####How to test, load, and show an image

    if(($image = Easy\Image::createFrom($filename)) !== FALSE) $image->show();


####How to turn off the http headers output

    Easy\Image::createfrom($filename)->show(FALSE);


####How to load and save an image

    Easy\Image::createfrom($filename)->save('zend');


####How to load and convert an image

    Easy\Image::createfrom($filename)->setImagetype(IMAGETYPE_GIF)->save('zend');


####How to manage the image quality

    Easy\Image::createfrom($filename)->setImagetype(IMAGETYPE_JPEG)->save('zend', 25);


####How to load, save and show an image in the same time

    Easy\Image::createfrom($filename)->save('zend')->show();


####How to make multiple save

    Easy\Image::createfrom($filename)->save('zend')->setImagetype(IMAGETYPE_GIF)->save('zend')->setImagetype(IMAGETYPE_JPEG)->save('zend');

----

# Create your own images

#### define a dimension
    $dimension = Easy\Dimension::create(300, 300);

####How to create a truetype image
    Easy\Image::create($dimension)->show();

####How to create a color with hexadecimal code
    $color = Easy\Color::create('#83d01e');

####How to create a color from a preset
    $color = Easy\Color::create(\Easy\Color::Yellow);

####How to create a preseted color 
    $color = Easy\Color::Yellow();

####How to fill an image with a color 
    Easy\Image::create($dimension, Easy\Color::Gray())->show();

----

# Adding text in the images 

#### How to create a GD text
    $text = Easy\Text::create('Hello World');

#### Define a position
    $position = Easy\Position::create(100, 125);


#### How to add a GD text into an image
    $image = Easy\Image::create($dimension, Easy\Color::Blue())->addText(
	$text->setColor(Easy\Color::Silver())
		->setSize(3)
		->setPosition($position)
    );


#### How to draw a string vertically into an image
    $image = Easy\Image::create(Easy\Dimension::create(100, 100))->addText(
	Easy\Text::create('gd library')
		->setSize(3)
		->setColor(Easy\Color::White())
		->setdrawtype(Easy\Text::TEXT_DRAW_VERTICAL)
		->setPosition(Easy\Position::create(40, 80))
    );

#### How to add a TrueType text into an image

    $text = Easy\TrueType::create('Hello True World', \Easy\Text::TEXT_MACOS_FONT_PATH . '/Arial Black.ttf')
	->setColor(Easy\Color::Silver())
	->setSize(16)
	->setAngle(45)
	->setPosition($position);


#### How to add a FreeType text into an image

    $text = Easy\FreeType::create('Hello Free World', \Easy\Text::TEXT_MACOS_FONT_PATH . '/Arial Black.ttf')
	->setColor(Easy\Color::Silver())
	->setSize(16)
	->setAngle(45)
	->setPosition($position);

#### How to apply an alpha color to a text into an image
    $text =	Easy\Text::create('Alpha Color')
	->setColor(
		Easy\Color::create('#FF0000')
		->setAlpha(90)
	)
	->setSize(5)
	->setPosition($position);

----

# Using the help methods


#### How to load an image for data src
    <img src="<?php echo Easy\Image::getDataSource($filename); ?>" />

#### how to get the information about an image
    $infos = Easy\Image::getInfos($filename);
    echo '<pre>', print_r($infos, 1), '</pre>';

----

# Transformations

## Resizing the images

#### How to resize an image
    Easy\Transformation::resizeByPercent($image, 0.5)->show();


#### How to resize an image by fixing the width or height
    Easy\Transformation::resizeByWidth($image, 100)->show();
    Easy\Transformation::resizeByHeight($image, 100)->show();

#### How to safetly resize an image 
    Easy\Transformation::resizeAuto($image, Easy\Dimension::create(600, 400))->show();

#### How to make a thumbnail
    Easy\Transformation::thumbnail($image, 140)->show();

## Croping and Rotation

#### How to crop an image
    Easy\Transformation::crop(
        Easy\Image::createFrom($filename), 
        Easy\Position::create(20, 13), 
        Easy\Dimension::create(80, 40))
        ->show();

#### How to make a rotation
    Easy\Transformation::rotate($image, 90)->show();


