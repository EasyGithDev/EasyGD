<?php

use Easy\Color;
use Easy\Dimension;
use Easy\Image;
use Easy\Position;

require '../autoload.php';

$filename = 'http://www.php.net/images/logos/php-med-trans.png';


/*
 * 
 * How to resize an image
 * 
 */
// (new Image)->load($filename)->resizeByPercent(0.5)->show();


/*
 * 
 * How to resize an image by fixing the width
 * 
 */
// (new Image)->load($filename)->resizeByWidth(50)->show();

/*
 * 
 * How to resize an image by fixing the height
 * 
 */
// (new Image)->load($filename)->resizeByHeight(30)->show();

/*
 * 
 * How to safetly resize an image 
 * 
 */
// (new Image)->load($filename)->resizeAuto((new Dimension())->create(600, 400))->show();

/*
 * 
 * How to crop an image
 * Original script : http://www.php.net/manual/en/function.imagecopy.php
 */
// $filename = 'http://static.php.net/www.php.net/images/php.gif';
// (new Image)->load($filename)->crop(Position::create(20, 13), (new Dimension())->create(80, 40))->show();



/*
 * 
 * How to make a thumbnail
 * 
 */
// (new Image)->load($filename)->thumbnail(140, Color::Silver())->show();


/*
 * 
 * How to make a rotation
 * 
 */
// (new Image)->load($filename)->rotate(90)->show();


/*
 * 
 * How to add merge two images
 * 
 */
// $logo = (new Image)->load('http://www.php.net/images/logos/php-med-trans-light.gif')->resizeByPercent(0.6);
// (new Image)->load('http://static.php.net/www.php.net/images/logos/php-med-trans.png')->inlay($logo, Position::create(30, 20), 100)->show();


// Chargement d'un image pour le fond
$logo = (new Image)->load('http://www.php.net/images/logos/php-med-trans.png')->resizeByPercent(0.3);

// Création d'une nouvelle image
$image = (new Image)->create((new Dimension())->create(400, 400));

// Définition du carrelage
imagesettile($image->getImg(), $logo->getImg());

// Répétition de l'image
imagefilledrectangle($image->getImg(), 0, 0, $image->getWidth() - 1, $image->getHeight() - 1, IMG_COLOR_TILED);

$image->show();
