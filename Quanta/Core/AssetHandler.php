<?php
namespace Quanta\Core;

use Quanta\Core\Assets\LinkAsset;
use Quanta\Core\Assets\ScriptAsset;
use Quanta\Quanta;

/**
 * Class AssetHandler
 * 
 * The AssetHandler class is responsible for managing assets (such as scripts and links) 
 * and rendering them based on their type or ID. It handles the addition, retrieval, 
 * and rendering of assets, and also supports loading assets from an array.
 */
class AssetHandler
{
    /**
     * @var array Stores the collection of assets.
     */
    protected array $assets;

    /**
     * Constructor: Initializes the assets array.
     */
    public function __construct()
    {
        $this->assets = array();
    }

    /**
     * Destructor: Clears the assets array when the object is destroyed.
     */
    public function __destruct()
    {
        $this->assets = array();
    }

    /**
     * Adds a new asset to the assets collection.
     * 
     * @param Asset $asset The asset to be added.
     * 
     * @return void
     */
    public function addAsset(Asset $asset)
    {
        $this->assets[$asset->getAssetID()] = $asset;
    }

    /**
     * Retrieves an asset by its unique asset ID.
     * 
     * @param string $asset_id The ID of the asset to retrieve.
     * 
     * @return Asset|null Returns the asset if found, or null if not.
     */
    public function getAsset(string $asset_id): ?Asset
    {
        if (isset($this->assets[$asset_id]))
        {
            return $this->assets[$asset_id];
        }
        return null;
    }

    /**
     * Renders assets of a specific type.
     * 
     * Iterates over the assets collection and outputs the rendered HTML for 
     * assets matching the given type (e.g., 'script' or 'link').
     * 
     * @param Quanta $quanta The Quanta instance used for rendering.
     * @param string $type The type of assets to render (e.g., 'script', 'link').
     * 
     * @return void
     */
    public function renderAssets(Quanta $quanta, string $type)
    {
        foreach ($this->assets as $asset)
        {
            if ($asset->getType() == $type)
            {
                echo $asset->render($quanta);
            }
        }
    }

    /**
     * Renders a specific asset by its ID.
     * 
     * Retrieves the asset by its ID and renders it if found.
     * 
     * @param Quanta $quanta The Quanta instance used for rendering.
     * @param string $assetId The unique ID of the asset to render.
     * 
     * @return void
     */
    public function renderAsset(Quanta $quanta, string $assetId)
    {
        $asset = $this->getAsset($assetId);
        if ($asset)
        {
            echo $asset->render($quanta);
        }
    }

    /**
     * Loads assets from an array and adds them to the assets collection.
     * 
     * Iterates through the provided assets array and creates either a LinkAsset 
     * or ScriptAsset depending on the 'type' specified for each asset.
     * 
     * @param array $assets The array of assets to load.
     * 
     * @return void
     */
    public function loadAssets(array $assets)
    {
        foreach ($assets as $asset)
        {
            if ($asset["type"] == LinkAsset::getType())
            {
                $linkAsset = new LinkAsset($asset["name"]);
                $linkAsset->setPrams($asset["params"]);
                $this->addAsset($linkAsset);
            }
            else if ($asset["type"] == ScriptAsset::getType())
            {
                $scriptAsset = new ScriptAsset($asset["name"]);
                $scriptAsset->setPrams($asset["params"]);
                $this->addAsset($scriptAsset);
            }
        }
    }

    /**
     * Prepares the value of a parameter by replacing placeholders with actual values.
     * 
     * @param string $paramValue The parameter value to process.
     * 
     * @return string The processed parameter value with replaced placeholders.
     */
    public function prepareParamValue(string $paramValue)
    {
        $paramValue = preg_replace("/\{QUANTA_DOMAIN\}/", Quanta::getDomain(), $paramValue);
        return $paramValue;
    }
}