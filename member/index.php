<?php
session_start();
if (!isset($_SESSION["member_id"])) {
  header("LOCATION: login.php");
}

include_once "classes/db.php";
include_once "classes/member.php";
$id = $_SESSION["member_id"];
$db = new Db();
$member = new Member($db->getConnection(), $id);
$total_deposit = $member->getDepositSum($id)->fetch_assoc()["total"];
$total_expense = $member->getExpenseSum($id)->fetch_assoc()["total"];
$net_balance = $member->getNetBalance($id);


$row = $member->getUserById()->fetch_assoc();
if (!$row) {
  header("LOCATION: handlers/logout.php");
}
$joinMonth = $member->joiningYears($row["date"]);
$joinMonth += 1;
$outstanding_amount = ($row["initial_amount"] * $joinMonth) - (empty($total_deposit) ? 0 : $total_deposit);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Report</title>
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

                    <div class="row mb-2 mt-5">
                      <div class="col-md-6">
                        <h5><b>Total Deposit: </b>$<?php echo (empty($total_deposit)) ? "0" : $total_deposit; ?></h5>
                        <h5><b>Total Expense: </b>$<?php echo (empty($total_expense)) ? "0" : $total_expense; ?></h5>
                      </div>
                      <div class="col-md-6">
                        <h5><b>Outstanding Amount: </b>$<?php echo $outstanding_amount; ?></h5>
                        <h5><b>Net Balance: </b>$<?php echo (empty($net_balance)) ? "0" : $net_balance; ?></h5>
                      </div>
                    </div>

                    <form action="">
                      <div class="container-fluid p-0">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th> Clause Name</th>
                              <th> Amount</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            include_once "classes/db.php";
                            include_once "classes/member.php";
                            $db = new Db();
                            $member = new Member($db->getConnection());
                            $id = $_SESSION["member_id"];
                            $res = $member->getReport($id);
                            if ($res->num_rows > 0) {
                              $index = 0;
                              while ($row = $res->fetch_assoc()) {
                            ?>
                                <tr>
                                  <th><?php echo ++$index; ?></th>
                                  <td><?php echo $row["name"]; ?></td>
                                  <td>$<?php echo $row["amount"]; ?></td>
                                  <td><?php echo $row["date"]; ?></td>
                                </tr>
                            <?php
                              }
                            } else {
                              echo "<td colspan='5' class='text-center'><b><h2>No Report Generated</h2></b></td>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </form>
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