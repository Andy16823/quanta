<?php
namespace Quanta;
session_start();

require_once("Core/Message.php");
require_once("Core/Module.php");
require_once("Core/Action.php");
require_once("Core/Component.php");
require_once("Core/ComponentHandler.php");
require_once("Core/ActionHandler.php");
require_once("Core/Memory.php");
require_once("Core/DatabaseHandler.php");
require_once("Core/RouteHandler.php");
require_once("Core/ModuleHandler.php");
require_once("Core/MessageHandler.php");
require_once("Core/PrebuildInstances.php");
require_once("Core/Route.php");

use Quanta\Core\Module;
use Quanta\Core\Memory;
use Quanta\Core\ActionHandler;
use Quanta\Core\ComponentHandler;
use Quanta\Core\DatabaseHandler;
use Quanta\Core\RouteHandler;
use Quanta\Core\ModuleHandler;
use Quanta\Core\MessageHandler;

class Quanta
{
    public ?Memory $memory;
    public ?ActionHandler $actionHandler;
    public ?ComponentHandler $componentHandler;
    public ?DatabaseHandler $databaseHandler;
    public ?RouteHandler $routeHandler;
    public ?ModuleHandler $moduleHandler;
    public ?MessageHandler $messageHandler;

    public function __construct()
    {
        $this->actionHandler = new ActionHandler();
        $this->memory = new Memory();
        $this->componentHandler = new ComponentHandler();
        $this->databaseHandler = new DatabaseHandler();
        $this->routeHandler = new RouteHandler();
        $this->moduleHandler = new ModuleHandler();
        $this->messageHandler = new MessageHandler();
    }

    public function __destruct()
    {
        $this->moduleHandler->disposeModules();
        $this->vars = array();
        $this->actionHandler = null;
        $this->memory = null;
        $this->componentHandler = null;
        $this->databaseHandler = null;
        $this->routeHandler = null;
        $this->moduleHandler = null;
        $this->messageHandler = null;
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
}