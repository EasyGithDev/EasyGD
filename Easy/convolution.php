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

    public static $CONVOLUTION_IDENTITY = array(
	0, 0, 0,
	0, 1, 0,
	0, 0, 0
    );
    public static $CONVOLUTION_SHARPEN_1 = array(
	0, -1, 0,
	-1, 5, -1,
	0, -1, 0
    );
    public static $CONVOLUTION_SHARPEN_2 = array(
	-1, -1, -1,
	-1, 9, -1,
	-1, -1, -1
    );
    public static $CONVOLUTION_DETECTION_EDGES = array(
	0, 1, 0,
	1, -4, 1,
	0, 1, 0
    );
    public static $CONVOLUTION_FIND_EDGES_1 = array(
	-1, -1, -1,
	-2, 8, -1,
	-1, -1, -1
    );
    public static $CONVOLUTION_FIND_EDGES_2 = array(
	0, 1, 0,
	1, -4, 1,
	0, 1, 0
    );
    public static $CONVOLUTION_FIND_EDGES_3 = array(
	1, -2, 1,
	-2, 4, -2,
	1, -2, 1
    );
    public static $CONVOLUTION_BLUR = array(
	1, 1, 1,
	1, 1, 1,
	1, 1, 1
    );
    public static $CONVOLUTION_GAUSSIAN = array(
	1, 2, 1,
	2, 4, 2,
	1, 2, 1
    );
// Repoussage
    public static $CONVOLUTION_EMBOSS = array(
	-2, -1, 0,
	-1, 1, 1,
	0, 1, 2
    );
// Renforcement des bords
// Edge Enhancement 
    public static $CONVOLUTION_ENHANCEMENT_EDGES_1 = array(
	0, 0, 0,
	-1, 1, 0,
	0, 0, 0
    );
    public static $CONVOLUTION_ENHANCEMENT_EDGES_2 = array(
	0, -1, 0,
	0, 1, 0,
	0, 0, 0
    );
    public static $CONVOLUTION_ENHANCEMENT_EDGES_3 = array(
	-1, 0, 0,
	0, 1, 0,
	0, 0, 0
    );
// Laplacien 1
    public static $CONVOLUTION_LAPLACIEN_1 = array(
	0, -1, 0,
	-1, 4, -1,
	0, -1, 0
    );
// Laplacien 2
    public static $CONVOLUTION_LAPLACIEN_2 = array(
	-1, -1, -1,
	-1, 8, -1,
	-1, -1, -1
    );
// Laplacien 3
    public static $CONVOLUTION_LAPLACIEN_3 = array(
	1, -2, 1,
	-2, 4, -2,
	1, -2, 1
    );
//Gradient 3x3 4-connex 
    public static $CONVOLUTION_4_CONNEX = array(
	0., -1, 0,
	-1, 4, -1,
	0, -1, 0);
//Gradient 3x3 8-connex 
    public static $CONVOLUTION_8_CONNEX = array(
	-1, -1, -1,
	-1, 8, -1,
	-1, -1, -1);
// EW
    public static $CONVOLUTION_GRADIENT_EW = array(
	1, 0, -1,
	1, 0, -1,
	1, 0, -1
    );
//WE
    public static $CONVOLUTION_GRADIENT_WE = array(
	-1, 0, 1,
	-1, 0, 1,
	-1, 0, 1
    );
// NS
    public static $CONVOLUTION_GRADIENT_NS = array(
	-1, -1, -1,
	0, 0, 0,
	1, 1, 1
    );
// SN
    public static $CONVOLUTION_GRADIENT_SN = array(
	1, 1, 1,
	0, 0, 0,
	-1, -1, -1
    );
// NW-SE
    public static $CONVOLUTION_GRADIENT_NWSE = array(
	-1, -1, 0,
	-1, 0, 1,
	0, 1, 1
    );
