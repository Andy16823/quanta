<?php
namespace Quanta\Core;

use Exception;

/**
 * An route handler which handles the drawing from components when given url's gets called
 */
class RouteHandler
{
    protected $routes;
    protected $routeParam;
    protected $fallbackComponent;

    /**
     * Returns an fallback component
     * @param mixed $quanta the Quanta instance
     * @throws \Exception No component exception
     * @return mixed return the fallback component
     */
    private function get_fallback_component($quanta)
    {
        if ($this->fallbackComponent)
        {
            if ($quanta->componentHandler->exist_component($this->fallbackComponent))
            {
                return $quanta->render_component($this->fallbackComponent);
            }
            else
            {
                throw new Exception("fallbackComponent dont exist.");
            }
        }
        else
        {
            return "404 - Component not found";
        }
    }

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

    /**
     * Initialize the routing
     * @param mixed $routeParam the get parameter where the handler is watching for
     * @param mixed $fallbackComponent the fallback component id
     * @return void
     */
    public function initial_routing($routeParam = "page", $fallbackComponent = null)
    {
        $this->routeParam = $routeParam;
        $this->fallbackComponent = $fallbackComponent;
    }

    /**
     * Register an new route
     * @param string $name the keyword where the handler is watching for
     * @param string $component_id the component id which gets rendered when the routeParam and the name match
     * @return void
     */
    public function register_route(string $name, string $component_id)
    {
        $this->routes[$name] = $component_id;
    }

    /**
     * Performs the routing. Gets called from quanta
     * @param mixed $quanta the Quanta instance
     * @return void
     */
    public function route($quanta, $defaultComponent = "")
    {
        if (isset($_GET[$this->routeParam]))
        {
            $route = $_GET[$this->routeParam];
            if (array_key_exists($route, $this->routes))
            {
                echo $quanta->render_component($this->routes[$route]);
            }
            else
            {
                echo $this->get_fallback_component($quanta);
            }
        }
        elseif ($defaultComponent)
        {
            echo $quanta->render_component($defaultComponent);
        }
    }
}