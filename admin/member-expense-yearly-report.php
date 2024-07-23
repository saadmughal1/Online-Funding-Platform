<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("LOCATION: login.php");
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("LOCATION: yearly-expense-report.php");
}

if (!isset($_GET["year"]) || empty($_GET["year"])) {
    header("LOCATION: yearly-expense-report.php");
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
    <title><?php echo $_GET["year"] . " expense report" ?></title>
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
                                        <h4 class="card-title">Total Expense Report</h4>
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4><b>Year: </b> <?php echo $_GET["year"] ?></h4>
                                                </div>
                                            </div>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Username </th>
                                                        <th> Clause Name </th>
                                                        <th> Amount </th>
                                                        <th> Date </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $res = $member->getYearlyExpenseReportByMember($_GET["year"], $id);
                                                    $index = 0;
                                                    $total = 0;
                                                    while ($row = $res->fetch_assoc()) {
                                                        $total += $row["amount"];
                                                    ?>
                                                        <tr>
                                                            <td><?php echo ++$index; ?></td>
                                                            <td><?php echo $row["username"]; ?></td>
                                                            <td><?php echo $row["name"]; ?></td>
                                                            <td><?php echo $row["amount"]; ?></td>
                                                            <td><?php echo $row["date"]; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                    </td>
                                                    <td class="text-danger"><b><?php echo $total ?></b></td>
                                                    <td></td>
                                                    </tr>
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