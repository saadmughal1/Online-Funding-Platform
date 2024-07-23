<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/clause.php";

if (isset($_POST["name"]) && isset($_POST["purpose"]) && isset($_POST["amount"])) {
    $name = $_POST["name"];
    $purpose = $_POST["purpose"];
    $amount = $_POST["amount"];
    

    if (empty($_POST["name"]) || empty($_POST["purpose"]) || empty($_POST["amount"])) {
        header("LOCATION: ../add-clause.php?err=All fields are required");
        die();
    }

    else if($_POST["amount"] <= 0){
        header("LOCATION: ../add-clause.php?err=Amount must be greater than 0");
        die();
    }

    $db = new Db();

    $clause = new Clause($db->getConnection(), null, $name, $purpose, $amount);
    $clause->addClause();
    header("LOCATION: ../get-funds.php");
}
