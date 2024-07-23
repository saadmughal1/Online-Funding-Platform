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

    $notification = new Notification($db->getConnection(), null, null, $clauseId,null);

    // foreach ($ids as $key => $id) {

    //     $netbalance = $member->getNetBalance($id);
    //     if ($cres["funds"] < $cres["amount"]) {
    //         $remaining = $cres["amount"] - $cres["funds"];

    //         if ($amountDivide > $remaining) {
    //             if ($remaining > $netbalance) {
    //                 $member->addExpense($id, $clauseId, $netbalance);
    //                 $clause->addFunds($clauseId, $netbalance);
    //             } else {
    //                 // cut remaining from net balance
    //                 $member->addExpense($id, $clauseId, $remaining);
    //                 $clause->addFunds($clauseId, $remaining);
    //             }
    //         } else {
    //             if ($amountDivide > $netbalance) {
    //                 $member->addExpense($id, $clauseId, $netbalance);
    //                 $clause->addFunds($clauseId, $netbalance);
    //             } else {
    //                 // cut remaining from net balance
    //                 $member->addExpense($id, $clauseId,  $amountDivide);
    //                 $clause->addFunds($clauseId,  $amountDivide);
    //             }
    //         }
    //     }

    // }


    
    foreach ($ids as $key => $id) {
        $netbalance = $member->getNetBalance($id);
        $amount = ($amountDivide > $netbalance) ? $netbalance : $amountDivide;
        $notification->sendNotification($id,$amount);
        $member->addExpense($id, $clauseId, $amount);
        $clause->addFunds($clauseId, $amount);
    }
    

    foreach ($sendNotification as $key => $id) {
    }
}
