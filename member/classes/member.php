<?php

include_once "db.php";

class Member
{

    private $id, $username, $email, $password, $deposit_amount;
    public $connection;

    public function __construct($connection = null, $id = null, $username = null, $password = null, $email = null, $deposit_amount = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->deposit_amount = $deposit_amount;
        $this->connection = $connection;
    }

    public function login()
    {
        $sql = "SELECT *  FROM `member` WHERE `email` ='$this->email' AND `password` = '$this->password';";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function depositAmount()
    {
        $currentDate = date("Y-m-d");
        $sql = "INSERT INTO `total_deposit`(`mid`, `amount`,`date`) VALUES ($this->id,$this->deposit_amount,'$currentDate');";

        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Update Query Failed: " . $this->connection->error);
    }

    public function getDepositSum($id)
    {
        $sql = "SELECT SUM(`amount`) as 'total' FROM `total_deposit` WHERE `mid` = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getExpenseSum($id)
    {
        $sql = "SELECT SUM(`amount`) as 'total' FROM `total_expense` WHERE `mid` = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getNetBalance($id)
    {
        $deposit_sum = $this->getDepositSum($id)->fetch_assoc()["total"];
        $expense_sum = $this->getExpenseSum($id)->fetch_assoc()["total"];
        return $deposit_sum - $expense_sum;
    }

    public function getReport($id)
    {
        $sql = "SELECT  te.amount,m.username,c.name, te.date FROM `total_expense` te
        join `member` m on m.id = te.mid
        join `clause` c on c.id = te.cid WHERE m.id = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getUserById()
    {
        $sql = "SELECT * FROM `member` WHERE `id` = $this->id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Delete Query Failed: " . $this->connection->error);
    }

    public function getDepositById($id)
    {
        $sql = "SELECT * FROM `total_deposit` td WHERE `mid` = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getExpenseById($id)
    {
        $sql = "SELECT c.name,te.id,te.amount,te.date  FROM `total_expense` te 
        join `clause` c on c.id = te.cid
        WHERE `mid` = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }


    public function joiningMonths($joinDate)
    {

        $joiningDate = $joinDate;
        $currentDate = date("Y-m-d");

        $startDate = new DateTime($joiningDate);
        $endDate = new DateTime($currentDate);

        $interval = $startDate->diff($endDate);
        return $interval->y * 12 + $interval->m;
    }

    public function joiningYears($joinDate)
    {

        $joiningDate = $joinDate;
        $currentDate = date("Y-m-d");

        $startDate = new DateTime($joiningDate);
        $endDate = new DateTime($currentDate);

        $interval = $startDate->diff($endDate);
        return $interval->y;
    }

    public function isEmailAlreadyAvailable()
    {
        $sql = "SELECT *  FROM `member` WHERE `email` = '$this->email'";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function addMember()
    {
        $currentDate = date("Y-m-d");
        $sql = "INSERT INTO `member`(`username`, `password`, `email`,`initial_amount`,`date`) VALUES ('$this->username','$this->password','$this->email',0,'$currentDate');";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Insert Query Failed: " . $this->connection->error);
    }
}
