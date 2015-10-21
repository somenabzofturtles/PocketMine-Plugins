<?php

namespace queryfacade;

use pocketmine\plugin\PluginBase;
use queryfacade\command\QueryFacadeCommand;
use queryfacade\event\QueryFacadeListener;
use queryfacade\utils\DataModifier;

class QueryFacade extends PluginBase{
    /** @var QueryModifier */
    private $modifier;
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->modifier = new DataModifier($this);
    	$this->getServer()->getCommandMap()->register("queryfacade", new QueryFacadeCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new QueryFacadeListener($this), $this);
        $this->getModifier()->setPlayerCount($this->getConfig()->get("playerCount"));
        $this->getModifier()->setMaxPlayerCount($this->getConfig()->get("maxPlayerCount"));
        $this->getModifier()->setLevelName($this->getConfig()->get("level"));
    }
    /**
     * @return QueryModifier
     */
    public function getModifier(){
        return $this->modifier;
    }
}
