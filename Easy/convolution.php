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
class Convolution {

    private $matrix;
    private $offset;
    private $divisor;

    public function __construct($matrix = array(), $divisor = 1.0, $offset = 0.0) {

        $this->setMatrix($matrix);
        $this->offset = floatval($offset);
        $this->divisor = floatval($divisor);
    }

    public static function create($matrix) {
        $obj = new self($matrix);
        $divisor = floatval(array_sum(array_map('array_sum', $obj->getMatrix())));
        $obj->setDivisor($divisor);
        return $obj;
    }

    public function getMatrix() {
        return $this->matrix;
    }

    public function setMatrix($matrix) {
        if (count($matrix) == 9) {

            $matrix = array_map('floatval', $matrix);

            $this->matrix = array(
                array($matrix[0], $matrix[1], $matrix[2]),
                array($matrix[3], $matrix[4], $matrix[5]),
                array($matrix[6], $matrix[7], $matrix[8])
            );
        } else if (count($matrix) == 3) {
            for ($i = 0; $i < 3; $i++)
                $matrix = array_map('floatval', $matrix[$i]);
            $this->matrix = $matrix;
        }
        else
            throw new Exception('Matrix must be 3x3');
        return $this;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function setOffset($offset) {
        $this->offset = floatval($offset);
        return $this;
    }

    public function getDivisor() {
        return $this->divisor;
    }

    public function setDivisor($divisor) {
        $this->divisor = floatval($divisor);
        return $this;
    }

}

?>