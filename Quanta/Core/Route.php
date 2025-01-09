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
    protected string $componentId;
    protected array $params;

    public function __construct(string $routeId, array $params, string $componentId)
    {
        parent::__construct($routeId);
        $this->params = $params;
        $this->componentId = $componentId;
    }

    public function process(Quanta $quanta, string $url)
    {
        if (in_array($url, $this->params))
        {
            $quanta->renderComponent($this->componentId);
        }
    }
}

class PatternRoute extends Route
{
    protected string $pattern;
    protected mixed $callback;

    public function __construct(string $routeId, string $pattern, callable $callback)
    {
        parent::__construct($routeId);
        $this->pattern = $pattern;
        $this->callback = $callback;
    }

    public function process(Quanta $quanta, string $url)
    {
        if (preg_match_all($this->pattern, $url, $matches))
        {
            call_user_func($this->callback, $quanta, $url, $matches);
        }
    }
}

class SimplePatternRoute extends Route
{
    protected string $pattern;
    protected mixed $callback;

    public function __construct(string $routeId, string $pattern, callable $callback)
    {
        parent::__construct($routeId);
        $this->pattern = $this->parsePattern($pattern);
        $this->callback = $callback;
    }

    private function parsePattern(string $pattern): array|string|null {
        return '#^' . preg_replace("/\{([a-zA-Z0-9_]+)\}/", "(?P<$1>[^/]+)", $pattern) . '$#';
    }

    public function process(Quanta $quanta, string $url)
    {
        if (preg_match_all($this->pattern, $url, $matches))
        {
            call_user_func($this->callback, $quanta, $url, $matches);
        }
    }
}