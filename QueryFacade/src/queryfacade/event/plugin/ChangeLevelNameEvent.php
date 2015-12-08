<?php

namespace queryfacade\event\plugin;

use queryfacade\event\plugin\QueryFacadeEvent;
use queryfacade\QueryFacade;

class ChangeLevelNameEvent extends QueryFacadeEvent{
    /** @var string */
    protected $oldName;
    /** @var string */
    protected $newName;
    /**
     * @param QueryFacade $plugin
     * @param string $oldName
     * @param string $newName
     */
    public function __construct(QueryFacade $plugin, $oldName, $newName){
        parent::__construct($plugin);
        $this->oldName = (string) $oldName;
        $this->newName = (string) $newName;
    }
    /**
     * @return string
     */
    public function getOldName(){
        return $this->oldName;
    }
    /**
     * @param string $name
     */
    public function setOldName($name){
        $this->oldName = (string) $name;
    }
    /**
     * @return string
     */
    public function getNewName(){
        return $this->newName;
    }
    /**
     * @param string $name
     */
    public function setNewName($name){
        $this->newName = (string) $name;
    }
}