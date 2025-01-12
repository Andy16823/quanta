<?php
namespace Quanta\Core\Assets;

use Quanta\Quanta;
use Quanta\Core\Asset;

/**
 * Class LinkAsset
 * 
 * Represents a link asset, extending the abstract Asset class. This class 
 * is responsible for rendering a <link> HTML tag based on the asset's parameters 
 * and managing the asset's specific properties, such as its type and ID.
 */
class LinkAsset extends Asset
{
    /**
     * @var string The type of the asset, which is "link" for LinkAsset.
     */
    protected string $type;

    /**
     * Constructor: Initializes the LinkAsset with an asset ID and sets its type.
     * 
     * @param string $assetId The unique ID for the link asset.
     */
    public function __construct(string $assetId)
    {
        parent::__construct($assetId);
        $this->type = $this->getType();
    }

    /**
     * Renders the link asset as an HTML <link> tag.
     * 
     * Iterates over the parameters of the link asset, prepares the values, 
     * and outputs an HTML string for the <link> tag with the appropriate attributes.
     * 
     * @param Quanta $quanta The Quanta instance used for preparing parameter values.
     * 
     * @return string The rendered <link> tag as a string.
     */
    public function render(Quanta $quanta): string
    {
        $html = "<" . $this->type;
        foreach ($this->params as $key => $value)
        {
            $param_value = $quanta->assetHandler->prepareParamValue($value);
            $html .= " " . htmlspecialchars($key) . "=\"" . htmlspecialchars($param_value) . "\"";
        }
        $html .= ">";
        return $html;
    }

    /**
     * Returns the type of the asset, which is "link" for this class.
     * 
     * @return string The type of the asset (always "link" for LinkAsset).
     */
    public static function getType(): string
    {
        return "link";
    }

    /**
     * Creates an instance of LinkAsset from an array of data.
     * 
     * This is a static method that constructs a new LinkAsset object using 
     * the data array, which contains the asset's name and parameters.
     * 
     * @param Quanta $quanta The Quanta instance, passed for context.
     * @param array $data The array containing asset data, including name and params.
     * 
     * @return Asset The created LinkAsset object.
     */
    public static function fromArray(Quanta $quanta, array $data): Asset
    {
        $asset = new LinkAsset($data["name"]);
        $asset->setPrams($data["params"]);
        return $asset;
    }
}
