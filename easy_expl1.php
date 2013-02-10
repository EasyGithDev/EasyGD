<?php

require 'autoload.php';

$filename = 'http://static.zend.com/topics/ZF2-for-ZF-site-logo-01-B-350.png';

/*
 * 
 * How to load and show an image
 * 
 */
Easy\Image::createfrom($filename)->show();


/*
 * 
 * How to load, change the mime type and show an image
 * 
 */
//Easy\Image::createfrom($filename)->setImagetype(IMAGETYPE_JPEG)->show();


/*
 * 
 * How to test, load, and show an image
 * 
 */
//if(($image = Easy\Image::createFrom($filename)) !== FALSE) $image->show();


/*
 * 
 * How to turn off the http headers output
 * 
 */
//Easy\Image::createfrom($filename)->show(FALSE);


/*
 * 
 * How to load and save an image
 * 
 */
//Easy\Image::createfrom($filename)->save('zend');


/*
 * 
 * How to load and convert an image
 * 
 */
//Easy\Image::createfrom($filename)->setImagetype(IMAGETYPE_GIF)->save('zend');


/*
 * 
 * How to manage the image quality
 * 
 */
//Easy\Image::createfrom($filename)->setImagetype(IMAGETYPE_JPEG)->save('zend', 25);

/*
 * 
 * How to load, save and show an image in the same time
 * 
 */
//Easy\Image::createfrom($filename)->save('zend')->show();


/*
 * 
 * How to make multiple save
 * 
 */
//Easy\Image::createfrom($filename)->save('zend')->setImagetype(IMAGETYPE_GIF)->save('zend')->setImagetype(IMAGETYPE_JPEG)->save('zend');

?>