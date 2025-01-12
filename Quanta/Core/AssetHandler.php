<?php
namespace Quanta\Core;

use Quanta\Core\Assets\LinkAsset;
use Quanta\Core\Assets\ScriptAsset;
use Quanta\Quanta;

class AssetHandler
{
    protected array $assets;

    public function __construct()
    {
        $this->assets = array();
    }

    public function __destruct()
    {
        $this->assets = array();
    }

    public function addAsset(Asset $asset)
    {
        $this->assets[$asset->getAssetID()] = $asset;
    }

    public function getAsset(string $asset_id): ?Asset
    {
        if (isset($this->assets[$asset_id]))
        {
            return $this->assets[$asset_id];
        }
        return null;
    }

    public function renderAssets(Quanta $quanta, string $type)
    {
        foreach ($this->assets as $asset)
        {
            echo "asset: " . $asset->getType();
            if ($asset->getType() == $type)
            {
                echo $asset->render($quanta);
            }
        }
    }

    public function renderAsset(Quanta $quanta, string $assetId)
    {
        $asset = $this->getAsset($assetId);
        if ($asset)
        {
            echo $asset->render($quanta);
        }
    }

    /**
     * Loads the assets from an asset array
     * @param array $assets
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

    public function prepareParamValue(string $paramValue)
    {
        $paramValue = preg_replace("/\{QUANTA_DOMAIN\}/", Quanta::getDomain(), $paramValue);
        return $paramValue;
    }
}