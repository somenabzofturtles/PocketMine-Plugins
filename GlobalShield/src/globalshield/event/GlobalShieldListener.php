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
    /**
     * @param GlobalShield $plugin
     */
    public function __construct(GlobalShield $plugin){
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
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onBlockBreak(BlockBreakEvent $event){
        
    }
    /** 
     * @param BlockPlaceEvent $event 
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onBlockPlace(BlockPlaceEvent $event){
        
    }
    /** 
     * @param EntityLevelChangeEvent $event 
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onEntityLevelChange(EntityLevelChangeEvent $event){
        
    }
    /** 
     * @param EntityTeleportEvent $event 
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onEntityTeleport(EntityTeleportEvent $event){
        
    }
    /** 
     * @param PlayerBucketEmptyEvent $event 
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onPlayerBucketEmpty(PlayerBucketEmptyEvent $event){
        
    }
    /**
     * @param PlayerBucketFillEvent $event
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onPlayerBucketFill(PlayerBucketFillEvent $event){
        
    }
    /** 
     * @param PlayerInteractEvent $event 
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onPlayerInteractEvent(PlayerInteractEvent $event){
        
    }
    /**
     * @param PlayerItemHeldEvent $event 
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onPlayerItemHeld(PlayerItemHeldEvent $event){
        
    }
}
