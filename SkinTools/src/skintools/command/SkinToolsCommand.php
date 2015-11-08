<?php

namespace skintools\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use skintools\utils\SkinConverter;
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
        $commands = [
            "file" => "Saves the specified player's skin as a data file",
            "help" => "Shows all SkinTools commands",
            "image" => "Saves the specified player's skin as an image",
            "morph" => "Sets user's skin to that of the specified player's",
            "restore" => "Restores user's skin to the skin they joined with",
            "swap" => "Swaps skins with the specified player",
            "touch" => "Toggles touch mode"
        ];
        $sender->sendMessage("SkinTools commands:");
        foreach($commands as $name => $description){
            $sender->sendMessage("/skintools ".$name.": ".$description);
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
                case "file":
                    if(isset($args[1])){
                        if($player = $sender->getServer()->getPlayer($args[1])){
                            SkinConverter::toFile($player);
                            $sender->sendMessage(TextFormat::GREEN."Saved ".$player->getName()."'s skin as a data file.");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."That player could not be found.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a valid player.");
                    }
                    return true;
                case "help":
                    $this->sendCommandHelp($sender);
                    return true;
                case "image":
                    //TODO: Fully implement command
                    return true;
                case "morph":
                    if($sender instanceof Player){
                        if(isset($args[1])){
                            if($player = $sender->getServer()->getPlayer($args[1])){
                                $this->getPlugin()->setStolenSkin($sender, $player);
                                $sender->sendMessage(TextFormat::GREEN."You got ".$player->getName()."'s skin.");
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
                    return true;
                case "restore":
                    if($sender instanceof Player){
                        $sender->setSkin($this->getPlugin()->retrieveSkinData($sender));
                        $sender->sendMessage(TextFormat::GREEN."Your original skin has been restored.");
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please run this command in-game.");
                    }
                    return true;
                case "swap":
                    if($sender instanceof Player){
                        //TODO: Fully implement command
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please run this command in-game.");
                    }
                    return true;
                case "touch":
                    if($sender instanceof Player){
                        if(isset($args[1])){
                            //TODO: Fully implement command
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Please specify a touch mode.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please run this command in-game.");
                    }
                    return true;
                default:
                    $sender->sendMessage("Usage: ".$this->getUsage());
                    return false;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return false;
        }
    }
}
