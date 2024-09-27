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
  <title>View Member</title>
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
                    <h4 class="card-title">All Members</h4>
                    <div class="container-fluid p-0">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Username </th>
                            <th> Email </th>
                            <th> Password </th>
                            <th> Initial Amount </th>
                            <th> Total Deposit </th>
                            <th> Outstanding Amount </th>
                            <th> Expenses </th>
                            <th> Net Balance </th>
                            <th> Edit </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          include_once "classes/member.php";

                          $grandTotalDeposit = 0;
                          $grandTotalExpense = 0;
                          $grandTotalNetBalance = 0;
                          $grandTotaloutstandingAmount = 0;
                          $member = new Member($db->getConnection(), $id);
                          $res = $member->display();
                          if ($res->num_rows > 0) {
                            $index = 0;
                            while ($row = $res->fetch_assoc()) {
                              $id = $row["id"];
                              $total_deposit = $member->getDepositSum($id)->fetch_assoc();
                              $total_expense = $member->getExpenseSum($id)->fetch_assoc();
                              $netBalance = $member->getNetBalance($id);

                              $grandTotalDeposit += $total_deposit["total"];
                              $grandTotalExpense += $total_expense["total"];
                              $grandTotalNetBalance += $netBalance;

                              $joinMonth  = $member->joiningYears($row["date"]);
                              $joinMonth += 1;
                              $outstanding_amount = ($row["initial_amount"] * $joinMonth) - (empty($total_deposit["total"]) ? 0 : $total_deposit["total"]);

                              if ($outstanding_amount > 0) {
                                $grandTotaloutstandingAmount += $outstanding_amount;
                              }

                          ?>
                              <tr>
                                <th><?php echo ++$index; ?></th>
                                <td><?php echo $row["username"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td>******</td>
                                <td>$<?php echo number_format($row["initial_amount"], 2); ?></td>
                                <td>$<a href="deposit-ledger.php?id=<?php echo $row["id"]; ?>"><?php echo empty($total_deposit["total"]) ? "0" : number_format($total_deposit["total"], 2); ?></a></td>
                                <td>$<?php echo number_format($outstanding_amount, 2); ?></td>
                                <td>$<a href="expense-ledger.php?id=<?php echo $row["id"]; ?>"><?php echo (empty($total_expense["total"])) ? "0" : number_format($total_expense["total"], 2); ?></a></td>
                                <td>$<?php echo number_format($netBalance, 2);  ?></td>
                                <td><a href="edit-member.php?id=<?php echo $row["id"]; ?>"><i class="mdi mdi-pencil"></i></a></td>
                              </tr>

                            <?php } ?>
                            <tr>
                              <th colspan="5"></th>
                              <th class="text-danger">$<?php echo $grandTotalDeposit; ?> </th>
                              <th class="text-danger">$<?php echo $grandTotaloutstandingAmount ?> </th>
                              <th class="text-danger">$<?php echo $grandTotalExpense; ?> </th>
                              <th class="text-danger">$<?php echo $grandTotalNetBalance ?> </th>
                              <th></th>
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

  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/misc.js"></script>
</body>

</html>