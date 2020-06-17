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
class Color
{
    const Aqua = '#00FFFF';
    const Black = '#000000';
    const Blue = '#0000FF';
    const Fuchsia = '#FF00FF';
    const Gray = '#808080';
    const Green = '#008000';
    const Lime = '#00FF00';
    const Maroon = '#800000';
    const Navy = '#000080';
    const Olive = '#808000';
    const Purple = '#800080';
    const Red = '#FF0000';
    const Silver = '#C0C0C0';
    const Teal = '#008080';
    const White = '#FFFFFF';
    const Yellow = '#FFFF00';

    private $hexa;
    private $rgb;
    private $alpha;

    public function __construct()
    {
        $this->hexa = '#000000';
        $this->rgb = [0, 0, 0];
        $this->alpha = 0;
    }

    public function create(string $hexa, int $alpha = 0)
    {
        if (!preg_match('/^#?([a-f0-9]{6})$/i', $hexa)) {
            throw new Exception('Hexa must be an hexadecimal value');
        }

        if (!is_int($alpha)) {
            throw new Exception('Alpha must be integer [0-127]');
        }

        $hexa = str_replace('#', '', $hexa);
        $this->hexa = $hexa;
        $this->rgb[0] = hexdec(substr($hexa, 0, 2));
        $this->rgb[1] = hexdec(substr($hexa, 2, 2));
        $this->rgb[2] = hexdec(substr($hexa, 4, 2));
        $this->alpha = ($alpha < 0 or $alpha > 127) ? 0 : $alpha;

        return $this;
    }

    public function createFromArray($array)
    {
        $r = str_pad(dechex($array[0]), 2, '0', STR_PAD_LEFT);
        $g = str_pad(dechex($array[1]), 2, '0', STR_PAD_LEFT);
        $b = str_pad(dechex($array[2]), 2, '0', STR_PAD_LEFT);
        return (new self())->create("#$r$g$b");
    }

    public function getAlpha()
    {
        return $this->alpha;
    }

    public function setAlpha($alpha)
    {
        $this->alpha = $alpha;
        return $this;
    }

    public function getHexa()
    {
        return $this->hexa;
    }

    public function setHexa($hexa)
    {
        $this->hexa = $hexa;
        return $this;
    }

    public function getRed()
    {
        return $this->rgb[0];
    }

    public function setRed($red)
    {
        $this->rgb[0] = $red;
        return $this;
    }

    public function getGreen()
    {
        return $this->rgb[1];
    }

    public function setGreen($green)
    {
        $this->rgb[1] = $green;
        return $this;
    }

    public function getBlue()
    {
        return $this->rgb[2];
    }

    public function setBlue($blue)
    {
        $this->rgb[2] = $blue;
        return $this;
    }

    public function __toString()
    {
        return (string) $this->hexa;
    }

    public static function __callStatic($name, $arguments)
    {
        if (defined(__NAMESPACE__ . '\Color::' . $name)) {
            return (new Color())->create(constant(__NAMESPACE__ . '\Color::' . $name));
        }
    }
}
