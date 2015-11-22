<?php

namespace queryfacade\utils;

//use queryfacade\event\server\QueryInformationChangeEvent;
use queryfacade\network\DummyPlayer;
use queryfacade\network\DummyPlugin;

//TODO: Fire QueryInformationChangeEvent when query data is modified, fully implement events
class DataModifier{
    /** @var DummyPlugin[] */
    private $plugins = [];
    /** @var DummyPlayer[] */
    private $players = [];
    /** @var int */
    private $playerCount = 0;
    /** @var int */
    private $maxPlayerCount = 0;
    /** @var string */
    private $level = "world";
    /**
     * @return DummyPlugin[]
     */
    public function getPlugins(){
        return $this->plugins;
    }
    /**
     * @param string[] $plugins
     */
    public function setPlugins(array $plugins){
        foreach($plugins as $plugin){
            $info = explode(";", $plugin);
            $this->plugins[] = new DummyPlugin($info[0], isset($info[1]) ? $info[1] : "1.0.0");
        }
    }
    /**
     * @return string
     */
    public function listPlugins(){
        $names = "";
        foreach($this->getPlugins() as $plugin){
            $names .= $plugin->getDescription()->getFullName().", ";
        }
        return substr($names, 0, -2);
    }
    /**
     * @return DummyPlayer[]
     */
    public function getPlayers(){
        return $this->players;
    }
    /**
     * @param string[] $players
     */
    public function setPlayers(array $players){
        foreach($players as $player){
            $this->players[] = new DummyPlayer($player);
        }
    }
    /**
     * @return string
     */
    public function listPlayers(){
        $names = "";
        foreach($this->getPlayers() as $player){
            $names .= $player->getName().", ";
        }
        return substr($names, 0, -2);
    }
    /**
     * @return int
     */
    public function getPlayerCount(){
        return $this->playerCount;
    }
    /**
     * @param int $count
     */
    public function setPlayerCount($count){
        $this->playerCount = (int) $count;
    }
    /** 
     * @return int
     */
    public function getMaxPlayerCount(){
        return $this->maxPlayerCount;
    }
    /**
     * @param int $count
     */
    public function setMaxPlayerCount($count){
        $this->maxPlayerCount = (int) $count;
    }
    /**
     * @return string
     */
    public function getLevelName(){
        return $this->level;
    }
    /**
     * @param string $name
     */
    public function setLevelName($name){
        $this->level = (string) $name;
    }
}