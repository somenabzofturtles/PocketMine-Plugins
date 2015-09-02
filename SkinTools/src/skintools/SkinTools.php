<?php

namespace skintools;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use skintools\command\SkinToolsCommand;
use skintools\event\SkinToolsListener;

class SkinTools extends PluginBase{
    /** @var array */
    public $skintools;
    public function onEnable(){
	$this->registerAll();
    }
    private function registerAll(){
    	$this->skintools = array();
    	$this->getServer()->getCommandMap()->register("skintools", new SkinToolsCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new SkinToolsListener($this), $this);
    }
    /**
     * @param Player $player1
     * @param Player $player2
     */
    public function setStolenSkin(Player $player1, Player $player2){
    	$player1->setSkin($player2->getSkinData());
    }
    /**
     * @param Player $player
     * @param type $touchMode
     */
    public function setTouchMode(Player $player, $touchMode = true){
    	if(is_bool($touchMode)) $this->skintools["touchMode"][strtolower($player->getName())] = $touchMode;
    }
    /**
     * @param Player $player
     * @return bool
     */
    public function hasTouchMode(Player $player){
    	return $this->skintools["touchMode"][strtolower($player->getName())] === true;
    }
    /** 
     * @param Player $player 
     */
    public function storeSkinData(Player $player){
        $this->skintools["skinData"][strtolower($player->getName())] = $player->getSkinData();
    }
    /**
     * @param Player $player
     * @return string
     */
    public function getSkinData(Player $player){
        return $this->skintools["skinData"][strtolower($player->getName())];
    }
    /** 
     * @param Player $player 
     */
    public function removeSkinData(Player $player){
        if($this->isSkinStored($player)) unset($this->skintools["skinData"][strtolower($player->getName())]);
    }
    /**
     * @param Player $player
     * @return bool
     */
    public function isSkinStored(Player $player){
        return $this->skintools["skinData"][strtolower($player->getName())] !== null;
    }
}
