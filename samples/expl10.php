<?php

use Easygd\ConvolutionFunctions;
use Easygd\Filter;
use Easygd\Image;

require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';

/***
 * 
 * How to use the filter factory
 * 
 */

// Preset filters
$src1 = Filter::negate()->process((new Image())->load($stream))->dataSrc();

// Convolution filters
$src2 = Filter::emboss()->process((new Image())->load($stream))->dataSrc();

// LookupTable filters
$src3 = Filter::thresholding()->process((new Image())->load($stream))->dataSrc();

?>
<img src="<?php echo $src1 ?>">
<img src="<?php echo $src2 ?>">
<img src="<?php echo $src3 ?>">