<?php

namespace queryfacade\task;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use queryfacade\utils\MinecraftQuery;

class QueryServerTask extends AsyncTask{
    /** @var string[] */
    private $targets;
    /** @var int */
    private $timeout;
    /** @var array */
    private $result = null;
    /**
     * @param array $targets
     * @param int $timeout
     */
    public function __construct($targets = [], $timeout = 3){
        $this->targets = $targets;
        //var_dump($targets);
        $this->timeout = (int) $timeout;
    }
    public function onRun(){
        $query = new MinecraftQuery();
        foreach($this->targets as $target){
            $address = explode(":", $target);
            $query->connect($address[0], isset($address[1]) ? $address[1] : 19132);
            $this->result[] = $query->getInfo();
            //var_dump($query->getInfo());
        }
    }
    /**
     * @param Server $server
     */
    public function onCompletion(Server $server){
        //TODO: Find a way to store the server data back in the main thread
    }
}