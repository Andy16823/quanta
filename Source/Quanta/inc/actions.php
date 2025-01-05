<?php

class HelloWorldAction extends Action { 
    public function execute($quanta): string|bool {
        echo "Hello World!";
        return false;
    }
}
$quanta->actionHandler->add_action(new HelloWorldAction("hello_world"));

class PrepareData extends Action {
    public function execute($quanta): string|bool {
        $quanta->memory->user_data = [
            "user_id" => 1,
            "user_name" => "Max Mustermann",
            "phone" => "0123/45678"
        ];
        return false;
    }
}
$quanta->actionHandler->add_action(new PrepareData("perepare_user"));