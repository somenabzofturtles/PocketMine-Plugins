<?php

namespace queryfacade\task;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use queryfacade\utils\MinecraftQuery;
use queryfacade\utils\MinecraftQueryException;

class QueryServerTask extends AsyncTask{
    /** @var string[] */
    private $targets;
    /** @var int */
    private $timeout;
    /** @var array */
    private $result = [];
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
        $data = [];
        $query = new MinecraftQuery();
        foreach($this->targets as $target){
            $address = explode(":", $target);
            try{
                $query->connect($address[0], isset($address[1]) ? $address[1] : 19132);
                $data[] = $query->getInfo();
                //var_dump($query->getInfo());
            }
            catch(MinecraftQueryException $exception){
                $data[] = false;
                //echo "[".date("H:i:s")."]: ".$exception->getMessage()."\n";
            }
        }
        $this->result = $data;
    }
    /**
     * @param Server $server
     */
    public function onCompletion(Server $server){
        //var_dump($this->result);
    }
}