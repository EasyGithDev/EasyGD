<?php

use Easygd\Image;
use Easygd\LookUpTable;
use Easygd\LookUpTableFilter;
use Easygd\LookupTableFunctions;


require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';

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
    $lut = (new LookUpTableFilter())->create((new LookUpTable())->create($closure))->process((new Image())->load($stream))->dataSrc();
?>

    <img src="<?php echo $lut ?>">


<?php
}

function personnal($rgb)
{
    $r = ($rgb['red'] > 128) ? 255 : 128;
    $g = ($rgb['green'] > 128) ? 255 : 128;
    $b = ($rgb['blue'] > 128) ? 255 : 128;
    return [$r, $g, $b];
}

$closure = \Closure::fromCallable('personnal');
$lut = (new LookUpTableFilter())->create((new LookUpTable())->create($closure))->process((new Image())->load($stream))->dataSrc();
?>

<img src="<?php echo $lut ?>">