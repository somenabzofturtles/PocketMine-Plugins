<?php

namespace rapidcmd\task;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\scheduler\PluginTask;
use rapidcmd\RapidCMD;

class RunCommandTask extends PluginTask{
    /** @var RapidCMD */
    private $plugin;
    /** @var string */
    private $command;
    /**
     * @param RapidCMD $plugin
     * @param string $command
     */
    public function __construct(RapidCMD $plugin, $command){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->command = $command;
    }
    /**
     * @return RapidCMD
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param int $currentTick
     */
    public function onRun($currentTick){
        $this->getPlugin()->getServer()->dispatchCommand(new ConsoleCommandSender(), $this->command);
        $this->getPlugin()->getServer()->getScheduler()->cancelTask($this->getTaskId());
    }
}