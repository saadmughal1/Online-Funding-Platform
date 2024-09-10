<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";



if (isset($_POST["mid"]) && isset($_POST["initial-amount"])) {
    $mid = $_POST["mid"];
    $initial_amount = $_POST["initial-amount"];

    $db = new Db();
    $member = new Member($db->getConnection(), $mid, null, null, null, $initial_amount);

    $member->activateAccount();
    header("LOCATION: ../view-members.php");
}
