<?php

require_once __DIR__ . '/../../config.php';

class Db
{
    private $hostname, $username, $password, $dbname;
    private $connection;

    public function __construct($hostname = DB_HOST, $username = DB_USER, $password = DB_PASS, $dbname = DB_NAME)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->createConnection();
    }

    private function createConnection()
    {
        $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

        if ($this->connection->connect_errno) {
            throw new Exception("Database Connection Error: " . $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function __destruct()
    {
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }
}
