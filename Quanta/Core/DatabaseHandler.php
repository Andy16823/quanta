<?php
namespace Quanta\Core;
use PDO;
use PDOException;

/**
 * An handler for the database connection
 */
class DatabaseHandler
{
    protected $pdo;

    /**
     * Initialize the database handler
     * @param mixed $host the database host
     * @param mixed $dbname the name from the database
     * @param mixed $user the user from the database
     * @param mixed $password the password from the database
     * @return void
     */
    public function init($host, $dbname, $user, $password)
    {
        try
        {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

    /**
     * Performs an prepared query to the database
     * @param mixed $sql the query to perform
     * @param mixed $params the parameters for the query
     * @return array the dataset
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Performs an prepared query to the database and returns a single row
     * @param mixed $sql the query to perform
     * @param mixed $params the parameters for the query
     * @return array the dataset
     */
    public function queryOne($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Performs an prepared execution to the database
     * @param mixed $sql
     * @param mixed $params
     * @return bool
     */
    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Recives the last insert id
     * @return bool|string the last insert id or false if nothing was insert
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }

}