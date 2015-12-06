<?php

namespace easymessages\task;

use easymessages\utils\Utils;
use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class AutoMessageTask extends PluginTask{
    /** @var EasyMessages */
    private $plugin;
    /**
     * @param EasyMessages $plugin
     */
    public function __construct(EasyMessages $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    /** 
     * @return EasyMessages 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param int $currentTick
     */
    public function onRun($currentTick){
        $this->getPlugin()->getServer()->broadcastMessage(Utils::getRandom($this->getPlugin()->getConfig()->getNested("message.messages")));
    }
}
