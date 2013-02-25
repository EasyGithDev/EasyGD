<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date dans le passé
require '../autoload.php';

$filename = str_replace('jpeg', 'jpg', urldecode($_GET['filename']));
$path = '/Users/florent/Pictures/Florent portable/' . $filename;
/*
  <div style="text-align: center">
  <img src="<?php echo Easy\Image::getDataSource($path); ?>" style="max-width: 500px" />
  </div>
 * 
 */
$action = $_GET['action'];
$fileSrc = $_GET['filesrc'];
switch ($action) {

    case 'info' :
	echo json_encode(Easy\Image::getInfos($fileSrc));
	break;
    case 'convolution' :
	$convolution = $_GET['convolution'];
	$imgSrc = Easy\Image::createFrom($fileSrc);
	$convolution = \Easy\Convolution::$convolution();
	Easy\Filter::create($convolution)->process($imgSrc)->show();
	break;
    case 'filter' :
	$smooth = isset($_GET['smooth']) ? $_GET['smooth'] : '';
	$contrast = isset($_GET['contrast']) ? $_GET['contrast'] : '';
	$brightness = isset($_GET['brightness']) ? $_GET['brightness'] : '';

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
	    default :
		$filter = \Easy\Filter::$filter();
		break;
	}


	$filter->process($imgSrc)->show();

//$blockSize = 3;
//$type = true;
//Easy\Filter::FILTER_PIXELATE($blockSize, $type)->process($image)->show();

//$color = \Easy\Color::Purple();
//Easy\Filter::FILTER_COLORIZE($color)->process($image)->show();
	break;
    default :
	break;
}
?>