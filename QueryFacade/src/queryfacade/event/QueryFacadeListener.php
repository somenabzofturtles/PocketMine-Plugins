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
     * @param QueryRegenerateEvent $event 
     * @priority HIGHEST
     */
    public function onQueryRegenerate(QueryRegenerateEvent $event){
        if($this->plugin->isApplicable(QueryFacade::PLUGINS)) $event->setPlugins($this->plugin->getModifier()->getPlugins());
        //var_dump($event->getPlugins());
        if($this->plugin->isApplicable(QueryFacade::PLAYERS)) $event->setPlayerList($this->plugin->getModifier()->getPlayers());
        //var_dump($event->getPlayerList());
        if($this->plugin->isApplicable(QueryFacade::COUNT)) $event->setPlayerCount($this->plugin->getModifier()->getPlayerCount());
        //var_dump($event->getPlayerCount());
        if($this->plugin->isApplicable(QueryFacade::MAX_COUNT)) $event->setMaxPlayerCount($this->plugin->getModifier()->getMaxPlayerCount());
        //var_dump($event->getMaxPlayerCount());
        if($this->plugin->isApplicable(QueryFacade::MAP)) $event->setWorld($this->plugin->getModifier()->getWorld());
        //var_dump($event->getWorld());
        //var_dump($event->getExtraData());
        //var_dump($event->getLongQuery());
        //var_dump($event->getShortQuery());
    }
}
