<?php

use Easygd\Filter;
use Easygd\Image;
use Easygd\LookUpTable;
use Easygd\LookupTableFunctions;


require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';


/***
 * 
 * How to use the filter factory
 * 
 */

$lut = Filter::make(Filter::FILTER_LOOKUPTABLE)
    ->create(\Closure::fromCallable([new LookupTableFunctions(), 'LightnessGray']))
    ->process((new Image())->load($stream))
    ->dataSrc();

?>

<img src="<?php echo $lut ?>">


<?php

$filter = Filter::make(Filter::FILTER_PRESET, 'PRESET_EMBOSS');
$filter = Filter::make(Filter::FILTER_PRESET, 'PRESET_PIXELATE', 3, true);
$filter = Filter::make(Filter::FILTER_CONVOLUTION, $matrix);
$filter = Filter::make(Filter::FILTER_CONVOLUTION, 'CONVOLUTION_LAPLACIEN_1');
