<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($_POST["email"]) || empty($_POST["password"])) {
        header("LOCATION: ../login.php?err=All fields are required");
        die();
    }

    $db = new Db();

    $email = mysqli_real_escape_string($db->getConnection(), $email);
    $password = mysqli_real_escape_string($db->getConnection(), $password);

    $member = new Member($db->getConnection(), null, null, $password, $email);
    $result = $member->login();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();


        if ($row["status"] == 1) {
            $_SESSION["member_id"] = $row["id"];
            $_SESSION["member_username"] = $row["username"];
            header("LOCATION: ../");
        } else {
            header("LOCATION: ../login?err=Account%20is%20deactivated%2C%20please%20contact%20admin%20to%20activate");
            exit();
        }
    } else {
        header("LOCATION: ../login.php?err=Invalid username and password");
    }
}
