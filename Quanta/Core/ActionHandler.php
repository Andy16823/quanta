<?php
namespace Quanta\Core;

use Quanta\Quanta;

class ActionHandler
{
    public $actions;
    public $actionParam;

    /**
     * Creates an new instance from the action handler
     */
    public function __construct()
    {
        $this->actions = array();
    }

    /**
     * Destructs the action handler
     */
    public function __destruct()
    {
        $this->actions = array();
    }

    /**
     * Initialize the action handler
     * @param mixed $action_param the action url parameter
     * @return void
     */
    public function init($actionParam = 'action')
    {
        $this->actionParam = $actionParam;
    }

    /**
     * Adds an action to the handler
     * @param Action $action the action to add
     * @return void
     */
    public function addAction(Action $action)
    {
        $this->actions[$action->getId()] = $action;
    }

    /**
     * Builds an action url for the given action id
     * @param string $action the action id
     * @param string $baseurl the base url to attach the action
     * @return string the url with the action parameter
     */
    public function buildActionURL(string $action, string $baseurl = null): string
    {
        if ($baseurl === null)
        {
            $baseurl = Quanta::getCurrentURL();
        }
        return $baseurl . '?' . $this->actionParam . '=' . $action;
    }

    /**
     * Process the action handling
     * @param mixed $quanta the Quanta instance
     * @param mixed $redirect determines if redirect or not
     * @return void
     */
    public function process(Quanta $quanta, bool $redirect = true)
    {
        if (isset($_GET[$this->actionParam]))
        {
            $action = $_GET[$this->actionParam];
            if (array_key_exists($action, $this->actions))
            {
                $result = $this->actions[$action]->execute($quanta);
                if ($redirect && $result)
                {
                    header('location: ' . $result);
                    exit;
                }
            }
        }
    }
}