<?php
session_start();

include_once __DIR__ . "/../classes/db.php";
include_once __DIR__ . "/../classes/member.php";

$data = "";

$db = new Db();
$member = new Member($db->getConnection());

if ($member->firstMemberJoinYear()->num_rows > 0) {



    $firstMemberJoinYear = $member->firstMemberJoinYear()->fetch_assoc()["year"];

    $currentYear = date("Y");
    $data .= '<option value="" selected>Select Year</option>';
    while ($firstMemberJoinYear <= $currentYear) {
        $data .= '<option value="' . $firstMemberJoinYear . '">' . $firstMemberJoinYear . '</option>';
        $firstMemberJoinYear++;
    }
    echo $data;
} else {
    echo '<option value="">Select Year</option>';
}
