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
    public function sendNotification($mid,$amount)
    {
        $sql = "INSERT INTO `notification`( `mid`, `cid`, `amount`) VALUES ($mid,$this->cid,$amount)";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Insert Query Failed: " . $this->connection->error);
    }

}
