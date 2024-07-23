<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/notification.php";

$data = "";

$db = new Db();
$notification = new Notification($db->getConnection());

$res = $notification->display();

if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {

        $color = "";
        if ($row["status"] == 0) {
            $color = "alert-danger";
        } else if ($row["status"] == 1) {
            $color = "alert-success";
        } else if ($row["status"] == 2) {
            $color = "alert-warning";
        }

        $data .= '<div class="row notification-card">';
        $data .= '<div class="col-md-12 alert ' . $color . ' border">';
        $data .= '<div class="d-md-flex justify-content-between align-items-center">';
        $data .= '<div class="row">';
        $data .= '<div class="col-md-6">';
        $data .= '<p><b>Username: </b>' . $row["username"] . '</p>';
        $data .= '</div>';
        $data .= '<div class="col-md-6">';
        $data .= '<p><b>Status: </b>';

        if ($row["status"] == 0) {
            $data .= "Cancel";
        } else if ($row["status"] == 1) {
            $data .= "Confirmed";
        } else if ($row["status"] == 2) {
            $data .= "Pending";
        }

        $data .= '</p>';
        $data .= '</div>';
        $data .= '<div class="col-md-6">';
        $data .= '<p><b>Amount: </b> ' . $row["amount"] . '</p>';
        $data .= '</div>';
        $data .= '<div class="col-md-6">';
        $data .= '<p><b>Clause: </b>' . $row["name"] . '</p>';
        $data .= '</div>';
        $data .= '</div>';
        $data .= '<div class="mt-2 mt-md-0">';
        $data .= '<button data-id="' . $row["id"] . '" class="btn btn-delete text-danger">';
        $data .= '<i class="mdi mdi-close"></i>';
        $data .= '</button>';
        $data .= '</div>';
        $data .= '</div>';
        $data .= '</div>';
        $data .= '</div>';
    }
    echo $data;
} else {
    echo "No Notifications Available";
}
