<?php
namespace Quanta\Core;

use Quanta\Quanta;
/**
 * The base class for the components
 */
abstract class Component
{
    protected $id;

    abstract public function render(Quanta $quanta, mixed $data);

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}