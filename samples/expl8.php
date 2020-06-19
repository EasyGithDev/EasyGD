<?php

use Easygd\Convolution;
use Easygd\ConvolutionFunctions;
use Easygd\Image;

require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';


/***
 * 
 * How to use the convolution filter
 * 
 */
$list = ConvolutionFunctions::getConvolutionList();
foreach ($list as $convolutionName) {
    $convolution = call_user_func_array('\Easygd\ConvolutionFunctions::' . $convolutionName, []);
    $dataSrc = $convolution->process((new Image())->load($stream))->dataSrc();
?>
    <p>
        <?php echo $convolutionName ?>
        <img src="<?php echo $dataSrc ?>">
    </p>

<?php
}

$matrix = array(
    -1, 7, -1,
    0, 0, 0,
    1, 7, 1
);

$dataSrc = (new Convolution())->create($matrix)->process((new Image())->load($stream))->dataSrc();

?>
<p>
    My Convolution
    <img src="<?php echo $dataSrc ?>">
</p>