# Quanta

Quanta is a modern and modular PHP framework designed for developers who prioritize simplicity, flexibility, and scalability. With its component-based architecture and intuitive design, Quanta is the perfect solution for building modern web applications efficiently.

---

## Features

- **Component-Based Design**: Create reusable UI components for a seamless development experience.
- **Flexible Routing**: Set up routes effortlessly to render components based on URLs.
- **Action System**: Define and execute actions to handle complex server-side operations.
- **Memory Management**: Utilize session-based or in-memory storage with ease.
- **Modular Architecture**: Expand functionality with shareable and self-contained modules.
- **Database Integration**: Simplified database handling with PDO.
- **Lightweight**: Minimal dependencies and optimized performance.
- **Scalable**: Built to handle projects of all sizes, from small apps to enterprise-level solutions.

---

## Installation

Clone the repository from GitHub:

```bash
git clone https://github.com/Andy16823/quanta.git
```

### Directory Structure

After installation, your project directory will look like this:

```
yourproject/
├── quanta/             # Framework core
├── index.php           # Entry point
```

### Setting Up Your First Route

Add the following code to `index.php` to set up your first route:

```php
include_once("quanta/quanta.php");

$quanta = new Quanta();
$quanta->databaseHandler->init("127.0.0.1", "quanta_test", "root", "");

include_once("inc/components.php");

$quanta->routeHandler->initial_routing('page', 'fallbackComponent');
$quanta->routeHandler->register_route('home', 'homeComponent');
$quanta->routeHandler->route($quanta);
```

### Rendering Components

Define components like this:

```php
class HomeComponent extends Component
{
    public function render($quanta, $data) {
        return "<h1>Welcome to Quanta!</h1>";
    }
}
$quanta->componentHandler->add_component(new HomeComponent("homeComponent"));
```
You can also load a PHP template directly into your component. If your component requires 
dynamic data, you can pass an associative array of variables to the `load_template` function. 
These variables will be accessible within the template, making it easier 
to separate logic from presentation.

```php
class UserProfileComponent extends Component
{
    public function render($quanta, $data) {
        // Add or modify variables in the $data array
        $data["username"] = "JohnDoe"; // Default value or overwrite
        $data["email"] = $data["email"] ?? "unknown@example.com"; // Fallback value
        $data["role"] = $data["role"] ?? "Guest";

        // Load the template with the enriched data
        return $quanta->load_template("templates/user-profile.php", $data);
    }
}
$quanta->componentHandler->add_component(new UserProfileComponent("userProfile"));
```

Visit `http://localhost/?page=home` to see your component in action.

### Actions

Actions allow you to handle server-side logic. For example:

```php
class SaveUserAction extends Action {
    public function execute($quanta): string|bool {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $quanta->databaseHandler->query("INSERT INTO users (username, email) VALUES (?, ?)", [$username, $email]);
        return false; // false because we dont want to redirect
    }
}
$quanta->actionHandler->add_action(new SaveUserAction("save_user"));
```

Trigger actions via HTTP requests like `http://localhost/?action=save_user`.

---

## Example: Building a User Management Module

Create a `UserModule` for handling user data:

```php
class UserModule extends Module
{
    private ?Quanta $quanta;

    public function load($quanta)
    {
        $this->quanta = $quanta;
        $this->initializeDatabase();
    }

    private function initializeDatabase()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL
        )";
        $this->quanta->databaseHandler->query($sql);
    }

    public function addUser($username, $email)
    {
        $this->quanta->databaseHandler->query(
            "INSERT INTO users (username, email) VALUES (?, ?)", [$username, $email]
        );
    }

    public function fetchUsers()
    {
        return $this->quanta->databaseHandler->query("SELECT * FROM users");
    }
}

$quanta->moduleHandler->add_module(new UserModule("user_module"));
```

---

## Contributing

We welcome contributions from the community! Feel free to submit pull requests, report issues, or share your modules.

---

## License

Quanta is open-source and distributed under the MIT License. See `LICENSE` for more details.

---

## Contact

For more information, visit [quanta-dev.com](https://quanta-dev.com) or contact us at [support@quanta-dev.com](mailto:support@quanta-dev.com).

