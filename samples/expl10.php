<?php

use Easygd\Filter;
use Easygd\Image;

require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';

/***
 * 
 * How to use the filter factory
 * 
 */

$src1 = Filter::negate()->process((new Image())->load($stream))->dataSrc();
$src2 = Filter::CONVOLUTION_EMBOSS()->process((new Image())->load($stream))->dataSrc();
$src3 = Filter::Thresholding()->process((new Image())->load($stream))->dataSrc();

?>
<img src="<?php echo $src1 ?>">
<img src="<?php echo $src2 ?>">
<img src="<?php echo $src3 ?>">