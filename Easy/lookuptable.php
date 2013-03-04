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
class LookUpTable implements Filter {

    private $function;

    public function __construct($function) {
	$this->function = $function;
    }

    public function process(Image $imgSrc) {

	$im = $imgSrc->getImg();

	if (imageistruecolor($im)) {
	    imagetruecolortopalette($im, false, 256);
	}

	for ($i = 0; $i < imagecolorstotal($im); $i++) {
	    $rgb = imagecolorsforindex($im, $i);
	    $color = call_user_func_array(array(__CLASS__, $this->function), array($rgb));
	    imagecolorset($im, $i, $color[0], $color[1], $color[2]);
	}

	return $imgSrc;
    }

    private function LightnessGray($rgb) {
	//(max(R, G, B) + min(R, G, B)) / 2.
	$max = max(array_values($rgb));
	$min = min(array_values($rgb));
	$gray = round(($max + $min) / 2);
	return array($gray, $gray, $gray);
    }

    private function AverageGray($rgb) {
	//(R + G + B) / 3
	$gray = round(($rgb['red'] + $rgb['green'] + $rgb['blue']) / 3);

	return array($gray, $gray, $gray);
    }

    private function LuminosityGray($rgb) {
	//0.21 R + 0.71 G + 0.07 B.
	$gray = round(0.299 * $rgb['red'] + 0.587 * $rgb['green'] + 0.114 * $rgb['blue']);
	return array($gray, $gray, $gray);
    }

    private function Thresholding($rgb) {
	//0.21 R + 0.71 G + 0.07 B.
	$r = ($rgb['red'] > 128) ? 255 : 0;
	$g = ($rgb['green'] > 128) ? 255 : 0;
	$b = ($rgb['blue'] > 128) ? 255 : 0;
	return array($r, $g, $b);
    }

    private function Negative($rgb) {
	//0.21 R + 0.71 G + 0.07 B.
	$r = 255 - $rgb['red'];
	$g = 255 - $rgb['green'];
	$b = 255 - $rgb['blue'];
	return array($r, $g, $b);
    }

    private function Special($rgb) {
	$r = ($rgb['red'] > 128) ? max($rgb['green'], $rgb['blue']) : min($rgb['green'], $rgb['blue']);
	$g = ($rgb['green'] > 128) ? max($rgb['red'], $rgb['blue']) : min($rgb['red'], $rgb['blue']);
	$b = ($rgb['blue'] > 128) ? max($rgb['green'], $rgb['red']) : min($rgb['green'], $rgb['red']);
	return array($r, $g, $b);
    }

}

?>