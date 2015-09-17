<?php

namespace skintools;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use skintools\command\SkinToolsCommand;
use skintools\event\SkinToolsListener;

class SkinTools extends PluginBase{
    const MODE_NONE = 0;
    const MODE_GIVE = 1;
    const MODE_STEAL = 2;
    /** @var array */
    public $skinData = [];
    /** @var array */
    public $touchMode = [];
    public function onEnable(){
	$this->registerAll();
    }
    private function registerAll(){
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
     * @param int $touchMode
     */
    public function setTouchMode(Player $player, $touchMode = self::MODE_NONE){
    	if(is_int($touchMode)) $this->touchMode[strtolower($player->getName())] = (int) $touchMode;
    }
    /**
     * @param Player $player
     * @return int
     */
    public function getTouchMode(Player $player){
        return $this->touchMode[strtolower($player->getName())];
    }
    /** 
     * @param Player $player 
     */
    public function storeSkinData(Player $player){
        $this->skinData[strtolower($player->getName())] = $player->getSkinData();
    }
    /**
     * @param Player $player
     * @return string
     */
    public function getSkinData(Player $player){
        return $this->skinData[strtolower($player->getName())];
    }
    /** 
     * @param Player $player 
     */
    public function removeSkinData(Player $player){
        if($this->isSkinStored($player)) unset($this->skinData[strtolower($player->getName())]);
    }
    /**
     * @param Player $player
     * @return bool
     */
    public function isSkinStored(Player $player){
        return $this->skinData[strtolower($player->getName())] !== null;
    }
}
