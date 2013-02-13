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
class Image {

    protected $img;
    protected $fileSrc;
    protected $imageType;
    protected $colors;

    public function __construct() {

        $this->img = NULL;
        $this->fileSrc = NULL;
        $this->imageType = IMAGETYPE_PNG;
        $this->colors = array();
    }

    public function __destruct() {
        if ($this->img)
            imagedestroy($this->img);
    }

    public static function create(Dimension $dimension, Color $color = NULL) {

        if (($img = imagecreatetruecolor($dimension->getWidth(), $dimension->getHeight())) === FALSE)
            return FALSE;

        $obj = new self;
        $obj->img = $img;

        if (!is_null($color))
            $obj->fill($color);

        return $obj;
    }

    public static function createFrom($fileSrc) {

        if (parse_url($url, PHP_URL_SCHEME) === FALSE)
            if (!file_exists($fileSrc))
                return FALSE;

        if (($imagetype = @exif_imagetype($fileSrc)) === FALSE)
            return FALSE;

        $extension = image_type_to_extension($imagetype, FALSE);
        if (empty($extension))
            return FALSE;

        $function = 'imagecreatefrom' . $extension;

        if (($img = call_user_func($function, $fileSrc)) === FALSE)
            return FALSE;

        $obj = new self;
        $obj->img = $img;
        $obj->imageType = $imagetype;
        $obj->fileSrc = $fileSrc;
        $obj->loadAlpha();

        return $obj;
    }

    public static function getDataSource($fileSrc) {

        if (parse_url($url, PHP_URL_SCHEME) === FALSE)
            if (!file_exists($fileSrc))
                return FALSE;

        if (($imagetype = @exif_imagetype($fileSrc)) === FALSE)
            return FALSE;

        if (($mime = image_type_to_mime_type($imagetype)) === FALSE)
            return FALSE;

        return "data:$mime;base64," . base64_encode(file_get_contents($fileSrc));
    }

    protected function manage(&$function, &$param_array, $quality) {

        $function = 'image' . image_type_to_extension($this->imageType, false);
        $param_array[] = $this->img;
        $param_array[] = NULL;
        if (!is_null($quality) AND ($this->imageType == IMAGETYPE_JPEG OR $this->imageType == IMAGETYPE_PNG)) {
            $quality = intval($quality);
            switch ($this->imageType) {
                case IMAGETYPE_JPEG:
                    $param_array[] = ($quality < 0 OR $quality > 100) ? 75 : $quality;
                    break;
                case IMAGETYPE_PNG:
                    $param_array[] = ($quality < 0 OR $quality > 9) ? 9 : $quality;
                    break;
            }
        }
    }

    public function show($header = true, $quality = NULL) {

        if ($header)
            header('Content-type: ' . image_type_to_mime_type($this->imageType));

        $this->manage($function, $param_array, $quality);
        call_user_func_array($function, $param_array);

        return $this;
    }

    public function save($fileDest, $quality = NULL) {

        $info = pathinfo($fileDest);
        $fileDest = $info['dirname'] . '/' . $info['filename'] . image_type_to_extension($this->imageType);
        $this->manage($function, $param_array, $quality);
        $param_array[1] = $fileDest;

        call_user_func_array($function, $param_array);

        return $this;
    }

    /**
     * Experimentale
     */
    public function loadAlpha() {


        if ($this->imageType == IMAGETYPE_GIF) {
            if (($transparent_index = ImageColorTransparent($this->img)) != (-1)) {
                $transparent_color = ImageColorsForIndex($this->img, $transparent_index);
                $this->setTransparentColor(Color::createFromArray($transparent_color)->setHexa('alpha'));
            }
        } elseif ($this->imageType == IMAGETYPE_PNG) {

            ImageAlphaBlending($this->img, TRUE);
            ImageSaveAlpha($this->img, TRUE);
        }

        return $this;
    }

    /**
     * Experimentale
     */
    public function saveAlpha() {
        if ($this->imageType == IMAGETYPE_GIF) {
//$this->fill($this->getColor('alpha'));
        } elseif ($this->imageType == IMAGETYPE_PNG) {
            ImageAlphaBlending($this->img, FALSE);
            ImageSaveAlpha($this->img, TRUE);
        }
        return $this;
    }

