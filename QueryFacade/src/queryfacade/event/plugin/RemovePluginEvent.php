<?php

namespace queryfacade\event\plugin;

use queryfacade\event\plugin\QueryFacadeEvent;
use queryfacade\network\DummyPlugin;
use queryfacade\QueryFacade;

class RemovePluginEvent extends QueryFacadeEvent{
    /** @var DummyPlugin */
    protected $dummy;
    /**
     * @param QueryFacade $plugin
     * @param DummyPlugin $dummy
     */
    public function __construct(QueryFacade $plugin, DummyPlugin $dummy){
        parent::__construct($plugin);
        $this->dummy = $dummy;
    }
    /**
     * @return DummyPlugin
     */
    public function getDummyPlugin(){
        return $this->dummy;
    }
}