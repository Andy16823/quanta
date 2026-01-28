<?php

namespace Quanta\Core;

/**
 * Service Handler
 * This class manages the registration and retrieval of services within the application.
 */
class ServiceHandler
{
    protected $services = [];

    public function registerService($name, $service)
    {
        $this->services[$name] = $service;
    }

    public function getService($name)
    {
        return isset($this->services[$name]) ? $this->services[$name] : null;
    }
}