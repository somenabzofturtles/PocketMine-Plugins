<?php

namespace restartme\task;

use pocketmine\scheduler\PluginTask;
use restartme\utils\MemoryChecker;
use restartme\RestartMe;

class CheckMemoryTask extends PluginTask{
    /** @var RestartMe */
    private $plugin;
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
    public function onRun($currentTick){
        if(!$this->getPlugin()->isTimerPaused()) return;
	if(memory_get_usage(true) > MemoryChecker::calculateBytes($this->getPlugin()->getMemoryLimit())){
            $this->getPlugin()->initiateRestart(RestartMe::TYPE_OVERLOADED);
	}
    }
}