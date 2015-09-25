<?php

namespace planb;

use planb\command\PlanBCommand;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\Player;

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
        if(!file_exists($this->getDataFolder()."values.txt")) $this->saveResource("values.txt");
        $this->backups = new Config($this->getDataFolder()."backups.txt", Config::ENUM);
    }
    private function registerAll(){
        $this->getServer()->getCommandMap()->register("planb", new PlanBCommand($this));
    }
    /**
     * @param string $player
     * @return bool
     */
    public function isBackupPlayer($player){
        return $this->backups->exists(strtolower($player), true);
    }
    /** 
     * @param string $player 
     */
    public function addBackup($player){
        $this->backups->set(strtolower($player));
        $this->backups->save();
    }
    /** 
     * @param string $player 
     */
    public function removeBackup($player){
        $this->backups->remove(strtolower($player));
        $this->backups->save();
    }
    /** 
     * @param CommandSender $sender 
     */
    public function sendBackups(CommandSender $sender){
        $backupCount = 0;
        $backupNames = "";
        foreach(file($this->getDataFolder()."backups.txt", FILE_SKIP_EMPTY_LINES) as $name){
            $backupNames .= trim($name).", ";
            $backupCount++;
        }
        $sender->sendMessage(TextFormat::AQUA."Found ".$backupCount." backup player(s): ".$backupNames);
    }
    public function restoreOps(){
        foreach($this->getServer()->getOnlinePlayers() as $player){
            if(!$this->isBackupPlayer($player->getName()) and $player->isOp()){
                $player->setOp(false);
                $player->close("", $this->getFixedMessage($player, $this->getConfig()->getNested("backup.kickReason")));
                if($this->getConfig()->getNested("backup.notifyAll") === true){
                    $this->getServer()->broadcastMessage($this->getFixedMessage($player, $this->getConfig()->getNested("backup.notifyMessage")));
                }
            }
            if($this->isBackupPlayer($player->getName()) and !$player->isOp()){
                $player->setOp(true);
                $player->sendMessage($this->getFixedMessage($player, $this->getConfig()->getNested("backup.restoreMessage")));
            }
        }
    }
    /**
     * @param Player $player
     * @param string $message
     * @return string
     */
    public function getFixedMessage(Player $player, $message = ""){
        return str_replace(   
            [
                "{PLAYER_ADDRESS}",
                "{PLAYER_DISPLAY_NAME}",
                "{PLAYER_NAME}",
                "{PLAYER_PORT}"
            ], 
            [
                $player->getAddress(),
                $player->getDisplayName(),
                $player->getName(),
                $player->getPort()
            ], 
            $message
        );
    }
}
