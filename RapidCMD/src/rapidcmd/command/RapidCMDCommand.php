<?php

namespace rapidcmd\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use rapidcmd\RapidCMD;

class RapidCMDCommand extends Command{
    /** @var RapidCMD */
    private $plugin;
    /**
     * @param RapidCMD $plugin
     */
    public function __construct(RapidCMD $plugin){
        parent::__construct("rapidcmd");
        $this->setDescription("Shows all RapidCMD commands");
        $this->setUsage("/rapidcmd <sub-command> [parameters]");
        $this->setPermission("rapidcmd.command.rapidcmd");
        $this->setAliases(["rc"]);
        $this->plugin = $plugin;
    }
    /**
     * @return RapidCMD
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param CommandSender $sender
     */
    public function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("RapidCMD commands:");
        $sender->sendMessage("/rapidcmd addcmd: Creates a new RCMD");
        $sender->sendMessage("/rapidcmd after: Runs a command after n seconds");
        $sender->sendMessage("/rapidcmd as: Runs a command as a player");
        $sender->sendMessage("/rapidcmd cmd: Sends information about a command");
        $sender->sendMessage("/rapidcmd delcmd: Deletes a RCMD, if it exists");
        $sender->sendMessage("/rapidcmd help: Shows all RapidCMD commands");
        $sender->sendMessage("/rapidcmd repeat: Runs the user's last command, if they have one");
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     */
    public function execute(CommandSender $sender, $label, array $args) {
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "ac":
                case "addcmd":
                    break;
                case "after":
                    break;
                case "as":
                    break;
                case "cmd":
                    break;
                case "dc":
                case "delcmd":
                    break;
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                default:
                    $sender->sendMessage("Usage: ".$this->getUsage());
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}