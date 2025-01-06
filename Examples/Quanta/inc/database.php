<?php

$table_name = "user";
$result = $quanta->databaseHandler->query("SHOW TABLES LIKE '" . $table_name . "'");
var_dump($result);
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

$sql = "INSERT IGNORE INTO $table_name (username, password, email, type) VALUES (?, ?, ?, ?)";
$params = array("Max2", "MaxMaxMax", "info2@musterman.de", 1);
$result = $quanta->databaseHandler->query($sql, $params);
var_dump($result . " " . $quanta->databaseHandler->lastInsertId());