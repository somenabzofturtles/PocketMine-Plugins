<?php

namespace queryfacade\event\plugin;

use queryfacade\event\plugin\QueryFacadeEvent;
use queryfacade\QueryFacade;

class ChangePlayerCountEvent extends QueryFacadeEvent{
    /** @var int */
    protected $oldCount;
    /** @var int */
    protected $newCount;
    /**
     * @param QueryFacade $plugin
     * @param int $oldCount
     * @param int $newCount
     */
    public function __construct(QueryFacade $plugin, $oldCount, $newCount){
        parent::__construct($plugin);
        $this->oldCount = (int) $oldCount;
        $this->newCount = (int) $newCount;
    }
    /**
     * @return int
     */
    public function getOldCount(){
        return $this->oldCount;
    }
    /**
     * @param int $count
     */
    public function setOldName($count){
        $this->oldCount = (int) $count;
    }
    /**
     * @return int
     */
    public function getNewCount(){
        return $this->newCount;
    }
    /**
     * @param int $count
     */
    public function setNewCount($count){
        $this->newCount = (int) $count;
    }
}