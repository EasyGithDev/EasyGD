<?php

require '../vendor/autoload.php';

use Easygd\Color;
use Easygd\Dimension;
use Easygd\Image;
use Easygd\Position;


$filename = 'http://www.php.net/images/logos/php-med-trans.png';

$src0 = (new Image)->load($filename)->dataSrc();

/*
 * 
 * How to resize an image
 * 
 */
$src1 = (new Image)->load($filename)
    ->resizeByPercent(0.5)
    ->dataSrc();



/*
 * 
 * How to resize an image by fixing the width
 * 
 */
$src2 = (new Image)->load($filename)
    ->resizeByWidth(50)
    ->dataSrc();

/*
 * 
 * How to resize an image by fixing the height
 * 
 */
$src3 = (new Image)->load($filename)
    ->resizeByHeight(30)
    ->dataSrc();

/*
 * 
 * How to safetly resize an image 
 * 
 */
$src4 = (new Image)->load($filename)
    ->resizeAuto((new Dimension())->create(300, 200))
    ->dataSrc();

/*
 * 
 * How to crop an image
 * Original script : http://www.php.net/manual/en/function.imagecopy.php
 */
$filename = 'http://static.php.net/www.php.net/images/php.gif';
$src5 = (new Image)->load($filename)
    ->crop((new Position)->create(20, 13), (new Dimension())->create(80, 40))
    ->dataSrc();

/*
 * 
 * How to make a thumbnail
 * 
 */
$src6 = (new Image)->load($filename)
    ->thumbnail(140, Color::Silver())
    ->dataSrc();


/*
 * 
 * How to make a rotation
 * 
 */
$src7 = (new Image)->load($filename)
    ->rotate(90)
    ->dataSrc();

/*
 * 
 * How to add merge two images
 * 
 */
$logo = (new Image)->load('http://www.php.net/images/logos/php-med-trans-light.gif')
    ->resizeByPercent(0.6);
$src8 = (new Image)->load('http://static.php.net/www.php.net/images/logos/php-med-trans.png')
    ->inlay($logo, (new Position)->create(30, 20), 100)->dataSrc();


// Chargement d'un image pour le fond
$logo = (new Image)->load('http://www.php.net/images/logos/php-med-trans.png')->resizeByPercent(0.3);

// // Création d'une nouvelle image
$image = (new Image)->create((new Dimension())->create(400, 400));

// // Définition du carrelage
imagesettile($image->getImg(), $logo->getImg());

// // Répétition de l'image
imagefilledrectangle($image->getImg(), 0, 0, $image->getWidth() - 1, $image->getHeight() - 1, IMG_COLOR_TILED);

$src9 = $image->dataSrc();
?>
<img src="<?php echo $src0 ?>"><br>
<img src="<?php echo $src1 ?>"><br>
<img src="<?php echo $src2 ?>"><br>
<img src="<?php echo $src3 ?>"><br>
<img src="<?php echo $src4 ?>"><br>
<img src="<?php echo $src5 ?>"><br>
<img src="<?php echo $src6 ?>"><br>
<img src="<?php echo $src7 ?>"><br>
<img src="<?php echo $src8 ?>"><br>
<img src="<?php echo $src9 ?>"><br>