<?php

namespace queryfacade\event\plugin;

use queryfacade\event\plugin\QueryFacadeEvent;
use queryfacade\network\DummyPlayer;
use queryfacade\QueryFacade;

class AddPlayerEvent extends QueryFacadeEvent{
    /** @var DummyPlayer */
    protected $dummy;
    /**
     * @param QueryFacade $plugin
     * @param DummyPlayer $dummy
     */
    public function __construct(QueryFacade $plugin, DummyPlayer $dummy){
        parent::__construct($plugin);
        $this->dummy = $dummy;
    }
    /**
     * @return DummyPlayer
     */
    public function getDummyPlayer(){
        return $this->dummy;
    }
}