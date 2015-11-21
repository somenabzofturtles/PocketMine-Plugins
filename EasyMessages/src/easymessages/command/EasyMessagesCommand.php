<?php

namespace easymessages\command;

use easymessages\EasyMessages;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class EasyMessagesCommand extends Command{
    /** @var EasyMessages */
    private $plugin;
    /**
     * @param EasyMessages $plugin
     */
    public function __construct(EasyMessages $plugin){
        parent::__construct("easymessages", "Shows all EasyMessages commands", null, ["em"]);
        $this->setPermission("easymessages.command.easymessages");
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
        $commands = [
            "help" => "Shows all EasyMessages commands",
            "message" => "Sends a message",
            "popup" => "Sends a popup",
            "tip" => "Sends a tip"
        ];
        $sender->sendMessage("EasyMessages commands:");
        foreach($commands as $name => $description){
            $sender->sendMessage("/easymessages ".$name.": ".$description);
        }
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     * @return bool
     */
    public function execute(CommandSender $sender, $label, array $args){
        if(!$this->testPermission($sender)) return false;
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "help":
                    $this->sendCommandHelp($sender);
                    return true;
                case "m":
                case "message":
                    if(isset($args[1])){
                        $message = $this->getPlugin()->replaceSymbols(implode(" ", array_slice($args, 2)));
                        if(strtolower($args[1]) === "@all"){
                            $sender->getServer()->broadcastMessage($message);
                            $sender->sendMessage(TextFormat::GREEN."Sent message to @all.");
                        }
                        elseif($player = $sender->getServer()->getPlayer($args[1])){
                            $player->sendMessage($message);
                            $sender->sendMessage(TextFormat::GREEN."Sent message to ".$player->getName().".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to send message due to invalid recipient(s).");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    return true;
                case "p":
                case "popup":
                    if(isset($args[1])){
                        $popup = $this->getPlugin()->replaceSymbols(implode(" ", array_slice($args, 2)));
                        if(strtolower($args[1]) === "@all"){
                            $this->getPlugin()->broadcastPopup($popup);
                            $sender->sendMessage(TextFormat::GREEN."Sent popup to @all.");
                        }
                        elseif($player = $sender->getServer()->getPlayer($args[1])){
                            $player->sendPopup($popup);
                            $sender->sendMessage(TextFormat::GREEN."Sent popup to ".$player->getName().".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to send message due to invalid recipient(s).");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    return true;
                case "t":
                case "tip":
                    if(isset($args[1])){
                        $tip = $this->getPlugin()->replaceSymbols(implode(" ", array_slice($args, 2)));
                        if(strtolower($args[1]) === "@all"){
                            $this->getPlugin()->broadcastTip($tip);
                            $sender->sendMessage(TextFormat::GREEN."Sent tip to @all.");
                        }
                        elseif($player = $sender->getServer()->getPlayer($args[1])){
                            $player->sendTip($tip);
                            $sender->sendMessage(TextFormat::GREEN."Sent tip to ".$player->getName().".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to send message due to invalid recipient(s).");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    return true;
                default:
                    $sender->sendMessage("Usage: /easymessages <sub-command> [parameters]");
                    return false;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return false;
        }
    }
}
