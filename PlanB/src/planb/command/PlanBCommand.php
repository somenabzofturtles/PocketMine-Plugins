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
    public function __construct(PlanB $plugin){
        parent::__construct("planb");
        $this->setDescription("Shows all the sub-commands for PlanB");
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
        $sender->sendMessage("PlanB commands:");
        $sender->sendMessage("/planb addbackup: Adds a player to backups.txt");
        $sender->sendMessage("/planb delbackup: Removes a player from backups.txt");
        $sender->sendMessage("/planb help: Shows all the sub-commands for PlanB");
        $sender->sendMessage("/planb list: Lists all backup players");
        $sender->sendMessage("/planb restore: Restores OP status of all online players listed in backup.txt");
    }
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
                case "?":
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
