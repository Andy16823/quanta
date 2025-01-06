<?php
namespace Quanta\Core;

/**
 * The base class for the modules
 */
abstract class Module {
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    abstract public function load($quanta);
    abstract public function dispose($quanta);
}