<?php

set_time_limit(0);

$time_start = microtime(true);
require 'autoload.php';

$filename = 'http://static.zend.com/topics/ZF2-for-ZF-site-logo-01-B-350.png';
$filename = 'http://xgarreau.org/aide/devel/gd/tux.jpg';

//$filename = 'grayscaleaverage.png';

if (($image = Easy\Image::createfrom($filename)) === FALSE)
    throw new Exception('Unable to load ' . $filename);

//$progress = new Easy\Progress();
//$histogramme = new Easy\Histogramme();

$thresholding = new Easy\Thresholding(128);
$negative = new Easy\Negative();
$grayscaleluminosity = new \Easy\GrayscaleLuminosity();
$grayscalelightness = new \Easy\GrayscaleLightness();
$grayscaleaverage = new \Easy\GrayscaleAverage();
//$floydsteinbergdithering = new \Easy\FloydSteinbergDithering();

$runer = Easy\RunThrough::create($image);
//$runer->attach($progress);
//$runer->attach($histogramme);
$runer->attach($negative);
$runer->attach($thresholding);
$runer->attach($negative);
$runer->attach($grayscalelightness);
$runer->attach($grayscaleluminosity);
$runer->attach($grayscaleaverage);
$runer->process();

//$runer->getImageDest()->save('tux');

$out = pathinfo($filename, PATHINFO_FILENAME);

foreach ($runer->getImageDest() as $k => $v) {
    $tab = explode('\\', $k);
    $v->save($out . '-' . strtolower($tab[1]));
}

//$runer->getImageDest()->show();


$time_end = microtime(true);
$time = $time_end - $time_start;

echo 'Exécution en ', $time, ' secondes';

//$histogramme->computeSigma($image->getWidth() * $image->getHeight());
//echo '<pre>', print_r($histogramme->getHisto(), 1), '</pre>';
//echo '<pre>', print_r($histogramme->getAverage(), 1), '</pre>';
//echo '<pre>', print_r($histogramme->getSigma(), 1), '</pre>';
//$histogramme->save();
?>