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
class RunThrough implements \SplSubject {

    private $imageSrc;
    private $imageDest;
    protected $line;
    protected $column;
// Ceci est le tableau qui va contenir tous les objets qui nous observent.
    protected $observers = array();

    public function __construct(Image $image) {
	$this->imageSrc = $image;
	$this->imageDest = Image::create($image->getDimension())
		->setImageType($image->getImagetype());
	$this->info = 0;
    }

    public static function create(Image $image) {
	return new self($image);
    }

    public function process() {

	for ($this->line = 0; $this->line < $this->imageSrc->getHeight(); $this->line++) {
	    for ($this->column = 0; $this->column < $this->imageSrc->getWidth(); $this->column++) {
		$this->notify();
	    }
	}
    }

    public function attach(\SplObserver $observer) {
	$this->observers[] = $observer;
    }

    public function detach(\SplObserver $observer) {
	if (is_int($key = array_search($observer, $this->observers, true))) {
	    unset($this->observers[$key]);
	}
    }

    public function notify() {
	foreach ($this->observers as $observer) {
	    $observer->update($this);
	}
    }

    public function getLine() {
	return $this->line;
    }

    public function getColumn() {
	return $this->column;
    }

    public function getImageSrc() {
	return $this->imageSrc;
    }

    public function getImageDest() {
	return $this->imageDest;
    }

}

?>