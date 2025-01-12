<?php
namespace Quanta\Core\Assets;

use Quanta\Quanta;
use Quanta\Core\Asset;

/**
 * Class ScriptAsset
 * 
 * Represents a script asset, extending the abstract Asset class. This class 
 * is responsible for rendering a <script> HTML tag based on the asset's parameters 
 * and managing the asset's specific properties, such as its type and ID.
 */
class ScriptAsset extends Asset
{
    /**
     * @var string The type of the asset, which is "script" for ScriptAsset.
     */
    protected string $type;

    /**
     * Constructor: Initializes the ScriptAsset with an asset ID and sets its type.
     * 
     * @param string $assetId The unique ID for the script asset.
     */
    public function __construct(string $assetId)
    {
        parent::__construct($assetId);
        $this->type = $this->getType();
    }

    /**
     * Renders the script asset as an HTML <script> tag.
     * 
     * Iterates over the parameters of the script asset, prepares the values, 
     * and outputs an HTML string for the <script> tag with the appropriate attributes.
     * 
     * @param Quanta $quanta The Quanta instance used for preparing parameter values.
     * 
     * @return string The rendered <script> tag as a string.
     */
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

    /**
     * Returns the type of the asset, which is "script" for this class.
     * 
     * @return string The type of the asset (always "script" for ScriptAsset).
     */
    public static function getType(): string
    {
        return "script";
    }

    /**
     * Creates an instance of ScriptAsset from an array of data.
     * 
     * This is a static method that constructs a new ScriptAsset object using 
     * the data array, which contains the asset's name and parameters.
     * 
     * @param Quanta $quanta The Quanta instance, passed for context.
     * @param array $data The array containing asset data, including name and params.
     * 
     * @return Asset The created ScriptAsset object.
     */
    public static function fromArray(Quanta $quanta, array $data): Asset
    {
        $asset = new ScriptAsset($data["name"]);
        $asset->setPrams($data["params"]);
        return $asset;
    }
}
