<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";

$data = "";

$db = new Db();
$member = new Member($db->getConnection());

$start_date = $_POST["start-date"];
$end_date = $_POST["end-date"];


$res = $member->getMonthlyDepositReport($start_date, $end_date);
$grandTotal = 0;
if ($res->num_rows > 0) {
    $index = 0;
    while ($row = $res->fetch_assoc()) {
        $grandTotal += $row["amount"];
        $data .= "<tr>";
        $data .= "<td>" . ++$index . "</td>";
        $data .= "<td><a href='member-deposit-monthly-report.php?id=" . $row["member_id"] . "&start=" . $start_date . "&end=" . $end_date. "'>" . $row["username"] . "</a></td>";
        $data .= "<td>$" . $row["amount"] . "</td>";
        $data .= "<td>" . $row["date"] . "</td>";
        $data .= "</tr>";
    }
    $data .= "<tr>";
    $data .= "<td colspan='2'></td>";
    $data .= "<th class='text-danger'>$" . $grandTotal . "</th>";
    $data .= "<td></td>";
    $data .= "</tr>";

    echo $data;
} else {
    echo "<td colspan='5' class='text-center'><b><h2>No Report Available</h2></b></td>";
}
