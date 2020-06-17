<?php

require '../vendor/autoload.php';

use Easygd\Color;
use Easygd\Image;
use Easygd\Iptc;
use Easygd\Position;
use Easygd\Text;

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
 * 
 * how to get the standard positions
 */

$image = (new Image())->load($filename);

echo 'TOP_LEFT:', $image->TOP_LEFT, '<br/>';
echo 'TOP_CENTER:', $image->TOP_CENTER, '<br/>';
echo 'TOP_RIGHT:', $image->TOP_RIGHT, '<br/>';
echo 'MIDDLE_LEFT', $image->MIDDLE_LEFT, '<br/>';
echo 'MIDDLE_CENTER', $image->MIDDLE_CENTER, '<br/>';
echo 'MIDDLE_RIGHT', $image->MIDDLE_RIGHT, '<br/>';
echo 'BOTTOM_LEFT', $image->BOTTOM_LEFT, '<br/>';
echo 'BOTTOM_CENTER', $image->BOTTOM_CENTER, '<br/>';
echo 'BOTTOM_RIGHT', $image->BOTTOM_RIGHT, '<br/>';

/*
 * It's VERY DANGEROUS to use this function in production. 
 * 
 * The src function use a temporary file to send the data.
 * Use only this function for testing your application.
 * 
 */

$image = (new Image())->load($filename)
	->addText(
		(new Text())->create('Hello Zend')
			->setColor(Color::Silver())
			->setSize(4)
			->setPosition((new Position)->create(60, 20))
	);

?>

<img src="<?php echo $image->src(); ?>">

<?php

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

// $iptc = $imageInfo->getIpct();
// $iptc->addTag(Iptc::IPTC_CITY, 'CHEVERNY')
// 	->addTag(Iptc::IPTC_COUNTRY, 'FRANCE')
// 	->addTag(Iptc::IPTC_CREATED_DATE, '2012-03-01')
// 	->addTag(Iptc::IPTC_CATEGORY, 'JOURNEY');

// if ($iptc->write($fileSrc, $fileDst) === false)
// 	throw new Exception('Error to write IPTC');

// $imageInfo = (new Image())->getInfos($fileDst);

// echo '<pre>', $imageInfo, '</pre>';



?>