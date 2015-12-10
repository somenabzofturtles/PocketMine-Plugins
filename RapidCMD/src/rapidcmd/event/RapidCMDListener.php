<?php

namespace rapidcmd\event;

use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\RemoteServerCommandEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\event\Listener;
use rapidcmd\RapidCMD;

class RapidCMDListener implements Listener{
    /** @var RapidCMD */
    private $plugin;
    /**
     * @param RapidCMD $plugin
     */
    public function __construct(RapidCMD $plugin){
        $this->plugin = $plugin;
    }
    /**
     * @param PlayerCommandPreprocessEvent $event
     * @priority LOWEST
     * @ignoreCancelled true
     */
    public function onPlayerCommandPreprocess(PlayerCommandPreprocessEvent $event){

    }
    /**
     * @param RemoteServerCommandEvent $event
     * @priority LOWEST
     */
    public function onRemoteServerCommand(RemoteServerCommandEvent $event){
        
    }
    /**
     * @param ServerCommandEvent $event
     * @priority LOWEST
     * @ignoreCancelled true
     */
    public function onServerCommand(ServerCommandEvent $event){
        
    }
}