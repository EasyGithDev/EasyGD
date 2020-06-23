<?php

require '../vendor/autoload.php';

use Easygd\Image;
use Easygd\ImageInfo;
use Easygd\Iptc;

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
 * IPTC work only with JPEG file
 */

(new Image())->load('https://www.php.net/images/logos/new-php-logo.png')->setType(IMG_JPEG)->save('iptc.jpg');

$fileSrc = __DIR__ . '/iptc.jpg';
$fileDst = __DIR__ . '/iptc2.jpg';

$iptc = (new Iptc())->create($fileSrc, null); 
// $imageInfo->getIpct();
var_dump($iptc);
$iptc->addTag(Iptc::IPTC_CITY, 'CHEVERNY')
    ->addTag(Iptc::IPTC_COUNTRY, 'FRANCE')
    ->addTag(Iptc::IPTC_CREATED_DATE, '2012-03-01')
    ->addTag(Iptc::IPTC_CATEGORY, 'JOURNEY');

if ($iptc->write($fileDst) === false) {
    throw new Exception('Error to write IPTC');
}
echo '<pre>', (new Image())->load($fileDst)->getInfos(), '</pre>';