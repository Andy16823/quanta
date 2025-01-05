<?php
include_once(dirname(__FILE__) . "/components.php");
include_once(dirname(__FILE__) . "/actions.php");

class UserModule extends Module
{
    private ?Quanta $quanta;

    private function start_sessions()
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    private function initial_database($quanta)
    {
        $table_name = "user";
        $result = $quanta->databaseHandler->query("SHOW TABLES LIKE '" . $table_name . "'");
        if (!$result)
        {
            $sql = "CREATE TABLE $table_name (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(64) NOT NULL UNIQUE,
                password TEXT NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                type VARCHAR(64) NOT NULL,
                last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $quanta->databaseHandler->query($sql);
        }
    }

    public function exist_username($username)
    {
        $sql = "SELECT * FROM user WHERE username = ?";
        $params = array($username);
        $result = $this->quanta->databaseHandler->query($sql, $params);
        if ($result)
        {
            return true;
        }
        return false;
    }

    public function exist_email($email)
    {
        $sql = "SELECT * FROM user WHERE username = ?";
        $params = array($email);
        $result = $this->quanta->databaseHandler->query($sql, $params);
        if ($result)
        {
            return true;
        }
        return false;
    }

    public function exist_user($username, $mail)
    {
        if ($this->exist_username($username) || $this->exist_email($mail))
        {
            return true;
        }
        return false;
    }

    public function create_user($username, $password, $email, $type = 1)
    {
        if ($this->exist_user($username, $email))
        {
            return false;
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT IGNORE INTO user (username, password, email, type) VALUES (?, ?, ?, ?)";
        $params = array($username, $password, $email, $type);
        $this->quanta->databaseHandler->query($sql, $params);
        return true;
    }

    public function login_user($username, $password)
    {
        $user = $this->fetch_user_with_mail($username);
        if ($user) {
            if(password_verify($password, $user["password"])) {
                $_SESSION["user"] = $user;
                return true;
            }
        }
        return false;
    }

    public function is_user_loggedin() {
        if(isset($_SESSION["user"])) {
            return true;
        }
        return false;
    }

    public function logout_user() {
        unset($_SESSION["user"]);
        return true;
    }

    public function get_current_user() {
        if($this->is_user_loggedin()) { 
            return $_SESSION["user"];
        }
        return false;
    }

    public function fetch_users()
    {
        $sql = "SELECT * FROM user";
        $result = $this->quanta->databaseHandler->query($sql);
        return $result;
    }

    public function fetch_user_with_mail($mail) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $params = array($mail);
        return $this->quanta->databaseHandler->query($sql, $params);
    }

    public function dispose($quanta)
    {
        $this->quanta = null;
    }

    public function load($quanta)
    {
        $this->quanta = $quanta;
        $this->start_sessions();
        $this->initial_database($quanta);

        $loginForm = new LoginForm("login_form");
        $this->quanta->componentHandler->add_component($loginForm);

        $registerForm = new RegisterForm("register_form");
        $this->quanta->componentHandler->add_component($registerForm);

        $createUserAction = new CreateUserAction("create_user", $this->id);
        $this->quanta->actionHandler->add_action($createUserAction);
    }

}
