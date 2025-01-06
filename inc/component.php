<?php
namespace Quanta;

/**
 * The base class for the components
 */
abstract class Component
{
    protected $id;

    abstract public function render($quanta, $data);

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}