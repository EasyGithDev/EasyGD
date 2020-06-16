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
class Preset extends Filter {

    protected $presetName;
    protected $paramArr;

    public function __construct() {
	$this->paramArr = array();
	$this->presetName = NULL;
    }

    public static function create() {

	$numargs = func_num_args();

	if ($numargs == 0) {
	    return new self();
	} else if ($numargs == 1) {
	    $presetFunction = func_get_arg(0);
	    return self::$presetFunction();
	} else if ($numargs > 1) {
	    $arg_list = func_get_args();
	    $presetFunction = array_shift($arg_list);
	    return call_user_func_array(array(__CLASS__, $presetFunction), $arg_list);
	}
    }

    public function getPresetName() {
	return $this->presetName;
    }

    public function setPresetName($presetName) {
	$this->presetName = $presetName;
    }

    public function getParamArr() {
	return $this->paramArr;
    }

    public function setParamArr($paramArr) {
	$this->paramArr = $paramArr;
	return $this;
    }

    public function process(Image $imgSrc) {

	if (is_null($this->presetName))
	    throw new Exception('Filter name dont be NULL');

	$paramArr[] = $imgSrc->getImg();
	$paramArr[] = $this->presetName;

	$paramArr = array_merge($paramArr, $this->paramArr);

	call_user_func_array('imagefilter', $paramArr);

	return $imgSrc;
    }

    public static function PRESET_NEGATE() {
	$filter = new self();
	$filter->presetName = IMG_FILTER_NEGATE;
	return $filter;
    }

    public static function PRESET_GRAYSCALE() {
	$filter = new self();
	$filter->presetName = IMG_FILTER_GRAYSCALE;
	return $filter;
    }

    public static function PRESET_EDGEDETECT() {
	$filter = new self();
	$filter->presetName = IMG_FILTER_EDGEDETECT;
	return $filter;
    }

    public static function PRESET_EMBOSS() {
	$filter = new self();
	$filter->presetName = IMG_FILTER_EMBOSS;
	return $filter;
    }

    public static function PRESET_GAUSSIAN_BLUR() {
	$filter = new self();
	$filter->presetName = IMG_FILTER_GAUSSIAN_BLUR;
	return $filter;
    }

    public static function PRESET_SELECTIVE_BLUR() {
	$filter = new self();
	$filter->presetName = IMG_FILTER_SELECTIVE_BLUR;
	return $filter;
    }

    public static function PRESET_MEAN_REMOVAL() {
	$filter = new self();
	$filter->presetName = IMG_FILTER_MEAN_REMOVAL;
	return $filter;
    }

    public static function PRESET_PIXELATE($blockSize, $type = FALSE) {
	$filter = new self();
	$filter->presetName = IMG_FILTER_PIXELATE;
	$filter->paramArr[] = $blockSize;
	$filter->paramArr[] = $type;
	return $filter;
    }

    /**
     * 
     * @param type $smooth, IMG_FILTER_SMOOTH, -8/+8
     * @return type
     */
    public static function PRESET_SMOOTH($smooth) {
	$filter = new self();
	$filter->presetName = IMG_FILTER_SMOOTH;
	$filter->paramArr[] = $smooth;
	return $filter;
    }

    /**
     * 
     * @param type $BRIGHTNESS, -255 = min brightness, 0 = no change, +255 = max brightness
     * @return type
     */
    public static function PRESET_BRIGHTNESS($brightness) {
	if ($brightness < -255 OR $brightness > 255)
	    $brightness = 0;
	$filter = new self();
	$filter->presetName = IMG_FILTER_BRIGHTNESS;
	$filter->paramArr[] = $brightness;
	return $filter;
    }

    /**
     * 
     * @param type $contrast,  
     * -100 = max contrast, 0 = no change, +100 = min contrast (note the direction!)
     * @return type
     */
    public static function PRESET_CONTRAST($contrast) {
	if ($contrast < -100 OR $contrast > 100)
	    $contrast = 0;
	$filter = new self();
	$filter->presetName = IMG_FILTER_CONTRAST;
	$filter->paramArr[] = $contrast;
	return $filter;
    }

    /**
     * 
     * @param type $colorize,     IMG_FILTER_COLORIZE, -127.12, -127.98, 127
     * @return type
     */
    public static function PRESET_COLORIZE($red, $green, $blue) {

	if ($red < -255 OR $red > 255)
	    $red = 0;
	if ($green < -255 OR $blue > 255)
	    $green = 0;
	if ($blue < -255 OR $blue > 255)
	    $blue = 0;

	$filter = new self();
	$filter->presetName = IMG_FILTER_COLORIZE;
	$filter->paramArr[] = $red;
	$filter->paramArr[] = $green;
	$filter->paramArr[] = $blue;
	return $filter;
    }

}

?>