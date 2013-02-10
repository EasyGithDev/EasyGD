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
class TrueType extends Text {

    protected $angle;

    public function __construct($text, $fontfile) {
        if (!file_exists($fontfile))
            throw new Exception('Unable to find the fontfile ' . $fontfile);
        
        parent::__construct($text, 8);
        $this->fontfile = $fontfile;
        $this->fonttype = self::TEXT_FONT_TRUETYPE;
        $this->angle = 0;
    }

    public static function create($text, $fontfile) {
        return new self($text, $fontfile);
    }

    public function setFontfile($fontfile) {
        $this->fontfile = $fontfile;
        return $this;
    }

    public function getAngle() {
        return $this->angle;
    }

    public function setAngle($angle) {
        $this->angle = $angle;
        return $this;
    }

}

?>