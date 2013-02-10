<?php

require 'autoload.php';

$filename = 'http://assets.natgeotv.com/Shows/2870.jpg';

//$convolution = Easy\StaticConvolution::CONVOLUTION_IDENTITY();
//$convolution = Easy\StaticConvolution::CONVOLTION_SHARPEN();
//$convolution = Easy\StaticConvolution::CONVOLTION_EDGE();
//$convolution = Easy\StaticConvolution::CONVOLUTION_FINDEDGES();
//$convolution = Easy\StaticConvolution::CONVOLUTION_BLUR();
//$convolution = Easy\StaticConvolution::CONVOLUTION_GAUSSIAN();
//$convolution = Easy\StaticConvolution::CONVOLUTION_REENFORCEMENT();
//$convolution = Easy\StaticConvolution::CONVOLUTION_LAPLACIEN_1();
//$convolution = Easy\StaticConvolution::CONVOLUTION_LAPLACIEN_2();
//$convolution = Easy\StaticConvolution::CONVOLUTION_LAPLACIEN_3();
//$convolution = Easy\StaticConvolution::CONVOLUTION_GRADIENT_EW();
//$convolution = Easy\StaticConvolution::CONVOLUTION_GRADIENT_WE();
//$convolution = Easy\StaticConvolution::CONVOLUTION_GRADIENT_NS(4);
//$convolution = Easy\StaticConvolution::CONVOLUTION_GRADIENT_SN(4);
$convolution = Easy\StaticConvolution::CONVOLUTION_GRADIENT_NWSE(4);
//$convolution = Easy\StaticConvolution::CONVOLUTION_PRATT();
//$convolution = Easy\StaticConvolution::CONVOLUTION_4_CONNEX();
//$convolution = Easy\StaticConvolution::CONVOLUTION_8_CONNEX();


/*
 * 
 * Loading an image
 * 
 */

if (($image = Easy\Image::createFrom($filename)) === FALSE)
    throw new Exception('Error loading');

Easy\Filter::process($image, $convolution)
->show();


?>