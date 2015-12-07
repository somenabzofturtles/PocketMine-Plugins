<?php

namespace queryfacade\task;

use pocketmine\scheduler\PluginTask;
use queryfacade\task\QueryServerTask;
use queryfacade\QueryFacade;

class UpdateDataTask extends PluginTask{
    /** @var QueryFacade */
    private $plugin;
    /**
     * @param QueryFacade $plugin
     */
    public function __construct(QueryFacade $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    /**
     * @return QueryFacade
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param int $currentTick
     */
    public function onRun($currentTick){
        $this->getPlugin()->getServer()->getScheduler()->scheduleAsyncTask(new QueryServerTask($this->getPlugin()->getConfig()->get("servers"), $this->getPlugin()->getConfig()->get("timeout")));
    }
}