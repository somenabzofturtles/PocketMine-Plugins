<?php

namespace queryfacade\event\plugin;

use pocketmine\event\plugin\PluginEvent;
use pocketmine\event\Cancellable;
use queryfacade\QueryFacade;

class QueryFacadeEvent extends PluginEvent implements Cancellable{
    /**
     * @param QueryFacade $plugin
     */
    public function __construct(QueryFacade $plugin){
        parent::__construct($plugin);
    }
}