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
     * @param EntityDamageEvent $event 
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function onEntityDamage(EntityDamageEvent $event){
        if($event instanceof EntityDamageByEntityEvent){
            if($event->getDamager() instanceof Player and $event->getEntity() instanceof Player){
                switch($this->plugin->getTouchMode($event->getDamager())){
                    case SkinTools::GIVE:
                        $event->setCancelled(true);
                        $this->plugin->setStolenSkin($event->getEntity(), $event->getDamager());
                        $event->getEntity()->sendMessage(TextFormat::GREEN.$event->getDamager()->getName()." gave you their skin!");
                        $event->getDamager()->sendMessage(TextFormat::GREEN.$event->getEntity()->getName()." has your skin now!");
                        break;
                    case SkinTools::STEAL:
                        $event->setCancelled(true);
                        $this->plugin->setStolenSkin($event->getDamager(), $event->getEntity());
                        $event->getDamager()->sendMessage(TextFormat::GREEN."You got ".$event->getEntity()->getName()."'s skin.");
                        break;
                }
            }
        }
    }
    /** 
     * @param PlayerLoginEvent $event 
     * @priority HIGHEST
     * @ignoreCancelled true
     */
    public function onPlayerLogin(PlayerLoginEvent $event){
        $this->plugin->storeSkinData($event->getPlayer());
        $this->plugin->setTouchMode($event->getPlayer(), SkinTools::NONE);
    }
    /** 
     * @param PlayerQuitEvent $event 
     * @priority MONITOR
     */
    public function onPlayerQuit(PlayerQuitEvent $event){
        if($this->plugin->isSkinStored($event->getPlayer())){
            $this->plugin->removeSkinData($event->getPlayer());
        }
        $this->plugin->clearTouchMode($event->getPlayer());
    }
}
