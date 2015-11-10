<?php

namespace rapidcmd;

use pocketmine\plugin\PluginBase;
use rapidcmd\command\RCMDStorage;
use rapidcmd\command\RapidCMDCommand;
use rapidcmd\event\RapidCMDListener;
use rapidcmd\task\RunCommandTask;

class RapidCMD extends PluginBase{
    /** @var RCMDStorage */
    private $storage;
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->storage = new RCMDStorage($this);
        $this->getServer()->getCommandMap()->register("rapidcmd", new RapidCMDCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new RapidCMDListener($this), $this);
        $this->getCommandStorage()->registerDefaults();
    }
    /**
     * @return RCMDStorage
     */
    public function getCommandStorage(){
        return $this->storage;
    }
    /**
     * @param string $command
     * @param int $delay
     */
    public function runLater($command, $delay = 3){
        $this->getServer()->getScheduler()->scheduleDelayedTask(new RunCommandTask($this, $command), ($delay * 20));
    }
}