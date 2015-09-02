<?php

namespace skintools\event;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use skintools\SkinTools;

class SkinToolsListener implements Listener{
    /** @var SkinTools */
    private $plugin;
    public function __construct(SkinTools $plugin){
        $this->plugin = $plugin;
    }
    /** 
     * @return SkinTools 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /** 
     * @param EntityDamageEvent $event 
     */
    public function onEntityDamage(EntityDamageEvent $event){
        if($event instanceof EntityDamageByEntityEvent){
            if($event->getDamager() instanceof Player and $event->getEntity() instanceof Player){
                if($this->getPlugin()->hasTouchMode($event->getDamager())){
                    $event->setCancelled(true);
                    $this->getPlugin()->setStolenSkin($event->getDamager(), $event->getEntity());
                    $event->getDamager()->sendMessage(TextFormat::GREEN."You got ".$event->getEntity()->getName()."'s skin.");
                }
            }
        }
    }
    /** 
     * @param PlayerLoginEvent $event 
     */
    public function onPlayerLogin(PlayerLoginEvent $event){
        $this->getPlugin()->storeSkinData($event->getPlayer());
        $this->getPlugin()->setTouchMode($event->getPlayer(), false);
    }
    /** 
     * @param PlayerQuitEvent $event 
     */
    public function onPlayerQuit(PlayerQuitEvent $event){
        if($this->getPlugin()->isSkinStored($event->getPlayer())){
            $this->getPlugin()->removeSkinData($event->getPlayer());
        }
    }
}
