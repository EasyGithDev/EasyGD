<?php

require 'autoload.php';

$filename = 'http://static.zend.com/topics/ZF2-for-ZF-site-logo-01-B-350.png';

/*
 * 
 * How to load an image for data src
 * 
 */

?>
<img src="<?php echo Easy\Image::getDataSource($filename); ?>" />