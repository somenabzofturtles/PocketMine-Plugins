<?php

namespace queryfacade\utils;

use queryfacade\event\plugin\AddPlayerEvent;
use queryfacade\event\plugin\AddPluginEvent;
use queryfacade\event\plugin\ChangeLevelNameEvent;
use queryfacade\event\plugin\ChangeMaxPlayerCountEvent;
use queryfacade\event\plugin\ChangePlayerCountEvent;
use queryfacade\event\plugin\RemovePlayerEvent;
use queryfacade\event\plugin\RemovePluginEvent;
use queryfacade\network\DummyPlayer;
use queryfacade\network\DummyPlugin;

//TODO: Implement calling of QueryFacade events
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
            $this->addPlugin($info[0], isset($info[1]) ? $info[1] : "1.0.0");
        }
    }
    /**
     * @param string $name
     * @param string $version
     */
    public function addPlugin($name, $version = "1.0.0"){
        $this->plugins[strtolower($name)] = new DummyPlugin($name, $version);
    }
    /**
     * @param string $name
     * @return bool
     */
    public function removePlugin($name){
        if(array_key_exists(strtolower($name), $this->plugins)){
            unset($this->plugins[strtolower($name)]);
            return true;
        }
        return false;
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
            $info = explode(";", $player);
            $this->addPlayer($info[0], isset($info[1]) ? $info[1] : "DUMMY", isset($info[2]) ? $info[2] : 19132);
        }
    }
    /**
     * @param string $name
     * @param string $ip
     * @param int $port
     */
    public function addPlayer($name, $ip = "DUMMY", $port = 19132){
        $this->players[strtolower($name)] = new DummyPlugin($name, $ip, $port);
    }
    /**
     * @param string $name
     * @return bool
     */
    public function removePlayer($name){
        if(array_key_exists(strtolower($name), $this->players)){
            unset($this->players[strtolower($name)]);
            return true;
        }
        return false;
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