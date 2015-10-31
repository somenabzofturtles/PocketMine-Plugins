<?php

namespace phputils\command;

use phputils\PHPUtils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class PHPUtilsCommand extends Command{
    /** @var PHPUtils */
    private $plugin;
    /**
     * @param PHPUtils $plugin
     */
    public function __construct(PHPUtils $plugin){
        parent::__construct("phputils");
        $this->setDescription("Shows all PHPUtils commands");
        $this->setUsage("/phputils <sub-command> [parameters]");
        $this->setPermission("phputils.command.phputils");
        $this->setAliases(["pu"]);
        $this->plugin = $plugin;
    }
    /**
     * @return PHPUtils
     */
    public function getPlugin(){
        return $this->plugin;
    }
    /**
     * @param CommandSender $sender
     */
    private function sendCommandHelp(CommandSender $sender){
        $commands = [
            "algos" => "Lists all the registered hashing algorithms",
            "class" => "Checks if the specified class exists",
            "cwd" => "Returns the name of the current working directory",
            "extens" => "Lists all the loaded PHP extensions",
            "func" => "Checks if the specified function exists",
            "hash" => "Returns a hash the specified string using the specified hashing algorithm",
            "help" => "Shows all PHPUtils commands",
            "php" => "Gets info about the PHP software the system is using",
            "shell" => "Executes a command in the command shell",
            "sys" => "Gets info about the system",
            "zend" => "Gets info about the Zend engine the system is using"
        ];
        $sender->sendMessage("PHPUtils commands:");
        foreach($commands as $name => $description){
            if($this->getPlugin()->isCommandEnabled($name)){
                $sender->sendMessage(TextFormat::GREEN."/phputils ".$name.": ".$description);
            }
            else{
                $sender->sendMessage(TextFormat::RED."/phputils ".$name.": ".$description);
            }
        }
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     */
    public function execute(CommandSender $sender, $label, array $args){
        //TODO: Fully implement command controlling
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "algos":
                    $algo = $this->getPlugin()->getAlgorithms();
                    $sender->sendMessage("Algorithms (".$algo[0]."): ".$algo[1]);
                    break;
                case "class":
                    if(isset($args[1])){
                        $this->getPlugin()->findClass($sender, $args[1]);
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a class path.");
                    }
                    break;
                case "cwd":
                    $sender->sendMessage("CWD: ".getcwd());
                    break;
                case "extens":
                    $ext = $this->getPlugin()->getExtensions();
                    $sender->sendMessage("Extensions (".$ext[0]."): ".$ext[1]);
                    break;
                case "func":
                    if(isset($args[1])){
                        $sender->sendMessage($args[1]." ".(function_exists($args[1]) ? "was" : "was not")." found.");
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a function name.");
                    }
                    break;
                case "hash":
                    if(isset($args[1])){
                        if(isset($args[2])){
                            $sender->sendMessage("Hashed using the ".$args[1]." algorithm: ".hash($args[1], implode(" ", array_slice($args, 2))));
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to hash due to insufficient parameters given.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a algorithm name.");
                    }
                    break;
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "php":
                    $this->getPlugin()->sendPHPInfo($sender);
                    break;
                case "shell":
                    if(isset($args[1])){
                        $command = implode(" ", array_slice($args, 1));
                        shell_exec($command);
                        $sender->sendMessage(TextFormat::GREEN."Executed \"".$command."\" on the command shell.");
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a command.");
                    }
                    break;
                case "sys":
                    $this->getPlugin()->sendSystemInfo($sender);
                    break;
                case "zend":
                    $this->getPlugin()->sendZendInfo($sender);
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