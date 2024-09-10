<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("LOCATION: login.php");
}

$id  = $_SESSION["admin_id"];
include_once "classes/db.php";
$db = new Db();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Member Requests</title>
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container-scroller">
        <?php include_once "./partials/navbar.php" ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once "./partials/sidebar.php" ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- main-body-start -->
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Member Requests</h4>
                                        <div class="container-fluid p-0">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Username </th>
                                                        <th> Email </th>
                                                        <th> </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once "classes/member.php";

                                                    $member = new Member($db->getConnection(), $id);
                                                    $res = $member->displayInActiveMembers();
                                                    if ($res->num_rows > 0) {
                                                        $index = 0;
                                                        while ($row = $res->fetch_assoc()) {
                                                    ?>
                                                            <tr>
                                                                <th><?php echo ++$index; ?></th>
                                                                <td><?php echo $row["username"]; ?></td>
                                                                <td><?php echo $row["email"]; ?></td>
                                                                <td><a href="activate-account?mid=<?php echo $row["id"]; ?>" class="btn btn-primary">Activate</a></td>
                                                            </tr>

                                                        <?php } ?>

                                                    <?php

                                                    } else {
                                                        echo "<td colspan='10' class='text-center'><b><h2>No Members Available</h2></b></td>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- main-body-end -->
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
</body>

</html>