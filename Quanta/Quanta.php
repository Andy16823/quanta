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
require_once(__DIR__ . "/Core/Script.php");
require_once(__DIR__ . "/Core/ScriptHandler.php");
require_once(__DIR__ . "/Core/EventHandler.php");
require_once(__DIR__ . "/Core/ServiceHandler.php");
require_once(__DIR__ . "/Core/LogHandler.php");

// Core modules and dependencies
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
use Quanta\Core\Script;
use Quanta\Core\ScriptHandler;
use Quanta\Core\EventHandler;
use Quanta\Core\ServiceHandler;
use Quanta\Core\LogHandler;

/**
 * The main Quanta class, responsible for managing the core components and modules of the application.
 */
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
    public ?ScriptHandler $scriptHandler;
    public ?EventHandler $eventHandler;
    public ?ServiceHandler $serviceHandler;
    public ?LogHandler $logHandler;
    /**
     * Constructor to initialize all handlers and core components.
     */
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
        $this->scriptHandler = new ScriptHandler();
        $this->eventHandler = new EventHandler();
        $this->serviceHandler = new ServiceHandler();
        $this->logHandler = new LogHandler();
    }

    /**
     * Destructor to clean up all handlers and release resources.
     */
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
        $this->scriptHandler = null;
        $this->eventHandler = null;
        $this->serviceHandler = null;
        $this->logHandler = null;
    }

    /**
     * Prepares the application environment, such as setting up routes.
     */
    public function prepareEnvironment()
    {
        $this->routeHandler->prepareRoute($this);
    }

    /**
     * Fetches all messages from the message queue.
     * 
     * @return void
     */
    public function fetchMessages()
    {
        $this->messageHandler->fetchMessages($this);
    }

    /**
     * Adds a message to the message queue.
     * 
     * @param \Quanta\Core\Message $message The message to add.
     * @return void
     */
    public function addMessage($message)
    {
        $this->messageHandler->addMessage($this, $message);
    }

    /**
     * Retrieves the current domain with the protocol (http or https).
     * 
     * @return string The current domain with protocol.
     */
    public static function getDomain(): string
    {
        $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== 'off') ? "https" : "http";
        $domain = $_SERVER["HTTP_HOST"];

        return $protocol . "://" . $domain;
    }

    /**
     * Retrieves the current URL without query parameters.
     * 
     * @return string|null The path of the current URL.
     */
    public static function getCurrentURL()
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * Processes actions and handles redirects if required.
     * 
     * @param bool $redirect Whether to handle redirects based on action output.
     * @return void
     */
    public function processAction($redirect = true)
    {
        $this->actionHandler->process($this, $redirect);
    }

    /**
     * Handles routing logic to render components based on the current URL.
     * 
     * @param string $defaultComponent Default component to render if no route matches.
     * @return void
     */
    public function processRouting($defaultComponent = "")
    {
        $this->routeHandler->process($this);
    }

    /**
     * Matches a specific route based on its ID.
     * 
     * @param string $routeId The route ID to match.
     * @return bool Whether the route was matched.
     */
    public function matchRoute($routeId): bool
    {
        return $this->routeHandler->matchRoute($this, $routeId);
    }

    /**
     * Renders the specified component.
     * 
     * @param string $id Component ID to render.
     * @param array $data Data passed to the component.
     * @return void
     */
    public function renderComponent(string $id, mixed $data = [])
    {
        $this->componentHandler->render($this, $id, $data);
    }

    /**
     * Loads all available modules into the application.
     * 
     * @return void
     */
    public function loadModules()
    {
        $this->moduleHandler->loadModules($this);
    }

    /**
     * Adds a module to the application.
     * 
     * @param Module $module The module to add.
     * @return Module The added module.
     */
    public function addModule(Module $module): Module
    {
        $this->moduleHandler->addModule($module);
        return $module;
    }

    /**
     * Loads a template from the specified file.
     * 
     * @param string $filename Path to the template file.
     * @param array $params Parameters to pass to the template.
     * @return string|false The rendered template content or false if the file doesn't exist.
     */
    public function loadTemplate($filename, $params = [])
    {
        $params['quanta'] = $this;
        if (file_exists($filename)) {
            extract($params);
            ob_start();
            include($filename);
            $templateContent = ob_get_clean();
            return $templateContent;
        }
        return false;
    }

    /**
     * Constructs a URL using the current domain and a given path.
     * 
     * @param string $path The URL path.
     * @return string The full URL.
     */
    public function buildUrl(string $path): string
    {
        if ($this->memory->appDomain !== null && $this->memory->baseUrl !== null) {
            return $this->memory->appDomain . $this->memory->baseUrl . $path;
        } else {
            return Quanta::getDomain() . $path;
        }
    }

    /**
     * Renders a specific asset by its ID.
     * 
     * @param string $assetId The asset ID to render.
     * @return void
     */
    public function renderAsset($assetId)
    {
        $this->assetHandler->renderAsset($this, $assetId);
    }

    /**
     * Renders all assets of a specific type.
     * 
     * @param string $type The type of assets to render (e.g., "css" or "js").
     * @return void
     */
    public function renderAssets($type)
    {
        $this->assetHandler->renderAssets($this, $type);
    }

    /**
     * Loads a configuration file and processes its contents.
     * 
     * @param string $file Path to the configuration file.
     * @return void
     */
    public function loadConfig(string $file)
    {
        if (file_exists($file)) {
            $file_contents = file_get_contents($file);
            $config = json_decode($file_contents, true);

            // Get the appDomain from the config and set it in memory
            if (isset($config['appDomain'])) {
                $this->memory->appDomain = $config['appDomain'];
            }

            // Get the baseUrl from the config and set it in memory
            if (isset($config['baseUrl'])) {
                $this->memory->baseUrl = $config['baseUrl'];
            }

            // Load assets from the config such as CSS and JS files
            if (isset($config['assets'])) {
                $assets = $config['assets'];
                $this->assetHandler->loadAssets($assets);
            }

            // Load variables into memory
            if (isset($config['vars'])) {
                foreach ($config['vars'] as $key => $value) {
                    $this->memory->$key = $value;
                }
            }

            // Load modules from the config and initialize them
            // Required fields: class, path, id
            if (isset($config['modules'])) {
                $modules = $config['modules'];
                foreach ($modules as $moduleInfo) {
                    if (isset($moduleInfo['class']) && isset($moduleInfo['path']) && isset($moduleInfo['id'])) {
                        require_once($moduleInfo['path']);
                        $className = $moduleInfo['class'];
                        if (class_exists($className) && is_subclass_of($className, Module::class)) {
                            $moduleInstance = new $className($moduleInfo['id']);
                            $this->addModule($moduleInstance);
                        }
                    }
                }
            }

            // Setup log files from the config
            if (isset($config['logs'])) {
                $logs = $config['logs'];
                foreach ($logs as $logInfo) {
                    if (isset($logInfo['file']) && isset($logInfo['id'])) {
                        $id = $logInfo['id'];
                        $logDir = dirname($logInfo['file']);
                        if (!is_dir($logDir)) {
                            mkdir($logDir, 0755, true);
                        }
                        $this->memory->$id = $logInfo['file'];
                    }
                }
            }

        }
    }

    /**
     * Redirects to a 403 page if the request is made from a 'www.' subdomain.
     * 
     * @return void
     */
    public function redirect403()
    {
        if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
            $newHost = substr($_SERVER['HTTP_HOST'], 4);
            $requestUri = $_SERVER['REQUEST_URI'];
            $newUrl = 'https://' . $newHost . $requestUri;

            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $newUrl);
            header("Connection: close");
            exit();
        }
    }

    /**
     * Gets a script by its ID.
     * 
     * @param string $scriptId
     * @return Script|null
     */
    public function getScript(string $scriptId): ?Script
    {
        return $this->scriptHandler->getScript($scriptId);
    }

    /**
     * Processes all scripts and returns their output.
     * 
     * @return string
     */
    public function processScripts(): string
    {
        return $this->scriptHandler->processScripts($this);
    }

    /**
     * Processes a specific script by its ID.
     * 
     * @param string $scriptId
     * @return string
     */
    public function processScript(string $scriptId): string
    {
        return $this->scriptHandler->processScript($this, $scriptId);
    }

    /**
     * Removes a script by its ID.
     * 
     * @param string $scriptId
     * @return void
     */
    public function removeScript(string $scriptId)
    {
        $this->scriptHandler->removeScript($scriptId);
    }

    /**
     * Adds a script to the script handler.
     * 
     * @param Script $script The script to add.
     * @return void
     */
    public function addScript(Script $script)
    {
        $this->scriptHandler->addScript($script);
    }

    /**
     * Triggers an event with the specified name and arguments.
     * 
     * @param string $eventName The name of the event to trigger.
     * @param mixed ...$args Additional arguments to pass to the event callbacks.
     * @return void
     */
    public function triggerEvent($eventName, ...$args)
    {
        if ($this->eventHandler !== null) {
            $this->eventHandler->triggerEvent($this, $eventName, ...$args);
        }
    }

    /**
     * Redirects to a specified URL.
     * 
     * @param string $url The URL to redirect to.
     * @return void
     */
    public function redirect(string $url)
    {
        header("Location: " . $url);
        exit();
    }

    /**
     * Redirects to a specified URL using JavaScript.
     * 
     * @param string $url The URL to redirect to.
     * @return void
     */
    public function redirectJs(string $url)
    {
        echo "<script>window.location.href = '" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "';</script>";
        exit();
    }

    /**
     * Registers a service with the service handler.
     * @param mixed $name
     * @param mixed $service
     * @return void
     */
    public function registerService($name, $service)
    {
        $this->serviceHandler->registerService($name, $service);
    }

    /**
     * Retrieves a service by name from the service handler.
     * @param mixed $name
     * @return mixed
     */
    public function getService($name)
    {
        return $this->serviceHandler->getService($name);
    }

    /**
     * Gets a variable from memory by its key.
     * @param string $key
     * @return mixed
     */
    public function getVar(string $key): mixed
    {
        return $this->memory->$key ?? null;
    }
}