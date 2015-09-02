<?php

namespace planb\command;

use planb\PlanB;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\utils\TextFormat;

class PlanBCommand extends Command implements PluginIdentifiableCommand{
    /** @var PlanB */
    private $plugin;
    public function __construct(PlanB $plugin){
        parent::__construct(
            "planb", 
            "Shows all the sub-commands for PlanB", 
            "/planb <sub-command> [parameters]", 
            array("pb")
        );
        $this->setPermission("planb.command.planb");
        $this->plugin = $plugin;
    }
    /**  @return PlanB  */
    public function getPlugin(){
        return $this->plugin;
    }
    /** @param CommandSender $sender */
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
            if(strtolower($args[0]) === "addbackup" or strtolower($args[0]) === "ab"){
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
                return true;
            }
            if(strtolower($args[0]) === "delbackup" or strtolower($args[0]) === "db"){
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
                return true;
            }
            if(strtolower($args[0]) === "help"){
                $this->sendCommandHelp($sender);
                return true;
            }
            if(strtolower($args[0]) === "list"){
                $this->getPlugin()->sendBackups($sender);
                return true;
            }
            if(strtolower($args[0]) === "restore"){
                if($this->getPlugin()->isBackupPlayer($sender->getName()) or $sender instanceof ConsoleCommandSender){
                    $this->getPlugin()->restoreOps();
                    $sender->sendMessage(TextFormat::YELLOW."Restoring the statuses of OPs...");
                }
                else{
                    $sender->sendMessage(TextFormat::RED."You do not not have permissions to restore OPs.");
                }
                return true;
            }
            else{
                $sender->sendMessage("Usage: ".$this->getUsage());
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}
