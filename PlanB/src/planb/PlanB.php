<?php

namespace planb;

use planb\command\PlanBCommand;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class PlanB extends PluginBase{
    /** @var Config */
    public $backups;
    public function onEnable(){
        $this->saveFiles();
        $this->registerAll();
    }
    private function saveFiles(){
    	if(!is_dir($this->getDataFolder())) mkdir($this->getDataFolder());
        if(file_exists($this->getDataFolder()."config.yml")){
            if($this->getConfig()->get("version") !== $this->getDescription()->getVersion() or !$this->getConfig()->exists("version")){
		$this->getServer()->getLogger()->warning("An invalid configuration file for ".$this->getDescription()->getName()." was detected.");
		if($this->getConfig()->getNested("plugin.autoUpdate") === true){
		    $this->saveResource("config.yml", true);
                    $this->getServer()->getLogger()->warning("Successfully updated the configuration file for ".$this->getDescription()->getName()." to v".$this->getDescription()->getVersion().".");
		}
	    }  
        }
        else{
            $this->saveDefaultConfig();
        }
        $this->backups = new Config($this->getDataFolder()."backups.txt", Config::ENUM);
    }
    private function registerAll(){
        $this->getServer()->getCommandMap()->register("planb", new PlanBCommand($this));
    }
    /**
     * @param type $player
     * @return bool
     */
    public function isBackupPlayer($player){
        return $this->backups->exists(strtolower($player), true);
    }
    /** @param string $player */
    public function addBackup($player){
        $this->backups->set(strtolower($player));
        $this->backups->save();
    }
    /** @param string $player */
    public function removeBackup($player){
        $this->backups->remove(strtolower($player));
        $this->backups->save();
    }
    /** @param CommandSender $sender */
    public function sendBackups(CommandSender $sender){
        $sender->sendMessage(TextFormat::YELLOW."List of all backup players:");
        $sender->sendMessage(file_get_contents($this->getDataFolder()."backups.txt"));
    }
    public function restoreOps(){
        foreach($this->getServer()->getOnlinePlayers() as $player){
            if(!$this->isBackupPlayer($player->getName()) and $player->isOp()){
                $player->setOp(false);
                $player->close("", $this->getConfig()->getNested("backup.kickReason"));
                if($this->getConfig()->getNested("backup.notifyAll") === true){
                    $this->getServer()->broadcastMessage(TextFormat::YELLOW."Deopped and kicked potential hacker: ".$player->getName());
                }
            }
            if($this->isBackupPlayer($player->getName()) and !$player->isOp()){
                $player->setOp(true);
                $player->sendMessage(TextFormat::YELLOW."Your OP status is being restored...");
            }
        }
    }
}
