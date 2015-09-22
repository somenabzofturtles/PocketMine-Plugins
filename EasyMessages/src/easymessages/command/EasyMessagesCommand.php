<?php

namespace easymessages\command;

use easymessages\EasyMessages;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class EasyMessagesCommand extends Command{
    /** @var EasyMessages */
    private $plugin;
    public function __construct(EasyMessages $plugin){
        parent::__construct("easymessages");
        $this->setDescription("Shows all the sub-commands for EasyMessages");
        $this->setUsage("/easymessages <sub-command> [parameters]");
        $this->setPermission("easymessages.command.easymessages");
        $this->setAliases(["em"]);
        $this->plugin = $plugin;
    }
    /** 
     * @return EasyMessages 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param CommandSender $sender 
     */
    private function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("EasyMessages commands:");
        $sender->sendMessage("/easymessages help: Shows all the sub-commands for EasyMessages");
        $sender->sendMessage("/easymessages message: Sends a message");
        $sender->sendMessage("/easymessages popup: Sends a popup");
        $sender->sendMessage("/easymessages tip: Sends a tip");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "?":
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "m":
                case "message":
                    if(isset($args[1])){
                        $message = $this->getPlugin()->replaceSymbols(implode(" ", array_slice($args, 2)));
                        if(strtolower($args[1]) === "@all"){
                            $sender->getServer()->broadcastMessage($message);
                            $sender->sendMessage(TextFormat::GREEN."Sent message to @all.");
                        }
                        elseif($sender->getServer()->getPlayer($args[1]) !== null){
                            $sender->getServer()->getPlayer($args[1])->sendMessage($message);
                            $sender->sendMessage(TextFormat::GREEN."Sent message to ".$sender->getServer()->getPlayer($args[1])->getName().".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to send message due to invalid recipient(s).");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    break;
                case "p":
                case "popup":
                    if(isset($args[1])){
                        $popup = $this->getPlugin()->replaceSymbols(implode(" ", array_slice($args, 2)));
                        if(strtolower($args[1]) === "@all"){
                            $this->getPlugin()->broadcastPopup($popup);
                            $sender->sendMessage(TextFormat::GREEN."Sent popup to @all.");
                        }
                        elseif($sender->getServer()->getPlayer($args[1]) !== null){
                            $sender->getServer()->getPlayer($args[1])->sendPopup($popup);
                            $sender->sendMessage(TextFormat::GREEN."Sent popup to ".$sender->getServer()->getPlayer($args[1])->getName().".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to send message due to invalid recipient(s).");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    break;
                case "t":
                case "tip":
                    if(isset($args[1])){
                        $tip = $this->getPlugin()->replaceSymbols(implode(" ", array_slice($args, 2)));
                        if(strtolower($args[1]) === "@all"){
                            $this->getPlugin()->broadcastTip($tip);
                            $sender->sendMessage(TextFormat::GREEN."Sent tip to @all.");
                        }
                        elseif($sender->getServer()->getPlayer($args[1]) !== null){
                            $sender->getServer()->getPlayer($args[1])->sendTip($tip);
                            $sender->sendMessage(TextFormat::GREEN."Sent tip to ".$sender->getServer()->getPlayer($args[1])->getName().".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to send message due to invalid recipient(s).");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    break;
                default:
                    $sender->sendMessage("Usage ".$this->getUsage());
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}
