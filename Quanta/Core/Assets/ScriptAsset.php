<?php
namespace Quanta\Core\Assets;

use Quanta\Quanta;
use Quanta\Core\Asset;

class ScriptAsset extends Asset
{
    protected $type = "script";

    public function render(Quanta $quanta): string
    {
        $html = "<" . $this->type;
        foreach ($this->params as $key => $value)
        {
            $html .= " " . htmlspecialchars($key) . "=\"" . htmlspecialchars($value) . "\"";
        }
        $html .= "></" . $this->type . ">";
        return $html;
    }

    public function getType(Quanta $quanta): string
    {
        return $this->type;
    }
}
