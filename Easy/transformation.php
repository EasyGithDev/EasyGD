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
class Transformation {
    const POSITION_TOP_LEFT = 1;
    const POSITION_TOP_MIDDLE = 2;
    const POSITION_TOP_RIGHT = 3;

    const POSITION_MIDDLE_LEFT = 4;
    const POSITION_MIDDLE_MIDDLE = 5;
    const POSITION_MIDDLE_RIGHT = 6;

    const POSITION_BOTTOM_LEFT = 7;
    const POSITION_BOTTOM_MIDDLE = 8;
    const POSITION_BOTTOM_RIGHT = 9;

    private static function resize(Image $imSrc, Dimension $d) {


        // Création du conteneur de destination
        if (($imDest = Image::create($d)) === FALSE)
            return FALSE;

        $imDest->setImagetype($imSrc->getImagetype());
        if (($color = $imSrc->getColor('alpha')) !== FALSE) {
            $imDest->setTransparentColor($color);
        }
        $imDest->saveAlpha();

        imagecopyresampled($imDest->getImg(), $imSrc->getImg(), 0, 0, 0, 0, $d->getWidth(), $d->getHeight(), $imSrc->getWidth(), $imSrc->getHeight());

        return $imDest;
    }

    /**
     * Redimentionne une image via un pourcentage
     * @param float $percent Valeur comprise entre 0.1 et 1
     */
    public static function resizeByPercent(Image $imSrc, $percent) {

        if (!is_float($percent))
            return FALSE;

        $newWidth = intval($imSrc->getWidth() * $percent);
        $newHeight = intval($imSrc->getHeight() * $percent);
        $dimension = Dimension::create($newWidth, $newHeight);

        return self::resize($imSrc, $dimension);
    }

    /**
     * Redimentionne une image en conservant le ratio
     * @param int $newHeight la nouvelle hauteur
     */
    public static function resizeByHeight(Image $imSrc, $newHeight) {

        if (!is_int($newHeight))
            return FALSE;

        $newWidth = intval($newHeight * $imSrc->getWidth() / $imSrc->getHeight());
        $dimension = Dimension::create($newWidth, $newHeight);
        return self::resize($imSrc, $dimension);
    }

    /**
     * Redimentionne une image en conservant le ratio
     * @param type $newWidth la nouvelle largeur 
     */
    public static function resizeByWidth(Image $imSrc, $newWidth) {

        if (!is_int($newWidth))
            return FALSE;

        $newHeight = intval($newWidth * $imSrc->getHeight() / $imSrc->getWidth());
        $dimension = Dimension::create($newWidth, $newHeight);
        return self::resize($imSrc, $dimension);
    }

    /**
     * Va redimentionner la nouvelle image en conservant les proportions
     * 
     * @param int $newWidth Nouvelle hauteur
     * @param int $newHeight Nouvelle largeur
     */
    public static function resizeAuto(Image $imSrc, Dimension $d) {

        $newWidth = $d->getWidth();
        $newHeight = $d->getHeight();
        $ratioSrc = $imSrc->getRatio();
        $ratioDest = $newWidth / $newHeight;

        if ($ratioSrc > $radioDest) {
            $d->setWidth(intval($newHeight * $ratioSrc));
        } else {
            $d->setHeight(intval($newWidth / $ratioSrc));
        }

        return self::resize($imSrc, $d);
    }

