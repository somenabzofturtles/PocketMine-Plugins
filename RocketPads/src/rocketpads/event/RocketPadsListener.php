<?php

namespace rocketpads\event;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\Listener;
use rocketpads\RocketPads;

class RocketPadsListener implements Listener{
    /** @var RocketPads */
    private $plugin;
    public function __construct(RocketPads $plugin){
        $this->plugin = $plugin;
    }
    /** @return RocketPads */
    public function getPlugin(){
        return $this->plugin;
    }
    /** @param BlockBreakEvent $event */
    public function onBlockBreak(BlockBreakEvent $event){
        
    }
    /** @param BlockPlaceEvent $event */
    public function onBlockPlace(BlockPlaceEvent $event){
        
    }
    /** @param PlayerInteractEvent $event */
    public function onPlayerInteract(PlayerInteractEvent $event){
        
    }
    /** @param PlayerMoveEvent $event */
    public function onPlayerMove(PlayerMoveEvent $event){
        if(!$event->isCancelled()){
            if($this->getPlugin()->isRocketPad($event->getPlayer()->getLevel()->getBlock($event->getPlayer()->subtract(0, 1, 0)))){
                $this->getPlugin()->launchPlayer($event->getPlayer());
            }
        }
    }
}