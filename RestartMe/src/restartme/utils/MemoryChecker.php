<?php

namespace restartme\utils;

class MemoryChecker{
    /**
     * @param string $toCheck
     * @return int
     */
    public static function calculateBytes($toCheck){
        $memCount = intval(substr(trim($toCheck), 0, 1));
        switch(strtoupper(substr($toCheck, -1))){
            /** @noinspection PhpMissingBreakStatementInspection */
            case "T": //terabytes
                $memCount *= 1024;
            /** @noinspection PhpMissingBreakStatementInspection */
            case "G": //gigabytes
                $memCount *= 1024;
            /** @noinspection PhpMissingBreakStatementInspection */
            case "M": //megabytes
                $memCount *= 1024;
            /** @noinspection PhpMissingBreakStatementInspection */
            case "K": //kilobytes
                $memCount *= 1024;
            case "B": //bytes
                $memCount *= 1024;
                break;
        }
        return $memCount;
    }
}