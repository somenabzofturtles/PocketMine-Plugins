<?php

namespace blockfreezer\command;

use blockfreezer\BlockFreezer;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class BlockFreezerCommand extends Command{
    /** @var BlockFreezer */
    private $plugin;
    /**
     * @param BlockFreezer $plugin
     */
    public function __construct(BlockFreezer $plugin){
        parent::__construct("blockfreezer");
        $this->plugin = $plugin;
    }
    /**
     * @return BlockFreezer
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param CommandSender $sender
     */
    public function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("BlockFreezer commands:");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "ab";
                case "addblock":
                    break;
                case "db":
                case "delblock":
                    break;
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                default:
                    $this->sendCommandHelp($sender);
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}