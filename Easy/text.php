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
class Text {

    const TEXT_DRAW_HORIZONTAL = 1;
    const TEXT_DRAW_VERTICAL = 2;
    const TEXT_FONT_DEFAULT = 1;
    const TEXT_FONT_TRUETYPE = 2;
    const TEXT_FONT_FREETYPE = 3;
    const TEXT_MACOS_FONT_PATH = '/Library/Fonts';
    const TEXT_WINDOWS_FONT_PATH = 'C:\\Windows\\fonts';
    const TEXT_UNIX_FONT_PATH = '/usr/share/fonts';

    protected $text;
    protected $color;
    protected $position;
    protected $size;
    protected $drawtype;
    protected $fonttype;
    protected $fontfile;

    public function __construct($text, $size = 1, Position $position = NULL, Color $color = NULL) {
	if (!is_int($size))
	    throw new Exception('Size must be integer');
	$this->text = $text;
	$this->size = $size;
	$this->position = ($position == NULL) ? Position::create() : $position;
	$this->color = ($color == NULL) ? Color::Black() : $color;
	$this->drawtype = self::TEXT_DRAW_HORIZONTAL;
	$this->fonttype = self::TEXT_FONT_DEFAULT;
    }

    public static function create($text) {
	return new self($text);
    }

    public static function getFontList($fontDir) {
	$list = array();
	foreach (new \DirectoryIterator($fontDir) as $file) {
	    if (preg_match('/\.ttf$/', $file->getFilename())) {
		$list[] = $file->getFilename();
	    }
	}
	return $list;
    }

    public function getText() {
	return $this->text;
    }

    public function setText($text) {
	$this->text = $text;
	return $this;
    }

    public function getColor() {
	return $this->color;
    }

    public function setColor(Color $color) {
	$this->color = $color;
	return $this;
    }

    public function getPosition() {
	return $this->position;
    }

    public function setPosition(Position $position) {
	$this->position = $position;
	return $this;
    }

    public function getSize() {
	return $this->size;
    }

    public function setSize($size) {
	if (!is_int($size))
	    throw new Exception('Size must be integer');
	$this->size = $size;
	return $this;
    }

    public function getDrawtype() {
	return $this->drawtype;
    }

    public function setDrawtype($drawtype) {
	$this->drawtype = $drawtype;
	return $this;
    }

    public function getFonttype() {
	return $this->fonttype;
    }

    public function setFonttype($fonttype) {
	$this->fonttype = $fonttype;
	return $this;
    }

    public function getFontfile() {
	return $this->fontfile;
    }

    public function setFontfile($fontfile) {
	imageloadfont($fontfile);
	$this->fontfile = $fontfile;
	return $this;
    }

}

?>