<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["initial-amount"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $initial_amount = $_POST["initial-amount"];

    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
        header("LOCATION: ../add-member.php?err=All fields are required");
        die();
    }

    $db = new Db();

    $member = new Member($db->getConnection(), null, $username, $password, $email, $initial_amount);
    if ($member->isEmailAlreadyAvailable()->num_rows > 0) {
        header("LOCATION: ../add-member.php?err=Email Already in use");
        die();
    }

    $member->addMember();
    header("LOCATION: ../view-members.php");
}
