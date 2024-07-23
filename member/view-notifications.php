<?php
session_start();
if (!isset($_SESSION["member_id"])) {
    header("LOCATION: login.php");
}

include_once "classes/db.php";
include_once "classes/notification.php";
include_once "classes/member.php";

$db  = new Db();
$member = new Member($db->getConnection());

$id  = $_SESSION["member_id"];
$net_balance = $member->getNetBalance($id);
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Notifications</title>
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
                    <div class="row d-flex">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Notifications</h4>

                                    <div class="row notification-card">
                                        <?php

                                        $db = new Db();
                                        $id  = $_SESSION["member_id"];
                                        $notification = new Notification($db->getConnection());

                                        $res = $notification->display($id);

                                        if ($res->num_rows > 0) {
                                            while ($row = $res->fetch_assoc()) {
                                        ?>
                                                <div class="col-md-12 alert alert-success border " role="alert">
                                                    <div class="row">
                                                        <div class="col-md-12 d-flex justify-content-between">
                                                            <h6 class="m-0">An amount of <strong>$<?php echo $row["amount"]; ?></strong> utilized for <strong><?php echo $row["name"]; ?></strong> funds. Thank you for your contribution.</h6>
                                                            <div class="mt-2 mt-md-0">
                                                                <a href="handlers/delete-notification.php?id=<?php echo $row["id"]; ?>" class="btn btn-delete text-danger">
                                                                    <i class="mdi mdi-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p class="m-0"><?php echo $row["date"]; ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php
                                            }
                                        } else {
                                            echo "<h6>No notifications Avaiable</h6>";
                                        }
                                        ?>
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

    <?php include_once "partials/confirm-modal.php"; ?>
    <?php include_once "partials/confirm-modal-2.php"; ?>

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



</body>

</html>