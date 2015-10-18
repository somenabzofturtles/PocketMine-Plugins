<?php

namespace queryfacade\event;

use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\event\Listener;
use queryfacade\QueryFacade;

class QueryFacadeListener implements Listener{
    /** @var QueryFacade */
    private $plugin;
    /**
     * @param QueryFacade $plugin
     */
    public function __construct(QueryFacade $plugin){
        $this->plugin = $plugin;
    }
    /** 
     * @return QueryFacade 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param QueryRegenerateEvent $event 
     */
    public function onQueryRegenerate(QueryRegenerateEvent $event){
        //$event->setPlugins($this->getPlugin()->getModifier());
        //$event->setPlayerList($this->getPlugin()->getModifier());
        $event->setPlayerCount($this->getPlugin()->getModifier()->getPlayerCount());
        $event->setMaxPlayerCount($this->getPlugin()->getModifier()->getMaxPlayerCount());
        $event->setWorld($this->getPlugin()->getModifier()->getLevelName());
    }
}
