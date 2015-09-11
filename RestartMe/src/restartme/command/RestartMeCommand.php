<?php

namespace restartme\command;

use restartme\RestartMe;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
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
        $sender->sendMessage("/restartme set: Sets the timer to n seconds");
        $sender->sendMessage("/restartme subtract: Advances the server restart by n seconds");
        $sender->sendMessage("/restartme time: Gets the remaining time until the server restarts");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "add":
                    if(isset($args[1])){
                        if(is_numeric($args[1])){
                            $floorTime = floor($args[1]);
                            $this->getPlugin()->addTime($floorTime);
                            $sender->sendMessage(TextFormat::GREEN."Added ".$floorTime." to restart timer.");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Time value must be numeric.");
                        } 
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a time value.");
                    }
                    break;
                case "?":
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "set":
                    if(isset($args[1])){
                        if(is_numeric($args[1])){
                            $floorTime = floor($args[1]);
                            $this->getPlugin()->setTime($floorTime);
                            $sender->sendMessage(TextFormat::GREEN."Set restart timer to ".$floorTime.".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Time value must be numeric.");
                        } 
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a time value.");
                    }
                    break;
                case "subtract":
                    if(isset($args[1])){
                        if(is_numeric($args[1])){
                            $floorTime = floor($args[1]);
                            $this->getPlugin()->subtractTime($floorTime);
                            $sender->sendMessage(TextFormat::GREEN."Subtracted ".$floorTime." from restart timer.");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Time value must be numeric.");
                        } 
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a time value.");
                    }
                    break;
                case "time":
                    $sender->sendMessage(TextFormat::YELLOW."Time left: ".$this->getPlugin()->getFormattedTime());
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