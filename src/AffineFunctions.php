<?php

namespace Easygd;

class AffineFunctions
{

    public static function test_1()
    {
        $affineArray = [1, 0, 0, 1, 0, 0];
        return (new Affine())->create($affineArray);
    }

    public static function test_2()
    {
        $affineArray = [1, 0, 0, 1, 150, 0];
        return (new Affine())->create($affineArray);
    }

    public static function test_3()
    {
        $affineArray = [1.2, 0, 0, 0.6, 0, 0];
        return (new Affine())->create($affineArray);
    }

    public static function test_4()
    {
        $affineArray = [1, 2, 0, 1, 0, 0];
        return (new Affine())->create($affineArray);
    }

    public static function test_5()
    {
        $affineArray = [2, 1, 0, 1, 0, 0];
        return (new Affine())->create($affineArray);
    }

    public static function test_6()
    {
        $affineArray = [cos(15), sin(15), -sin(15), cos(15), 0, 0];
        return (new Affine())->create($affineArray);
    }

    public static function test_7()
    {
        $affineArray = [cos(15), -sin(15), sin(15), cos(15), 0, 0];
        return (new Affine())->create($affineArray);
    }
}
