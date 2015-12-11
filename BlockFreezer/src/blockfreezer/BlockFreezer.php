<?php

namespace blockfreezer;

use blockfreezer\event\BlockFreezerListener;
use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class BlockFreezer extends PluginBase implements Listener{
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new BlockFreezerListener($this), $this);
    }
    /**
     * @param int $id
     * @param int $meta
     * @param int $levelName
     */
    public function addBlockType($id, $meta, $levelName){
        
    }
    /**
     * @param int $id
     * @param int $meta
     * @param int $levelName
     */
    public function removeBlockType($id, $meta, $levelName){
        
    }
    /**
     * @param Block $block
     * @return bool
     */
    public function isBlockSpecified(Block $block){
        $key = array_change_key_case($this->getConfig()->get("level"), CASE_LOWER);
        $levelKey = $key[strtolower($block->getLevel()->getName())];
    	if(is_array($levelKey)){
            return in_array($block->getId().":".$block->getDamage(), $levelKey);	
        }
    }
}
