<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/admin.php";

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($_POST["username"]) || empty($_POST["password"])) {
        header("LOCATION: ../login.php?err=All fields are required");
        die();
    }
    $db = new Db();

    $username = mysqli_real_escape_string($db->getConnection(), $username);
    $password = mysqli_real_escape_string($db->getConnection(), $password);

    $admin = new Admin($db->getConnection(), null, $username, $password);
    $result = $admin->login();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $_SESSION["admin_id"] = $row["id"];
        $_SESSION["admin_username"] = $row["username"];

        header("LOCATION: ../");
    } else {
        header("LOCATION: ../login.php?err=Invalid username and password");
    }
}
