<?php

use Easygd\Convolution;
use Easygd\Image;
use Easygd\LookUpTable;
use Easygd\Preset;

require '../vendor/autoload.php';

$filename = 'https://www.php.net/images/logos/new-php-logo.png';

/***
 * 
 * How to use the lookuptable filter
 * 
 */

$lt1 = (new LookUpTable())->create('LightnessGray')->process((new Image())->load($filename))->dataSrc();
$lt2 = (new LookUpTable())->create('AverageGray')->process((new Image())->load($filename))->dataSrc();
$lt3 = (new LookUpTable())->create('LuminosityGray')->process((new Image())->load($filename))->dataSrc();
$lt4 = (new LookUpTable())->create('Thresholding')->process((new Image())->load($filename))->dataSrc();
$lt5 = (new LookUpTable())->create('Negative')->process((new Image())->load($filename))->dataSrc();
$lt6 = (new LookUpTable())->create('Special')->process((new Image())->load($filename))->dataSrc();

?>

<img src="<?php echo $lt1 ?>">
<img src="<?php echo $lt2 ?>">
<img src="<?php echo $lt3 ?>">
<img src="<?php echo $lt4 ?>">
<img src="<?php echo $lt5 ?>">
<img src="<?php echo $lt6 ?>">

<?php

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