<?php

namespace skintools\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use skintools\SkinTools;

class SkinToolsCommand extends Command{
    /** @var SkinTools */
    private $plugin;
    /**
     * @param SkinTools $plugin
     */
    public function __construct(SkinTools $plugin){
        parent::__construct("skintools");
        $this->setDescription("Shows all SkinTools commands");
        $this->setUsage("/skintools <sub-command> [parameters]");
        $this->setPermission("skintools.command.skintools");
        $this->setAliases(["st"]);
        $this->plugin = $plugin;
    }
    /** 
     * @return SkinTools 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param CommandSender $sender 
     */
    private function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("SkinTools commands:");
        $sender->sendMessage("/skintools help: Shows all SkinTools commands");
        $sender->sendMessage("/skintools morph: Sets user's skin to that of the specified player's");
        $sender->sendMessage("/skintools restore: Restores user's skin to the skin they joined with");
        $sender->sendMessage("/skintools swap: Swaps skins with the specified player");
        $sender->sendMessage("/skintools touch: Toggles touch mode");
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     */
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "morph":
                    if($sender instanceof Player){
                        if(isset($args[1])){
                            if($sender->getServer()->getPlayer($args[1]) !== null){
                                $this->getPlugin()->setStolenSkin($sender, $sender->getServer()->getPlayer($args[1]));
                                $sender->sendMessage(TextFormat::GREEN."You got ".$sender->getServer()->getPlayer($args[1])->getName()."'s skin.");
                            }
                            else{
                                $sender->sendMessage(TextFormat::RED."That player could not be found.");
                            }
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Please specify a valid player.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please run this command in-game.");
                    }
                    break;
                case "restore":
                    if($sender instanceof Player){
                        $sender->setSkin($this->getPlugin()->getSkinData($sender));
                        $sender->sendMessage(TextFormat::GREEN."Your original skin has been restored.");
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please run this command in-game.");
                    }
                    break;
                case "swap":
                    if($sender instanceof Player){
                        
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please run this command in-game.");
                    }
                    break;
                case "touch":
                    if($sender instanceof Player){
                        if(isset($args[1])){
                            switch($args[1]){
                                case SkinTools::MODE_NONE:
                                case SkinTools::MODE_GIVE:
                                case SkinTools::MODE_STEAL:
                                    break;
                                default:
                                    $sender->sendMessage(TextFormat::RED."Invalid touch mode entered.");
                                    break;
                            }
                        }
                        else{
                            
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please run this command in-game.");
                    }
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
