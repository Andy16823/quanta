<?php
namespace Quanta\Core;

use Exception;
use Quanta\Quanta;
use Quanta\Core\Route;

/**
 * A route handler that manages the processing and preparation of components 
 * when specified URLs are accessed.
 */
class RouteHandler
{
    /** 
     * @var array $routes List of routes registered with the handler 
     */
    protected array $routes;

    /**
     * Creates an new instance from the route handler
     */
    public function __construct()
    {
        $this->routes = array();
    }

    /**
     * Cleans up the routes when the RouteHandler is destroyed.
     */
    public function __destruct()
    {
        $this->routes = array();
    }

    /**
     * Registers a new route with the handler.
     *
     * @param Route $route The route to be added.
     * @return void
     */
    public function addRoute(Route $route)
    {
        $this->routes[$route->routeId] = $route;
    }

    /**
     * Prepares all registered routes. This involves invoking the `prepare` method
     * on each route to allow them to set up necessary data or perform tasks 
     * before processing begins.
     *
     * @param Quanta $quanta The Quanta instance, representing the application context.
     * @return void
     */
    public function prepareRoute(Quanta $quanta)
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $route)
        {
            $route->prepare($quanta, $requestUri);
        }
    }

    /**
     * Processes all registered routes. This involves invoking the `process` method
     * on each route to handle the rendering or other logic based on the current request.
     *
     * @param Quanta $quanta The Quanta instance, representing the application context.
     * @return void
     */
    public function process(Quanta $quanta)
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $route)
        {
            $route->process($quanta, $requestUri);
        }
    }

    public function matchRoute(Quanta $quanta, $routeId): bool {
        $requestUri = $_SERVER['REQUEST_URI'];
        $route = $this->routes[$routeId];
        if($route) {
            if($route->isRoute($quanta, $requestUri)) {
                return true;
            }
        }
        return false;
    }
}