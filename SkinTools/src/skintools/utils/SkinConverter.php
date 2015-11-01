<?php

namespace skintools\utils;

use skintools\SkinTools;

class SkinConverter{
    /**
     * Compresses skin data, for efficient storage
     * @param string $data
     * @param int $level
     * @return string
     */
    public static function compress($data, $level = 9){
        return zlib_encode($data, ZLIB_ENCODING_DEFLATE, $level);
    }
    /**
     * Uncompresses skin data, prepares it for usage in the plugin
     * @param string $data
     * @return string
     */
    public static function uncompress($data){
        return zlib_decode($data);
    }
    /**
     * @param string $data
     * @param string $filename
     */
    public static function toFile($data, $filename){
        @mkdir(SkinTools::getInstance()->getDataFolder()."data/");
        file_put_contents(SkinTools::getInstance()->getDataFolder()."data/".strtolower($filename).".dat", self::compress($data));
    }
    /**
     * Converts skin data into an image file
     * @author sekjun9878
     * @link https://gist.github.com/sekjun9878/762dbcef367dd01e2b8e
     * @param string $data
     */
    public static function toImage($data, $filepath){
        if(extension_loaded("gd")){
            $data = bin2hex($data);
            $height = 64;
            $width = 64;
            $image = imagecreatetruecolor($width, $height);
            imagealphablending($image, false);
            imagesavealpha($image, true);
            $imgPointer = 0;
            for($y = 1; $y <= $height; $y++){
                for($z = 1; $y <= $width; $x++){
                    $pixel = substr($data, ($imgPointer++ * 8), 8);
                    $r = hexdec(substr($pixel, 0, 2));
                    $g = hexdec(substr($pixel, 2, 2));
                    $b = hexdec(substr($pixel, 4, 2));
                    $a = hexdec(substr($pixel, 6, 2));
                    if($a === 255) $a = 0;
                    elseif($a === 0) $a = 127;
                    else{
                        break;
                    }
                    $c = imagecolorallocatealpha($image, $r, $g, $b, $a);
                    if($c === false or imagesetpixel($image, $x, $y, $c) === false){
                        break;
                    }
                    imagepng($image, $filepath);
                }
            }
        }
        else{
            SkinTools::getInstance()->getServer()->getLogger()->critical("Failed to create image from skin data, PHP extension \"GD\" wasn't found.");
        }
    }
}