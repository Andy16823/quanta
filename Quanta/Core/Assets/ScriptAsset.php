<?php
namespace Quanta\Core\Assets;

use Quanta\Quanta;
use Quanta\Core\Asset;

class ScriptAsset extends Asset
{
    protected string $type;

    public function __construct(string $assetId)
    {
        parent::__construct($assetId);
        $this->type = $this->getType();
    }

    public function render(Quanta $quanta): string
    {
        $html = "<" . $this->type;
        foreach ($this->params as $key => $value)
        {
            $param_value = $quanta->assetHandler->prepareParamValue($value);
            $html .= " " . htmlspecialchars($key) . "=\"" . htmlspecialchars($param_value) . "\"";
        }
        $html .= "></" . $this->type . ">";
        return $html;
    }

    public static function getType(): string
    {
        return "script";
    }

    public static function fromArray(Quanta $quanta, array $data): Asset
    {
        $asset = new ScriptAsset($data["name"]);
        $asset->setPrams($data["params"]);
        return $asset;
    }
}
