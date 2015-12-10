<?php

namespace domath\command;

use domath\utils\BasicCalculator;
//use domath\utils\ScientificCalculator;
//use domath\utils\ShapeCalculator;
//use domath\utils\SimpleStorage;
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
        parent::__construct("domath", "Shows all DoMath commands", null, ["dm"]);
        $this->setPermission("domath.command.domath");
        $this->plugin = $plugin;
    }
    /**
     * @param CommandSender $sender
     */
    public function sendCommandHelp(CommandSender $sender){
        $commands = [
            "add" => "",
            "divide" => "",
            "exponent" => "",
            "help" => "Shows all DoMath commands",
            "multiply" => "",
            "percent" => "",
            "square" => "",
            "subtract" => ""
        ];
        $sender->sendMessage("DoMath commands:");
        foreach($commands as $name => $description){
            $sender->sendMessage("/domath ".$name.": ".$description);
        }
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     * @return bool
     */
    public function execute(CommandSender $sender, $label, array $args){
        if(!$this->testPermission($sender)) return false;
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "a":
                case "add":
                    if(count(array_slice($args, 1)) > 1){
                        $sender->sendMessage(BasicCalculator::toString(array_slice($args, 1), BasicCalculator::ADD));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    return true;
                case "d":
                case "divide":
                    if(count(array_slice($args, 1)) > 1){
                        $sender->sendMessage(BasicCalculator::toString(array_slice($args, 1), BasicCalculator::DIVIDE));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");  
                    }
                    return true;
                case "e":
                case "exponent":
                    if(count(array_slice($args, 1)) === 2){
                        $sender->sendMessage(BasicCalculator::toString(array_slice($args, 1), BasicCalculator::EXPONENT));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    return true;
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "m":
                case "multiply":
                    if(count(array_slice($args, 1)) > 1){
                        $sender->sendMessage(BasicCalculator::toString(array_slice($args, 1), BasicCalculator::MULTIPLY));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    return true;
                case "p":
                case "percent":
                    if(count(array_slice($args, 1)) === 2){
                        $sender->sendMessage(BasicCalculator::toString(array_slice($args, 1), BasicCalculator::PERCENT));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    return true;
                case "sq":
                case "square":
                    if(isset($args[1])){
                        $sender->sendMessage(BasicCalculator::toString($args[1], BasicCalculator::SQUARE));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    return true;
                case "s":
                case "subtract":
                    if(count(array_slice($args, 1)) > 1){
                        $sender->sendMessage(BasicCalculator::toString(array_slice($args, 1), BasicCalculator::SUBTRACT));
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Failed to calculate due to insufficient parameters.");
                    }
                    return true;
                default:
                    $sender->sendMessage("Usage: /domath <sub-command> [parameters]");
                    return false;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return false;
        }
    }
}