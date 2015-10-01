<?php

namespace domath\command;

use domath\utils\Calculator;
use domath\DoMath;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class DoMathCommand extends Command{
    /** @var DoMath */
    private $plugin;
    /**
     * @param DoMath $plugin
     */
    public function __construct(DoMath $plugin){
        parent::__construct("domath");
        $this->setDescription("Shows all DoMath commands");
        $this->setUsage("/domath <sub-command> [parameters]");
        $this->setPermission("domath.command.domath");
        $this->setAliases(["dm"]);
        $this->plugin = $plugin;
    }
    /**
     * @return DoMath
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param CommandSender $sender
     */
    public function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("DoMath commands:");
        $sender->sendMessage("/domath add:");
        $sender->sendMessage("/domath divide:");
        $sender->sendMessage("/domath help: Shows all DoMath commands");
        $sender->sendMessage("/domath multiply:");
        $sender->sendMessage("/domath square:");
        $sender->sendMessage("/domath subtract:");
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     */
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "a":
                case "add":
                    if(count(array_slice($args, 1)) > 1){
                        $sender->sendMessage($this->getPlugin()->getCalculator()->toString(array_slice($args, 1), Calculator::ADD));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    break;
                case "d":
                case "divide":
                    break;
                case "?":
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "m":
                case "multiply":
                    if(count(array_slice($args, 1)) > 1){
                        $sender->sendMessage($this->getPlugin()->getCalculator()->toString(array_slice($args, 1), Calculator::MULTIPLY));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    break;
                case "sq":
                case "square":
                    if(isset($args[1])){
                        $sender->sendMessage($this->getPlugin()->getCalculator()->toString($args[1], Calculator::SQUARE));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    break;
                case "s":
                case "subtract":
                    if(count(array_slice($args, 1)) > 1){
                        $sender->sendMessage($this->getPlugin()->getCalculator()->toString(array_slice($args, 1), Calculator::SUBTRACT));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameteres.");
                    }
                    break;
                default:
                    $this->sendCommandHelp($sender);
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}