<?php
namespace Quanta;

use Quanta\Core\Assets\LinkAsset;
session_start();

require_once(__DIR__ . "/Core/Message.php");
require_once(__DIR__ . "/Core/Module.php");
require_once(__DIR__ . "/Core/Action.php");
require_once(__DIR__ . "/Core/Component.php");
require_once(__DIR__ . "/Core/ComponentHandler.php");
require_once(__DIR__ . "/Core/ActionHandler.php");
require_once(__DIR__ . "/Core/Memory.php");
require_once(__DIR__ . "/Core/DatabaseHandler.php");
require_once(__DIR__ . "/Core/RouteHandler.php");
require_once(__DIR__ . "/Core/ModuleHandler.php");
require_once(__DIR__ . "/Core/MessageHandler.php");
require_once(__DIR__ . "/Core/PrebuildInstances.php");
require_once(__DIR__ . "/Core/Route.php");
require_once(__DIR__ . "/Core/AssetHandler.php");
require_once(__DIR__ . "/Core/Asset.php");
require_once(__DIR__ . "/Core/Assets/LinkAsset.php");
require_once(__DIR__ . "/Core/Assets/ScriptAsset.php");

use Quanta\Core\Module;
use Quanta\Core\Memory;
use Quanta\Core\ActionHandler;
use Quanta\Core\ComponentHandler;
use Quanta\Core\DatabaseHandler;
use Quanta\Core\RouteHandler;
use Quanta\Core\ModuleHandler;
use Quanta\Core\MessageHandler;
use Quanta\Core\Asset;
use Quanta\Core\AssetHandler;

class Quanta
{
    public ?Memory $memory;
    public ?ActionHandler $actionHandler;
    public ?ComponentHandler $componentHandler;
    public ?DatabaseHandler $databaseHandler;
    public ?RouteHandler $routeHandler;
    public ?ModuleHandler $moduleHandler;
    public ?MessageHandler $messageHandler;
    public ?AssetHandler $assetHandler;

    public function __construct()
    {
        $this->actionHandler = new ActionHandler();
        $this->memory = new Memory();
        $this->componentHandler = new ComponentHandler();
        $this->databaseHandler = new DatabaseHandler();
        $this->routeHandler = new RouteHandler();
        $this->moduleHandler = new ModuleHandler();
        $this->messageHandler = new MessageHandler();
        $this->assetHandler = new AssetHandler();
    }

    public function __destruct()
    {
        $this->moduleHandler->disposeModules($this);
        $this->actionHandler = null;
        $this->memory = null;
        $this->componentHandler = null;
        $this->databaseHandler = null;
        $this->routeHandler = null;
        $this->moduleHandler = null;
        $this->messageHandler = null;
        $this->assetHandler = null;
    }

    /**
     * Fetch the messages from the message que
     * @return void
     */
    public function fetchMessages()
    {
        $this->messageHandler->fetchMessages($this);
    }

    /**
     * Returns the current domain with the protocol
     * @return string
     */
    public static function getDomain(): string {
        $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== 'off') ? "https" : "http";
        $domain = $_SERVER["HTTP_HOST"];

        return $protocol . "://" . $domain;
    }

    /**
     * Returns the current url without any parameters
     * @return array|bool|int|string|null
     */
    public static function getCurrentURL()
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * Process the action commands
     * @param mixed $redirect if true you can redirect to the given url from the action return.
     * @return void
     */
    public function processAction($redirect = true)
    {
        $this->actionHandler->process($this, $redirect);
    }

    /**
     * Process the routing
     * @return void
     */
    public function processRouting($defaultComponent = "")
    {
        $this->routeHandler->process($this);
    }

    /**
     * Renders the given component
     * @param string $id the component id
     * @param mixed $data an array with data wich passed to the component render function
     * @return void
     */
    public function renderComponent(string $id, mixed $data = [])
    {
        $this->componentHandler->render($this, $id, $data);
    }

    /**
     * Loads the modules
     * @return void
     */
    public function loadModules()
    {
        $this->moduleHandler->loadModules($this);
    }

    /**
     * Adds an module
     * @param Module $module the module to add
     * @return Module the added module
     */
    public function addModule(Module $module): Module
    {
        $this->moduleHandler->addModule($module);
        return $module;
    }

    /**
     * Loads an template from the fiven filename
     * @param mixed $filename the path to the file
     * @param mixed $params the parameters wich passed to the template wich gets loaded
     * @return bool|string returns the loaded template as string or false if the file dont exist
     */
    public function loadTemplate($filename, $params = [])
    {
        $params['quanta'] = $this;
        if (file_exists($filename))
        {
            extract($params);
            ob_start();
            include($filename);
            $templateContent = ob_get_clean();
            return $templateContent;
        }
        return false;
    }

    /**
     * Builds an url with the current domain and the url path
     * @param string $path the path for the url
     * @return string the builded domain
     */
    public function buildUrl(string $path): string {
        return Quanta::getDomain() . $path;
    }

    /**
     * Renders the asset with the given assetId
     * @param mixed $assetId the id for the asset
     * @return void
     */
    public function renderAsset($assetId) {
        $this->assetHandler->renderAsset($this, $assetId);
    }

    /**
     * Renders the assets with the given type
     * @param mixed $type
     * @return void
     */
    public function renderAssets($type) {
        $this->assetHandler->renderAssets($this, $type);
    }

    /**
     * Loads an config file
     * @param string $file the path to the config file
     * @return void
     */
    public function loadConfig(string $file) {
        if(file_exists($file)) {
            $file_contents = file_get_contents($file);
            $config = json_decode($file_contents, true);
            if(isset($config['assets'])) {
                $assets = $config['assets'];
                $this->assetHandler->loadAssets($assets);
                var_dump($this->assetHandler);
            }
        }
    }
}