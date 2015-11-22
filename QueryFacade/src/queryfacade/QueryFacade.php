<?php

namespace queryfacade;

use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use queryfacade\command\QueryFacadeCommand;
use queryfacade\event\QueryFacadeListener;
use queryfacade\utils\DataModifier;

class QueryFacade extends PluginBase{
    /** @var QueryModifier */
    private $modifier;
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->modifier = new DataModifier();
    	$this->getServer()->getCommandMap()->register("queryfacade", new QueryFacadeCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new QueryFacadeListener($this), $this);
        $this->getModifier()->setPlugins($this->getConfig()->get("plugins"));
        $this->getModifier()->setPlayers($this->getConfig()->get("playerList"));
        $this->getModifier()->setPlayerCount($this->getConfig()->get("playerCount"));
        $this->getModifier()->setMaxPlayerCount($this->getConfig()->get("maxPlayerCount"));
        $this->getModifier()->setLevelName($this->getConfig()->get("level"));
        $this->getServer()->getLogger()->notice(count($this->getModifier()->getPlugins())." plugin(s) have been \"installed\": ".$this->getModifier()->listPlugins().".");
        $this->getServer()->getLogger()->notice(count($this->getModifier()->getPlayers())." player(s) have \"joined\" the game: ".$this->getModifier()->listPlayers().".");
        $this->getServer()->getLogger()->notice("Player count set to ".$this->getModifier()->getPlayerCount().", max player count set to ".$this->getModifier()->getMaxPlayerCount().".");
        $this->getServer()->getLogger()->notice("Current map name set to \"".$this->getModifier()->getLevelName()."\".");
    }
    /**
     * @return QueryModifier
     */
    public function getModifier(){
        return $this->modifier;
    }
    /**
     * @param CommandSender $sender
     */
    public function sendQueryInfo(CommandSender $sender){
        $sender->sendMessage("Cloak-plugins (".count($this->getModifier()->getPlugins())."): ".$this->getModifier()->listPlugins());
        $sender->sendMessage("Cloak-players (".count($this->getModifier()->getPlayers())."): ".$this->getModifier()->listPlayers());
        $sender->sendMessage("Player-slots: ".$this->getModifier()->getPlayerCount()."/".$this->getModifier()->getMaxPlayerCount());
        $sender->sendMessage("Map: ".$this->getModifier()->getLevelName());
    }
}
