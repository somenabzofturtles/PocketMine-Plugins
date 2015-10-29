<?php

namespace skintools\utils;

class SkinConverter{
    /**
     * @param string $data
     * @return string
     */
    public static function compress($data){
        return zlib_encode($data, ZLIB_ENCODING_DEFLATE, 9);
    }
    /**
     * @param string $data
     * @return string
     */
    public static function uncompress($data){
        return zlib_decode($data);
    }
    /**
     * @param string $data
     */
    public static function toImage($data){
        //TODO: Add code to convert skin data to image files
    }
}