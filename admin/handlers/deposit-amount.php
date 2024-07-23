<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";

if (isset($_POST["deposit-amount"]) && isset($_POST["id"])) {
 $deposit_amount = $_POST["deposit-amount"];
$id = $_POST["id"];

    if (empty($_POST["deposit-amount"])) {
        header("LOCATION: ../deposit-amount-form.php?err=All fields are required");
        die();
    }

    if ($deposit_amount <= 0) {
        header("LOCATION: ../deposit-amount-form.php?err=Deposit amount must be greater than 0");
        die();
    }
    $db = new Db();

    $member = new Member($db->getConnection(), $id, null,null,null,null);
    $member->depositAmount($deposit_amount);
    header("LOCATION: ../view-members.php");
}
