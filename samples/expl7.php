<?php

use Easygd\Image;
use Easygd\PresetFilter;
use Easygd\PresetFunctions;

require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';

/***
 * 
 * How to use the preset filter
 * 
 */

$preset1 = (new PresetFilter())->create(PresetFunctions::negate())->process((new Image())->load($stream))->src();
$preset2 = (new PresetFilter())->create(PresetFunctions::grayscale())->process((new Image())->load($stream))->src();
$preset3 = (new PresetFilter())->create(PresetFunctions::edgedetect())->process((new Image())->load($stream))->src();
$preset4 = (new PresetFilter())->create(PresetFunctions::emboss())->process((new Image())->load($stream))->src();
$preset5 = (new PresetFilter())->create(PresetFunctions::gaussian_blur())->process((new Image())->load($stream))->src();
$preset6 = (new PresetFilter())->create(PresetFunctions::mean_removal())->process((new Image())->load($stream))->src();
$preset7 = (new PresetFilter())->create(PresetFunctions::selective_blur())->process((new Image())->load($stream))->src();

$blockSize = 3;
$type = true;
$preset8 = (new PresetFilter())->create(PresetFunctions::pixelate($blockSize, $type))->process((new Image())->load($stream))->src();

$smooth = 100;
$preset9 = (new PresetFilter())->create(PresetFunctions::smooth($smooth))->process((new Image())->load($stream))->src();

$contrast = 10;
$preset10 = (new PresetFilter())->create(PresetFunctions::contrast($contrast))->process((new Image())->load($stream))->src();

$brightness = 100;
$preset11 = (new PresetFilter())->create(PresetFunctions::brigthness($brightness))->process((new Image())->load($stream))->src();

$red = $green = $blue = 128;
$preset12 = (new PresetFilter())->create(PresetFunctions::colorize($red, $green, $blue))->process((new Image())->load($stream))->src();

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