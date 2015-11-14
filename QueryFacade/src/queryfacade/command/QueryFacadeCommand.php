<?php

namespace queryfacade\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use queryfacade\QueryFacade;

class QueryFacadeCommand extends Command{
    /** @var QueryFacade */
    private $plugin;
    /**
     * @param QueryFacade $plugin
     */
    public function __construct(QueryFacade $plugin){
        parent::__construct("queryfacade");
        $this->setDescription("Shows all QueryFacade commands");
        $this->setUsage("/queryfacade <sub-command> [parameters]");
        $this->setPermission("queryfacade.command.queryfacade");
        $this->setAliases(["qf"]);
        $this->plugin = $plugin;
    }
    /** 
     * @return QueryFacade 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param CommandSender $sender 
     */
    private function sendCommandHelp(CommandSender $sender){
        $commands = [
            "help" => "Shows all QueryFacade commands",
            "info" => "Sends server's query information",
            "level" => "Changes the server's current default level",
            "maxplayercount" => "Changes the server's max player count",
            "playercount" => "Changes the server's player count"
        ];
        $sender->sendMessage("QueryFacade commands:");
        foreach($commands as $name => $description){
            $sender->sendMessage("/queryfacade ".$name.": ".$description);
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
                case "info":
                    //TODO: Fully implement command
                    return true;
                case "level":
                    if(isset($args[1])){
                        $this->getPlugin()->getModifier()->setLevelName($args[1]);
                        $sender->sendMessage(TextFormat::GREEN."Set level name to \"".$args[1]."\".");
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a name.");
                    }
                    return true;
                case "mpc":
                case "maxplayercount":
                    if(isset($args[1])){
                        if(is_numeric($args[1])){
                            $this->getPlugin()->getModifier()->setMaxPlayerCount($args[1]);
                            $sender->sendMessage(TextFormat::GREEN."Set max player count to ".$args[1].".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."The specified amount is not an integer.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a valid amount.");
                    }
                    return true;
                case "pc":
                case "playercount":
                    if(isset($args[1])){
                        if(is_numeric($args[1])){
                            $this->getPlugin()->getModifier()->setPlayerCount($args[1]);
                            $sender->sendMessage(TextFormat::GREEN."Set player count to ".$args[1].".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."The specified amount is not an integer.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a valid amount.");
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
