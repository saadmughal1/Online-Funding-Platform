<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("LOCATION: login.php");
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("LOCATION: view-members.php");
}


include_once "classes/db.php";
include_once "classes/member.php";

$db = new Db();
$id = $_GET["id"];
$member = new Member($db->getConnection(), $id);
$row = $member->getUserById()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Total Deposit ledger</title>
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
                                        <h4 class="card-title">Total Deposit ledger - (<?php if(isset($row["username"])) echo $row["username"]; ?>)</h4>
                                        <div class="container-fluid p-0">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Date </th>
                                                        <th> Amount </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once "classes/db.php";
                                                    include_once "classes/member.php";
                                                    $db = new Db();
                                                    $member = new Member($db->getConnection());
                                                    $id = $_GET["id"];
                                                    $res = $member->getDepositById($id);

                                                    $index = 0;
                                                    while ($row = $res->fetch_assoc()) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo ++$index; ?></td>
                                                            <td><?php echo $row["date"]; ?></td>
                                                            <td><?php echo $row["amount"]; ?></td>
                                                        </tr>
                                                    <?php
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