<?php

namespace queryfacade\network;

use pocketmine\IPlayer;

class DummyPlayer implements IPlayer{
    /** @var string */
    protected $name;
    /**
     * @param string name
     */
    public function __construct($name){
        $this->name = (string) $name;
    }
    /**
     * @param bool $value
     */
    public function setOp($value){ 
    }
    /**
     * @return bool
     */
    public function isBanned(){
        return false;
    }
    /**
     * @return bool
     */
    public function isWhitelisted(){
        return false;
    }
    public function getLastPlayed(){
    }
    public function getFirstPlayed(){
    }
    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    public function hasPlayedBefore(){
    }
    /**
     * @param bool $banned
     */
    public function setBanned($banned){
    }
    /**
     * @return bool
     */
    public function isOp(){
        return false;
    }
    /**
     * @param bool $value
     */
    public function setWhitelisted($value){
    }
    /**
     * @return bool
     */
    public function isOnline(){
        return true;
    }
    public function getPlayer(){
    }
}