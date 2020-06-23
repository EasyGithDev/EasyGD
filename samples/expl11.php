<?php

use Easygd\AffineFilter;
use Easygd\AffineFunctions;
use Easygd\Image;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require '../vendor/autoload.php';

$stream = 'https://www.php.net/images/logos/new-php-logo.png';

/***
 * 
 * How to use the affine filter
 * 
 */

foreach (get_class_methods(AffineFunctions::class) as $name) {

    $affine = (new AffineFilter())->create(AffineFunctions::$name())->process((new Image())->load($stream))->src();
?>

    <p>
        <?php echo $name ?>
        <img src="<?php echo $affine ?>">
    </p>

<?php
}
