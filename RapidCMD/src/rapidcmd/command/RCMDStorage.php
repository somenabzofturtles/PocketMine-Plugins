<?php

namespace rapidcmd\command;

use pocketmine\permission\Permission;
use rapidcmd\command\RCMD;
use rapidcmd\RapidCMD;

class RCMDStorage{
    /** @var RapidCMD */
    private $plugin;
    /** @var RCMD[] */
    private $commands = [];
    /**
     * @param RapidCMD $plugin
     */
    public function __construct(RapidCMD $plugin){
        $this->plugin = $plugin;
    }
    /**
     * @return RapidCMD
     */
    public function getPlugin(){
        return $this->plugin;
    }
    public function registerDefaults(){
        $successCount = 0;
        $failCount = 0;
        $commands = $this->getPlugin()->getConfig()->get("commands");
        if(is_array($commands)){
            $count = 0;
            foreach($commands as $command){
                if(!$this->isCommandStored($command["name"])){
                    $rcmd = new RCMD(strtolower($command["name"]));
                    $rcmd->setDescription($command["description"]);
                    $rcmd->setPermNode(strtolower($command["permission"]));
                    $rcmd->setPermValue(strtolower($command["value"]));
                    $rcmd->setActions($command["actions"]);
                    $this->addCommand($rcmd);
                    $permission = new Permission($rcmd->getPermNode(), $rcmd->getDescription(), $rcmd->getPermValue());
                    $this->getPlugin()->getServer()->getPluginManager()->addPermission($permission);
                    $count++;
                }
            }
            $this->getPlugin()->getServer()->getLogger()->info("Loaded ".$count."/".count($commands)." RCMD(s).");
        }
        else{
            $this->getPlugin()->getServer()->getLogger()->critical("Failed to load RCMD(s), please make sure the config file is properly set up.");
        }
    }
    /**
     * @param RCMD $command
     */
    public function addCommand(RCMD $command){
        if(!$this->isCommandStored($command->getName())){
            $this->commands[strtolower($command->getName())] = $command;
        }
    }
    /**
     * @param RCMD $command
     */
    public function removeCommand(RCMD $command){
        if($this->isCommandStored($command->getName())){
            unset($this->commands[strtolower($command->getName())]);
        }
    }
    /**
     * @param string $name
     * @return RCMD|bool
     */
    public function getCommand($name){
        if($this->isCommandStored($name)){
            return $this->commands[strtolower($name)];
        }
        return false;
    }
    /**
     * @param string $name
     * @return bool
     */
    public function isCommandStored($name){
        return isset($this->commands[strtolower($name)]);
    }
}