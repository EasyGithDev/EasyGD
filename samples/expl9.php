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

foreach (get_class_methods(LookupTableFunctions::class) as $name) {
    
    $closure = \Closure::fromCallable([new LookupTableFunctions(), $name]);
    $lut = (new LookUpTableFilter())->create((new LookUpTable())->create($closure))->process((new Image())->load($stream))->src();
?>

    <p>
        <?php echo $name ?>
        <img src="<?php echo $lut ?>">
    </p>



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
$lut = (new LookUpTableFilter())->create((new LookUpTable())->create($closure))->process((new Image())->load($stream))->src();
?>

<img src="<?php echo $lut ?>">