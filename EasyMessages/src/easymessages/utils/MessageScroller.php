<?php

namespace easymessages\utils;

class MessageScroller{
    /**
     * @param string $message
     * @return string
     */
    public static function next($message = ""){
        return implode("", array_push(str_split($message)));
    }
}