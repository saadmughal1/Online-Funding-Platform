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

    $amountDivide = floor($amount / count($ids));
    $notification = new Notification($db->getConnection(), null, null, $clauseId, null);




    $collectEach = 0;
    foreach ($ids as $key => $id) {
        $netbalance = $member->getNetBalance($id);
        $tempAmmount = ($amountDivide > $netbalance) ? $netbalance : $amountDivide;
        $notification->sendNotification($id, $tempAmmount);
        $member->addExpense($id, $clauseId, $tempAmmount);
        $clause->addFunds($clauseId, $tempAmmount);


        $collectEach += $tempAmmount;
    }

    $remainingAmount = $amount - $collectEach;

    if ($remainingAmount > 0) {
        echo json_encode([
            "success" => true,
            "message" => "$$remainingAmount remains to be collected. Please select the members to collect the amount again."
        ]);
    } else {
        echo json_encode([
            "success" => true,
            "message" => "All amounts have been collected successfully."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request. Please provide all required data."
    ]);
}
