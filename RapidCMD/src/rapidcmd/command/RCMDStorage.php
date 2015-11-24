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
                    $this->getPlugin()->getServer()->getPluginManager()->addPermission(new Permission($rcmd->getPermNode(), $rcmd->getDescription(), $rcmd->getPermValue()));
                    $count++;
                }
            }
            $this->getPlugin()->getServer()->getLogger()->info("Loaded ".$count."/".count($commands)." RCMD(s).");
            //var_dump($this->getCommands(), $count);
        }
        else{
            $this->getPlugin()->getServer()->getLogger()->critical("Failed to load RCMD(s), please make sure the config file is properly set up.");
        }
    }
    /**
     * @return RCMD[]
     */
    public function getCommands(){
        return $this->commands;
    }
    /**
     * @param RCMD $command
     * @return bool
     */
    public function addCommand(RCMD $command){
        if(!$this->isCommandStored($command->getName())){
            $this->commands[strtolower($command->getName())] = $command;
            return true;
        }
        return false;
    }
    /**
     * @param RCMD $command
     * @return bool
     */
    public function removeCommand($command){
        if($this->isCommandStored($command)){
            unset($this->commands[strtolower($command)]);
            return true;
        }
        return false;
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