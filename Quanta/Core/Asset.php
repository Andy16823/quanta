<?php
namespace Quanta\Core;

use Quanta\Quanta;

abstract class Asset
{
    protected $assetId;
    protected $params;

    public function __construct(string $assetId)
    {
        $this->assetId = $assetId;
        $this->params = array();
    }

    public function __get($name)
    {
        if (isset($this->params[$name]))
        {
            return $this->params[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __unset($name)
    {
        $this->params[$name] = null;
    }

    public function setPrams(array $params)
    {
        $this->params = $params;
    }

    public function getAssetID(): string
    {
        return $this->assetId;
    }

    public abstract function render(Quanta $quanta): string;
    public static abstract function fromArray(Quanta $quanta, array $data): Asset;
    public static abstract function getType(): string;
}