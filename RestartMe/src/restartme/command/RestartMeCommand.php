<?php

namespace restartme\command;

use restartme\RestartMe;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\utils\TextFormat;

class RestartMeCommand extends Command implements PluginIdentifiableCommand{
    /** @var RestartMe */
    private $plugin;
    public function __construct(RestartMe $plugin){
        parent::__construct("restartme");
        $this->setDescription("Shows all the sub-commands for RestartMe");
        $this->setUsage("/restartme <sub-command> [parameters]");
        $this->setPermission("restartme.command.restartme");
        $this->setAliases(["rm"]);
        $this->plugin = $plugin;
    }
    /** 
     * @return RestartMe 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param CommandSender $sender 
     */
    private function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("RestartMe commands:");
        $sender->sendMessage("/restartme add: Delays the server restart by n seconds");
        $sender->sendMessage("/restartme help: Shows all the sub-commands for RestartMe");
        $sender->sendMessage("/restartme subtract: Advances the server restart by n seconds");
        $sender->sendMessage("/restartme time: Gets the remaining time until the server restarts");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "add":
                    break;
                case "?":
                case "help":
                    break;
                case "subtract":
                    break;
                case "time":
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}