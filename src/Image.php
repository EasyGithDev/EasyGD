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
class Image
{

	protected $img;
	protected $stream;
	protected $type;
	protected $colors;

	use Transformation;

	public function __construct()
	{

		$this->img = null;
		$this->stream = null;
		$this->type = IMAGETYPE_PNG;
		$this->colors = [];
	}

	public function __destruct()
	{
		if ($this->img) {
			imagedestroy($this->img);
		}
	}

	public function create(Dimension $dimension, Color $color = null)
	{

		if (($img = imagecreatetruecolor($dimension->width, $dimension->height)) === false) {
			return false;
		}

		$obj = new self;
		$obj->img = $img;

		if (!is_null($color)) {
			$obj->fill($color);
		}

		return $obj;
	}

	public function load(string $stream)
	{

		if (parse_url($stream, PHP_URL_SCHEME) === false) {
			if (!file_exists($stream)) {
				return false;
			}
		}

		if (($type = @exif_imagetype($stream)) === false) {
			return false;
		}

		$extension = image_type_to_extension($type, false);
		if (empty($extension)) {
			return false;
		}
		$function = 'imagecreatefrom' . $extension;

		if (($img = call_user_func($function, $stream)) === false) {
			return false;
		}

		$obj = new self;
		$obj->img = $img;
		$obj->type = $type;
		$obj->stream = $stream;

		return $obj;
	}

