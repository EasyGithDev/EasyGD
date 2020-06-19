<?php

use Easygd\Image;
use Easygd\LookUpTable;
use Easygd\LookupTableFunctions;


require '../vendor/autoload.php';

$filename = 'https://www.php.net/images/logos/new-php-logo.png';

/***
 * 
 * How to use the lookuptable filter
 * 
 */

$closures = [
    \Closure::fromCallable([new LookupTableFunctions(), 'LightnessGray']),
    \Closure::fromCallable([new LookupTableFunctions(), 'AverageGray']),
    \Closure::fromCallable([new LookupTableFunctions(), 'LuminosityGray']),
    \Closure::fromCallable([new LookupTableFunctions(), 'Thresholding']),
    \Closure::fromCallable([new LookupTableFunctions(), 'Negative']),
    \Closure::fromCallable([new LookupTableFunctions(), 'Special']),
];

foreach ($closures as $closure) {
    $lut = (new LookUpTable())->create($closure)->process((new Image())->load($filename))->dataSrc();
?>

    <img src="<?php echo $lut ?>">


<?php
}
/***
 * 
 * How to use the filter factory
 * 
 */

//$filter = Filter::create(Filter::FILTER_LOOKUPTABLE, 'Negative');
//$filter = FilterFactory::create(FilterFactory::FILTER_PRESET, 'PRESET_EMBOSS');
//$filter = FilterFactory::create(FilterFactory::FILTER_PRESET, 'PRESET_PIXELATE', 3, true);
//$filter = FilterFactory::create(FilterFactory::FILTER_CONVOLUTION, $matrix);
//$filter = FilterFactory::create(FilterFactory::FILTER_CONVOLUTION, 'CONVOLUTION_LAPLACIEN_1');