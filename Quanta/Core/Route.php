<?php
namespace Quanta\Core;

use Quanta\Quanta;

abstract class Route
{
    public string $routeId;

    public function __construct(string $routeId)
    {
        $this->routeId = $routeId;
    }

    abstract public function process(Quanta $quanta, string $url);
}

class DefaultRoute extends Route
{
    protected string $queryParameterName;
    protected string $componentId;

    public function __construct(string $routeId, string $queryParameterName, string $componentId)
    {
        parent::__construct($routeId);
        $this->queryParameterName = $queryParameterName;
        $this->componentId = $componentId;
    }

    public function process(Quanta $quanta, string $url)
    {
        if (!isset($_GET[$this->queryParameterName]))
        {
            $quanta->renderComponent($this->componentId);
        }
    }
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
                $quanta->renderComponent($this->componentId);
            }
        }
    }
}

class CleanRoute extends Route
{
    protected string $pattern;
    protected string $componentId;

    public function __construct(string $routeId, string $pattern, string $componentId)
    {
        parent::__construct($routeId);
        $this->pattern = $pattern;
        $this->componentId = $componentId;
    }

    public function process(Quanta $quanta, string $url)
    {
        // $requestPath = parse_url($url, PHP_URL_PATH);
        if ($requestPath === $this->pattern) {
            $quanta->renderComponent($this->componentId);
        }
    }

}