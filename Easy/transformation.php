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

    private static function resize(Image $imSrc, Dimension $d) {

	$imDest = $imSrc->createCopy($d);

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

	$ratioSrc = $imSrc->getRatio();
	$ratioDest = $d->getWidth() / $d->getHeight();
	$roundSrc = round($ratioSrc, 2);
	$roundDest = round($ratioDest, 2);

	// la largeur est recalculée en fonction de la nouvelle hauteur
	if ($roundSrc > $roundDest) {
	    $d->setWidth(round($d->getHeight() * $ratioSrc));
	}
	// la hauteur est recalculée en fonction de la nouvelle largeur
	else if ($roundSrc < $roundDest) {
	    $d->setHeight(round($d->getWidth() / $ratioSrc));
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
    public static function thumbnail(Image $imSrc, $max, Color $color = NULL) {

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
	$imDest = Image::create(Dimension::create($max, $max), $color)
		->setImagetype($imSrc->getImagetype());

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

    public static function rotate(Image $imSrc, $angle, Color $color = NULL) {

	if (is_null($color))
	    $color = Color::Black();
	$imSrc->setColor($color);

	$imDest = clone $imSrc;
	$imDest->setImg(imagerotate($imSrc->getImg(), $angle, $imSrc->getColor("$color")));

	return $imDest;
    }

    /**
     * PNG ALPHA CHANNEL SUPPORT for imagecopymerge(); 
     * by Sina Salek 
     * 
     * Bugfix by Ralph Voigt (bug which causes it 
     * to work only for $src_x = $src_y = 0. 
     * Also, inverting opacity is not necessary.) 
     * 08-JAN-2011 
     * 
     * */
    private static function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct) {
	// creating a cut resource 
	$cut = imagecreatetruecolor($src_w, $src_h);

	// copying relevant section from background to the cut resource 
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

	// copying relevant section from watermark to the cut resource 
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

	// insert cut resource to destination image 
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
    }

    public static function inlay(Image $origine, Image $logo, Position $position = NULL, $pct = 100) {

	$position = (is_null($position)) ? Position::create() : $position;
	$pct = ($pct < 1 OR $pct > 100) ? 100 : intval($pct);

	//imagecopy($origine->getImg(), $logo->getImg(), $position->getX(), $position->getY(), 0, 0, $logo->getWidth(), $logo->getHeight());

	if ($logo->getImagetype() == IMAGETYPE_PNG)
	    self::imagecopymerge_alpha($origine->getImg(), $logo->getImg(), $position->getX(), $position->getY(), 0, 0, $logo->getWidth(), $logo->getHeight(), $pct);
	else
	    imagecopymerge($origine->getImg(), $logo->getImg(), $position->getX(), $position->getY(), 0, 0, $logo->getWidth(), $logo->getHeight(), $pct);


	return $origine;
    }

}

?>