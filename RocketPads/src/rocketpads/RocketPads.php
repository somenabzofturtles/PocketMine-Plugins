<?php

namespace rocketpads;

use pocketmine\block\Block;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use rocketpads\command\RocketPadsCommand;
use rocketpads\event\RocketPadsListener;

class RocketPads extends PluginBase{
    /** @var Config */
    public $pads;
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
        $this->pads = new Config($this->getDataFolder()."pads.txt", Config::ENUM);
    }
    private function registerAll(){
        $this->getServer()->getCommandMap()->register("rocketpads", new RocketPadsCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new RocketPadsListener($this), $this);
    }
    /**
     * @param Block $block
     * @return bool
     */
    public function isRocketPad(Block $block){
        if(is_array($this->getConfig()->getNested("pad.blockId"))) return in_array($block->getId().":".$block->getDamage(), $this->getConfig()->getNested("pad.blockId")) === true;
    }
    /**
     * @param Block $block
     */
    public function addRocketPad(Block $block){
        $this->pads->set($block->getFloorX().":".$block->getFloorY().":".$block->getFloorZ().":".strtolower($block->getLevel()->getName()));
        $this->pads->save();
    }
    /**
     * @param Block $block
     */
    public function removeRocketPad(Block $block){
        $this->pads->remove($block->getFloorX().":".$block->getFloorY().":".$block->getFloorZ().":".strtolower($block->getLevel()->getName()));
    }
    /**
     * @return string
     */
    public function getBaseValue(){
        return $this->getConfig()->getNested("pad.baseValue");
    }
    /**
     * @return int
     */
    public function getLaunchDistance(){
        return (int) $this->getConfig()->getNested("pad.launchDistance");
    }
    /**
     * @param Player $player
     */
    public function launchPlayer(Player $player){
        switch($player->getDirection()){
            case 0:
                $player->knockBack($player, 0, $this->getLaunchDistance(), 0, $this->getBaseValue());
                break;
            case 1:
                $player->knockBack($player, 0, 0, $this->getLaunchDistance(), $this->getBaseValue());
                break;
            case 2:
                $player->knockBack($player, 0, -$this->getLaunchDistance(), 0, $this->getBaseValue());
                break;
            case 3:
                $player->knockBack($player, 0, 0, -$this->getLaunchDistance(), $this->getBaseValue());
                break;
        }
    }
}
