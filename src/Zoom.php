<?php

/**
 * EasyGd - a PHP framework for use GD easier
 *
 * @author      Florent Brusciano
 * @copyright   2013 Florent Brusciano
 * @version     1.1.0
 * @package     Easy
 *
 *  MIT LICENSE
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
class Zoom implements \SplObserver {

    private $mult;
    private $position;

    public function __construct($mult = 2, Position $position = NULL) {
	$this->position = $position;
	$this->mult = $mult;
    }

    public function update(\SplSubject $obj) {

	$j = $obj->getColumn();
	$i = $obj->getLine();
	$imageSrc = $obj->getImageSrc();
	$imageDest = $obj->getImageDest(__CLASS__);
	$position = (is_null($this->position)) ? $imageSrc->MIDDLE_MIDDLE : $this->position;

	$y2 = $i - round($imageSrc->IMG_HEIGHT/2);
	$y1 = $y2 / $this->mult;
	$y = $y1 + $position->getY();

	$x2 = $j - round($imageSrc->IMG_WIDTH/2);
	$x1 = $x2 / $this->mult;
	$x = $x1 + $position->getX();

	$ir = round($y + 0.5);
	$jr = round($x + 0.5);

	$rgb = imagecolorat($imageSrc->getImg(), $jr, $ir);

	imagesetpixel($imageDest->getImg(), $j, $i, $rgb);
    }

}

?>