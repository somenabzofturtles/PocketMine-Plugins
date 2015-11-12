<?php

namespace phputils;

use phputils\command\PHPUtilsCommand;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

class PHPUtils extends PluginBase{
    const NOT_FOUND = -1;
    const DISABLED = 0;
    const ENABLED = 1;
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("phputils", new PHPUtilsCommand($this));
    }
    /**
     * @param string $name
     * @return int
     */
    public function isCommandEnabled($name){
        if($this->getConfig()->exists($name, true)){
            if($this->getConfig()->get(strtolower($name)) === true){
                return self::ENABLED; //Command found, and is enabled
            }
            return self::DISABLED; //Command found, and is disabled
        }
        return self::NOT_FOUND; //Command not found
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
        $info = [
            "CWD" => getcwd(),
            "GID" => getmygid(),
            "PID" => getmypid(),
            "UID" => getmyuid(),
            "Memory-usage" => memory_get_usage(true),
            "Memory-peak-usage" => memory_get_peak_usage(true),
            "Version" => phpversion()
        ];
        $sender->sendMessage("PHP information:");
        foreach($info as $key => $value){
            $sender->sendMessage($key.": ".$value);
        }
    }
    /**
     * @param CommandSender $sender
     */
    public function sendZendInfo(CommandSender $sender){
        $info = [
            "Version" => zend_version()
        ];
        $sender->sendMessage("Zend information:");
        foreach($info as $key => $value){
            $sender->sendMessage($key.": ".$value);
        }
    }
}