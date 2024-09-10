<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
        header("LOCATION: ../signup.php?err=All fields are required");
        die();
    }

    $db = new Db();

    $member = new Member($db->getConnection(), null, $username, $password, $email);
    if ($member->isEmailAlreadyAvailable()->num_rows > 0) {
        header("LOCATION: ../signup.php?err=Email Already in use");
        die();
    }

    $member->addMember();
    header("LOCATION: ../login.php?msg=Your account has been created. You will be able to log in after the admin approves it");
}
