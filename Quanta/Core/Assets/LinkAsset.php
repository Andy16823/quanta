<?php
namespace Quanta\Core\Assets;

use Quanta\Quanta;
use Quanta\Core\Asset;

class LinkAsset extends Asset
{
    protected $type = "link";

    public function render(Quanta $quanta): string
    {
        $html = "<" . $this->type;
        foreach ($this->params as $key => $value)
        {
            $html .= " " . htmlspecialchars($key) . "=\"" . htmlspecialchars($value) . "\"";
        }
        $html .= ">";
        return $html;
    }

    public function getType(Quanta $quanta): string
    {
        return $this->type;
    }
}
