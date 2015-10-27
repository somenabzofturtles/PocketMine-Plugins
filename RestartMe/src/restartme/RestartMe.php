<?php

namespace restartme;

use pocketmine\plugin\PluginBase;
use restartme\command\RestartMeCommand;
use restartme\task\AutoBroadcastTask;
use restartme\task\CheckMemoryTask;
use restartme\task\RestartServerTask;

class RestartMe extends PluginBase{
    const TYPE_NORMAL = 0;
    const TYPE_OVERLOADED = 1;
    /** @var int */
    public $timer = 0;
    /** @var bool */
    public $paused = false;
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("restartme", new RestartMeCommand($this));
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoBroadcastTask($this), ($this->getConfig()->getNested("restart.broadcastInterval") * 20));
        if($this->getConfig()->get("restartOnOverload") === true){
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new CheckMemoryTask($this), 6000);
            $this->getServer()->getLogger()->notice("Memory overload restarts are enabled. If memory usage goes above ".$this->getMemoryLimit().", the server will restart.");
        }
        else{
            $this->getServer()->getLogger()->notice("Memory overload restarts are disabled.");
        }
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new RestartServerTask($this), 20);
    	$this->setTime($this->getConfig()->get("restartInterval") * 60);
    }
    /** 
     * @return int 
     */
    public function getTime(){
    	return $this->timer;
    }
    /**
     * @return string
     */
    public function getFormattedTime(){
        $time = $this->toArray();
        return $time[0]." hr ".$time[1]." min ".$time[2]." sec";
    }
    /**
     * @return array
     */
    public function toArray(){
        return [
            floor($this->getTime() / 3600), //hour
            floor(($this->getTime() / 60) - (floor($this->getTime() / 3600) * 60)), //minute
            floor($this->getTime() % 60) //second
        ];
    }
    /** 
     * @param int $seconds 
     */
    public function setTime($seconds){
    	$this->timer = (int) $seconds;
    }
    /** 
     * @param int $seconds 
     */
    public function addTime($seconds){
    	if(is_numeric($seconds)) $this->timer += (int) $seconds;
    }
    /** 
     * @param int $seconds 
     */
    public function subtractTime($seconds){
    	if(is_numeric($seconds)) $this->timer -= (int) $seconds;
    }
    /** 
     * @param string $messageType 
     */
    public function broadcastTime($messageType){
        $message = str_replace("{RESTART_TIME}", $this->getTime(), $this->getConfig()->get("countdownMessage"));
        switch(strtolower($messageType)){
            case "chat":
                $this->getServer()->broadcastMessage($message);
                break;
            case "popup":
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->sendPopup($message);
                }
                break;
            case "tip":
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->sendTip($message);
                }
                break;
        }
    }
    /** 
     * @param int $mode 
     */
    public function initiateRestart($mode){
        switch($mode){
            case self::TYPE_NORMAL:
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->close("", $this->getConfig()->get("quitMessage"));
                }
                $this->getServer()->getLogger()->info($this->getConfig()->get("quitMessage"));
                break;
            case self::TYPE_OVERLOADED:
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->close("", $this->getConfig()->get("overloadQuitMessage"));
                }
                $this->getServer()->getLogger()->info($this->getConfig()->get("overloadQuitMessage"));
                break;
        }
        $this->getServer()->shutdown();
    }
    /**
     * @return bool
     */
    public function isTimerPaused(){
        return $this->paused === true;
    }
    /**
     * @param bool $value
     */
    public function setPaused($value = true){
        $this->paused = (bool) $value;
    }
    /**
     * @return string
     */
    public function getMemoryLimit(){
        return strtoupper($this->getConfig()->get("memoryLimit"));
    }
}