<?php

use Easygd\Image;
use Easygd\Preset;
use Easygd\PresetFunctions;

require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';


/***
 * 
 * How to use the preset filter
 * 
 */

$preset1 = PresetFunctions::negate()->process((new Image())->load($stream))->dataSrc();
$preset2 = PresetFunctions::grayscale()->process((new Image())->load($stream))->dataSrc();
$preset3 = PresetFunctions::edgedetect()->process((new Image())->load($stream))->dataSrc();
$preset4 = PresetFunctions::emboss()->process((new Image())->load($stream))->dataSrc();
$preset5 = PresetFunctions::gaussian_blur()->process((new Image())->load($stream))->dataSrc();
$preset6 = PresetFunctions::mean_removal()->process((new Image())->load($stream))->dataSrc();
$preset7 = PresetFunctions::selective_blur()->process((new Image())->load($stream))->dataSrc();

$blockSize = 3;
$type = true;
$preset8 = PresetFunctions::pixelate($blockSize, $type)->process((new Image())->load($stream))->dataSrc();

$smooth = 100;
$preset9 = PresetFunctions::smooth($smooth)->process((new Image())->load($stream))->dataSrc();

$contrast = 10;
$preset10 = PresetFunctions::contrast($contrast)->process((new Image())->load($stream))->dataSrc();

$brightness = 100;
$preset11 = PresetFunctions::brigthness($brightness)->process((new Image())->load($stream))->dataSrc();

$red = $green = $blue = 128;
$preset12 = PresetFunctions::colorize($red, $green, $blue)->process((new Image())->load($stream))->dataSrc();

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