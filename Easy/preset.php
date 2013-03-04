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
class Preset implements Filter {

    protected $filterType;
    protected $paramArr;

    public function __construct() {
	$this->paramArr = array();
    }

    public static function create() {
	return new self();
    }

    public function process(Image $imgSrc) {

	$paramArr[] = $imgSrc->getImg();
	$paramArr[] = $this->filterType;

	$paramArr = array_merge($paramArr, $this->paramArr);

	call_user_func_array('imagefilter', $paramArr);

	return $imgSrc;
    }

    public static function FILTER_NEGATE() {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_NEGATE;
	return $filter;
    }

    public static function FILTER_GRAYSCALE() {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_GRAYSCALE;
	return $filter;
    }

    public static function FILTER_EDGEDETECT() {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_EDGEDETECT;
	return $filter;
    }

    public static function FILTER_EMBOSS() {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_EMBOSS;
	return $filter;
    }

    public static function FILTER_GAUSSIAN_BLUR() {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_GAUSSIAN_BLUR;
	return $filter;
    }

    public static function FILTER_SELECTIVE_BLUR() {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_SELECTIVE_BLUR;
	return $filter;
    }

    public static function FILTER_MEAN_REMOVAL() {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_MEAN_REMOVAL;
	return $filter;
    }

    public static function FILTER_PIXELATE($blockSize, $type = FALSE) {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_PIXELATE;
	$filter->paramArr[] = $blockSize;
	$filter->paramArr[] = $type;
	return $filter;
    }

    /**
     * 
     * @param type $smooth, IMG_FILTER_SMOOTH, -8/+8
     * @return type
     */
    public static function FILTER_SMOOTH($smooth) {
	$filter = self::create();
	$filter->filterType = IMG_FILTER_SMOOTH;
	$filter->paramArr[] = $smooth;
	return $filter;
    }

    /**
     * 
     * @param type $BRIGHTNESS, -255 = min brightness, 0 = no change, +255 = max brightness
     * @return type
     */
    public static function FILTER_BRIGHTNESS($brightness) {
	if ($brightness < -255 OR $brightness > 255)
	    $brightness = 0;
	$filter = self::create();
	$filter->filterType = IMG_FILTER_BRIGHTNESS;
	$filter->paramArr[] = $brightness;
	return $filter;
    }

    /**
     * 
     * @param type $contrast,  
     * -100 = max contrast, 0 = no change, +100 = min contrast (note the direction!)
     * @return type
     */
    public static function FILTER_CONTRAST($contrast) {
	if ($contrast < -100 OR $contrast > 100)
	    $contrast = 0;
	$filter = self::create();
	$filter->filterType = IMG_FILTER_CONTRAST;
	$filter->paramArr[] = $contrast;
	return $filter;
    }

    /**
     * 
     * @param type $colorize,     IMG_FILTER_COLORIZE, -127.12, -127.98, 127
     * @return type
     */
    public static function FILTER_COLORIZE($red, $green, $blue) {

	if ($red < -255 OR $red > 255)
	    $red = 0;
	if ($green < -255 OR $blue > 255)
	    $green = 0;
	if ($blue < -255 OR $blue > 255)
	    $blue = 0;

	$filter = self::create();
	$filter->filterType = IMG_FILTER_COLORIZE;
	$filter->paramArr[] = $red;
	$filter->paramArr[] = $green;
	$filter->paramArr[] = $blue;
	return $filter;
    }

}

?>