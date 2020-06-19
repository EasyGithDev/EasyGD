<?php

require '../vendor/autoload.php';

use Easygd\Image;


$stream = 'https://www.php.net/images/logos/new-php-logo.png';

/*
 * 
 * how to get the information about an image
 */
$infos = (new Image())->load($stream)->getInfos();
echo '<pre>', $infos, '</pre>';

$infos = (new Image())->load($stream)->getInfos()->toArray();
echo '<pre>', print_r($infos, true), '</pre>';

/*
 * 
 * how to get the standard positions
 */

$image = (new Image())->load($stream);

echo 'TOP_LEFT:', $image->topLeft(), '<br/>';
echo 'TOP_CENTER:', $image->topCenter(), '<br/>';
echo 'TOP_RIGHT:', $image->topRight(), '<br/>';
echo 'MIDDLE_LEFT', $image->middleLeft(), '<br/>';
echo 'MIDDLE_CENTER', $image->middleCenter(), '<br/>';
echo 'MIDDLE_RIGHT', $image->middleRight(), '<br/>';
echo 'BOTTOM_LEFT', $image->bottomLeft(), '<br/>';
echo 'BOTTOM_CENTER', $image->bottomeCenter(), '<br/>';
echo 'BOTTOM_RIGHT', $image->bottomRight(), '<br/>';

/*
 * 
 * how to get / add the ipct tag
 */

// $fileSrc = __DIR__ . '/2012-05-07 11.57.45.jpg';
// $fileDst = __DIR__ . '/iptc.jpg';

// $iptc = $imageInfo->getIpct();
// $iptc->addTag(Iptc::IPTC_CITY, 'CHEVERNY')
// 	->addTag(Iptc::IPTC_COUNTRY, 'FRANCE')
// 	->addTag(Iptc::IPTC_CREATED_DATE, '2012-03-01')
// 	->addTag(Iptc::IPTC_CATEGORY, 'JOURNEY');

// if ($iptc->write($fileSrc, $fileDst) === false)
// 	throw new Exception('Error to write IPTC');

// $imageInfo = (new Image())->getInfos($fileDst);

// echo '<pre>', $imageInfo, '</pre>';
