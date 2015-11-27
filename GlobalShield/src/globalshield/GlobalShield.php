<?php

namespace globalshield;

use globalshield\event\GlobalShieldListener;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\Sign;
use pocketmine\tile\Tile;
use pocketmine\Player;

class GlobalShield extends PluginBase{
    const ACTION_BLOCK_BREAKING = 0;
    const ACTION_BLOCK_INTERACTION = 1;
    const ACTION_BLOCK_PLACING = 2;
    const ACTION_BUCKET_EMPTYING = 3;
    const ACTION_BUCKET_FILLING = 4;
    public function onEnable(){
        $this->saveDefaultConfig();
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
            case self::ACTION_BLOCK_BREAKING:
                break;
            case self::ACTION_BLOCK_INTERACTION:
                break;
            case self::ACTION_BLOCK_PLACING:
                break;
            case self::ACTION_BUCKET_EMPTYING:
                break;
            case self::ACTION_BUCKET_FILLING:
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
    /**
     * @param Player $player
     * @param mixed $data
     */
    public function readData(Player $player, $data){
        
    }
}
