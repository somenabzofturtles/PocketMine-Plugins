<?php

namespace rapidcmd\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
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
        $sender->sendMessage("/rapidcmd list: Returns a list of names of loaded RCMDs");
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
                    if(isset($args[1]) and isset($args[2])){
                        if(is_numeric($args[1])){
                            $command = implode(" ", array_slice($args, 2));
                            $this->getPlugin()->runLater($command, $args[1]);
                            $sender->sendMessage(TextFormat::GREEN."Command \"".$command."\" will be run in ".$args[1]." seconds.");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Time value must be an integer.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Insufficient parameters given, this command requires a time value and a command to execute.");
                    }
                    break;
                case "as":
                    break;
                case "cmd":
                    break;
                case "dc":
                case "delcmd":
                    if(isset($args[1])){
                        if($this->getPlugin()->getCommandStorage()->removeCommand($args[1])){
                            $sender->sendMessage(TextFormat::GREEN."Successfully disabled RCMD: ".strtolower($args[1]).".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to remove due to nonexistent command specified.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a command name.");
                    }
                    break;
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "list":
                    $count = 0;
                    $names = "";
                    foreach($this->getPlugin()->getCommandStorage()->getCommands() as $command){
                        $names .= $command->getName().", ";
                        $count++;
                    }
                    $sender->sendMessage("RCMDs (".$count."): ".substr($names, 0, -2));
                    break;
                case "repeat":
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