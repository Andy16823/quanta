<?php

/**
 * An simple memory class
 */
class Memory{
    public $vars;

    public function __construct(){
        $this->vars = array();
    }

    public function __destruct(){
        $this->vars = array();
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->vars)) {
            return $this->vars[$name];
        }
        return null;
    }

    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }
}