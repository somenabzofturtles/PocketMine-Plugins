<?php

namespace queryfacade\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use queryfacade\QueryFacade;

class QueryFacadeCommand extends Command{
    /** @var QueryFacade */
    private $plugin;
    /**
     * @param QueryFacade $plugin
     */
    public function __construct(QueryFacade $plugin){
        parent::__construct("queryfacade");
        $this->setDescription("Shows all the sub-commands for QueryFacade");
        $this->setUsage("/queryfacade <sub-commands> [parameters]");
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
        $sender->sendMessage("QueryFacade commands:");
        $sender->sendMessage("/queryfacade help: Shows all the sub-commands for QueryFacade");
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
                default:
                    $sender->sendMessage("Usage: ".$this->getUsage());
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}
