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

<?php
/*
 * 
 * how to get the information about an image
 */

$imageInfo = Easy\Image::getInfos($filename);
echo '<pre>', $imageInfo, '</pre>';

/*
 * 
 * how to get / add the ipct tag
 */

/*
$iptc = $imageInfo->getIpct();
$iptc->addTag(\Easy\Iptc::IPTC_CITY, 'Dans ton luc !!!!');

$fileSrc = $imageInfo->getFilename();
$fileDst = 'yes.jpg';

$iptc->write($fileSrc, $fileDst);
*/

/*
 * 
 * how to get the standard positions
 */

echo $image->TOP_LEFT, '<br/>';
echo $image->TOP_MIDDLE, '<br/>';
echo $image->TOP_RIGHT, '<br/>';
echo $image->MIDDLE_LEFT, '<br/>';
echo $image->MIDDLE_MIDDLE, '<br/>';
echo $image->MIDDLE_RIGHT, '<br/>';
echo $image->BOTTOM_LEFT, '<br/>';
echo $image->BOTTOM_MIDDLE, '<br/>';
echo $image->BOTTOM_RIGHT, '<br/>';
?>