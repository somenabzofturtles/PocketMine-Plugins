<?php

namespace easymessages\event;

use easymessages\EasyMessages;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;

class EasyMessagesListener implements Listener{
    /** @var EasyMessages */
    private $plugin;
    /**
     * @param EasyMessages $plugin
     */
    public function __construct(EasyMessages $plugin){
        $this->plugin = $plugin;
    }
    /** 
     * @return EasyMessages 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param PlayerChatEvent $event
     * @priority MONITOR
     */
    public function onPlayerChat(PlayerChatEvent $event){
        if(!$this->getPlugin()->getConfig()->getNested("color.colorChat") and !$event->getPlayer()->hasPermission("easymessages.action.color")){
            $event->setMessage($this->getPlugin()->replaceSymbols($event->getMessage(), true));
        }
    }
}
