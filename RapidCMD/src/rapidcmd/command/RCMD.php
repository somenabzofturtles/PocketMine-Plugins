<?php

namespace rapidcmd\command;

class RCMD{
    /** @var string */
    protected $name;
    /** @var string */
    protected $description;
    /** @var string */
    protected $permNode;
    /** @var mixed */
    protected $permValue;
    /** @var string[] */
    protected $actions;
    /**
     * @param string $name
     * @param string $description
     * @param string $permNode
     * @param mixed $permValue
     * @param string[] $actions
     */
    public function __construct($name = "", $description = "", $permNode = "", $permValue = false, array $actions = []){
        $this->name = $name;
        $this->description = $description;
        $this->permNode = $permNode;
        $this->permValue = $permValue;
        $this->actions = $actions;
    }
    /**
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    /**
     * @param string $description
     */
    public function setDescription($description){
        $this->description = $description;
    }
    /**
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }
    /**
     * @param string $name
     */
    public function setPermNode($name){
        $this->permNode = $name;
    }
    /**
     * @return string
     */
    public function getPermNode(){
        return $this->permNode;
    }
    /**
     * @param mixed $value
     */
    public function setPermValue($value){
        $this->permValue = $value;
    }
    /**
     * @return bool|string
     */
    public function getPermValue(){
        return $this->permValue;
    }
    /**
     * @param string[] $actions
     */
    public function setActions(array $actions){
        $this->actions = $actions;
    }
    /**
     * @return string[]
     */
    public function getActions(){
        return $this->actions;
    }
}