<?php

namespace skintools\event\player;

use pocketmine\event\player\PlayerEvent;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerToggleTouchEvent extends PlayerEvent implements Cancellable{
    public static $handlerList = null;
    /** @var Player */
    protected $player;
    /** @var int */
    protected $oldMode;
    /** @var int */
    protected $newMode;
    /**
     * @param Player $player
     * @param int $oldMode
     * @param int $newMode
     */
    public function __construct(Player $player, $oldMode, $newMode){
        $this->player = $player;
        $this->oldMode = (int) $oldMode;
        $this->newMode = (int) $newMode;
    }
    /**
     * @return Player
     */
    public function getPlayer(){
        return $this->player;
    }
    /**
     * @param int $mode
     */
    public function setOldMode($mode){
        $this->oldMode = (int) $mode;
    }
    /**
     * @return int
     */
    public function getOldMode(){
        return $this->oldMode;
    }
    /**
     * @param int $mode
     */
    public function setNewMode($mode){
        $this->newMode = (int) $mode;
    }
    /**
     * @return int
     */
    public function getNewMode(){
        return $this->newMode;
    }
}