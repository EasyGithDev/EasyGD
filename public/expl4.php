<?php

require '../autoload.php';

use Easy\Image;

$filename = 'https://www.php.net/images/logos/new-php-logo.png';
 
/*
 * 
 * How to load an image for data src
 * Use it only on small image, if you dont want that your html page becommes to big 
 */
?>

<img src="<?php echo (new Image())->getDataSource($filename) ?>" />

<?php

/*
 * It's VERY DANGEROUS to use this function in production. 
 * 
 * The src function use a temporary file to send the data.
 * Use only this function for testing your application.
 * 
 */

$image = (new Image())->load($filename)
	->addText(
	Easy\Text::create('Hello Zend')
	->setColor(Easy\Color::Silver())
	->setSize(4)
	->setPosition(Easy\Position::create(60, 20))
);
?>

<img src="<?php echo $image->src(); ?>">

<?php

die;
/*
 * 
 * how to get the information about an image
 */
$fileSrc = __DIR__ . '/2012-05-07 11.57.45.jpg';
$fileDst = __DIR__ . '/iptc.jpg';

$imageInfo = (new Image())->getInfos($filename);
echo '<pre>', $imageInfo, '</pre>';

/*
 * 
 * how to get / add the ipct tag
 */

$iptc = $imageInfo->getIpct();
$iptc->addTag(\Easy\Iptc::IPTC_CITY, 'CHEVERNY')
	->addTag(Easy\Iptc::IPTC_COUNTRY, 'FRANCE')
	->addTag(Easy\Iptc::IPTC_CREATED_DATE, '2012-03-01')
	->addTag(Easy\Iptc::IPTC_CATEGORY, 'JOURNEY');

if ($iptc->write($fileSrc, $fileDst) === false)
    throw new Exception('Error to write IPTC');

$imageInfo = (new Image())->getInfos($fileDst);

echo '<pre>', $imageInfo, '</pre>';


/*
 * 
 * how to get the standard positions
 */

echo $image->TOP_LEFT, '<br/>';
echo $image->TOP_CENTER, '<br/>';
echo $image->TOP_RIGHT, '<br/>';
echo $image->MIDDLE_LEFT, '<br/>';
echo $image->MIDDLE_CENTER, '<br/>';
echo $image->MIDDLE_RIGHT, '<br/>';
echo $image->BOTTOM_LEFT, '<br/>';
echo $image->BOTTOM_CENTER, '<br/>';
echo $image->BOTTOM_RIGHT, '<br/>';
?>