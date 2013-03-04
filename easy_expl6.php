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

//$filter = Easy\Preset::FILTER_NEGATE();
//$filter = Easy\Preset::FILTER_GRAYSCALE();
//$filter = Easy\Preset::FILTER_EDGEDETECT();
//$filter =Easy\Preset::FILTER_EMBOSS();
//$filter = Easy\Preset::FILTER_GAUSSIAN_BLUR();
//$filter = Easy\Preset::FILTER_MEAN_REMOVAL();
//$filter = Easy\Preset::FILTER_SELECTIVE_BLUR();

//$blockSize = 3;
//$type = true;
//$filter = Easy\Preset::FILTER_PIXELATE($blockSize, $type);

//$smooth = 100;
//$filter = Easy\Preset::FILTER_SMOOTH($smooth);

//$contrast = 10;
//$filter = Easy\Preset::FILTER_CONTRAST($contrast);

//$brightness = 100;
//$filter = Easy\Preset::FILTER_BRIGHTNESS($brightness);

//$red = $green = $blue = 128;
//$filter = Easy\Preset::FILTER_COLORIZE($red,$green, $blue);


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

//$matrix = array(-1, 7, -1,
//    0, 0, 0,
//    1, 7, 1
//);
//
//$filter = \Easy\Convolution::create($matrix);


$filter = new \Easy\LookUpTable('LightnessGray');
//$filter = new \Easy\LookUpTable('AverageGray');
//$filter = new \Easy\LookUpTable('LuminosityGray');
//$filter = new \Easy\LookUpTable('Thresholding');
//$filter = new \Easy\LookUpTable('Negative');
//$filter = new \Easy\LookUpTable('Special');


\Easy\FilterFactory::process($image, $filter)->show();


?>