	public function createCopy(Dimension $d = null)
	{
		$d = (is_null($d)) ? $this->getDimension() : $d;

		// Création du conteneur de destination
		if (($imDest = (new Image)->create($d)) === false) {
			return false;
		}

		$imDest->settype($this->gettype());

		if (($this->gettype() == IMAGETYPE_GIF) || ($this->gettype() == IMAGETYPE_PNG)) {
			$trnprt_indx = imagecolortransparent($this->getImg());

			// If we have a specific transparent color
			if ($trnprt_indx >= 0) {

				// Get the original image's transparent color's RGB values
				$trnprt_color = imagecolorsforindex($this->getImg(), $trnprt_indx);

				// Allocate the same color in the new image resource
				$trnprt_indx = imagecolorallocate($imDest->getImg(), $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

				// Completely fill the background of the new image with allocated color.
				imagefill($imDest->getImg(), 0, 0, $trnprt_indx);

				// Set the background color for new image to transparent
				imagecolortransparent($imDest->getImg(), $trnprt_indx);
			}
			// Always make a transparent background color for PNGs that don't have one allocated already
			elseif ($this->gettype() == IMAGETYPE_PNG) {

				// Turn off transparency blending (temporarily)
				imagealphablending($imDest->getImg(), false);

				// Create a new transparent color for image
				$color = imagecolorallocatealpha($imDest->getImg(), 0, 0, 0, 127);

				// Completely fill the background of the new image with allocated color.
				imagefill($imDest->getImg(), 0, 0, $color);

				// Restore transparency blending
				imagesavealpha($imDest->getImg(), true);
			}
		}

		return $imDest;
	}

	public function getDataSource(string $stream)
	{
		if (parse_url($stream, PHP_URL_SCHEME) === false) {
			if (!file_exists($stream)) {
				return false;
			}
		}

		if (($type = @exif_imagetype($stream)) === false) {
			return false;
		}

		if (($mime = image_type_to_mime_type($type)) === false) {
			return false;
		}

		return "data:$mime;base64," . base64_encode(file_get_contents($stream));
	}

	public function getInfos(string $stream)
	{
		return ImageInfo::create($stream);
	}

	protected function manage(&$function, &$param_array, int $quality)
	{

		$function = 'image' . image_type_to_extension($this->type, false);
		$param_array[] = $this->img;
		$param_array[] = null;
		if ($this->type == IMAGETYPE_JPEG || $this->type == IMAGETYPE_PNG) {
			$quality = intval($quality);
			switch ($this->type) {
				case IMAGETYPE_JPEG:
					$param_array[] = ($quality < 0 or $quality > 100) ? 75 : $quality;
					break;
				case IMAGETYPE_PNG:
					// Restore transparency blending
					imagesavealpha($this->getImg(), true);
					$param_array[] = ($quality < 0 or $quality > 9) ? 9 : $quality;
					break;
			}
		}
	}

	/**
	 * Dont use this function in production
	 * 
	 * @return the image string 
	 */
	public function src()
	{
		$tmp = 'easy' . image_type_to_extension($this->type);
		$this->save($tmp);
		$content = $this->getDataSource($tmp);
		unlink($tmp);
		return $content;
	}

	public function show($header = true, $quality = 100)
	{

		if ($header) {
			header('Content-type: ' . image_type_to_mime_type($this->type));
		}

		$this->manage($function, $param_array, $quality);
		call_user_func_array($function, $param_array);

		return $this;
	}

	public function save(string $fileDest, int $quality = 100)
	{

		$this->manage($function, $param_array, $quality);
		$param_array[1] = $fileDest;

		call_user_func_array($function, $param_array);

		return $this;
	}

	public function getWidth()
	{
		return ($this->img) ? imagesx($this->img) : false;
	}

	public function getHeight()
	{
		return ($this->img) ? imagesy($this->img) : false;
	}

	public function getDimension()
	{
		return (new Dimension)->create(imagesx($this->img), imagesy($this->img));
	}

	public function getImg()
	{
		return $this->img;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getstream()
	{
		return $this->stream;
	}

	public function getRatio()
	{
		return $this->getWidth() / $this->getHeight();
	}

	public function getColor($hexa)
	{
		return isset($this->colors[$hexa]) ? $this->colors[$hexa] : false;
	}

	public function setImg($img)
	{
		$this->img = $img;
	}

	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}

	public function setTransparentColor(Color $color)
	{

		$this->setColor($color);

		// On rend l'arrière-plan transparent
		imagecolortransparent($this->img, $this->colors["$color"]);
		return $this;
	}

	public function setColor(Color $color)
	{
		if (isset($this->colors["$color"])) {
			return $this;
		}

		$this->colors["$color"] = imagecolorallocatealpha($this->img, $color->getRed(), $color->getGreen(), $color->getBlue(), $color->getAlpha());
		return $this;
	}

	public function addText(Text $text)
	{
		if ($text->getPosition()->x > $this->getWidth() or $text->getPosition()->y > $this->getHeight()) {
			return false;
		}

		$color = $text->getColor();
		$this->setColor($color);

		switch ($text->getFonttype()) {
			case TEXT::TEXT_FONT_TRUETYPE:
				@imagettftext(
					$this->img,
					$text->getSize(),
					$text->getAngle(),
					$text->getPosition()->x,
					$text->getPosition()->y,
					$this->colors["$color"],
					$text->getFontfile(),
					$text->getText()
				);
				break;
			case Text::TEXT_FONT_FREETYPE:
				@imagefttext(
					$this->img,
					$text->getSize(),
					$text->getAngle(),
					$text->getPosition()->x,
					$text->getPosition()->y,
					$this->colors["$color"],
					$text->getFontfile(),
					$text->getText()
				);
				break;
			case Text::TEXT_FONT_DEFAULT:
			default:
				$function = ($text->getDrawtype() == TEXT::TEXT_DRAW_HORIZONTAL) ? 'imagestring' : 'imagestringup';
				$function($this->img, $text->getSize(), $text->getPosition()->x, $text->getPosition()->y, $text->getText(), $this->colors["$color"]);
				break;
		}

		return $this;
	}

	public function fill(Color $color, Position $position = null)
	{
		$this->setColor($color);
		$x = 0;
		$y = 0;
		if (!is_null($position)) {
			$x = $position->x;
			$y = $position->y;
		}

		imagefill($this->img, $x, $y, $this->colors["$color"]);
		return $this;
	}

	public function drawLine(Position $p1, Position $p2, Color $color)
	{
		$this->setColor($color);
		imageline($this->img, $p1->getX(), $p1->getY(), $p2->getX(), $p2->getY(), $this->colors["$color"]);
	}

	public static function __callStatic($name, $arguments)
	{
		return (new self);
	}

	public function __get($key)
	{
		switch ($key) {
			case 'IMG_WIDTH':
				return ($this->img) ? imagesx($this->img) : false;
				break;
			case 'IMG_HEIGHT':
				return ($this->img) ? imagesy($this->img) : false;
				break;
			case 'IMG_TYPE':
				return $this->type;
				break;
			case 'IMG_SRC':
				return $this->stream;
				break;
			case 'TOP_LEFT':
				return (new Position)->create();
				break;
			case 'TOP_CENTER':
				return (new Position)->create(intval($this->getWidth() / 2), 0);
				break;
			case 'TOP_RIGHT':
				return (new Position)->create($this->getWidth(), 0);
				break;
			case 'MIDDLE_LEFT':
				return (new Position)->create(0, intval($this->getHeight() / 2));
				break;
			case 'MIDDLE_CENTER':
				return (new Position)->create(intval($this->getWidth() / 2), intval($this->getHeight() / 2));
				break;
			case 'MIDDLE_RIGHT':
				return (new Position)->create($this->getWidth(), intval($this->getHeight() / 2));
				break;
			case 'BOTTOM_LEFT':
				return (new Position)->create(0, $this->getHeight());
				break;
			case 'BOTTOM_CENTER':
				return (new Position)->create(intval($this->getWidth() / 2), $this->getHeight());
				break;
			case 'BOTTOM_RIGHT':
				return (new Position)->create($this->getWidth(), $this->getHeight());
				break;
		}

		return false;
	}
}
