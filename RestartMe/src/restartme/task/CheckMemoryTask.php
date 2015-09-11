<?php

namespace restartme\task;

use pocketmine\scheduler\PluginTask;
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
	if(memory_get_usage(true) > $this->getPlugin()->getMemoryLimit()){
            $this->getPlugin()->initiateRestart(RestartMe::TYPE_OVERLOADED);
	}
    }
}