<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/notification.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $db = new Db();
    $notification = new Notification($db->getConnection(), $id, null, null, null, null);

    $notification->delete();
    header("LOCATION: ../view-notifications.php");
}
