<?php

namespace planb\command;

use planb\PlanB;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;

class PlanBCommand extends Command{
    /** @var PlanB */
    private $plugin;
    /**
     * @param PlanB $plugin
     */
    public function __construct(PlanB $plugin){
        parent::__construct("planb");
        $this->setDescription("Shows all PlanB commands");
        $this->setUsage("/planb <sub-command> [parameters]");
        $this->setPermission("planb.command.planb");
        $this->setAliases(["pb"]);
        $this->plugin = $plugin;
    }
    /**  
     * @return PlanB  
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param CommandSender $sender 
     */
    private function sendCommandHelp(CommandSender $sender){
        $commands = [
            "addbackup" => "Adds a player to backups.txt",
            "delbackup" => "Removes a player from backups.txt",
            "help" => "Shows all PlanB commands",
            "list" => "Lists all backup players",
            "restore" => "Restores OP status of all online players listed in backup.txt"
        ];
        $sender->sendMessage("PlanB commands:");
        foreach($commands as $name => $description){
            $sender->sendMessage("/planb ".$name.": ".$description);
        }
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     */
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "ab":
                case "addbackup":
                    if(isset($args[1])){
                        if($sender instanceof ConsoleCommandSender){
                            if($this->getPlugin()->isBackupPlayer($args[1])){
                                $sender->sendMessage(TextFormat::RED.$args[1]." already exists in backups.txt.");
                            }
                            else{
                                $this->getPlugin()->addBackup($args[1]);
                                $sender->sendMessage(TextFormat::GREEN."Added ".$args[1]." to backups.txt.");
                            }
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Please run this command on the console.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a valid player."); 
                    }
                    break;
                case "db":
                case "delbackup":
                    if(isset($args[1])){
                        if($sender instanceof ConsoleCommandSender){
                            if($this->getPlugin()->isBackupPlayer($args[1])){
                                $this->getPlugin()->removeBackup($args[1]);
                                $sender->sendMessage(TextFormat::GREEN."Removed ".$args[1]." from backups.txt.");
                            }
                            else{
                                $sender->sendMessage(TextFormat::RED.$args[1]." does not exist in backups.txt.");
                            }
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Please run this command on the console.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a valid player.");
                    }
                    break;
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "list":
                    $this->getPlugin()->sendBackups($sender);
                    break;
                case "restore":
                    if($this->getPlugin()->isBackupPlayer($sender->getName()) or $sender instanceof ConsoleCommandSender){
                        $this->getPlugin()->restoreOps();
                        $sender->sendMessage(TextFormat::YELLOW."Restoring the statuses of OPs...");
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."You do not not have permissions to restore OPs.");
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
