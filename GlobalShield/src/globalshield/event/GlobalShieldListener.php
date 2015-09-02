<?php

namespace globalshield\event;

use globalshield\GlobalShield;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\player\PlayerBucketEmptyEvent;
use pocketmine\event\player\PlayerBucketFillEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\Listener;

class GlobalShieldListener implements Listener{
    /** @var GlobalShield */
    private $plugin;
    public function __construct(GlobalShield $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    /** 
     * @return GlobalShield 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param BlockBreakEvent $event 
     */
    public function onBlockBreak(BlockBreakEvent $event){
        
    }
    /** 
     * @param EntityLevelChangeEvent $event 
     */
    public function onEntityLevelChange(EntityLevelChangeEvent $event){
        
    }
    /** 
     * @param EntityTeleportEvent $event 
     */
    public function onEntityTeleport(EntityTeleportEvent $event){
        
    }
    /** 
     * @param BlockPlaceEvent $event 
     */
    public function onBlockPlace(BlockPlaceEvent $event){
        
    }
    /** 
     * @param PlayerBucketEmptyEvent $event 
     */
    public function onPlayerBucketEmpty(PlayerBucketEmptyEvent $event){
        
    }
    /**
     * @param PlayerBucketFillEvent $event 
     */
    public function onPlayerBucketFill(PlayerBucketFillEvent $event){
        
    }
    /** 
     * @param PlayerInteractEvent $event 
     */
    public function onPlayerInteractEvent(PlayerInteractEvent $event){
        
    }
    /**
     * @param PlayerItemHeldEvent $event 
     */
    public function onPlayerItemHeld(PlayerItemHeldEvent $event){
        
    }
}