// Pratt Filter
    public static $CONVOLUTION_PRATT = array(
	-1, -1, -1,
	-1, 17, -1,
	-1, -1, -1
    );
    private $matrix;
    private $offset;
    private $divisor;

    public function __construct($matrix = array(), $divisor = 1.0, $offset = 0.0) {
	if (!count($matrix))
	    $matrix = self::$CONVOLUTION_IDENTITY;
	$this->setMatrix($matrix);
	$this->offset = floatval($offset);
	$this->divisor = floatval($divisor);
    }

    public static function create($matrix) {
	$obj = new self($matrix);
	$divisor = floatval(array_sum(array_map('array_sum', $obj->getMatrix())));
	if ($divisor != 0)
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

	if ($divisor == 0)
	    throw new \Exception('oups');
	$this->divisor = floatval($divisor);
	return $this;
    }

    public static function getConvolutionList() {
	$reflection = new \ReflectionClass(new self);
	$staticProperties = $reflection->getStaticProperties();
	return array_keys($staticProperties);
    }

    public static function CONVOLUTION_IDENTITY() {
	return Convolution::create(self::$CONVOLUTION_IDENTITY);
    }

// Contraste (Sharpen)
    public static function CONVOLUTION_SHARPEN_1() {
	return Convolution::create(self::$CONVOLUTION_SHARPEN_1);
    }

    public static function CONVOLUTION_SHARPEN_2() {
	return Convolution::create(self::$CONVOLUTION_SHARPEN_2);
    }

// Border detection (Edge)
    public static function CONVOLUTION_DETECTION_EDGES() {
	return Convolution::create(self::$CONVOLUTION_DETECTION_EDGES);
    }

    public static function CONVOLUTION_FIND_EDGES_1() {
	return Convolution::create(self::$CONVOLUTION_FIND_EDGES_1);
    }

    public static function CONVOLUTION_FIND_EDGES_2() {
	return Convolution::create(self::$CONVOLUTION_FIND_EDGES_2);
    }

    public static function CONVOLUTION_FIND_EDGES_3() {
	return Convolution::create(self::$CONVOLUTION_FIND_EDGES_3);
    }

// Median Blur
    public static function CONVOLUTION_BLUR() {
	return Convolution::create(self::$CONVOLUTION_BLUR);
    }

// Gaussian Blur
    public static function CONVOLUTION_GAUSSIAN() {
	return Convolution::create(self::$CONVOLUTION_GAUSSIAN);
    }

    public static function CONVOLUTION_EMBOSS() {
	return Convolution::create(self::$CONVOLUTION_EMBOSS);
    }

    public static function CONVOLUTION_ENHANCEMENT_EDGES_1() {
	return Convolution::create(self::$CONVOLUTION_ENHANCEMENT_EDGES_1);
    }

    public static function CONVOLUTION_ENHANCEMENT_EDGES_2() {
	return Convolution::create(self::$CONVOLUTION_ENHANCEMENT_EDGES_2);
    }

    public static function CONVOLUTION_ENHANCEMENT_EDGES_3() {
	return Convolution::create(self::$CONVOLUTION_ENHANCEMENT_EDGES_3);
    }

    public static function CONVOLUTION_LAPLACIEN_1($alpha = 2) {

	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_LAPLACIEN_1[$i] * $alpha;

	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(4)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_LAPLACIEN_2($alpha = 2) {
	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_LAPLACIEN_2[$i] * $alpha;

	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(4)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_LAPLACIEN_3($alpha = 2) {
	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_LAPLACIEN_3[$i] * $alpha;

	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(4)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_GRADIENT_EW($alpha = 2) {
	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_GRADIENT_EW[$i] * $alpha;
	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(6)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_GRADIENT_WE($alpha = 2) {
	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_GRADIENT_WE[$i] * $alpha;
	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(6)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_GRADIENT_NS($alpha = 2) {
	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_GRADIENT_NS[$i] * $alpha;
	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(6)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_GRADIENT_SN($alpha = 2) {
	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_GRADIENT_SN[$i] * $alpha;
	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(6)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_GRADIENT_NWSE($alpha = 2) {
	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_GRADIENT_NWSE[$i] * $alpha;
	$convolution = Convolution::create($matrix);
	$convolution->setDivisor((4 * sqrt(2) / 3) * 3)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_4_CONNEX($alpha = 10) {
	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_4_CONNEX[$i] * $alpha;
	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(4)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_8_CONNEX($alpha = 10) {

	$matrix = array();
	for ($i = 0; $i < 9; $i++)
	    $matrix[$i] = self::$CONVOLUTION_8_CONNEX[$i] * $alpha;
	$convolution = Convolution::create($matrix);
	$convolution->setDivisor(9.657)->setOffset(128);
	return $convolution;
    }

    public static function CONVOLUTION_PRATT() {
	$convolution = Convolution::create(self::$CONVOLUTION_PRATT);
	$convolution->setDivisor(9);
	return $convolution;
    }

}

?>