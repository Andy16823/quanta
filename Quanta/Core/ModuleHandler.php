<?php
namespace Quanta\Core;

/**
 * Handles the external modules
 */
class ModuleHandler
{
    private $modules = [];

    /**
     * Adds an module to the collection
     * @param Module $module the module to add
     * @return void
     */
    public function addModule(Module $module)
    {
        $this->modules[$module->getId()] = $module;
    }

    /**
     * Returns the closest module with the given type
     * @param mixed $type the type for the modul
     * @return Module|null the Module if it exist otherwise null
     */
    public function getModuleFromType($type)
    {
        foreach ($this->modules as $module)
        {
            if ($module instanceof $type)
            {
                return $module;
            }
        }
        return null;
    }

    /**
     * Returns the closest module with the given id
     * @param mixed $id the id from the module
     * @return Module|null the Module if it exist otherwise null
     */
    public function getModuleWithID($id)
    {
        foreach ($this->modules as $module)
        {
            if ($module->getId() == $id)
            {
                return $module;
            }
        }
        return null;
    }

    /**
     * Loads the modules
     * @param mixed $quanta the Quanta instance
     * @return void
     */
    public function loadModules($quanta)
    {
        foreach ($this->modules as $module)
        {
            $module->load($quanta);
        }
    }

    /**
     * Dispose the modules
     * @return void
     */
    public function disposeModules()
    {
        foreach ($this->modules as $module)
        {
            $module->dispose(null);
        }
    }
}