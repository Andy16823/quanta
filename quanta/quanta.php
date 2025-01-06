<?php
session_start();
include_once("inc/message.php");
include_once("inc/module.php");
include_once("inc/action.php");
include_once("inc/component.php");
include_once("inc/component_handler.php");
include_once("inc/action_handler.php");
include_once("inc/memory.php");
include_once("inc/database_handler.php");
include_once("inc/route_handler.php");
include_once("inc/module_handler.php");
include_once("inc/message_handler.php");
include_once("inc/prebuild-instances.php");

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
        $this->moduleHandler->dispose_modules();
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
    public function fetch_messages()
    {
        $this->messageHandler->fetch_messages($this);
    }

    /**
     * Returns the current url without any parameters
     * @return array|bool|int|string|null
     */
    public static function get_current_url()
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * Process the action commands
     * @param mixed $redirect if true you can redirect to the given url from the action return.
     * @return void
     */
    public function process_action($redirect = true)
    {
        $this->actionHandler->process($this, $redirect);
    }

    /**
     * Process the routing
     * @return void
     */
    public function process_routing()
    {
        $this->routeHandler->route($this);
    }

    /**
     * Renders the given component
     * @param string $id the component id
     * @param mixed $data an array with data wich passed to the component render function
     * @return void
     */
    public function render_component($id, $data = [])
    {
        $this->componentHandler->render($this, $id, $data);
    }

    /**
     * Loads the modules
     * @return void
     */
    public function load_modules()
    {
        $this->moduleHandler->load_modules($this);
    }

    /**
     * Adds an module
     * @param Module $module the module to add
     * @return Module the added module
     */
    public function add_module(Module $module): Module
    {
        $this->moduleHandler->add_module($module);
        return $module;
    }

    /**
     * Loads an template from the fiven filename
     * @param mixed $filename the path to the file
     * @param mixed $params the parameters wich passed to the template wich gets loaded
     * @return bool|string returns the loaded template as string or false if the file dont exist
     */
    public function load_template($filename, $params = [])
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