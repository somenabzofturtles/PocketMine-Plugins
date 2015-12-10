<?php

namespace restartme\utils;

class Utils{
    /**
     * Calculates the memory usage threshold from a string
     * @param string $toCheck
     * @return int
     */
    public static function calculateBytes($toCheck){
        $byteLimit = (int) substr(trim($toCheck), 0, 1);
        switch(strtoupper(substr($toCheck, -1))){
            case "T": //terabyte
                $byteLimit *= 1024;
            case "G": //gigabyte
                $byteLimit *= 1024;
            case "M": //megabyte
                $byteLimit *= 1024;
            case "K": //kilobyte
                $byteLimit *= 1024;
            case "B": //byte
                $byteLimit *= 1024;
                break;
        }
        return $byteLimit;
    }
    /**
     * Returns true if $toCheck is greater than the current memory usage
     * @param string $toCheck
     * @return bool
     */
    public static function isOverloaded($toCheck){
        return memory_get_usage(true) > self::calculateBytes($toCheck);
    }
}