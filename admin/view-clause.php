<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
  header("LOCATION: login.php");
}

include_once "classes/db.php";
include_once "classes/clause.php";

$db = new Db();
$clause = new Clause($db->getConnection());

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Clause</title>
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
                    <h4 class="card-title">All Clause</h4>
                    <div class="container-fluid p-0">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Clause Name</th>
                            <th> Puspose </th>
                            <th> Amount </th>
                            <th> Collected Funds </th>
                            <th> Status </th>
                            <th> Edit </th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php

                          $res = $clause->display();
                          if ($res->num_rows > 0) {
                            $index = 0;
                            while ($row = $res->fetch_assoc()) {
                          ?>
                              <tr>
                                <th><?php echo ++$index; ?></th>
                                <td><?php echo $row["name"]; ?></td>
                                <td>
                                  <p style="text-wrap:wrap;"><?php echo $row["purpose"]; ?></p>
                                </td>
                                <td>$<?php echo $row["amount"]; ?></td>
                                <td>
                                  <a href="contributions?cid=<?php echo $row['id']; ?>">$<?php echo $row["funds"]; ?></a>
                                </td>
                                <td><?php echo ($row["funds"] == $row["amount"]) ? '<i class="mdi mdi-check-circle text-success clause-status-icon"></i>' : '<i class="mdi mdi-close-circle text-danger clause-status-icon"></i>' ?></td>
                                <td><a href="edit-clause.php?id=<?php echo $row["id"]; ?>"><i class="mdi mdi-pencil"></i></a></td>
                              </tr>
                          <?php
                            }
                          } else {
                            echo "<td colspan='6' class='text-center'><b><h2>No Clause Available</h2></b></td>";
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