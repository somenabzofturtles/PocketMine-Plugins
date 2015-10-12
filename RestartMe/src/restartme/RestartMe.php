<?php

namespace restartme;

use pocketmine\plugin\PluginBase;
use restartme\command\RestartMeCommand;
use restartme\task\AutoBroadcastTask;
use restartme\task\CheckMemoryTask;
use restartme\task\RestartServerTask;

class RestartMe extends PluginBase{
    /** @const int */
    const TYPE_NORMAL = 0;
    /** @const int */
    const TYPE_OVERLOADED = 1;
    /** @var int */
    public $timer = 0;
    /** @var bool */
    public $paused = false;
    public function onEnable(){
        $this->saveFiles();
        $this->registerAll();
    }
    private function saveFiles(){
        if(file_exists($this->getDataFolder()."config.yml")){
            if($this->getConfig()->get("version") !== $this->getDescription()->getVersion() or !$this->getConfig()->exists("version")){
		$this->getServer()->getLogger()->warning("An invalid configuration file for ".$this->getDescription()->getName()." was detected.");
		if($this->getConfig()->getNested("plugin.autoUpdate") === true){
		    $this->saveResource("config.yml", true);
                    $this->getServer()->getLogger()->warning("Successfully updated the configuration file for ".$this->getDescription()->getName()." to v".$this->getDescription()->getVersion().".");
		}
	    }  
        }
        else{
            $this->saveDefaultConfig();
            $this->getServer()->getLogger()->warning("Remember to use a server restarter script, or else this plugin won't work properly.");
        }
    }
    private function registerAll(){
    	$this->setTime($this->getConfig()->getNested("restart.restartInterval") * 60);
        $this->getServer()->getCommandMap()->register("restartme", new RestartMeCommand($this));
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoBroadcastTask($this), ($this->getConfig()->getNested("restart.broadcastInterval") * 20));
        if($this->getConfig()->getNested("restart.restartOnOverload") === true){
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new CheckMemoryTask($this), 6000);
            $this->getServer()->getLogger()->notice("Memory overload restarts are enabled. If memory usage goes above ".$this->getMemoryLimit().", the server will restart.");
        }
        else{
            $this->getServer()->getLogger()->notice("Memory overload restarts are disabled.");
        }
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new RestartServerTask($this), 20);
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
        $hour = floor($this->getTime() / 3600);
        $minute = floor(($this->getTime() / 60) - ($hour * 60));
        $second = floor($this->getTime() % 60);
        return $hour." hr ".$minute." min ".$second." sec";
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
        $message = str_replace("{RESTART_TIME}", $this->getTime(), $this->getConfig()->getNested("restart.countdownMessage"));
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
                    $player->close("", $this->getConfig()->getNested("restart.quitMessage"));
                }
                $this->getServer()->getLogger()->info($this->getConfig()->getNested("restart.quitMessage"));
                break;
            case self::TYPE_OVERLOADED:
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->close("", $this->getConfig()->getNested("restart.overloadQuitMessage"));
                }
                $this->getServer()->getLogger()->info($this->getConfig()->getNested("restart.overloadQuitMessage"));
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
        return strtoupper($this->getConfig()->getNested("restart.memoryLimit"));
    }
}