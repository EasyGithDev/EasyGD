<?php

require 'autoload.php';

$filename = 'http://static.zend.com/topics/ZF2-for-ZF-site-logo-01-B-350.png';

/*
 * 
 * How to have the histogramme
 * 
 */
if(($image = Easy\Image::createfrom($filename)) === FALSE)
    throw new Exception('Unable to load ' . $filename);

$histo = Easy\Histogramme::create($image)->process();

echo '<pre>',  print_r($histo->getHisto(), 1),'</pre>';
echo '<pre>',  print_r($histo->getAverage(), 1),'</pre>';
echo '<pre>',  print_r($histo->getSigma(), 1),'</pre>';


$histo->save();

?>