<?php

include_once "db.php";

class Clause
{

    private $id, $name, $purpose, $amount;
    public $connection;

    public function __construct($connection = null, $id = null, $name = null, $purpose = null, $amount = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->purpose = $purpose;
        $this->amount = $amount;
        $this->connection = $connection;
    }


    public function getClauseById()
    {
        $sql = "SELECT * FROM `clause` WHERE `id` = $this->id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Delete Query Failed: " . $this->connection->error);
    }

}
