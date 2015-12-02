<?php

namespace blockfreezer\event;

use blockfreezer\BlockFreezer;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\event\Listener;

class BlockFreezerListener implements Listener{
    /** @var BlockFreezer */
    private $plugin;
    /**
     * @param BlockFreezer $plugin
     */
    public function __construct(BlockFreezer $plugin){
        $this->plugin = $plugin;
    }
    /**
     * @return BlockFreezer
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param BlockUpdateEvent $event
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onBlockUpdate(BlockUpdateEvent $event){
	if($this->getPlugin()->isBlockSpecified($event->getBlock())){
	    $event->setCancelled(true);
	}
    }
}