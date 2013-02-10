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
class Position {
    const POSITION_TOP_LEFT = 1;
    const POSITION_TOP_MIDDLE = 2;
    const POSITION_TOP_RIGHT = 3;

    const POSITION_MIDDLE_LEFT = 4;
    const POSITION_MIDDLE_MIDDLE = 5;
    const POSITION_MIDDLE_RIGHT = 6;

    const POSITION_BOTTOM_LEFT = 7;
    const POSITION_BOTTOM_MIDDLE = 8;
    const POSITION_BOTTOM_RIGHT = 9;

    protected $x;
    protected $y;

    public function __construct($x = 0, $y = 0) {
        if (!is_int($x) OR !is_int($y))
            throw new Exception('X and Y must be integer');
        $this->x = $x;
        $this->y = $y;
    }

    public static function create($x = 0, $y = 0) {
        return new self($x, $y);
    }

    public function getX() {
        return $this->x;
    }

    public function setX($x) {
        $this->x = $x;
    }

    public function getY() {
        return $this->y;
    }

    public function setY($y) {
        $this->y = $y;
    }

}

?>