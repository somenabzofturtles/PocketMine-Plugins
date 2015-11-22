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
        parent::__construct("queryfacade", "Shows all QueryFacade commands", null, ["qf"]);
        $this->setPermission("queryfacade.command.queryfacade");
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
            "level" => "Changes the server's current default level",
            "maxplayercount" => "Changes the server's max player count",
            "playercount" => "Changes the server's player count",
            "players" => "Returns a list of players being sent in query",
            "plugins" => "Returns a list of plugins being sent in query"
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
                case "level":
                    if(isset($args[1])){
                        if($this->getPlugin()->isApplicable(QueryFacade::MAP)){
                            $this->getPlugin()->getModifier()->setLevelName($args[1]);
                            $sender->sendMessage(TextFormat::GREEN."Set level name to \"".$args[1]."\", change will be applied in the next query.");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Map cloak is not enabled.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::YELLOW."Current map name is \"".$this->getPlugin()->getServer()->getQueryInformation()->getWorld()."\".");
                    }
                    return true;
                case "mpc":
                case "maxplayercount":
                    if(isset($args[1])){
                        if(is_numeric($args[1])){
                            if($this->getPlugin()->isApplicable(QueryFacade::MAX_COUNT)){
                                $this->getPlugin()->getModifier()->setMaxPlayerCount($args[1]);
                                $sender->sendMessage(TextFormat::GREEN."Set max player count to ".$args[1].", change will be applied in the next query.");
                            }
                            else{
                                $sender->sendMessage(TextFormat::RED."Max player count cloak is not enabled.");
                            }
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."The specified amount is not an integer.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::YELLOW."Current max player count is ".$this->getPlugin()->getServer()->getQueryInformation()->getMaxPlayerCount().".");
                    }
                    return true;
                case "pc":
                case "playercount":
                    if(isset($args[1])){
                        if(is_numeric($args[1])){
                            if($this->getPlugin()->isApplicable(QueryFacade::MAX_COUNT)){
                                $this->getPlugin()->getModifier()->setPlayerCount($args[1]);
                                $sender->sendMessage(TextFormat::GREEN."Set player count to ".$args[1].", change will be applied in the next query.");
                            }
                            else{
                                $sender->sendMessage(TextFormat::RED."Player count cloak is not enabled.");
                            }
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."The specified amount is not an integer.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::YELLOW."Current player count is ".$this->getPlugin()->getServer()->getQueryInformation()->getPlayerCount().".");
                    }
                    return true;
                case "players":
                    $modifier = $this->getPlugin()->getModifier();
                    $sender->sendMessage(TextFormat::YELLOW."There are currently ".count($modifier->getPlayers())." players: ".$modifier->listPlayers().".");
                    return true;
                case "plugins":
                    $modifier = $this->getPlugin()->getModifier();
                    $sender->sendMessage(TextFormat::YELLOW."There are currently ".count($modifier->getPlugins())." plugins: ".$modifier->listPlugins().".");
                    return true;
                default:
                    $sender->sendMessage("Usage: /queryfacade <sub-command> [parameters]");
                    return false;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return false;
        }
    }
}
