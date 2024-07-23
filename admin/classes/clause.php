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

    public function addClause()
    {
        $sql = "INSERT INTO `clause`(`name`, `purpose`, `amount`) VALUES ('$this->name','$this->purpose','$this->amount')";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Insert Query Failed: " . $this->connection->error);
    }

    public function display()
    {
        $sql = "SELECT *  FROM `clause`;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
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

    public function update()
    {
        $sql = "UPDATE `clause` SET `name`='$this->name',`purpose`='$this->purpose',`amount`= $this->amount WHERE `id` = $this->id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Update Query Failed: " . $this->connection->error);
    }

    public function addFunds($id, $funds)
    {
        $sql = "UPDATE `clause` SET `funds`=`funds`+ $funds WHERE `id` = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Update Query Failed: " . $this->connection->error);
    }
}
