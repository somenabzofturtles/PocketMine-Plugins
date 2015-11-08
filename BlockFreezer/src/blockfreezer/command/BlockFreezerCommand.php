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
                case "ab";
                case "addblock":
                    return true;
                case "db":
                case "delblock":
                    return true;
                case "help":
                    $this->sendCommandHelp($sender);
                    return true;
                default:
                    $this->sendCommandHelp($sender);
                    return false;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return false;
        }
    }
}