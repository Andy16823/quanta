<?php
namespace Quanta\Core;

use Quanta\Quanta;

/**
 * Class Asset
 * 
 * Abstract class representing an asset. An asset can be a script, link, or other 
 * resources, and it encapsulates properties like the asset ID and parameters.
 * Concrete classes should extend this class and implement the `render()` and 
 * other abstract methods.
 */
abstract class Asset
{
    /**
     * @var string The unique identifier for the asset.
     */
    protected $assetId;

    /**
     * @var array An associative array to store parameters for the asset.
     */
    protected $params;

    /**
     * Constructor: Initializes the asset with an ID and an empty parameters array.
     * 
     * @param string $assetId The unique ID for the asset.
     */
    public function __construct(string $assetId)
    {
        $this->assetId = $assetId;
        $this->params = array();
    }

    /**
     * Magic getter: Retrieves the value of a parameter by its name.
     * 
     * If the parameter exists, it returns its value; otherwise, returns null.
     * 
     * @param string $name The name of the parameter.
     * 
     * @return mixed|null The value of the parameter or null if not found.
     */
    public function __get($name)
    {
        if (isset($this->params[$name]))
        {
            return $this->params[$name];
        }
        return null;
    }

    /**
     * Magic setter: Sets the value of a parameter.
     * 
     * This allows dynamic setting of parameters.
     * 
     * @param string $name The name of the parameter.
     * @param mixed $value The value to assign to the parameter.
     */
    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * Magic unset: Unsets a parameter by its name.
     * 
     * This will remove the specified parameter and set its value to null.
     * 
     * @param string $name The name of the parameter to unset.
     */
    public function __unset($name)
    {
        $this->params[$name] = null;
    }

    /**
     * Sets multiple parameters at once.
     * 
     * @param array $params An associative array of parameters to set.
     * 
     * @return void
     */
    public function setPrams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Retrieves the unique asset ID.
     * 
     * @return string The unique identifier for the asset.
     */
    public function getAssetID(): string
    {
        return $this->assetId;
    }

    /**
     * Renders the asset as a string.
     * 
     * This method should be implemented by subclasses to define how the asset
     * should be rendered (e.g., generating HTML for a script or link tag).
     * 
     * @param Quanta $quanta The Quanta instance used for rendering.
     * 
     * @return string The rendered output of the asset.
     */
    public abstract function render(Quanta $quanta): string;

    /**
     * Creates an instance of an asset from an array.
     * 
     * This is a factory method used to create an asset object from an array 
     * of data. Subclasses should implement this method to correctly instantiate 
     * objects from the provided data.
     * 
     * @param Quanta $quanta The Quanta instance for context.
     * @param array $data The data array used to create the asset.
     * 
     * @return Asset The newly created asset object.
     */
    public static abstract function fromArray(Quanta $quanta, array $data): Asset;

    /**
     * Retrieves the type of the asset.
     * 
     * This method should be implemented by subclasses to return a string 
     * representing the asset's type (e.g., 'script', 'link').
     * 
     * @return string The type of the asset.
     */
    public static abstract function getType(): string;
}