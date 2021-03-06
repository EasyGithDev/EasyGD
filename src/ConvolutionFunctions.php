<?php

namespace Easygd;

class ConvolutionFunctions
{

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
        0, -1, 0
    );
    //Gradient 3x3 8-connex 
    public static $CONVOLUTION_8_CONNEX = array(
        -1, -1, -1,
        -1, 8, -1,
        -1, -1, -1
    );
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

    public static function identity()
    {
        return (new Convolution())->create(self::$CONVOLUTION_IDENTITY);
    }

    // Contraste (Sharpen)
    public static function sharpen_1()
    {
        return (new Convolution())->create(self::$CONVOLUTION_SHARPEN_1);
    }

    public static function sharpen_2()
    {
        return (new Convolution())->create(self::$CONVOLUTION_SHARPEN_2);
    }

    // Border detection (Edge)
    public static function detection_edges()
    {
        return (new Convolution())->create(self::$CONVOLUTION_DETECTION_EDGES);
    }

    public static function find_edges_1()
    {
        return (new Convolution())->create(self::$CONVOLUTION_FIND_EDGES_1);
    }

    public static function find_edges_2()
    {
        return (new Convolution())->create(self::$CONVOLUTION_FIND_EDGES_2);
    }

    public static function find_edges_3()
    {
        return (new Convolution())->create(self::$CONVOLUTION_FIND_EDGES_3);
    }

    // Median Blur
    public static function blur()
    {
        return (new Convolution())->create(self::$CONVOLUTION_BLUR);
    }

    // Gaussian Blur
    public static function gaussian()
    {
        return (new Convolution())->create(self::$CONVOLUTION_GAUSSIAN);
    }

    public static function emboss()
    {
        return (new Convolution())->create(self::$CONVOLUTION_EMBOSS);
    }


    public static function enhancement_edges_1()
    {
        return (new Convolution())->create(self::$CONVOLUTION_ENHANCEMENT_EDGES_1);
    }

    public static function enhancement_edges_2()
    {
        return (new Convolution())->create(self::$CONVOLUTION_ENHANCEMENT_EDGES_2);
    }

    public static function enhancement_edges_3()
    {
        return (new Convolution())->create(self::$CONVOLUTION_ENHANCEMENT_EDGES_3);
    }

    public static function laplacien_1($alpha = 2)
    {

        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_LAPLACIEN_1[$i] * $alpha;
        }
        return (new Convolution())->create($matrix)->setDivisor(4)->setOffset(128);
    }

    public static function laplacien_2($alpha = 2)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_LAPLACIEN_2[$i] * $alpha;
        }

        return (new Convolution())->create($matrix)->setDivisor(4)->setOffset(128);
    }

    public static function laplacien_3($alpha = 2)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_LAPLACIEN_3[$i] * $alpha;
        }

        return (new Convolution())->create($matrix)->setDivisor(4)->setOffset(128);
    }

    public static function gradient_ew($alpha = 2)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_GRADIENT_EW[$i] * $alpha;
        }
        return (new Convolution())->create($matrix)->setDivisor(6)->setOffset(128);
    }

    public static function gradient_we($alpha = 2)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_GRADIENT_WE[$i] * $alpha;
        }
        return (new Convolution())->create($matrix)->setDivisor(6)->setOffset(128);
    }

    public static function gradient_ns($alpha = 2)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_GRADIENT_NS[$i] * $alpha;
        }
        return (new Convolution())->create($matrix)->setDivisor(6)->setOffset(128);
    }

    public static function gradient_sn($alpha = 2)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_GRADIENT_SN[$i] * $alpha;
        }
        return (new Convolution())->create($matrix)->setDivisor(6)->setOffset(128);
    }

    public static function gradient_nwse($alpha = 2)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_GRADIENT_NWSE[$i] * $alpha;
        }
        return (new Convolution())->create($matrix)->setDivisor((4 * sqrt(2) / 3) * 3)->setOffset(128);
    }

    public static function four_connex($alpha = 10)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_4_CONNEX[$i] * $alpha;
        }
        return (new Convolution())->create($matrix)->setDivisor(4)->setOffset(128);
    }

    public static function eight_connex($alpha = 10)
    {
        $matrix = [];
        for ($i = 0; $i < 9; $i++) {
            $matrix[$i] = self::$CONVOLUTION_8_CONNEX[$i] * $alpha;
        }
        return (new Convolution())->create($matrix)->setDivisor(9.657)->setOffset(128);
    }

    public static function pratt()
    {
        return (new Convolution())->create(self::$CONVOLUTION_PRATT)->setDivisor(9);
    }
}
