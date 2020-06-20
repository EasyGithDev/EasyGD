<?php

use Easygd\Convolution;
use Easygd\ConvolutionFilter;
use Easygd\ConvolutionFunctions;
use Easygd\Image;

require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';

$dataSrc = (new ConvolutionFilter())->create(ConvolutionFunctions::gaussian())->process((new Image())->load($stream))->dataSrc();

?>
<p>
    <img src="<?php echo $dataSrc ?>">
</p>
<?php


// All convolution
foreach (get_class_methods(ConvolutionFunctions::class) as $name) {

    $convolution = ConvolutionFunctions::$name();
    $dataSrc = (new ConvolutionFilter())->create($convolution)->process((new Image())->load($stream))->dataSrc();

?>
    <p>
        <?php echo $name ?>
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