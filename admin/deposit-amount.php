<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("LOCATION: login.php");
}

include_once "classes/db.php";
$db = new Db();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Deposit Amount</title>
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
                                        <h4 class="card-title">Deposit Amount</h4>
                                        <div class="container-fluid p-0">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Username </th>
                                                        <th> Email </th>
                                                        <th> Total Deposit </th>
                                                        <th> Expenses </th>
                                                        <th> Net Balance </th>
                                                        <th> Add Amount </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once "classes/member.php";

                                                    $grandTotalDeposit = 0;
                                                    $grandTotalExpense = 0;
                                                    $grandTotalNetBalance = 0;
                                                    $member = new Member($db->getConnection());
                                                    $res = $member->display();
                                                    if ($res->num_rows > 0) {
                                                        $index = 0;
                                                        while ($row = $res->fetch_assoc()) {
                                                            $id = $row["id"];
                                                            $total_deposit = $member->getDepositSum($id)->fetch_assoc();
                                                            $total_expense = $member->getExpenseSum($id)->fetch_assoc();
                                                            $outstandingAmount = $total_deposit["total"] - $total_expense["total"];
                                                            $netBalance = $member->getNetBalance($id);

                                                            $grandTotalDeposit += $total_deposit["total"];
                                                            $grandTotalExpense += $total_expense["total"];
                                                            $grandTotalNetBalance += $netBalance;

                                                    ?>
                                                            <tr>
                                                                <th><?php echo ++$index; ?></th>
                                                                <td><?php echo $row["username"]; ?></td>
                                                                <td><?php echo $row["email"]; ?></td>
                                                                <td><a href="deposit-ledger.php?id=<?php echo $row["id"]; ?>"><?php echo (empty($total_deposit["total"])) ? "0" : $total_deposit["total"]; ?></a></td>
                                                                <td><a href="expense-ledger.php?id=<?php echo $row["id"]; ?>"><?php echo (empty($total_expense["total"])) ? "0" : $total_expense["total"]; ?></a></td>
                                                                <td><?php echo $netBalance ?></td>
                                                                <td>
                                                                    <a href="deposit-amount-form.php?id=<?php echo $row["id"]; ?>">Deposit Amount</a>
                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-danger"> <?php echo $grandTotalDeposit; ?> </th>
                                                            <th class="text-danger"> <?php echo $grandTotalExpense; ?> </th>
                                                            <th class="text-danger"> <?php echo $grandTotalNetBalance ?> </th>
                                                        </tr>
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>

</body>

</html>