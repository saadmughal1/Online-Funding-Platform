<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
  header("LOCATION: login.php");
}

include_once "classes/db.php";
include_once "classes/clause.php";
include_once "classes/member.php";

$db = new Db();
$member = new Member($db->getConnection());
$clause = new Clause($db->getConnection());
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Get Funds</title>

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
                    <h4 class="card-title">Get Funds</h4>
                    <h6 class="text-danger">
                      <?php if (isset($_GET["err"])) echo $_GET["err"]; ?></h6>
                    <!-- <form action="handlers/get-funds.php" method="POST"> -->
                    <div class="container-fluid p-0">
                      <div class="row mb-4">
                        <div class="col-md-4">
                          <select class="form-control" name="selected-clause" id="selected-clause">
                            <option value="" data-amount="">Select Clause</option>
                            <?php
                            $res = $clause->display();
                            while ($row = $res->fetch_assoc()) {
                              if ($row["amount"] != $row["funds"]) {
                            ?>
                                <option value="<?php echo $row["id"]; ?>" data-funds="<?php echo $row["funds"]; ?>" data-amount="<?php echo $row["amount"]; ?>"><?php echo $row["name"]; ?></option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <p id="display-amount"></p>
                        </div>
                      </div>
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>
                              <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </th>
                            <th> Username </th>
                            <!-- <th> Total Deposit </th> -->
                            <!-- <th> Outstanding Amount </th> -->
                            <th> Net Balance </th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          include_once "classes/db.php";
                          include_once "classes/member.php";
                          $db = new Db();
                          $member = new Member($db->getConnection());
                          $res = $member->display();
                          if ($res->num_rows > 0) {
                            $index = 0;
                            while ($row = $res->fetch_assoc()) {
                              $id = $row["id"];
                              $total_deposit = $member->getDepositSum($id)->fetch_assoc();
                              $netBalance = $member->getNetBalance($id);
                              if ($netBalance > 0) {

                          ?>

                                <tr>
                                  <td>
                                    <div class="form-check form-check-flat form-check-primary">
                                      <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="member-ids[]" value="<?php echo $row["id"] ?>" data-net-balance="<?php echo $netBalance ?>">
                                      </label>
                                    </div>
                                  </td>
                                  <td><?php echo $row["username"]; ?></td>
                                  <td>$<?php echo $netBalance ?></td>
                                </tr>

                          <?php
                              }
                            }
                          } else {
                            echo "<td colspan='10' class='text-center'><b><h2>No Members Available</h2></b></td>";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="form-group d-flex justify-content-end mt-3">
                      <button type="button" class="btn btn-gradient-primary me-2" id="collect-button">Collect</button>
                    </div>
                    <!-- </form> -->
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

  <?php include_once "partials/warning-modal.php"; ?>
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/misc.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {

      $('input[type="checkbox"]').eq(0).on('change', function() {
        var isChecked = $(this).prop('checked');
        $('input[type="checkbox"]').not(this).prop('checked', isChecked);
      });

      $('#selected-clause').change(function(e) {
        e.preventDefault();
        var selectedOption = $(this).find(":selected");
        var totalAmount = selectedOption.data("amount");
        var totalFunds = selectedOption.data("funds");
        $("#display-amount").text(`Amount: ${totalAmount - totalFunds}`);
      });

      var membersId = [];
      $('input[type="checkbox"]').on('change', function() {
        membersId = []

        var amount = $("#display-amount").text().replace("Amount: ", "");
        $('input[type="checkbox"]:checked').each(function() {
          var checkbox = $(this);
          membersId.push($(this).val())
        });

        membersId = membersId.filter(function(item) {
          return item !== 'on';
        });

      });

      $("#collect-button").click(function(e) {
        e.preventDefault();
        var clauseId = $('#selected-clause').val()

        if (membersId.length == 0) {
          $("#modal-body-text").text("Please select at least one member")
          $('#alert-modal').modal('show');
          return;
        }

        if (clauseId == "") {
          $("#modal-body-text").text("Please Select Clause")
          $('#alert-modal').modal('show');
          return;
        }

        var amount = $("#display-amount").text().replace("Amount: ", "");
        $.ajax({
          type: "POST",
          url: "handlers/collect-funds.php",
          data: {
            "clauseId": clauseId,
            "ids": membersId,
            "amount": amount
          },
          success: function(response) {
            window.location = "get-funds.php";
          }
        });
      });

      $('#close-btn').on('click', function() {
        $('#alert-modal').modal('hide');
      });

    });
  </script>


</body>

</html>