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
        parent::__construct("blockfreezer", "Shows all BlockFreezer commands", null, ["bf"]);
        $this->setPermission("blockfreezer.command.blockfreezer");
        $this->plugin = $plugin;
    }
    /**
     * @param CommandSender $sender
     */
    public function sendCommandHelp(CommandSender $sender){
        $commands = [
            "addblock" => "",
            "delblock" => "",
            "help" => "Shows all BlockFreezer commands"
        ];
        $sender->sendMessage("BlockFreezer commands:");
        foreach($commands as $name => $description){
            $sender->sendMessage("/blockfreezer ".$name.": ".$description);
        }
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     * @return bool
     */
    public function execute(CommandSender $sender, $label, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }
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
                    $sender->sendMessage("Usage: /blockfreezer <sub-command> [parameters]");
                    return false;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return false;
        }
    }
}