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

//Easy\Filter::FILTER_NEGATE()->process($image)->show();
//Easy\Filter::FILTER_GRAYSCALE()->process($image)->show();
//Easy\Filter::FILTER_EDGEDETECT()->process($image)->show();
//Easy\Filter::FILTER_EMBOSS()->process($image)->show();
//Easy\Filter::FILTER_GAUSSIAN_BLUR()->process($image)->show();
//Easy\Filter::FILTER_MEAN_REMOVAL()->process($image)->show();
//$blockSize = 3;
//$type = true;
//Easy\Filter::FILTER_PIXELATE($blockSize, $type)->process($image)->show();
//Easy\Filter::FILTER_SELECTIVE_BLUR()->process($image)->show();
//$smooth = 100;
//Easy\Filter::FILTER_SMOOTH($smooth)->process($image)->show();
//$contrast = 10;
//Easy\Filter::FILTER_CONTRAST($contrast)->process($image)->show();
//$brightness = 100;
//Easy\Filter::FILTER_BRIGHTNESS($brightness)->process($image)->show();
//$color = \Easy\Color::Purple();
//Easy\Filter::FILTER_COLORIZE($color)->process($image)->show();
//$convolution = Easy\Convolution::CONVOLUTION_IDENTITY();
//$convolution = Easy\Convolution::CONVOLTION_SHARPEN();
//$convolution = Easy\Convolution::CONVOLTION_DECTECTION_EDGES();
//$convolution = Easy\Convolution::CONVOLUTION_FIND_EDGES();
//$convolution = Easy\Convolution::CONVOLUTION_BLUR();
//$convolution = Easy\Convolution::CONVOLUTION_GAUSSIAN();
//$convolution = Easy\Convolution::CONVOLUTION_ENHANCEMENT_EDGES();
//$convolution = Easy\Convolution::CONVOLUTION_LAPLACIEN_1();
//$convolution = Easy\Convolution::CONVOLUTION_LAPLACIEN_2();
//$convolution = Easy\Convolution::CONVOLUTION_LAPLACIEN_3();
//$convolution = Easy\Convolution::CONVOLUTION_GRADIENT_EW();
//$convolution = Easy\Convolution::CONVOLUTION_GRADIENT_WE();
//$convolution = Easy\Convolution::CONVOLUTION_GRADIENT_NS(4);
//$convolution = Easy\Convolution::CONVOLUTION_GRADIENT_SN(4);
//$convolution = Easy\Convolution::CONVOLUTION_GRADIENT_NWSE(4);
//$convolution = Easy\Convolution::CONVOLUTION_PRATT();
//$convolution = Easy\Convolution::CONVOLUTION_4_CONNEX();
//$convolution = Easy\Convolution::CONVOLUTION_8_CONNEX();



$matrix = array(-1, 7, -1,
    0, 0, 0,
    1, 7, 1
);

$convolution = \Easy\Convolution::create($matrix);


Easy\Filter::create($convolution)->process($image)->show();
?>