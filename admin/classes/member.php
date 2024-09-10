<?php

include_once "db.php";

class Member
{

    private $id, $username, $email, $password, $initial_amount;
    public $connection;

    public function __construct($connection = null, $id = null, $username = null, $password = null, $email = null, $initial_amount = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->initial_amount = $initial_amount;
        $this->connection = $connection;
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
        $sql = "INSERT INTO `member`(`username`, `password`, `email`,`initial_amount`,`date`,`status`) VALUES ('$this->username','$this->password','$this->email',$this->initial_amount,'$currentDate',1);";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Insert Query Failed: " . $this->connection->error);
    }

    public function login()
    {
        $sql = "SELECT *  FROM `member` WHERE `username` ='$this->username' AND `password` = '$this->password';";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function display()
    {
        $sql = "SELECT *  FROM `member` where status = 1;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function displayInActiveMembers()
    {
        $sql = "SELECT *  FROM `member` where status = 0;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }


    public function delete()
    {
        $sql = "DELETE FROM `member` WHERE `id` = $this->id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Delete Query Failed: " . $this->connection->error);
    }

    public function getUserById()
    {
        $sql = "SELECT `username`,`email`,`password`,`initial_amount` FROM `member` WHERE `id` = $this->id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Delete Query Failed: " . $this->connection->error);
    }

    public function update()
    {
        $sql = "UPDATE `member` SET `username`='$this->username',`password`='$this->password',`email`='$this->email',`initial_amount` = $this->initial_amount WHERE `id` = $this->id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Update Query Failed: " . $this->connection->error);
    }


    public function activateAccount()
    {
        $sql = "UPDATE `member` SET `initial_amount` = $this->initial_amount , `status` = 1 WHERE `id` = $this->id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Update Query Failed: " . $this->connection->error);
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

    public function getDepositSum($id)
    {
        $sql = "SELECT SUM(`amount`) as 'total' FROM `total_deposit` WHERE `mid` = $id";
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
    public function getReport()
    {
        $sql = "SELECT  te.amount,m.username,c.name, te.date FROM `total_expense` te
        join `member` m on m.id = te.mid
        join `clause` c on c.id = te.cid";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function depositAmount($amount)
    {
        $currentDate = date("Y-m-d");
        $sql = "INSERT INTO `total_deposit`(`mid`, `amount`,`date`) VALUES ($this->id,$amount,'$currentDate');";


        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Update Query Failed: " . $this->connection->error);
    }

    public function getInitialAmount()
    {

        $sql = "SELECT `initial_amount` FROM `member` WHERE `id` = $this->id";
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


    public function firstMemberJoinYear()
    {

        $sql = "SELECT YEAR(date) as `year` FROM member ORDER BY date ASC LIMIT 1;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getYearlyExpenseReport($year)
    {
        $sql = "SELECT  m.id as `member_id`,m.username, c.name, te.amount,te.date
        FROM `member`m
        join `total_expense` te
        on m.id = te.mid
        join `clause` c
        on c.id = te.cid
        WHERE YEAR(te.`date`) = $year; ";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getYearlyDepositReport($year)
    {
        $sql = "SELECT  m.id as `member_id`,m.username, d.amount,d.date
        FROM `member`m
        join `total_deposit` d
        on m.id = d.mid
        WHERE YEAR(d.`date`) = $year; ";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getMonthlyExpenseReport($start, $end)
    {
        $sql = "SELECT  m.id as `member_id`,m.username, c.name, te.amount,te.date
        FROM `member`m
        join `total_expense` te
        on m.id = te.mid
        join `clause` c
        on c.id = te.cid
        WHERE te.`date` BETWEEN '$start' AND '$end'; ";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getMonthlyDepositReport($start, $end)
    {
        $sql = "SELECT  m.id as `member_id`,m.username, d.amount,d.date
        FROM `member`m
        join `total_deposit` d
        on m.id = d.mid
        WHERE d.`date` BETWEEN '$start' AND '$end';";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getMonthlyExpenseReportByMember($start, $end, $id)
    {
        $sql = "SELECT  m.id as `member_id`,m.username, c.name, te.amount,te.date
        FROM `member`m
        join `total_expense` te
        on m.id = te.mid
        join `clause` c
        on c.id = te.cid
        WHERE te.`date` BETWEEN '$start' AND '$end' AND m.id = $id; ";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }


    public function getMonthlyDepositReportByMember($start, $end, $id)
    {
        $sql = "SELECT  m.id as `member_id`,m.username, d.amount,d.date
        FROM `member`m
        join `total_deposit` d
        on m.id = d.mid
        WHERE d.`date` BETWEEN '$start' AND '$end' AND m.id = $id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getYearlyDepositReportByMember($year, $id)
    {
        $sql = "SELECT  m.id as `member_id`,m.username, d.amount,d.date
        FROM `member`m
        join `total_deposit` d
        on m.id = d.mid
        WHERE YEAR(d.`date`) = $year AND m.id = $id;";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }

    public function getYearlyExpenseReportByMember($year, $id)
    {
        $sql = "SELECT m.username,c.name, te.amount,te.date
        FROM `member`m
        join `total_expense` te
        on m.id = te.mid
        join `clause` c
        on c.id = te.cid
        WHERE YEAR(te.`date`) = $year  AND m.id = $id";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Select Query Failed: " . $this->connection->error);
    }
    public function addExpense($id, $cid, $amount)
    {
        $currentDate = date("Y-m-d");
        $sql = "INSERT INTO `total_expense`(`mid`, `amount`, `cid`, `date`) VALUES ($id,$amount,$cid,'$currentDate')";
        $result = $this->connection->query($sql);
        if ($result) {
            return $result;
        }
        die("Insert Query Failed: " . $this->connection->error);
    }
}
