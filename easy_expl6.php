<?php

require 'autoload.php';

$filename = 'http://assets.natgeotv.com/Shows/2870.jpg';

/*
 *
 * Loading an image
 *
 */

if (($image = Easy\Image::createFrom($filename)) === FALSE)
    throw new Exception('Error loading');

/***
 * 
 * How to use the preset filter
 * 
 */

//$filter = Easy\Preset::PRESET_NEGATE();
//$filter = Easy\Preset::PRESET_GRAYSCALE();
//$filter = Easy\Preset::PRESET_EDGEDETECT();
//$filter =Easy\Preset::PRESET_EMBOSS();
//$filter = Easy\Preset::PRESET_GAUSSIAN_BLUR();
//$filter = Easy\Preset::PRESET_MEAN_REMOVAL();
//$filter = Easy\Preset::PRESET_SELECTIVE_BLUR();

//$blockSize = 3;
//$type = true;
//$filter = Easy\Preset::PRESET_PIXELATE($blockSize, $type);

//$smooth = 100;
//$filter = Easy\Preset::PRESET_SMOOTH($smooth);

//$contrast = 10;
//$filter = Easy\Preset::PRESET_CONTRAST($contrast);

//$brightness = 100;
//$filter = Easy\Preset::PRESET_BRIGHTNESS($brightness);

//$red = $green = $blue = 128;
//$filter = Easy\Preset::PRESET_COLORIZE($red,$green, $blue);

/***
 * 
 * How to use the convolution filter
 * 
 */

//$filter = Easy\Convolution::CONVOLUTION_IDENTITY();
//$filter = Easy\Convolution::CONVOLUTION_SHARPEN_1();
//$filter = Easy\Convolution::CONVOLUTION_SHARPEN_2();
//$filter = Easy\Convolution::CONVOLUTION_DETECTION_EDGES();
//$filter = Easy\Convolution::CONVOLUTION_FIND_EDGES_1();
//$filter = Easy\Convolution::CONVOLUTION_FIND_EDGES_2();
//$filter = Easy\Convolution::CONVOLUTION_FIND_EDGES_3();
//$filter = Easy\Convolution::CONVOLUTION_BLUR();
//$filter = Easy\Convolution::CONVOLUTION_GAUSSIAN();
//$filter = Easy\Convolution::CONVOLUTION_ENHANCEMENT_EDGES_1();
//$filter = Easy\Convolution::CONVOLUTION_ENHANCEMENT_EDGES_2();
//$filter = Easy\Convolution::CONVOLUTION_ENHANCEMENT_EDGES_3();
//$filter = Easy\Convolution::CONVOLUTION_LAPLACIEN_1();
//$filter = Easy\Convolution::CONVOLUTION_LAPLACIEN_2();
//$filter = Easy\Convolution::CONVOLUTION_LAPLACIEN_3();
//$filter = Easy\Convolution::CONVOLUTION_GRADIENT_EW();
//$filter = Easy\Convolution::CONVOLUTION_GRADIENT_WE();
//$filter = Easy\Convolution::CONVOLUTION_GRADIENT_NS(4);
//$filter = Easy\Convolution::CONVOLUTION_GRADIENT_SN(4);
//$filter = Easy\Convolution::CONVOLUTION_GRADIENT_NWSE(4);
//$filter = Easy\Convolution::CONVOLUTION_PRATT();
//$filter = Easy\Convolution::CONVOLUTION_4_CONNEX();
//$filter = Easy\Convolution::CONVOLUTION_8_CONNEX();

$matrix = array(-1, 7, -1,
    0, 0, 0,
    1, 7, 1
);

//$filter = \Easy\Convolution::create($matrix);

/***
 * 
 * How to use the lookuptable filter
 * 
 */

//$filter = \Easy\LookUpTable::create('LightnessGray');
//$filter = \Easy\LookUpTable::create('AverageGray');
//$filter = \Easy\LookUpTable::create('LuminosityGray');
//$filter = \Easy\LookUpTable::create('Thresholding');
//$filter = \Easy\LookUpTable::create('Negative');
//$filter = \Easy\LookUpTable::create('Special');

/***
 * 
 * How to use the filter factory
 * 
 */

$filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_LOOKUPTABLE, 'Negative');
//$filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_PRESET, 'PRESET_EMBOSS');
//$filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_PRESET, 'PRESET_PIXELATE', 3, true);
//$filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_CONVOLUTION, $matrix);
//$filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_CONVOLUTION, 'CONVOLUTION_LAPLACIEN_1');

$filter->process($image)->show();


?>