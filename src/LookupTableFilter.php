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

namespace Easygd;

/**
 * Easy
 * @package Easy
 * @author  Florent Brusciano
 * @since   1.0.0
 */
class LookUpTableFilter extends Filter
{

	protected $lut;

	public function create($lut)
	{
		$this->lut = $lut;
		return $this;
	}

	public function process(Image $imgSrc)
	{
		$im = $imgSrc->getImg();

		if (imageistruecolor($im)) {
			imagetruecolortopalette($im, false, 256);
		}

		for ($i = 0; $i < imagecolorstotal($im); $i++) {
			$rgb = imagecolorsforindex($im, $i);
			$color = call_user_func($this->lut->getCallbackFunction(), $rgb);
			imagecolorset($im, $i, $color[0], $color[1], $color[2]);
		}

		return $imgSrc;
	}
}
