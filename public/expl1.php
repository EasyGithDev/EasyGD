<?php

require '../vendor/autoload.php';

use Easygd\Color;
use Easygd\Image;

$filename = 'https://www.php.net/images/logos/new-php-logo.png';

/*
 * 
 * How to load and show an image
 * 
 */

// (new Image())->load($filename)->show();

/*
 * 
 * How to load, change the mime type and show an image
 * 
 */
// (new Image())->load($filename)->setType(IMAGETYPE_PNG)->show();

/*
 * 
 * How to test, load, and show an image
 * 
 */
// if (($image = (new Image())->load($filename)) !== FALSE) {
//     $image->show();
// }




/*
 * 
 * How to turn off the http headers output
 * 
 */
// (new Image())->load($filename)->show(FALSE);


/*
 * 
 * How to load and save an image
 * 
 */
// (new Image())->load($filename)->save('php.png');


/*
 * 
 * How to load and convert an image
 * 
 */
// (new Image())->load($filename)->setType(IMAGETYPE_GIF)->save('php.gif');


/*
 * 
 * How to manage the image quality
 * 
 */
// (new Image())->load($filename)->setType(IMAGETYPE_JPEG)->save('php.jpg', 25);

/*
 * 
 * How to load, save and show an image in the same time
 * 
 */
// (new Image())->load($filename)->save('php.png')->show();


/*
 * 
 * How to make multiple save
 * 
 */
// (new Image())->load($filename)->save('php.png')->setType(IMAGETYPE_GIF)->save('php.gif')->setType(IMAGETYPE_JPEG)->save('php.jpg');
