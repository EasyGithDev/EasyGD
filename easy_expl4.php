<?php
require 'autoload.php';

$filename = 'http://static.zend.com/topics/ZF2-for-ZF-site-logo-01-B-350.png';

/*
 * 
 * How to load an image for data src
 * Use it only on small image, if you dont want that your html page becommes to big 
 */
?>

<img src="<?php echo Easy\Image::getDataSource($filename); ?>" />

<?php
/*
 * It's VERY DANGEROUS to use this function in production. 
 * 
 * The src function use a temporary file to send the data.
 * Use only this function for testing your application.
 * 
 */

$image = Easy\Image::createfrom($filename)
        ->addText(
        Easy\Text::create('Hello Zend')
        ->setColor(Easy\Color::Silver())
        ->setSize(4)
        ->setPosition(Easy\Position::create(60, 20))
        );
?>

<img src="<?php echo $image->src(); ?>">