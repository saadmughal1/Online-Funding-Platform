<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/clause.php";

if (isset($_POST["name"]) && isset($_POST["purpose"]) && isset($_POST["amount"]) && isset($_POST["id"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $purpose = $_POST["purpose"];
    $amount = $_POST["amount"];


    if (empty($_POST["name"]) || empty($_POST["purpose"]) || empty($_POST["amount"])) {
        header("LOCATION: ../edit-clause.php?err=All fields are required&id=" . $id);
        die();
    } else if ($_POST["amount"] <= 0) {
        header("LOCATION: ../edit-clause.php?err=Amount must be greater than 0&id=" . $id);
        die();
    }

    $db = new Db();

    $clause = new Clause($db->getConnection(), $id, $name, $purpose, $amount);
    $clause->update();
    header("LOCATION: ../view-clause.php");
}
