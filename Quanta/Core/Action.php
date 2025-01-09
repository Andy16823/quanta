<?php
namespace Quanta\Core;

use Quanta\Quanta;
/**
 * The base class to create the actions for the action handler
 */
abstract class Action
{
    protected $id;

    abstract public function execute(Quanta $quanta) : string|bool;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}