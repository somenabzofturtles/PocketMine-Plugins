<?php

namespace mytag\command;

use mytag\MyTag;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class MyTagCommand extends Command{
    /** @var MyTag */
    private $plugin;
    /**
     * @param MyTag $plugin
     */
    public function __construct(MyTag $plugin){
        parent::__construct("mytag");
        $this->setDescription("Shows all the sub-commands for MyTag");
        $this->setUsage("/mytag <sub-command> [parameters]");
        $this->setPermission("mytag.command.mytag");
        $this->setAliases(["mt"]);
    	$this->plugin = $plugin;
    }
    /**
     * @return MyTag
     */
    public function getPlugin(){
    	return $this->plugin;
    }
    /**
     * @param CommandSender $sender
     */
    private function sendCommandHelp(CommandSender $sender){
    	$sender->sendMessage("MyTag commands:");
    	$sender->sendMessage("/mytag address: Shows IP address and port number on the name tag");
    	$sender->sendMessage("/mytag chat: Shows the last message spoken on the name tag");
    	$sender->sendMessage("/mytag health: Shows health on the name tag");
    	$sender->sendMessage("/mytag help: Shows all the sub-commands for MyTag");
    	$sender->sendMessage("/mytag hide: Hides the name tag");
    	$sender->sendMessage("/mytag restore: Restores current name tag to the default name tag");
    	$sender->sendMessage("/mytag set: Sets the name tag to whatever is specified");
    	$sender->sendMessage("/mytag view: Shows the name tag with a message");
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     */
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
	    switch(strtolower($args[0])){
	    	case "address":
	    	    break;
	    	case "chat":
	    	    break;
	    	case "health":
	    	    break;
	    	case "?":
	    	case "help":
	    	    break;
	    	case "hide":
	      	    break;
	      	case "restore":
	            break;
	        case "set":
	            break;
	        case "view":
	            break;
	    }
    	}
    	else{
	    $this->sendCommandHelp($sender);
    	}
    }
}
