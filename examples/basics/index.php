<?php
require 'vendor/autoload.php'; 
use Quanta\Core\QueryParameterRoute;
use Quanta\Quanta;
use Quanta\Core\Component;
use Quanta\Core\Route;

// Create the quanta instance
$quanta = new Quanta();  

// Create an simple component
class MyComponent extends Component {
    public function render($quanta, $data) {
        return "<h1>Hello Quanta</h1>";
    }
}
$quanta->componentHandler->addComponent(new MyComponent("homeComponent"));

// Register an simple route and call the url: https://yourpage.com/?page=home
$quanta->routeHandler->addRoute(new QueryParameterRoute("home", "page", "home", "homeComponent"));

// Process the routing
$quanta->processRouting();