<?php

/**
 * EasyGd - a PHP framework for use GD easier
 *
 * @author      Florent Brusciano
 * @copyright   2013 Florent Brusciano
 * @version     1.1.0
 * @package     Easy
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Easy;

/**
 * Easy
 * @package Easy
 * @author  Florent Brusciano
 * @since   1.0.0
 */
class Histogramme implements \SplObserver {

    private $histo = array(
	'red' => array(),
	'green' => array(),
	'blue' => array(),
	'alpha' => array()
    );
    private $max = array(
	'red' => 0,
	'green' => 0,
	'blue' => 0,
	'alpha' => 0
    );
    private $average = array(
	'red' => 0,
	'green' => 0,
	'blue' => 0,
	'alpha' => 0
    );
    private $sigma = array(
	'red' => 0,
	'green' => 0,
	'blue' => 0,
	'alpha' => 0
    );
    private $max_height = 256;

    public function __construct() {
	foreach ($this->histo as $k => &$v) {
	    $v = array_fill(0, 256, 0);
	}
    }

    public function computeSigma($pixels) {
	$var = array(
	    'red' => 0,
	    'green' => 0,
	    'blue' => 0,
	    'alpha' => 0
	);

	$div = floatval(1 / $pixels);
	foreach ($this->histo as $k => $v) {
	    $sum = 0;
	    $sum2 = 0;
	    for ($i = 0; $i < 255; $i++) {
		$sum += $v[$i] * $i;
		$sum2 += $v[$i] * $i * $i;
	    }
	    $this->average[$k] = round($sum * $div);
	    $var[$k] = $sum2 * $div - $sum * $div * $sum * $div;
	    $this->sigma[$k] = round(sqrt($var[$k]));
	}
    }

    public function save($path) {

	$dimension = Dimension::create($this->max_height, $this->max_height);
	$white = Color::White();
	$red = Color::Red();
	$green = Color::Green();
	$blue = Color::Blue();
	foreach ($this->histo as $k => $v) {
	    $ratio = $this->max_height / $this->max[$k];
	    $image = Image::create($dimension)->fill($white);

	    $p1 = Position::create(0, $this->max_height);
	    $p2 = Position::create(0, $this->max_height);

	    for ($i = 0; $i < 255; $i++) {

		$p1->setX($i);
		$p2->setX($i);
		$p2->setY($this->max_height - round($v[$i] * $ratio));

		$image->drawLine($p1, $p2, $$k);
	    }
	    $image->save($path .'/'. $k);
	}
    }

    public function update(\SplSubject $obj) {

	$x = $obj->getColumn();
	$y = $obj->getLine();
	$imageSrc = $obj->getImageSrc();


	$rgb = imagecolorat($imageSrc->getImg(), $x, $y);
	$r = ($rgb >> 16) & 0xFF;
	$g = ($rgb >> 8) & 0xFF;
	$b = $rgb & 0xFF;

	if ($r > 255)
	    $r = 255;
	if ($g > 255)
	    $g = 255;
	if ($b > 255)
	    $b = 255;

	if ($r < 0)
	    $r = 0;
	if ($g < 0)
	    $g = 0;
	if ($b < 0)
	    $b = 0;

	if ($r != 0)
	    $this->histo['red'][$r]++;
	if ($g != 0)
	    $this->histo['green'][$g]++;
	if ($b != 0)
	    $this->histo['blue'][$b]++;

	if ($this->histo['red'][$r] > $this->max['red'])
	    $this->max['red'] = $this->histo['red'][$r];

	if ($this->histo['green'][$g] > $this->max['green'])
	    $this->max['green'] = $this->histo['green'][$g];

	if ($this->histo['blue'][$b] > $this->max['blue'])
	    $this->max['blue'] = $this->histo['blue'][$b];

	unset($this->histo['alpha']);
	unset($this->max['alpha']);
    }

    public function getHisto() {
	return $this->histo;
    }

    public function getAverage() {
	return $this->average;
    }

    public function getSigma() {
	return $this->sigma;
    }

}

?>