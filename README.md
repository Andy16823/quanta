# Quanta

[Quanta](https://getquanta.dev/) is a modern and modular PHP framework designed for developers who prioritize simplicity, flexibility, and scalability. With its component-based architecture and intuitive design, Quanta is the perfect solution for building modern web applications efficiently.

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

Install via Composer
To install Quanta in your project, you can use Composer. First, make sure you have Composer installed on your system. If you don’t have Composer, you can download and install it from here.

Add Quanta to your project by running the following command:

```bash
composer require andy16823/quanta
```

Manual Installation (Optional)
Alternatively, you can clone the repository manually and include the framework in your project:

```bash
git clone https://github.com/Andy16823/quanta.git
```

### How to use Quanta

You can read our starter guide here: [https://getquanta.dev/learn](https://getquanta.dev/learn)

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

For more information, visit [getquanta.dev](https://getquanta.dev)

