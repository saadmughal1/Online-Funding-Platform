<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";
include_once __DIR__ . "/../../config.php";


if (isset($_POST["deposit-amount"])) {
    $deposit_amount = $_POST["deposit-amount"];

    if (empty($_POST["deposit-amount"])) {
        header("LOCATION: ../deposit-amount.php?err=All fields are required");
        die();
    }

    if ($deposit_amount <= 0) {
        header("LOCATION: ../deposit-amount.php?err=Deposit amount must be greater than 0");
        die();
    }


    $token = $_POST["stripeToken"];
    $data = \Stripe\Charge::create(array(
        "amount" => $deposit_amount * 100,
        "currency" => "usd",
        "description" => "...",
        "source" => $token,
    ));

    if ($token) {
        $id = $_SESSION["member_id"];
        $db = new Db();
        $member = new Member($db->getConnection(), $id, null, null, null, $deposit_amount);
        $member->depositAmount();

        header("LOCATION: ../payment-success.php?amount=".($data["amount"]/100)."");

    }
}
