<?php
require 'vendor/autoload.php'; 
use Quanta\Quanta;
use Quanta\Component;

// Create the quanta instance
$quanta = new Quanta();  

// Create an simple component
class MyComponent extends Component {
    public function render($quanta, $data) {
        return "<h1>Hello Quanta</h1>";
    }
}
$quanta->componentHandler->add_component(new MyComponent("home_component"));

// Register an simple route and call the url: https://yourpage.com/?page=home
$quanta->routeHandler->initial_routing();
$quanta->routeHandler->register_route("home", "home_component");

// Process the routing
$quanta->process_routing();