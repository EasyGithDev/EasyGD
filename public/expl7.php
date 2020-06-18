<?php

use Easygd\Convolution;
use Easygd\Image;
use Easygd\LookUpTable;
use Easygd\Preset;

require '../vendor/autoload.php';

$filename = 'https://www.php.net/images/logos/new-php-logo.png';


/***
 * 
 * How to use the preset filter
 * 
 */

$preset1 = Preset::PRESET_NEGATE()->process((new Image())->load($filename))->dataSrc();
$preset2 = Preset::PRESET_GRAYSCALE()->process((new Image())->load($filename))->dataSrc();
$preset3 = Preset::PRESET_EDGEDETECT()->process((new Image())->load($filename))->dataSrc();
$preset4 = Preset::PRESET_EMBOSS()->process((new Image())->load($filename))->dataSrc();
$preset5 = Preset::PRESET_GAUSSIAN_BLUR()->process((new Image())->load($filename))->dataSrc();
$preset6 = Preset::PRESET_MEAN_REMOVAL()->process((new Image())->load($filename))->dataSrc();
$preset7 = Preset::PRESET_SELECTIVE_BLUR()->process((new Image())->load($filename))->dataSrc();

$blockSize = 3;
$type = true;
$preset8 = Preset::PRESET_PIXELATE($blockSize, $type)->process((new Image())->load($filename))->dataSrc();

$smooth = 100;
$preset9 = Preset::PRESET_SMOOTH($smooth)->process((new Image())->load($filename))->dataSrc();

$contrast = 10;
$preset10 = Preset::PRESET_CONTRAST($contrast)->process((new Image())->load($filename))->dataSrc();

$brightness = 100;
$preset11 = Preset::PRESET_BRIGHTNESS($brightness)->process((new Image())->load($filename))->dataSrc();

$red = $green = $blue = 128;
$preset12 = Preset::PRESET_COLORIZE($red, $green, $blue)->process((new Image())->load($filename))->dataSrc();

?>

<img src="<?php echo $preset1 ?>">
<img src="<?php echo $preset2 ?>">
<img src="<?php echo $preset3 ?>">
<img src="<?php echo $preset4 ?>">
<img src="<?php echo $preset5 ?>">
<img src="<?php echo $preset6 ?>">
<img src="<?php echo $preset7 ?>">
<img src="<?php echo $preset8 ?>">
<img src="<?php echo $preset9 ?>">
<img src="<?php echo $preset10 ?>">
<img src="<?php echo $preset11 ?>">
<img src="<?php echo $preset12 ?>">