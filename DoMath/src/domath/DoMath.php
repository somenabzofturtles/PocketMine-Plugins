<?php

namespace domath;

use domath\command\DoMathCommand;
use domath\utils\Calculator;
use pocketmine\plugin\PluginBase;

class DoMath extends PluginBase{
    public function onEnable(){
        $this->getServer()->getCommandMap()->register("domath", new DoMathCommand($this));
    }
    /**
     * @return Calculator
     */
    public function getCalculator(){
        return new Calculator();
    }
}