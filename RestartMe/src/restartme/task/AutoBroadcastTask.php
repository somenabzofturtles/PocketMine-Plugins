<?php

namespace restartme\task;

use pocketmine\scheduler\PluginTask;
use restartme\RestartMe;

class AutoBroadcastTask extends PluginTask{
    /** @var RestartMe */
    private $plugin;
    /**
     * @param RestartMe $plugin
     */
    public function __construct(RestartMe $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    /** 
     * @return RestartMe 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param int $currentTick
     */
    public function onRun($currentTick){
        if(!$this->getPlugin()->isTimerPaused()){
            if($this->getPlugin()->getTime() >= $this->getPlugin()->getConfig()->getNested("restart.startCountdown")){
                $this->getPlugin()->broadcastTime($this->getPlugin()->getConfig()->getNested("restart.displayType"));
            }
        }
    }
}