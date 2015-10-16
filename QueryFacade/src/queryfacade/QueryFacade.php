<?php

namespace queryfacade;

use pocketmine\plugin\PluginBase;
use queryfacade\command\QueryFacadeCommand;
use queryfacade\event\QueryFacadeListener;
use queryfacade\utils\QueryModifier;

class QueryFacade extends PluginBase{
    /** @var QueryModifier */
    private $queryModifier;
    public function onEnable(){
        $this->saveFiles();
        $this->queryModifier = new QueryModifier($this);
    	$this->getServer()->getCommandMap()->register("queryfacade", new QueryFacadeCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new QueryFacadeListener($this), $this);
        $this->getModifier()->setPlayerCount($this->getConfig()->getNested("query.playerCount"));
        $this->getModifier()->setMaxPlayerCount($this->getConfig()->getNested("query.maxPlayerCount"));
        $this->getModifier()->setLevelName($this->getConfig()->getNested("query.level"));
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
    /**
     * @return QueryModifier
     */
    public function getModifier(){
        return $this->queryModifier;
    }
}
