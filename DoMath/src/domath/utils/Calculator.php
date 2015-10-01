<?php

namespace domath\utils;

class Calculator{
    /** @const int */
    const ADD = 0;
    /** @const int */
    const SUBTRACT = 1;
    /** @const int */
    const MULTIPLY = 2;
    /** @const int */
    const DIVIDE = 3;
    /** @const int */
    const SQUARE = 4;
    /**
     * @param mixed $input
     * @param int $mode
     * @return string
     */
    public function toString($input, $mode){
        $output = "";
        $answer = null;
        $symbol = null;
        switch($mode){
            case self::ADD:
                $symbol = "+";
                if(is_array($input)) $answer = $this->add($input);
                break;
            case self::SUBTRACT:
                $symbol = "-";
                if(is_array($input)) $answer = $this->subtract($input);
                break;
            case self::MULTIPLY:
                $symbol = "*";
                if(is_array($input)) $answer = $this->multiply($input);
                break;
            /*
            case self::DIVIDE:
                $symbol = "/";
                $answer = $this->divide($input);
                break;
             */
            case self::SQUARE:
                $symbol = "√";
                if(is_string($input)) $answer = $this->square($input);
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
    public function add(array $inputs){
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
    public function subtract(array $inputs){
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
    public function multiply(array $inputs){
        if(is_array($inputs)){
            $output = $inputs[0];
            foreach(array_slice($inputs, 1) as $input){
                $output *= $input;
            }
            return $output;
        }
    }
    /**
     * @param int $input
     * @return int|float
     */
    public function square($input){
        if(is_numeric($input)) return sqrt($input);
    }
}