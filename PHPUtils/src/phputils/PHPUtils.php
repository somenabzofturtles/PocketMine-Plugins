<?php

namespace phputils;

use phputils\command\PHPUtilsCommand;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

class PHPUtils extends PluginBase{
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("phputils", new PHPUtilsCommand($this));
    }
    /**
     * @param string $name
     * @return bool
     */
    public function isCommandEnabled($name){
        if($this->getConfig()->exists($name, true)){
            return $this->getConfig()->get(strtolower($name)) === true;
        }
        return false;
    }
    /**
     * @return array
     */
    public function getAlgorithms(){
        $algoCount = 0;
        $algoNames = "";
        foreach(hash_algos() as $algo){
            $algoNames .= $algo.", ";
            $algoCount++;
        }
        return [$algoCount, $algoNames];
    }
    /**
     * @param CommandSender $sender
     * @param string $classPath
     */
    public function findClass(CommandSender $sender, $classPath){
        //TODO: Work on handling the exception caused by looking for a nonexistent class
    }
    /**
     * @return array
     */
    public function getExtensions(){
        $extCount = 0;
        $extNames = "";
        foreach(get_loaded_extensions() as $extension){
            $extNames .= $extension.", ";
            $extCount++;
        }
        return [$extCount, $extNames];
    }
    /**
     * @param CommandSender $sender
     */
    public function sendPHPInfo(CommandSender $sender){
        //TODO: Work on sending PHP info
    }
    /**
     * @param CommandSender $sender
     */
    public function sendSystemInfo(CommandSender $sender){
        //TODO: Work on sending system info
    }
    /**
     * @param CommandSender $sender
     */
    public function sendZendInfo(CommandSender $sender){
        //TODO: Work on sending Zend info
    }
}