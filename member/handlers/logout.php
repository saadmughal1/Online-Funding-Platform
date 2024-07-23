<?php 
session_start();
unset($_SESSION["member_id"]);
unset($_SESSION["member_username"]);
header("LOCATION: ../login.php");
?>