<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";

if (isset($_POST["id"]) && isset($_POST["did"]) && isset($_POST["amount"])) {
    $id = $_POST["id"];
    $did = $_POST["did"];
    $amount = $_POST["amount"];
    $db = new Db();
    $member = new Member($db->getConnection());
    $member->editDeposit($did, $amount);
    header("LOCATION: ../deposit-ledger.php?id=" . $id);
}
