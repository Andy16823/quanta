<?php
class ActionHandler
{
    public $actions;
    public $action_param;

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
    public function init($action_param = 'action')
    {
        $this->action_param = $action_param;
    }

    /**
     * Adds an action to the handler
     * @param Action $action the action to add
     * @return void
     */
    public function add_action(Action $action)
    {
        $this->actions[$action->getId()] = $action;
    }

    /**
     * Builds an action url for the given action id
     * @param string $action the action id
     * @param string $baseurl the base url to attach the action
     * @return string the url with the action parameter
     */
    public function build_action_url(string $action, string $baseurl = null): string
    {
        if ($baseurl === null) { 
            $baseurl = Quanta::get_current_url();
        }
        return $baseurl . '?' . $this->action_param . '=' . $action;
    }

    /**
     * Process the action handling
     * @param mixed $quanta the Quanta instance
     * @param mixed $redirect determines if redirect or not
     * @return void
     */
    public function process($quanta, $redirect = true)
    {
        if (isset($_GET[$this->action_param]))
        {
            $action = $_GET[$this->action_param];
            if (array_key_exists($action, $this->actions))
            {
                $result = $this->actions[$action]->execute($quanta);
                if ($redirect && $result)
                {
                    header('location: ' . $result);
                }
            }
        }
    }
}