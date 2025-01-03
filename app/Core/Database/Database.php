<?php

namespace App\Core\Database;

use PDO;
use PDOException;
use App\Core\Errors\Errors;
/**
 * Database class is responsible for handling all database related operations
 */

class Database
{
    /**
     * @var PDO
     */
    protected $pdo;
    protected string $hostname;
    protected string $port;
    protected string $db_name;
    protected string $username;
    protected string $password;
    /**
     * Database constructor
     */
    public function __construct()
    {
        $this->pdo = $this->connect();
    }
    private function connect() 
    {
        $this->hostname = DB_HOST;
        $this->port = DB_PORT;
        $this->db_name = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;

        try {
            $connect = "mysql:host=" . $this->hostname . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $options = [PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC];
            return $this->pdo = new PDO($connect, $this->username, $this->password, $options);
        } catch (PDOException $message) {
            Errors::E500($_REQUEST, $message->getMessage());
            return die('Database Connection Error: ' . $message->getMessage() . ' (check database connection ==> config / app.php)');
        }
    }
}