    /**
     *
     * Création d'une miniature carré de taille $max X $max
     * 
     * @param Image $imSrc l'image original
     * @param type $max la taille de la miniature
     * @return Image l'image de sortie
     */
    public function thumbnail(Image $imSrc, $max, Color $color = NULL) {

        if (!is_int($max))
            return FALSE;

        // Largeur et heuteur de l'image source
        $fileSrc = $imSrc->getFilesrc();
        $width = $imSrc->getWidth();
        $height = $imSrc->getHeight();


        // Si l'image original est plus petite que le conteneur de destination
        $im = $imSrc->getImg();
        $newHeight = $height;
        $newWidth = $width;
        $posY = ($max - $height) / 2;
        $posX = ($max - $width) / 2;

        // Création du conteneur de sortie
        $imDest = Image::create(Dimension::create($max, $max), $color);

        // Si l'image original est plus grande que le conteneur de destination
        if ($width > $max OR $height > $max) {

            $posX = $posY = 0;

            // Si l'image est carrée
            $newWidth = $newHeight = $max;

            // Si l'image est plus large (paysage)
            if ($width > $height) {
                $newWidth = $max;
                $newHeight = intval($height / ($width / $max));
                $posY = ($max - $newHeight) / 2;
            }

            // Si l'image est plus haute (portrait)
            else if ($width < $height) {
                $newWidth = intval($width / ($height / $max));
                $newHeight = $max;
                $posX = ($max - $newWidth) / 2;
            }


            $resized = Image::create(Dimension::create($newWidth, $newHeight))
                    ->setImagetype($imSrc->getImagetype());

            $im = $resized->getImg();

            // Redimentionnement de l'image originale
            imagecopyresampled($im, $imSrc->getImg(), 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        }

        imagecopymerge($imDest->getImg(), $im, $posX, $posY, 0, 0, $newWidth, $newHeight, 100);

        return $imDest;
    }

    public static function crop(Image $imSrc, Position $p, Dimension $d) {

        if (($imDest = Image::create($d)) === FALSE)
            return FALSE;

        imagecopymerge($imDest->getImg(), $imSrc->getImg(), 0, 0, $p->getX(), $p->getY(), $d->getWidth(), $d->getHeight(), 100);

        return $imDest;
    }

    public static function inlay(Image $origine, Image $logo, $position, Position $offset = NULL, $pct = 100) {

        $offset = (is_null($offset)) ? Position::create() : $offset;

        switch ($position) {
            case self::POSITION_TOP_LEFT :
                $dst_x = $offset->getX();
                $dst_y = $offset->getY();
                break;
            case self::POSITION_TOP_MIDDLE :
                $dst_x = intval($origine->getWidth() / 2) - intval($logo->getWidth() / 2) - $offset->getX();
                $dst_y = $offset->getY();
                break;
            case self::POSITION_TOP_RIGHT :
                $dst_x = $origine->getWidth() - $logo->getWidth() - $offset->getX();
                $dst_y = $offset->getY();
                break;
            case self::POSITION_MIDDLE_LEFT :
                $dst_x = $offset->getX();
                $dst_y = intval($origine->getHeight() / 2) - intval($logo->getHeight() / 2) - $offset->getY();
                break;
            case self::POSITION_MIDDLE_MIDDLE :
                $dst_x = intval($origine->getWidth() / 2) - intval($logo->getWidth() / 2) - $offset->getX();
                $dst_y = intval($origine->getHeight() / 2) - intval($logo->getHeight() / 2) - $offset->getY();
                break;
            case self::POSITION_MIDDLE_RIGHT :
                $dst_x = $origine->getWidth() - $logo->getWidth() - $offset->getX();
                $dst_y = intval($origine->getHeight() / 2) - intval($logo->getHeight() / 2) - $offset->getY();
                break;
            case self::POSITION_BOTTOM_LEFT :
                $dst_x = $offset->getX();
                $dst_y = $origine->getHeight() - $logo->getHeight() - $offset->getY();
                break;
            case self::POSITION_BOTTOM_MIDDLE :
                $dst_x = intval($origine->getWidth() / 2) - intval($logo->getWidth() / 2) - $offset->getX();
                $dst_y = $origine->getHeight() - $logo->getHeight() - $offset->getY();
                break;
            case self::POSITION_BOTTOM_RIGHT :
                $dst_x = $origine->getWidth() - $logo->getWidth() - $offset->getX();
                $dst_y = $origine->getHeight() - $logo->getHeight() - $offset->getY();
                break;
        }

        // Bug with imagecopymerge
        //imagecopymerge($origine->getImg(), $logo->getImg(), $dst_x, $dst_y, 0, 0, $logo->getWidth(), $logo->getHeight(), $pct);
        imagecopy($origine->getImg(), $logo->getImg(), $dst_x, $dst_y, 0, 0, $logo->getWidth(), $logo->getHeight());
        return $origine;
    }

}

?>