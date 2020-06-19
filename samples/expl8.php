<?php

use Easygd\Convolution;
use Easygd\ConvolutionFilter;
use Easygd\ConvolutionFunctions;
use Easygd\Image;

require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';

$dataSrc = (new ConvolutionFilter())->create(ConvolutionFunctions::CONVOLUTION_GAUSSIAN())->process((new Image())->load($stream))->dataSrc();

?>
<p>
    <img src="<?php echo $dataSrc ?>">
</p>
<?php


/***
 * 
 * How to use the convolution filter
 * 
 */
$list = ConvolutionFunctions::getConvolutionList();
foreach ($list as $convolutionName) {

    $convolution = call_user_func_array('\Easygd\ConvolutionFunctions::' . $convolutionName, []);
    $dataSrc = (new ConvolutionFilter())->create($convolution)->process((new Image())->load($stream))->dataSrc();

?>
    <p>
        <?php echo $convolutionName ?>
        <img src="<?php echo $dataSrc ?>">
    </p>

<?php
}

$matrix = [
    -1, 7, -1,
    0, 0, 0,
    1, 7, 1
];

$convolution = (new Convolution())->create($matrix);;
$dataSrc = (new ConvolutionFilter())->create($convolution)->process((new Image())->load($stream))->dataSrc();

?>
<p>
    My Convolution
    <img src="<?php echo $dataSrc ?>">
</p>