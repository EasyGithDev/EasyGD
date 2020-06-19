<?php

require '../vendor/autoload.php';

use Easygd\Image;

$filename = 'https://www.php.net/images/logos/new-php-logo.png';

/*
 * 
 * How to load an image for data src
 * Use it only on small image, if you dont want that your html page becommes to big 
 */
?>

<img src="<?php echo (new Image())->load($filename)->dataSrc() ?>" />