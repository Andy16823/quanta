<?php
namespace Quanta\Core;

use Quanta\Quanta;

abstract class Route
{
    public string $routeId;
    public mixed $prepareCallback = null;

    public function __construct(string $routeId)
    {
        $this->routeId = $routeId;
    }

    public function setPrepareCallback(callable $prepareCallback)
    {
        $this->prepareCallback = $prepareCallback;
    }

    abstract protected function isRoute(Quanta $quanta, string $url) : mixed;
    abstract public function prepare(Quanta $quanta, string $url);
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

    protected function isRoute(Quanta $quanta, string $url): bool
    {
        if (!isset($_GET[$this->queryParameterName]))
        {
            return true;
        }
        return false;
    }

    public function prepare(Quanta $quanta, string $url)
    {
        if ($this->isRoute($quanta, $url))
        {
            if ($this->prepareCallback !== null)
            {
                call_user_func($this->prepareCallback, $quanta, $url, null);
            }
        }
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

    protected function isRoute(Quanta $quanta, string $url): bool
    {
        if (isset($_GET[$this->queryParameterName]))
        {
            if ($_GET[$this->queryParameterName] == $this->expectedParameterValue)
            {
                return true;
            }
        }
        return false;
    }

    public function prepare(Quanta $quanta, string $url)
    {
        if ($this->isRoute($quanta, $url))
        {
            if ($this->prepareCallback !== null)
            {
                call_user_func($this->prepareCallback, $quanta, $url, null);
            }
        }
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

    public function isRoute(Quanta $quanta, string $url): bool
    {
        $cleanUrl = strtok($url, '?');
        if (in_array($cleanUrl, $this->params))
        {
            return true;
        }
        return false;
    }

    public function prepare(Quanta $quanta, string $url)
    {
        if ($this->isRoute($quanta, $url))
        {
            if ($this->prepareCallback !== null)
            {
                call_user_func($this->prepareCallback, $quanta, $url, null);
            }
        }
    }

    public function process(Quanta $quanta, string $url)
    {
        if ($this->isRoute($quanta, $url))
        {
            $quanta->renderComponent($this->componentId);
        }
    }
}

class PatternRoute extends Route
{
    protected string $pattern;
    protected mixed $callback;
    protected bool $cleanUrl;

    public function __construct(string $routeId, string $pattern, bool $cleanUrl, callable $callback)
    {
        parent::__construct($routeId);
        $this->pattern = $pattern;
        $this->callback = $callback;
        $this->cleanUrl = $cleanUrl;
    }

    protected function isRoute(Quanta $quanta, string $url): array|bool|null
    {
        if ($this->cleanUrl)
        {
            $url = strtok($url, '?');
        }
        if (preg_match_all($this->pattern, $url, $matches))
        {
            return $matches;
        }
        return false;
    }

    public function prepare(Quanta $quanta, string $url)
    {
        $result = $this->isRoute($quanta, $url);
        if ($result)
        {
            if ($this->prepareCallback !== null)
            {
                call_user_func($this->prepareCallback, $quanta, $url, $result);
            }
        }
    }

    public function process(Quanta $quanta, string $url)
    {
        $result = $this->isRoute($quanta, $url);
        if ($result)
        {
            call_user_func($this->callback, $quanta, $url, $result);
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

    private function parsePattern(string $pattern): array|string|null
    {
        return '#^' . preg_replace("/\{([a-zA-Z0-9_]+)\}/", "(?P<$1>[^/]+)", $pattern) . '$#';
    }

    protected function isRoute(Quanta $quanta, string $url): array|bool|null
    {
        $url = strtok($url, '?');
        if (preg_match_all($this->pattern, $url, $matches))
        {
            return $matches;
        }
        return false;
    }

    public function prepare(Quanta $quanta, string $url)
    {
        $result = $this->isRoute($quanta, $url);
        if ($result)
        {
            if ($this->prepareCallback !== null)
            {
                call_user_func($this->prepareCallback, $quanta, $url, $result);
            }
        }
    }

    public function process(Quanta $quanta, string $url)
    {
        $result = $this->isRoute($quanta, $url);
        if ($result)
        {
            call_user_func($this->callback, $quanta, $url, $result);
        }
    }
}