<?php

namespace domath\utils;

class SimpleStorage{
    /** @var array */
    private $answers = [];
    /**
     * @param mixed $key
     * @param int $input
     */
    public static function store($key, $input){
        $this->answers[strtolower($key)] = $input;
    }
    /**
     * @param mixed $key
     */
    public static function remove($key){
        if(self::exists($key)) unset($this->answers[strtolower($key)]);
    }
    /**
     * @param mixed $key
     * @return int|bool
     */
    public static function retrieve($key){
        if(self::exists($key)){
            return $this->answers[strtolower($key)];
        }
        return false;
    }
    /**
     * @param mixed $key
     * @return bool
     */
    public static function exists($key){
        return $this->answers[strtolower($key)] !== null;
    }
    public static function clear(){
        $this->answers = [];
    }
}