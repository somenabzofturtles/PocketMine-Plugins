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
        if($this->getPlugin()->isApplicable(QueryFacade::PLUGINS)) $event->setPlugins($this->getPlugin()->getModifier()->getPlugins());
        //var_dump($event->getPlugins());
        if($this->getPlugin()->isApplicable(QueryFacade::PLAYERS)) $event->setPlayerList($this->getPlugin()->getModifier()->getPlayers());
        //var_dump($event->getPlayerList());
        if($this->getPlugin()->isApplicable(QueryFacade::COUNT)) $event->setPlayerCount($this->getPlugin()->getModifier()->getPlayerCount());
        //var_dump($event->getPlayerCount());
        if($this->getPlugin()->isApplicable(QueryFacade::MAX_COUNT)) $event->setMaxPlayerCount($this->getPlugin()->getModifier()->getMaxPlayerCount());
        //var_dump($event->getMaxPlayerCount());
        if($this->getPlugin()->isApplicable(QueryFacade::MAP)) $event->setWorld($this->getPlugin()->getModifier()->getLevelName());
        //var_dump($event->getWorld());
        //var_dump($event->getExtraData());
        //var_dump($event->getLongQuery());
        //var_dump($event->getShortQuery());
    }
}
