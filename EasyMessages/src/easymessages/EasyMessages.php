<?php

namespace easymessages;

use easymessages\command\EasyMessagesCommand;
use easymessages\event\EasyMessagesListener;
use easymessages\task\AutoMessageTask;
use easymessages\task\AutoPopupTask;
use easymessages\task\AutoTipTask;
use easymessages\task\BlinkingPopupTask;
use easymessages\task\BlinkingTipTask;
use easymessages\task\InfinitePopupTask;
use easymessages\task\InfiniteTipTask;
use easymessages\task\ScrollingPopupTask;
use easymessages\task\ScrollingTipTask;
use easymessages\task\UpdateMotdTask;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class EasyMessages extends PluginBase{
    /** @var string|null */
    public $scrollingPopup = null;
    /** @var string|null */
    public $scrollingTip = null;
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->saveResource("values.txt");
    	$this->getServer()->getCommandMap()->register("easymessages", new EasyMessagesCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new EasyMessagesListener($this), $this);
    	if($this->getConfig()->getNested("message.autoBroadcast") === true){
    	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoMessageTask($this), ($this->getConfig()->getNested("message.interval") * 20));
    	}
        switch(strtolower($this->getConfig()->getNested("popup.displayType"))){
            case "auto":
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoPopupTask($this), ($this->getConfig()->getNested("popup.interval") * 20));
                break;
            case "blinking":
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new BlinkingPopupTask($this), 30);
                break;
            case "infinite":
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new InfinitePopupTask($this), 7);
                break;
            case "scrolling":
                $this->setScrollingTip($this->getConfig()->getNested("popup.scrollingMessage"));
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new ScrollingPopupTask($this), 7);
                break;
        }
        switch(strtolower($this->getConfig()->getNested("tip.displayType"))){
            case "auto":
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoTipTask($this), ($this->getConfig()->getNested("tip.interval") * 20));
                break;
            case "blinking":
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new BlinkingTipTask($this), 30);
                break;
            case "infinite":
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new InfiniteTipTask($this), 7);
                break;
            case "scrolling":
                $this->setScrollingTip($this->getConfig()->getNested("tip.scrollingMessage"));
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new ScrollingTipTask($this), 7);
                break;
        }
        switch(strtolower($this->getConfig()->getNested("motd.displayType"))){
            case "dynamic":
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new UpdateMotdTask($this), ($this->getConfig()->getNested("motd.interval") * 20));
                break;
            case "static":
                $this->getServer()->getNetwork()->setName($this->getConfig()->getNested("motd.staticMotd"));
                break;
        }
    }
    /** 
     * @param string $message 
     */
    public function broadcastPopup($message){
        foreach($this->getServer()->getOnlinePlayers() as $player){
            $player->sendPopup($message);
        }
    }
    /** 
     * @param string $message 
     */
    public function broadcastTip($message){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    $player->sendTip($message);
    	}
    }
    /** 
     * @param array $messages
     * @return string
     */
    public function getRandomMessage(array $messages){
    	if(is_array($messages)) return $messages[array_rand($messages, 1)];
    }
    /**
     * @param string $message
     * @param bool $revert
     * @return string
     */
    public function replaceSymbols($message, $revert = false){
    	$defaultFormat = [
    	    TextFormat::BLACK,
    	    TextFormat::DARK_BLUE,
    	    TextFormat::DARK_GREEN,
    	    TextFormat::DARK_AQUA,
    	    TextFormat::DARK_RED,
    	    TextFormat::DARK_PURPLE,
    	    TextFormat::GOLD,
    	    TextFormat::GRAY,
    	    TextFormat::DARK_GRAY,
    	    TextFormat::BLUE,
    	    TextFormat::GREEN,
    	    TextFormat::AQUA,
    	    TextFormat::RED,
    	    TextFormat::LIGHT_PURPLE,
    	    TextFormat::YELLOW,
    	    TextFormat::WHITE,
    	    TextFormat::OBFUSCATED,
    	    TextFormat::BOLD,
    	    TextFormat::STRIKETHROUGH,
    	    TextFormat::UNDERLINE,
    	    TextFormat::ITALIC,
    	    TextFormat::RESET
    	];
    	$newFormat = [
    	    "&0",
    	    "&1",
    	    "&2",
    	    "&3",
    	    "&4",
    	    "&5",
    	    "&6",
    	    "&7",
    	    "&8",
    	    "&9",
    	    "&a",
    	    "&b",
    	    "&c",
    	    "&d",
    	    "&e",
    	    "&f",
    	    "&k",
    	    "&l",
    	    "&m",
    	    "&n",
    	    "&o",
    	    "&r"
    	];
    	if($revert === true){
    	    return str_replace($defaultFormat, "", $message);
    	}
    	else{
    	    return str_replace($newFormat, $defaultFormat, $message);
    	}
    }
    /**
     * @param string $message
     */
    public function setScrollingPopup($message){
        $this->scrollingPopup = (string) $message;
    }
    /**
     * @return string|null
     */
    public function getScrollingPopup(){
        return $this->scrollingPopup;
    }
    /**
     * @param string $message
     */
    public function setScrollingTip($message){
        $this->scrollingTip = (string) $message;
    }
    /**
     * @return string|null
     */
    public function getScrollingTip(){
        return $this->scrollingTip;
    }
}
