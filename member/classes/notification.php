<?php

include_once "db.php";

class Notification
{

    private $id, $mid, $cid, $amount;
    public $connection;

    public function __construct($connection = null, $id = null, $mid = null, $cid = null, $amount = null)
    {
        $this->id = $id;
        $this->mid = $mid;
        $this->cid = $cid;
        $this->amount = $amount;
        $this->connection = $connection;
    }

    public function display($id)
    {
        $sql = "SELECT c.name,n.id,n.amount,n.date FROM `notification` n join `clause` c on n.cid = c.id WHERE n.mid = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Display Query Failed: " . $this->connection->error);
    }

    public function getNotifById($id)
    {
        $sql = "SELECT * FROM `notification` WHERE `id` = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function delete()
    {
        $sql = "DELETE FROM `notification` WHERE `id` = $this->id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("delete Query Failed: " . $this->connection->error);
    }

}
