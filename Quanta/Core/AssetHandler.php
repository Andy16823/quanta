<?php
namespace Quanta\Core;

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
        foreach ($this->assets as $key => $value)
        {
            if ($value->getType($quanta) == $type)
            {
                echo $value->render($quanta);
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
}