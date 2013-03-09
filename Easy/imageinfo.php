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
class ImageInfo {

    protected $filename;
    protected $width;
    protected $height;
    protected $type;
    protected $img;
    protected $mime;
    protected $channels;
    protected $bits;
    protected $iptc;

    public function __construct($filename) {

	if (($infos = getimagesize($filename, $additional)) === FALSE)
	    return FALSE;

	$this->filename = $filename;
	$this->width = $infos[0];
	$this->height = $infos[1];
	$this->type = $infos[2];
	$this->img = $infos[3];
	$this->mime = $infos['mime'];
	$this->channels = $infos['channels'];
	$this->bits = $infos['bits'];
	$this->iptc = (isset($additional["APP13"])) ? Iptc::create($additional["APP13"]) : Iptc::create();
    }

    public static function create($filename) {
	return new self($filename);
    }

    public function __toString() {
	return "
	filename : $this->filename 
	width : $this->width 
	height : $this->height 
	type : $this->type 
	img : $this->img 
	mime : $this->mime 
	channels : $this->channels 
	bits : $this->bits 
	$this->iptc ";
    }

    public function toArray() {

	$array = array();

	$array['filename'] = $this->filename;
	$array['width'] = $this->width;
	$array['height'] = $this->height;
	$array['type'] = $this->type;
	$array['img'] = $this->img;
	$array['mime'] = $this->mime;
	$array['channels'] = $this->channels;
	$array['bits'] = $this->bits;

	if (!is_null($this->iptc))
	    $array = array_merge($array, $this->iptc->toArray());

	return $array;
    }

    public function getFilename() {
	return $this->filename;
    }

    public function getWidth() {
	return $this->width;
    }

    public function getHeight() {
	return $this->height;
    }

    public function getType() {
	return $this->type;
    }

    public function getImg() {
	return $this->img;
    }

    public function getMime() {
	return $this->mime;
    }

    public function getChannels() {
	return $this->channels;
    }

    public function getBits() {
	return $this->bits;
    }

    public function getIpct() {
	return $this->iptc;
    }

}

?>