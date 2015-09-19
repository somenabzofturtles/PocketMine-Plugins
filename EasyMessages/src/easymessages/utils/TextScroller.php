<?php

namespace easymessages\utils;

class TextScroller{
    /**
     * @param string $message
     * @return string
     */
    public static function next($message = ""){
        return implode("", array_push(str_split($message)));
    }
}