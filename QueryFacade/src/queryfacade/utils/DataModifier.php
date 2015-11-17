<?php

namespace queryfacade\utils;

//use queryfacade\event\server\QueryInformationChangeEvent;

//TODO: Fire QueryInformationChangeEvent when query data is modified, fully implement events
class DataModifier{
    /** @var \pocketmine\plugin\Plugin[] */
    private $plugins = [];
    /** @var \pocketmine\Player[] */
    private $players = [];
    /** @var int */
    private $playerCount = 0;
    /** @var int */
    private $maxPlayerCount = 0;
    /** @var string */
    private $level = "world";
    /**
     * @return \pocketmine\plugin\Plugin[]
     */
    public function getPlugins(){
        return $this->plugins;
    }
    /**
     * @param \pocketmine\plugin\Plugin[] $plugins
     */
    public function setPlugins(array $plugins){
        $this->plugins = $plugins;
    }
    /**
     * @return \pocketmine\Player[]
     */
    public function getPlayers(){
        return $this->players;
    }
    /**
     * @param \pocketmine\Player[] $players
     */
    public function setPlayers(array $players){
        $this->players = $players;
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