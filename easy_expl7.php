<?php

set_time_limit(0);

require 'autoload.php';

$filename = 'http://static.zend.com/topics/ZF2-for-ZF-site-logo-01-B-350.png';

if (($image = Easy\Image::createfrom($filename)) === FALSE)
    throw new Exception('Unable to load ' . $filename);

$progress = new Easy\Progress();
$thresholding = new Easy\Thresholding(128);
$negative = new Easy\Negative();
$histogramme = new Easy\Histogramme();

$runer = Easy\RunThrough::create($image);
$runer->attach($progress);
$runer->attach($histogramme);
$runer->attach($negative);
$runer->process();

$runer->getImageDest()->show();

//$histogramme->computeSigma();

//echo '<pre>',  print_r($histo->getHisto(), 1),'</pre>';
//echo '<pre>',  print_r($histo->getAverage(), 1),'</pre>';
//echo '<pre>',  print_r($histo->getSigma(), 1),'</pre>';

//$histogramme->save();

?>