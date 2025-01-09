<?php
namespace Quanta\Core;

use Quanta\Quanta;

/**
 * The base class for the modules
 */
abstract class Module {
    protected $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    abstract public function load(Quanta $quanta);
    abstract public function dispose(Quanta $quanta);
}