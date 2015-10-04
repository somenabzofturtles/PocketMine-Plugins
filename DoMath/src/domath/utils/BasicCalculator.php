<?php

namespace domath\utils;

class BasicCalculator{
    /** @const int */
    const ADD = 0;
    /** @const int */
    const SUBTRACT = 1;
    /** @const int */
    const MULTIPLY = 2;
    /** @const int */
    const DIVIDE = 3;
    /** @const int */
    const PERCENT = 4;
    /** @const int */
    const SQUARE = 5;
    /** @const int */
    const EXPONENT = 6;
    /**
     * @param mixed $input
     * @param int $mode
     * @return string
     */
    public static function toString($input, $mode){
        $output = "";
        $answer = null;
        $symbol = null;
        switch($mode){
            case self::ADD:
                $symbol = "+";
                if(is_array($input)) $answer = self::add($input);
                break;
            case self::SUBTRACT:
                $symbol = "-";
                if(is_array($input)) $answer = self::subtract($input);
                break;
            case self::MULTIPLY:
                $symbol = "*";
                if(is_array($input)) $answer = self::multiply($input);
                break;
            /*
            case self::DIVIDE:
                $symbol = "/";
                if(is_array($input)) $answer = self::divide($input);
                break;
             */
            case self::PERCENT:
                $symbol = "%";
                if(is_array($input)) $answer = self::percent($input[0], $input[1]);
                break;
            case self::SQUARE:
                $symbol = "√";
                if(is_string($input)) $answer = self::square($input);
                break;
            case self::EXPONENT:
                $symbol = "^";
                if(is_array($input)) $answer = self::exponent ($input[0], $input[1]);
                break;
        }
        if(is_array($input)){
            foreach($input as $inputValue){
                $output .= $inputValue.$symbol;
            }
            return substr($output, 0, -1)."=".$answer;
        }
        else{
            return $symbol.$input."=".$answer;
        }
    }
    /**
     * @param int[] $inputs
     * @return int
     */
    public static function add(array $inputs){
        if(is_array($inputs)){
            $output = 0;
            foreach($inputs as $input){
                $output += $input;
            }
            return $output;
        }
    }
    /**
     * @param int[] $inputs
     * @return int
     */
    public static function subtract(array $inputs){
        if(is_array($inputs)){
            $output = $inputs[0];
            foreach(array_slice($inputs, 1) as $input){
                $output -= $input;
            }
            return $output;
        }
    }
    /**
     * @param int[] $inputs
     * @return int
     */
    public static function multiply(array $inputs){
        if(is_array($inputs)){
            $output = $inputs[0];
            foreach(array_slice($inputs, 1) as $input){
                $output *= $input;
            }
            return $output;
        }
    }
    /**
     * @param int[] $inputs
     * @return int
     */
    public static function divide(array $inputs){
        if(is_array($inputs)){
            $output = $inputs[0];
            foreach(array_slice($inputs, 1) as $input){
                $output /= $input; //TODO: Handle division by zero
            }
            return $output;
        }
    }
    /**
     * @param int $input1
     * @param int $input2
     * @return int
     */
    public static function percent($input1, $input2){
        return ($input1 / $input2) * 100;
    }
    /**
     * @param int $input
     * @return int
     */
    public static function square($input){
        return sqrt($input);
    }
    /**
     * @param int $input
     * @param int $exponent
     * @return int
     */
    public static function exponent($input, $exponent){
        return $input ** $exponent;
    }
}