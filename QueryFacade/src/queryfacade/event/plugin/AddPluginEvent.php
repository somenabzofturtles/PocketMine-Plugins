<?php

namespace queryfacade\event\plugin;

use queryfacade\event\plugin\QueryFacadeEvent;
use queryfacade\network\DummyPlugin;

class AddPluginEvent extends QueryFacadeEvent{
    /** @var \pocketmine\event\HandlerList */
    public static $handlerList = null;
    /** @var DummyPlugin */
    private $plugin;
    /**
     * @param DummyPlugin $plugin
     */
    public function __construct(DummyPlugin $plugin){
        $this->plugin = $plugin;
    }
    /**
     * @return DummyPlugin
     */
    public function getPlugin(){
        return $this->plugin;
    }
}