<?php

namespace easymessages\utils;

class TextUtils{
    /**
     * @param string $message
     * @return string
     */
    public static function next($message = ""){
        if(is_string($message)){
            return substr($message, -1).substr($message, 0, -1);
        }
    }
}