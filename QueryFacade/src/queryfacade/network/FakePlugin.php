<?php

namespace queryfacade\network;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginDescription;

class FakePlugin implements Plugin{
    /** @var PluginDescription */
    protected $description;
    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name, $version = "1.0.0"){
        $this->description = new PluginDescription(["name" => (string) $name, "main" => "", "version" => (string) $version, "api" => "1.0.0"]);
    }
    public function onLoad(){
    }
    public function onEnable(){
    }
    public function isEnabled(){
    }
    public function onDisable(){
    }
    public function isDisabled(){
    }
    public function getDataFolder(){
    }
    /**
     * @return PluginDescription
     */
    public function getDescription(){
        return $this->description;
    }
    /**
     * @param CommandSender $sender
     * @param Command $command
     * @param string $label
     * @param string[] $args
     * @return bool
     */
    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
        return false;
    }
    /**
     * @param string $filename
     */
    public function getResource($filename){
    }
    /**
     * @param string $filename
     * @param bool $replace
     */
    public function saveResource($filename, $replace = false){
    }
    public function getResources(){
    }
    public function getConfig(){
    }
    public function saveConfig(){
    }
    public function saveDefaultConfig(){
    }
    public function reloadConfig(){
    }
    public function getServer(){
    }
    public function getName(){
    }
    public function getLogger(){
    }
    public function getPluginLoader(){
    }
}