<?php

namespace globalshield;

use globalshield\event\GlobalShieldListener;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\Sign;
use pocketmine\tile\Tile;

class GlobalShield extends PluginBase{
    const TYPE_BLOCK_BREAKING = 0;
    const TYPE_BLOCK_INTERACTION = 1;
    const TYPE_BLOCK_PLACING = 2;
    const TYPE_BUCKET_EMPTYING = 3;
    const TYPE_BUCKET_FILLING = 4;
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
    }
    private function registerAll(){
    	$this->getServer()->getPluginManager()->registerEvents(new GlobalShieldListener($this), $this);
    }
    /**
     * @param Item $item
     * @param Level $level
     * @return bool
     */
    public function isItemBannedInLevel(Item $item, Level $level){
        return in_array($item->getId().":".$item->getDamage(), $this->getConfig()->getNested("level.".strtolower($level->getName()).".bannedItems"));
    }
    /**
     * @param int $type
     * @param Level $level
     */
    public function isLevelProtected($type, Level $level){
        switch($type){
            case self::TYPE_BLOCK_BREAKING:
                break;
            case self::TYPE_BLOCK_INTERACTION:
                break;
            case self::TYPE_BLOCK_PLACING:
                break;
            case self::TYPE_BUCKET_EMPTYING:
                break;
            case self::TYPE_BUCKET_FILLING:
                break;
        }
    }
    /**
     * @param Tile $tile
     * @return bool
     */
    public function isBadSign(Tile $tile){
        if($tile instanceof Sign){
            $text = "";
            foreach($tile->getText() as $line){
                $text .= strtolower(trim($line));
            }
        }
    }
}
