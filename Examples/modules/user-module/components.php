<?php

class LoginForm extends Component {
    public function render($quanta, $data) {
        $path = dirname(__FILE__) . "/templates/login-form.php";
        $template = $quanta->load_template($path);
        return $template;
    }
}

class RegisterForm extends Component {
    public function render($quanta, $data) {
        $path = dirname(__FILE__) . "/templates/register-form.php";
        $template = $quanta->load_template($path, $data);
        return $template;
    }
}