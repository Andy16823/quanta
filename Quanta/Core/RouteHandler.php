<?php
namespace Quanta\Core;

use Exception;
use Quanta\Core\Route;

/**
 * An route handler which handles the drawing from components when given url's gets called
 */
class RouteHandler
{
    protected array $routes;

    /**
     * Creates an new instance from the route handler
     */
    public function __construct()
    {
        $this->routes = array();
    }

    /**
     * Creates an destructor for the route handler
     */
    public function __destruct()
    {
        $this->routes = array();
    }

    public function addRoute(Route $route)
    {
        $this->routes[$route->routeId] = $route;
    }

    /**
     * Performs the routing. Gets called from quanta
     * @param mixed $quanta the Quanta instance
     * @return void
     */
    public function process($quanta)
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        foreach($this->routes as $route) {
            $route->process($quanta, $requestUri);
        }
    }
}