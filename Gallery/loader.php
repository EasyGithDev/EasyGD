<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date dans le passé

require 'conf.php';

$action = $_GET['action'];
$fileSrc = $_GET['filesrc'];
switch ($action) {

    case 'info' :
	$imageInfo = Easy\Image::getInfos($fileSrc);
	echo json_encode($imageInfo->toArray());
	break;
    case 'convolution' :
	$convolution = $_GET['convolution'];
	$imgSrc = Easy\Image::createFrom($fileSrc);
	$convolution = \Easy\Convolution::$convolution();
	Easy\Filter::create($convolution)->process($imgSrc)->show();
	break;
    case 'convolution_custom':
	$divisor = $_GET['divisor'];
	$offset = $_GET['offset'];
	$matrix = json_decode($_GET['matrix']);
	$imgSrc = Easy\Image::createFrom($fileSrc);
	$convolution = \Easy\Convolution::create($matrix);
	$convolution->setDivisor($divisor)->setOffset($offset);
	\Easy\Filter::create($convolution)->process($imgSrc)->show();
	break;
    case 'convolution_info' :
	$convolution = $_GET['convolution'];
	$convolution = \Easy\Convolution::$convolution();
	$json = array(
	    'matrix' => $convolution->getMatrix(),
	    'divisor' => $convolution->getDivisor(),
	    'offset' => $convolution->getOffset(),
	);
	echo json_encode($json);
	break;
    case 'histogramme' :
	/**
	 * trop long

	  set_time_limit(0);
	  $histogramme = new Easy\Histogramme();
	  $imgSrc = Easy\Image::createFrom($fileSrc);
	  $runer = Easy\RunThrough::create($imgSrc);
	  $runer->attach($histogramme);
	  $runer->process();
	  $histogramme->computeSigma($imgSrc->getWidth() * $imgSrc->getHeight());
	  $histogramme->save(THUMB_HISTO);

	 * 
	 */
	break;
    case 'filter' :
	$smooth = isset($_GET['smooth']) ? $_GET['smooth'] : 0;
	$contrast = isset($_GET['contrast']) ? $_GET['contrast'] : 0;
	$brightness = isset($_GET['brightness']) ? $_GET['brightness'] : 0;
	$blocksize = isset($_GET['blocksize']) ? $_GET['blocksize'] : 0;
	$red = isset($_GET['red']) ? $_GET['red'] : 0;
	$green = isset($_GET['green']) ? $_GET['green'] : 0;
	$blue = isset($_GET['blue']) ? $_GET['blue'] : 0;

	$filter = 'FILTER_' . strtoupper($_GET['filter']);
	$imgSrc = Easy\Image::createFrom($fileSrc);

	switch ($filter) {
	    case 'FILTER_SMOOTH':
		$filter = \Easy\Filter::$filter($smooth);
		break;
	    case 'FILTER_CONTRAST':
		$filter = \Easy\Filter::$filter($contrast);
		break;
	    case 'FILTER_BRIGHTNESS':
		$filter = \Easy\Filter::$filter($brightness);
		break;
	    case 'FILTER_PIXELATE':
		$type = true;
		$filter = Easy\Filter::$filter($blocksize, $type);
		break;
	    case 'FILTER_COLORIZE':
		$filter = Easy\Filter::$filter($red, $green, $blue);
		break;
	    default :
		$filter = \Easy\Filter::$filter();
		break;
	}

	$filter->process($imgSrc)->show();

	break;
    default :
	break;
}
?>