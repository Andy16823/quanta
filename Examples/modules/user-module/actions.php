<?php

class CreateUserAction extends Action
{
    private string $moduleId;

    public function __construct($id, $moduleId)
    {
        parent::__construct($id);
        $this->moduleId = $moduleId;
    }

    public function execute($quanta): string|bool
    {
        // $user = $quanta->moduleHandler->get_module_by_type(UserModule::class);
        $user = $quanta->moduleHandler->get_module_by_id($this->moduleId);
        if ($user)
        {
            if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]))
            {
                $result = $user->create_user($_POST["username"], $_POST["password"], $_POST["email"]);
                if ($result)
                {
                    $quanta->messageHandler->add_message(new SuccessMessage("User Created!"));
                }
                else
                {
                    $quanta->messageHandler->add_message(new ErrorMessage("Can't create user"));
                }
            }
            else
            {
                $quanta->messageHandler->add_message(new ErrorMessage("Missing formdata"));
            }
        }
        return false;
    }
}