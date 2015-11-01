<?php

namespace easymessages\task;

use easymessages\utils\TextUtils;
use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class ScrollingPopupTask extends PluginTask{
    /** @var EasyMessages */
    private $plugin;
    /**
     * @param EasyMessages $plugin
     */
    public function __construct(EasyMessages $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    /** 
     * @return EasyMessages 
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param int $currentTick
     */
    public function onRun($currentTick){
        $popup = $this->getPlugin()->getScrollingPopup();
        $this->getPlugin()->broadcastPopup($popup);
        $this->getPlugin()->setScrollingPopup(TextUtils::next($popup));
    }
}