    public function getWidth() {
        return ($this->img) ? imagesx($this->img) : FALSE;
    }

    public function getHeight() {
        return ($this->img) ? imagesy($this->img) : FALSE;
    }

    public function getImg() {
        return $this->img;
    }

    public function getImagetype() {
        return $this->imageType;
    }

    public function getFilesrc() {
        return $this->fileSrc;
    }

    public function getRatio() {
        return $this->getWidth() / $this->getHeight();
    }

    public function getColor($hexa) {
        return isset($this->colors[$hexa]) ? $this->colors[$hexa] : FALSE;
    }

    public function setImagetype($imageType) {
        $this->imageType = $imageType;
        return $this;
    }

    public function setTransparentColor(Color $color) {

        $this->setColor($color);

        // On rend l'arrière-plan transparent
        imagecolortransparent($this->img, $this->colors["$color"]);
        return $this;
    }

    public function setColor(Color $color) {
        if (isset($this->colors["$color"]))
            return $this;

        $col = imagecolorallocatealpha($this->img, $color->getRed(), $color->getGreen(), $color->getBlue(), $color->getAlpha());
        $this->colors["$color"] = $col;
        return $this;
    }

    public function addText(Text $text) {
        $color = $text->getColor();
        $this->setColor($color);
        $function = ($text->getDrawtype() == TEXT::TEXT_DRAW_HORIZONTAL) ? 'imagestring' : 'imagestringup';

        switch ($text->getFonttype()) {

            case TEXT::TEXT_FONT_TRUETYPE :
                imagettftext($this->img, $text->getSize(), $text->getAngle(), $text->getPosition()->getX(), $text->getPosition()->getY(), $this->colors["$color"], $text->getFontfile(), $text->getText());
                break;
            case Text::TEXT_FONT_FREETYPE :
                imagefttext($this->img, $text->getSize(), $text->getAngle(), $text->getPosition()->getX(), $text->getPosition()->getY(), $this->colors["$color"], $text->getFontfile(), $text->getText());
                break;
            case Text::TEXT_FONT_DEFAULT :
            default :
                $function($this->img, $text->getSize(), $text->getPosition()->getX(), $text->getPosition()->getY(), $text->getText(), $this->colors["$color"]);
                break;
        }


        return $this;
    }

    public function fill(Color $color, Position $position = NULL) {
        $this->setColor($color);
        $x = 0;
        $y = 0;
        if (!is_null($position)) {
            $x = $position->getX();
            $y = $position->getY();
        }

        imagefill($this->img, $x, $y, $this->colors["$color"]);
        return $this;
    }

    public function drawLine(Position $p1, Position $p2, Color $color) {
        $this->setColor($color);
        imageline($this->img, $p1->getX(), $p1->getY(), $p2->getX(), $p2->getY(), $this->colors["$color"]);
    }

    public function __call($name, $arguments) {

        switch ($name) {
            case 'TOP_LEFT' :
                return Position::create();
                break;
            case 'TOP_MIDDLE' :
                return Position::create(intval($this->getWidth() / 2), 0);
                break;
            case 'TOP_RIGHT' :
                return Position::create($this->getWidth(), 0);
                break;
            case 'MIDDLE_LEFT' :
                return Position::create(0, intval($this->getHeight() / 2));
                break;
            case 'MIDDLE_MIDDLE' :
                return Position::create(intval($this->getWidth() / 2), intval($this->getHeight() / 2));
                break;
            case 'MIDDLE_RIGHT' :
                return Position::create($this->getWidth(), intval($this->getHeight() / 2));
                break;
            case 'BOTTOM_LEFT' :
                return Position::create(0, $this->getHeight());
                break;
            case 'BOTTOM_MIDDLE' :
                return Position::create(intval($this->getWidth() / 2), $this->getHeight());
                break;
            case 'BOTTOM_RIGHT' :
                return Position::create($this->getWidth(), $this->getHeight());
                break;
        }
    }

}

?>