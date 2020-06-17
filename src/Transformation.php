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

namespace Easygd;

/**
 * Easy
 * @package Easy
 * @author  Florent Brusciano
 * @since   1.0.0
 */

trait Transformation
{

	private function resize(Dimension $d)
	{

		$imDest = $this->createCopy($d);

		imagecopyresampled($imDest->getImg(), $this->getImg(), 0, 0, 0, 0, $d->width, $d->height, $this->getWidth(), $this->getHeight());

		return $imDest;
	}

	/**
	 * Redimentionne une image via un pourcentage
	 * @param float $percent Valeur comprise entre 0.1 et 1
	 */
	public function resizeByPercent(float $percent)
	{

		$newWidth = intval($this->getWidth() * $percent);
		$newHeight = intval($this->getHeight() * $percent);
		$dimension = (new Dimension)->create($newWidth, $newHeight);

		return $this->resize($dimension);
	}

	/**
	 * Redimentionne une image en conservant le ratio
	 * @param int $newHeight la nouvelle hauteur
	 */
	public function resizeByHeight(int $newHeight)
	{

		$newWidth = intval($newHeight * $this->getWidth() / $this->getHeight());
		$dimension = (new Dimension)->create($newWidth, $newHeight);
		return $this->resize($dimension);
	}

	/**
	 * Redimentionne une image en conservant le ratio
	 * @param type $newWidth la nouvelle largeur 
	 */
	public function resizeByWidth(int $newWidth)
	{

		$newHeight = intval($newWidth * $this->getHeight() / $this->getWidth());
		$dimension = (new Dimension)->create($newWidth, $newHeight);
		return $this->resize($dimension);
	}

	/**
	 * Va redimentionner la nouvelle image en conservant les proportions
	 * 
	 * @param int $newWidth Nouvelle hauteur
	 * @param int $newHeight Nouvelle largeur
	 */
	public function resizeAuto(Dimension $d)
	{
		$ratioSrc = $this->getRatio();
		$ratioDest = $d->width / $d->height;
		$roundSrc = round($ratioSrc, 2);
		$roundDest = round($ratioDest, 2);

		// la largeur est recalculée en fonction de la nouvelle hauteur
		if ($roundSrc > $roundDest) {
			$d->width(round($d->height * $ratioSrc));
		}
		// la hauteur est recalculée en fonction de la nouvelle largeur
		else if ($roundSrc < $roundDest) {
			$d->height(round($d->width / $ratioSrc));
		}

		return $this->resize($d);
	}

	/**
	 *
	 * Création d'une miniature carré de taille $max X $max
	 * 
	 * @param Image $imSrc l'image original
	 * @param type $max la taille de la miniature
	 * @return Image l'image de sortie
	 */
	public function thumbnail(int $max, Color $color = null)
	{

		// Largeur et heuteur de l'image source
		$width = $this->getWidth();
		$height = $this->getHeight();


		// Si l'image original est plus petite que le conteneur de destination
		$im = $this->getImg();
		$newHeight = $height;
		$newWidth = $width;
		$posY = ($max - $height) / 2;
		$posX = ($max - $width) / 2;

		// Création du conteneur de sortie
		$imDest = (new Image)->create((new Dimension)->create($max, $max), $color)->setType($this->getType());

		// Si l'image original est plus grande que le conteneur de destination
		if ($width > $max or $height > $max) {

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

			$resized = (new Image)->create((new Dimension)->create($newWidth, $newHeight))->setType($this->getType());
			$im = $resized->getImg();

			// Redimentionnement de l'image originale
			imagecopyresampled($im, $this->getImg(), 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		}

		imagecopymerge($imDest->getImg(), $im, $posX, $posY, 0, 0, $newWidth, $newHeight, 100);

		return $imDest;
	}

	public function crop(Position $p, Dimension $d)
	{

		if (($imDest = (new Image)->create($d)) === false) {
			return false;
		}

		imagecopymerge($imDest->getImg(), $this->getImg(), 0, 0, $p->x, $p->y, $d->width, $d->height, 100);

		return $imDest;
	}

	public function rotate(int $angle, Color $color = null)
	{
		$this->setColor(($color) ?? Color::Black());
		$imDest = clone $this;
		$imDest->setImg(imagerotate($this->getImg(), $angle, $this->getColor("$color")));

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
	private function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
	{
		// creating a cut resource 
		$cut = imagecreatetruecolor($src_w, $src_h);

		// copying relevant section from background to the cut resource 
		imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

		// copying relevant section from watermark to the cut resource 
		imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

		// insert cut resource to destination image 
		imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
	}

	public function inlay(Image $logo, Position $position = null, $pct = 100)
	{

		$position = (is_null($position)) ? (new Position)->create() : $position;
		$pct = ($pct < 1 or $pct > 100) ? 100 : intval($pct);

		//imagecopy($origine->getImg(), $logo->getImg(), $position->getX(), $position->getY(), 0, 0, $logo->getWidth(), $logo->getHeight());

		if ($logo->getType() == IMAGETYPE_PNG) {
			$this->imagecopymerge_alpha($this->getImg(), $logo->getImg(), $position->x, $position->y, 0, 0, $logo->getWidth(), $logo->getHeight(), $pct);
		} else {
			imagecopymerge($this->getImg(), $logo->getImg(), $position->x, $position->y, 0, 0, $logo->getWidth(), $logo->getHeight(), $pct);
		}

		return $this;
	}
}
