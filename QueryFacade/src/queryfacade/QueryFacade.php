<?php

namespace queryfacade;

use pocketmine\plugin\PluginBase;
use queryfacade\command\QueryFacadeCommand;
use queryfacade\event\QueryFacadeListener;

class QueryFacade extends PluginBase{
    /** @var int */
    private $playerCount = 0;
    /** @var int */
    private $maxPlayerCount = 0;
    /** @var \pocketmine\Player[] */
    private $playerList = [];
    /** @var string */
    private $level = "";
    /** @var \pocketmine\plugin\Plugin[] */
    private $plugins = [];
    public function onEnable(){
        $this->saveFiles();
        $this->registerAll();
    }
    private function saveFiles(){
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
    }
    private function registerAll(){
    	$this->getServer()->getCommandMap()->register("queryfacade", new QueryFacadeCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new QueryFacadeListener($this), $this);
        $this->setCloakPlayerCount($this->getConfig()->getNested("query.playerCount"));
        $this->setCloakMaxPlayerCount($this->getConfig()->getNested("query.maxPlayerCount"));
        $this->setCloakPlayerList($this->getConfig()->getNested("query.playerList"));
        $this->setCloakLevel($this->getConfig()->getNested("query.level"));
        $this->setCloakPlugins($this->getConfig()->getNested("query.plugins"));
    }
    /** 
     * @return int 
     */
    public function getCloakPlayerCount(){
	return $this->playerCount;
    }
    /** 
     * @param int $count 
     */
    public function setCloakPlayerCount($count = 0){
    	$this->playerCount = $count;
    }
    /** 
     * @return int 
     */
    public function getCloakMaxPlayerCount(){
    	return $this->maxPlayerCount;
    }
    /** 
     * @param int $count 
     */
    public function setCloakMaxPlayerCount($count = 1){
    	$this->maxPlayerCount = $count;
    }
    /**
     * @return \pocketmine\Player[]
     */
    public function getCloakPlayerList(){
    	return $this->playerList;
    }
    /**
     * @param \pocketmine\Player[] $players
     */
    public function setCloakPlayerList(array $players){
    	$this->playerList = $players;
    }
    /**
     * @return string
     */
    public function getCloakLevel(){
    	return $this->level;
    }
    /**
     * @param string $level
     */
    public function setCloakLevel($level){
    	$this->level = $level;
    }
    /**
     * @return \pocketmine\plugin\Plugin[]
     */
    public function getCloakPlugins(){
    	return $this->plugins;
    }
    /**
     * @param \pocketmine\plugin\Plugin[] $plugins
     */
    public function setCloakPlugins(array $plugins){
    	$this->plugins = $plugins;
    }
}
