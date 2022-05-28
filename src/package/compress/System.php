<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
namespace idescript\package\compress;
class System{

    public static function instance(): System{
        return new System();
    }

    public function compress($string){
        return base64_encode(gzdeflate(base64_encode(gzdeflate($string))));
    }

    public function decompression($string){
        return gzinflate(base64_decode(gzinflate(base64_decode($string))));
    }
}