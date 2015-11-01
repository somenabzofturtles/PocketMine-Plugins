<?php

namespace rapidcmd\utils;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\Server;

class ActionParser{
    /**
     * @param string $line
     */
    public function run($line){
        $part = explode(";", $line);
        switch(strtolower($part[0])){
            case "run":
                Server::getInstance()->dispatchCommand(new ConsoleCommandSender(), $part[1]);
                break;
        }
    }
}