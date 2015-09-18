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
use easymessages\utils\MessageScroller;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class EasyMessages extends PluginBase{
    /** @var string */
    public $scrollingPopup = "";
    /** @var string */
    public $scrollingTip = "";
    public function onEnable(){
        $this->saveFiles();
        $this->registerAll();
    }
    private function saveFiles(){
        if(!file_exists($this->getDataFolder())) mkdir($this->getDataFolder());
        if(file_exists($this->getDataFolder()."config.yml")){
            if($this->getConfig()->get("version") !== $this->getDescription()->getVersion() or !$this->getConfig()->exists("version")){
		$this->getServer()->getLogger()->warning("An invalid configuration file for ".$this->getDescription()->getName()." was detected.");
		if($this->getConfig()->getNested("plugin.autoUpdate") === true){
		    $this->saveResource("config.yml", true);
                    $this->getServer()->getLogger()->warning("Successfully updated the configuration file for ".$this->getDescription()->getName()." to v".$this->getDescription()->getVersion().".");
		}
	    }	
        }
        else{
            $this->saveDefaultConfig();
        }
        if(!file_exists($this->getDataFolder()."values.txt")) $this->saveResource("values.txt");
    }
    private function registerAll(){
    	$this->getServer()->getCommandMap()->register("easymessages", new EasyMessagesCommand($this));
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
            case "scrolling":
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
    	$this->getServer()->getPluginManager()->registerEvents(new EasyMessagesListener($this), $this);
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
     * @return string
     */
    public function getScrollingPopup(){
        return $this->scrollingPopup;
    }
    /**
     * @return string
     */
    public function getScrollingTip(){
        return $this->scrollingTip;
    }
}
