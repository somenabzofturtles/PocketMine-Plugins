<?php

namespace easymessages\task;

use easymessages\utils\Utils;
use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class ScrollingTipTask extends PluginTask{
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
        $tip = $this->getPlugin()->getScrollingTip();
        $this->getPlugin()->broadcastTip($tip);
        $this->getPlugin()->setScrollingTip(Utils::next($tip));
    }
}
