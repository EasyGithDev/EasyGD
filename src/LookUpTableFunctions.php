<?php

namespace Easygd;

class LookupTableFunctions
{

    public function lightnessGray($rgb)
    {
        //(max(R, G, B) + min(R, G, B)) / 2.
        $max = max(array_values($rgb));
        $min = min(array_values($rgb));
        $gray = round(($max + $min) / 2);
        return [$gray, $gray, $gray];
    }

    public function average_gray($rgb)
    {
        //(R + G + B) / 3
        $gray = round(($rgb['red'] + $rgb['green'] + $rgb['blue']) / 3);

        return [$gray, $gray, $gray];
    }

    public function luminosity_gray($rgb)
    {
        //0.21 R + 0.71 G + 0.07 B.
        $gray = round(0.299 * $rgb['red'] + 0.587 * $rgb['green'] + 0.114 * $rgb['blue']);
        return [$gray, $gray, $gray];
    }

    public function thresholding($rgb, $threshold = 128)
    {
        $r = ($rgb['red'] > $threshold) ? 255 : 0;
        $g = ($rgb['green'] > $threshold) ? 255 : 0;
        $b = ($rgb['blue'] > $threshold) ? 255 : 0;
        return [$r, $g, $b];
    }

    public function negative($rgb)
    {
        $r = 255 - $rgb['red'];
        $g = 255 - $rgb['green'];
        $b = 255 - $rgb['blue'];
        return [$r, $g, $b];
    }

    public function special($rgb)
    {
        $r = ($rgb['red'] > 128) ? max($rgb['green'], $rgb['blue']) : min($rgb['green'], $rgb['blue']);
        $g = ($rgb['green'] > 128) ? max($rgb['red'], $rgb['blue']) : min($rgb['red'], $rgb['blue']);
        $b = ($rgb['blue'] > 128) ? max($rgb['green'], $rgb['red']) : min($rgb['green'], $rgb['red']);
        return [$r, $g, $b];
    }
}
