<?php
namespace Quanta\Core;

use Quanta\Quanta;

abstract class Route
{
    public string $routeId;

    public function __construct(string $routeId) {
        $this->routeId = $routeId;
    }

    abstract public function process(Quanta $quanta, string $url);
}

class QueryParameterRoute extends Route
{
    protected $queryParameterName;
    protected $componentId;
    protected $expectedParameterValue;


    public function __construct(string $routeId, string $queryParameterName, string $expectedParameterValue, string $componentId)
    {
        parent::__construct($routeId);
        $this->queryParameterName = $queryParameterName;
        $this->expectedParameterValue = $expectedParameterValue;
        $this->componentId = $componentId;
    }

    public function process(Quanta $quanta, string $url)
    {
        if (isset($_GET[$this->queryParameterName]))
        {
            if ($_GET[$this->queryParameterName] == $this->expectedParameterValue)
            {
                echo $quanta->render_component($this->componentId);
            }
        }
    }
}