<?php
namespace App\Lib\ImageProcesor;


class Dpi {
    public static function size($profile, $density) {
        $size = config("dpi.$profile");
        
        if (empty($size)) throw new \Exception("Profile invalid.");
        
        $d = config("dpi._densities.$density");
        if (empty($d)) throw new \Exception("Density invalid.");

        $size[0] *= $d[1];
        $size[1] *= $d[1];
        return $size;
    }
}