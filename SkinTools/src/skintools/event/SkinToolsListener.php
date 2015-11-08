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
    /**
     * @param SkinTools $plugin
     */
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
                switch($this->getPlugin()->getTouchMode($event->getDamager())){
                    case SkinTools::GIVE:
                        $event->setCancelled(true);
                        $this->getPlugin()->setStolenSkin($event->getEntity(), $event->getDamager());
                        $event->getEntity()->sendMessage(TextFormat::GREEN.$event->getDamager()->getName()." gave you their skin!");
                        $event->getDamager()->sendMessage(TextFormat::GREEN.$event->getEntity()->getName()." has your skin now!");
                        break;
                    case SkinTools::STEAL:
                        $event->setCancelled(true);
                        $this->getPlugin()->setStolenSkin($event->getDamager(), $event->getEntity());
                        $event->getDamager()->sendMessage(TextFormat::GREEN."You got ".$event->getEntity()->getName()."'s skin.");
                        break;
                }
            }
        }
    }
    /** 
     * @param PlayerLoginEvent $event 
     */
    public function onPlayerLogin(PlayerLoginEvent $event){
        $this->getPlugin()->storeSkinData($event->getPlayer());
        $this->getPlugin()->setTouchMode($event->getPlayer(), SkinTools::NONE);
    }
    /** 
     * @param PlayerQuitEvent $event 
     */
    public function onPlayerQuit(PlayerQuitEvent $event){
        if($this->getPlugin()->isSkinStored($event->getPlayer())){
            $this->getPlugin()->removeSkinData($event->getPlayer());
        }
        $this->getPlugin()->clearTouchMode($event->getPlayer());
    }
}
