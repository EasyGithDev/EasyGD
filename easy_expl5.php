<?php

require 'autoload.php';

//$filename = 'http://static.zend.com/topics/ZF2-for-ZF-site-logo-01-B-350.png';
$filename = 'http://www.php.net/images/logos/php-med-trans.png';
//$filename = 'http://intechgriti.in/wp-content/uploads/2012/06/php-frameworks.gif';

/*
 * 
 * Loading an image
 * 
 */

if (($image = Easy\Image::createFrom($filename)) === FALSE)
    throw new Exception('Error loading');

/*
 * 
 * How to resize an image
 * 
 */
//Easy\Transformation::resizeByPercent($image, 0.5)->saveAlpha()->show();

/*
 * 
 * How to resize an image by fixing the width
 * 
 */
//Easy\Transformation::resizeByWidth($image, 100)->show();


/*
 * 
 * How to resize an image by fixing the height
 * 
 */
//Easy\Transformation::resizeByHeight($image, 100)->show();

/*
 * 
 * How to safetly resize an image 
 * 
 */
//Easy\Transformation::resizeAuto($image, Easy\Dimension::create(600, 400))->show();

/*
 * 
 * How to crop an image
 * Original script : http://www.php.net/manual/en/function.imagecopy.php
 */

/*
$filename = 'http://static.php.net/www.php.net/images/php.gif';
Easy\Transformation::crop(
        Easy\Image::createFrom($filename), 
        Easy\Position::create(20, 13), 
        Easy\Dimension::create(80, 40))
        ->show();
*/


/*
 * 
 * How to make a thumbnail
 * 
 */
//Easy\Transformation::thumbnail($image, 140, Easy\Color::Silver())->show();


/*
 * 
 * How to make a rotation
 * 
 */
Easy\Transformation::rotate($image, 90)->show();


/*
 * 
 * How to add merge two images
 * 
 */
//$logo = Easy\Image::createFrom('http://www.php.net/images/logos/php-med-trans.png');
//$logo = Easy\Transformation::resizeByPercent($logo, 0.6);
//Easy\Transformation::inlay($image, $logo, Easy\Transformation::POSITION_MIDDLE_RIGHT, Easy\Position::create(30, 10), 50 )->show();

/*
// Chargement d'un image pour le fond
$logo = Easy\Transformation::resizeByPercent(Easy\Image::createFrom('http://www.php.net/images/logos/php-med-trans.png'), 0.2)->saveAlpha();

// Création d'une nouvelle image
$image = Easy\Image::create(Easy\Dimension::create(200, 200))->saveAlpha();

// Définition du carrelage
imagesettile($image->getImg(), $logo->getImg());

// Répétition de l'image
imagefilledrectangle($image->getImg(), 0, 0, $image->getWidth()-1, $image->getHeight()-1, IMG_COLOR_TILED);

$image->show();
 * 
 */
?>