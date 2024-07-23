<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["id"]) && $_POST["old_email"] && isset($_POST["initial-amount"])) {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $old_email = $_POST["old_email"];
    $initial_amount = $_POST["initial-amount"];

    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
        header("LOCATION: ../edit-member.php?err=All fields are required&id=" . $_POST["id"]);
        die();
    }
    $db = new Db();
    $member = new Member($db->getConnection(), $id, $username, $password, $email, $initial_amount);

    if ($old_email != $email) {
        if ($member->isEmailAlreadyAvailable()->num_rows > 0) {
            header("LOCATION: ../edit-member.php?err=Email Already in use&id=" . $_POST["id"]);
            die();
        }
    }

    $member->update();
    header("LOCATION: ../view-members.php");
}
