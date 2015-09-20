<?php

namespace easymessages\task;

use easymessages\utils\TextScroller;
use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class ScrollingTipTask extends PluginTask{
    /** @var EasyMessages */
    private $plugin;
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
    public function onRun($currentTick){
        $tip = $this->getPlugin()->getScrollingTip();
        $this->getPlugin()->broadcastTip($tip);
        $this->getPlugin()->setScrollingPopup(TextScroller::next($tip));
    }
}
