<?php
namespace Quanta\Core;

use Quanta\Quanta;
/**
 * Handles the components
 */
Class ComponentHandler {
    public array $components;

    /**
     * Creates an new instance from the component handler
     */
    public function __construct() {
        $this->components = array();
    }

    /**
     * Adds an component to the collection
     * @param mixed $component the component to add
     * @return void
     */
    public function addComponent($component)
    {
        $this->components[$component->getId()] = $component;
    }

    /**
     * Checks if the component with the given id exist
     * @param mixed $id the id from the component
     * @return bool returns true if the component exist, false if not
     */
    public function existComponent($id): bool {
        return array_key_exists($id, $this->components);
    }

    /**
     * Renders the component
     * @param mixed $quanta the Quanta instance
     * @param mixed $id the component id
     * @param mixed $data the data wich get passed to the render function
     * @return void
     */
    public function render($quanta, $id, $data) {
        if(array_key_exists($id, $this->components)) {
            echo $this->components[$id]->render($quanta, $data);
        }
    }
}
