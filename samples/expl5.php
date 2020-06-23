<?php

require '../vendor/autoload.php';

use Easygd\Color;
use Easygd\Dimension;
use Easygd\Image;
use Easygd\Position;


$stream = 'http://www.php.net/images/logos/php-med-trans.png';

$src0 = (new Image)->load($stream)->src();

/*
 * 
 * How to resize an image
 * 
 */
$src1 = (new Image)->load($stream)
    ->resizeByPercent(0.5)
    ->src();



/*
 * 
 * How to resize an image by fixing the width
 * 
 */
$src2 = (new Image)->load($stream)
    ->resizeByWidth(50)
    ->src();

/*
 * 
 * How to resize an image by fixing the height
 * 
 */
$src3 = (new Image)->load($stream)
    ->resizeByHeight(30)
    ->src();

/*
 * 
 * How to safetly resize an image 
 * 
 */
$src4 = (new Image)->load($stream)
    ->resizeAuto((new Dimension())->create(300, 200))
    ->src();

/*
 * 
 * How to crop an image
 * Original script : http://www.php.net/manual/en/function.imagecopy.php
 */
$stream = 'http://static.php.net/www.php.net/images/php.gif';
$src5 = (new Image)->load($stream)
    ->crop((new Position)->create(20, 13), (new Dimension())->create(80, 40))
    ->src();

/*
 * 
 * How to make a thumbnail
 * 
 */
$src6 = (new Image)->load($stream)
    ->thumbnail(140, Color::Silver())
    ->src();


/*
 * 
 * How to make a rotation
 * 
 */
$src7 = (new Image)->load($stream)
    ->rotate(90)
    ->src();

/*
 * 
 * How to add merge two images
 * 
 */
$logo = (new Image)->load('http://www.php.net/images/logos/php-med-trans-light.gif')
    ->resizeByPercent(0.6);
$src8 = (new Image)->load('http://static.php.net/www.php.net/images/logos/php-med-trans.png')
    ->inlay($logo, (new Position)->create(30, 20), 100)->src();


// Chargement d'un image pour le fond
$logo = (new Image)->load('http://www.php.net/images/logos/php-med-trans.png')->resizeByPercent(0.3);

// // Création d'une nouvelle image
$image = (new Image)->create((new Dimension())->create(400, 400));

// // Définition du carrelage
imagesettile($image->getImg(), $logo->getImg());

// // Répétition de l'image
imagefilledrectangle($image->getImg(), 0, 0, $image->getWidth() - 1, $image->getHeight() - 1, IMG_COLOR_TILED);

$src9 = $image->src();
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