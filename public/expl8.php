<?php

use Easygd\Convolution;
use Easygd\Image;
use Easygd\LookUpTable;
use Easygd\Preset;

require '../vendor/autoload.php';

$filename = 'https://www.php.net/images/logos/new-php-logo.png';


/***
 * 
 * How to use the convolution filter
 * 
 */
$list = Convolution::getConvolutionList();
foreach ($list as $convolutionName) {
    $convolution = call_user_func_array('\Easygd\Convolution::' . $convolutionName, []);
    $dataSrc = $convolution->process((new Image())->load($filename))->dataSrc();
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

$dataSrc = (new Convolution())->create($matrix)->process((new Image())->load($filename))->dataSrc();

?>
<p>
    My Convolution
    <img src="<?php echo $dataSrc ?>">
</p>