<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";
include_once __DIR__ . "/../classes/notification.php";
include_once __DIR__ . "/../classes/clause.php";



if (isset($_POST["clauseId"]) && isset($_POST["ids"]) && isset($_POST["amount"])) {

    $clauseId = $_POST["clauseId"];
    $amount = $_POST["amount"];
    $ids = $_POST["ids"];

    $db = new Db();
    $member = new Member($db->getConnection());

    $clause = new Clause($db->getConnection(), $clauseId);
    $cres = $clause->getClauseById()->fetch_assoc();

    $amountDivide = $amount / count($ids);

    $notification = new Notification($db->getConnection(), null, null, $clauseId, null);

    foreach ($ids as $key => $id) {
        $netbalance = $member->getNetBalance($id);
        $tempAmmount = ($amountDivide > $netbalance) ? $netbalance : $amountDivide;
        $notification->sendNotification($id, $tempAmmount);
        $member->addExpense($id, $clauseId, $tempAmmount);
        $clause->addFunds($clauseId, $tempAmmount);
    }

    $cres = $clause->getClauseById()->fetch_assoc();
    if (($cres["amount"] - $cres["funds"]) < 1) {
        $clause->resolveDecimal($clauseId, $cres["amount"]);
    }
}
