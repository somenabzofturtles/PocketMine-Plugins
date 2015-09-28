<?php

namespace imanager\command;

use imanager\iManager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Player;

class iManagerCommand extends Command{
    /** @var iManager */
    private $plugin;
    /**
     * @param iManager $plugin
     */
    public function __construct(iManager $plugin){
        parent::__construct("imanager");
        $this->setDescription("Shows all the sub-commands for iManager");
        $this->setUsage("/imanager <sub-command> [parameters]");
        $this->setPermission("imanager.command.imanager");
        $this->setAliases(["im"]);
    	$this->plugin = $plugin;
    }
    /**
     * @return iManager
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param CommandSender $sender
     */
    private function sendCommandHelp(CommandSender $sender){
    	$sender->sendMessage("iManager commands:");
    	$sender->sendMessage("/imanager addexempt: Adds a player's name to exempt.txt");
    	$sender->sendMessage("/imanager addip: Adds a player's IP address to ip.txt");
    	$sender->sendMessage("/imanager addresslist: Lists every player's IP address and port");
    	$sender->sendMessage("/imanager attackall: Attacks all the players in the server");
        $sender->sendMessage("/imanager block: Gets info about a block");
    	$sender->sendMessage("/imanager burn: Burns a player");
    	$sender->sendMessage("/imanager delexempt: Removes a player's name from exempt.txt");
    	$sender->sendMessage("/imanager delip: Removes a player's IP address from ip.txt");
    	$sender->sendMessage("/imanager deopall: Revokes all the player's OP status");
        $sender->sendMessage("/imanager entity: Gets info about an entity");
    	$sender->sendMessage("/imanager giveall: Gives the specified item to all players in the server");
    	$sender->sendMessage("/imanager heal: Heals a players");
    	$sender->sendMessage("/imanager help: Shows all the sub-commands for iManager");
    	$sender->sendMessage("/imanager info: Gets all the information about a player");
    	$sender->sendMessage("/imanager kickall: Kicks all the players without EXEMPT status from the server");
    	$sender->sendMessage("/imanager killall: Kills all the players without EXEMPT status in the server");
        $sender->sendMessage("/imanager level: Gets info about a level");
    	$sender->sendMessage("/imanager opall: Grants OP status to everyone in the server");
    	$sender->sendMessage("/imanager ops: Lists all the OPs");
        $sender->sendMessage("/imanager player: Gets info about a player");
    	$sender->sendMessage("/imanager server: Gets info about the server");
        $sender->sendMessage("/imanager transferall: Transfers all players in the server without EXEMPT status to the specified server");
    	$sender->sendMessage("/imanager warpall: Teleports all players in the server without EXEMPT status to the given location");
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     */
    public function execute(CommandSender $sender, $label, array $args){
    	if(isset($args[0])){
    	    switch(strtolower($args[0])){
                case "?":
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "level":
                    if(isset($args[1])){
                        if($sender->getServer()->getLevelByName($args[1]) !== null){
                            $this->getPlugin()->getInfoFetcher()->sendLevelInfo($sender, $sender->getServer()->getLevelByName($args[1]));
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to get information due to invalid level name.");
                        } 
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a level name.");
                    }
                    break;
                case "player":
                    if(isset($args[1])){
                        if($sender->getServer()->getPlayer($args[1]) !== null){
                            $this->getPlugin()->getInfoFetcher()->sendPlayerInfo($sender, $sender->getServer()->getPlayer($args[1]));
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to get information due to invalid recipient.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    break;
                default:
                    $sender->sendMessage("Usage: ".$this->getUsage());
    	    }
    	}
    	else{
	    $this->sendCommandHelp($sender);
    	}
    }
}
