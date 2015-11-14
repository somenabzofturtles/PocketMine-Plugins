<?php

namespace queryfacade\event\server;

use pocketmine\event\server\ServerEvent;
use pocketmine\event\Cancellable;

class QueryInformationChangeEvent extends ServerEvent implements Cancellable{
    /** @var \pocketmine\event\HandlerList|null */
    public static $handlerList = null;
    /** @var mixed */
    protected $oldData;
    /** @var mixed */
    protected $newData;
    /**
     * @param mixed $oldData
     * @param mixed $newData
     */
    public function __construct($oldData, $newData){
        $this->oldData = $oldData;
        $this->newData = $newData;
    }
    /**
     * @param mixed $data
     */
    public function setOldData($data){
        $this->oldData = $data;
    }
    /**
     * @return mixed
     */
    public function getOldData(){
        return $this->oldData;
    }
    /**
     * @param mixed $data
     */
    public function setNewData($data){
        $this->newData = $data;
    }
    /**
     * @return mixed
     */
    public function getNewData(){
        return $this->newData;
    }
}