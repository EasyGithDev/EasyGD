<?php

namespace Easygd;

class PresetFunctions
{

    public static function negate()
    {
        return (new Preset())->setName(IMG_FILTER_NEGATE);
    }

    public static function grayscale()
    {
        return (new Preset())->setName(IMG_FILTER_GRAYSCALE);
    }

    public static function edgedetect()
    {
        return (new Preset())->setName(IMG_FILTER_EDGEDETECT);
    }

    public static function emboss()
    {
        return (new Preset())->setName(IMG_FILTER_EMBOSS);
    }

    public static function gaussian_blur()
    {
        return (new Preset())->setName(IMG_FILTER_GAUSSIAN_BLUR);
    }

    public static function selective_blur()
    {
        return (new Preset())->setName(IMG_FILTER_SELECTIVE_BLUR);
    }

    public static function mean_removal()
    {
        return (new Preset())->setName(IMG_FILTER_MEAN_REMOVAL);
    }

    public static function pixelate($blockSize, $type = false)
    {
        return (new Preset())->setName(IMG_FILTER_PIXELATE)->setParametters([$blockSize, $type]);
    }

    /**
     * 
     * @param type $smooth, IMG_FILTER_SMOOTH, -8/+8
     * @return type
     */
    public static function smooth($smooth)
    {
        return (new Preset())->setName(IMG_FILTER_SMOOTH)->setParametters([$smooth]);
    }

    /**
     * 
     * @param type $BRIGHTNESS, -255 = min brightness, 0 = no change, +255 = max brightness
     * @return type
     */
    public static function brightness(int $brightness)
    {
        if ($brightness < -255 or $brightness > 255) {
            $brightness = 0;
        }
        return (new Preset())->setName(IMG_FILTER_BRIGHTNESS)->setParametters([$brightness]);
    }

    /**
     * 
     * @param type $contrast,  
     * -100 = max contrast, 0 = no change, +100 = min contrast (note the direction!)
     * @return type
     */
    public static function contrast(int $contrast)
    {
        if ($contrast < -100 or $contrast > 100) {
            $contrast = 0;
        }
        return (new Preset())->setName(IMG_FILTER_CONTRAST)->setParametters([$contrast]);
    }

    /**
     * 
     * @param type $colorize,     IMG_FILTER_COLORIZE, -127.12, -127.98, 127
     * @return type
     */
    public static function colorize(int $red, int $green, int $blue)
    {

        if ($red < -255 or $red > 255) {
            $red = 0;
        }
        if ($green < -255 or $blue > 255) {
            $green = 0;
        }
        if ($blue < -255 or $blue > 255) {
            $blue = 0;
        }

        return (new Preset())->setName(IMG_FILTER_COLORIZE)->setParametters([$red, $green, $blue]);
    }
}
