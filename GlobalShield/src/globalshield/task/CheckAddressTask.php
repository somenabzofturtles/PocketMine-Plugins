<?php

namespace globalshield\task;

use globalshield\GlobalShield;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Player;
use pocketmine\Server;

class CheckAddressTask extends AsyncTask{
    /** @var string */
    private $ip;
    /** @var mixed */
    private $player;
    /** @var mixed */
    private $result = null;
    /**
     * @param string $ip
     * @param mixed $player
     */
    public function __construct($ip, $player){
        $this->ip = $ip;
        $this->player = $player instanceof Player ? $player->getName() : $player;
        
    }
    public function onRun(){
        try{
            $this->result = json_decode(file_get_contents("http://www.ip-api.com/json/".$this->ip), true);
            //var_dump($this->result);
        }
        catch(\RuntimeException $exception){
            $this->result = false;
        }
    }
    /**
     * 
     * @param Server $server
     */
    public function onCompletion(Server $server){
        if(($plugin = $server->getPluginManager()->getPlugin("GlobalShield")) instanceof GlobalShield){
            if(($player = $server->getPlayer($this->player)) instanceof Player){
                $plugin->readData($player, $this->result);
            }
        }
    }
}