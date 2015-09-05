<?php

namespace easymessages\task;

use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class UpdateMotdTask extends PluginTask{
    /** @var EasyMessages */
    private $plugin;
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
    public function onRun($currentTick){
        $this->getPlugin()->getServer()->getNetwork()->setName(str_replace(
            [
                "{SERVER_DEFAULT_LEVEL}",
                "{SERVER_MAX_PLAYER_COUNT}",
                "{SERVER_PLAYER_COUNT}",
                "{SERVER_NAME}",
                "{SERVER_PORT}",
                "{SERVER_TPS}"
            ],
            [
                $this->getPlugin()->getServer()->getDefaultLevel()->getName(),
                $this->getPlugin()->getServer()->getMaxPlayers(),
                count($this->getPlugin()->getServer()->getOnlinePlayers()),
                $this->getPlugin()->getServer()->getServerName(),
                $this->getPlugin()->getServer()->getPort(),
                $this->getPlugin()->getServer()->getTicksPerSecond()
            ],
            $this->getPlugin()->getConfig()->getNested("motd.dynamicMotd")
        ));
    }
}
