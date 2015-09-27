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
        $event->setPlugins($this->getPlugin()->getCloakPlugins());
        $event->setPlayerList($this->getPlugin()->getCloakPlayerList());
        $event->setPlayerCount($this->getPlugin()->getCloakPlayerCount());
        $event->setMaxPlayerCount($this->getPlugin()->getCloakMaxPlayerCount());
        $event->setWorld($this->getPlugin()->getCloakLevel());
    }
}
