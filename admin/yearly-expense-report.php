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
  <title>Yearly Report</title>
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
                    <h4 class="card-title">Yearly Expense Report</h4>
                    <form action="">
                      <div class="container-fluid p-0">
                        <div class="row mb-4">
                          <div class="col-md-6">
                            <select class="form-control" name="selected-clause" id="selected-year"></select>
                          </div>
                        </div>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th> Username</th>
                              <th> Clause Name</th>
                              <th> Amount</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody id="report-body"></tbody>
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


  <script>
    $(document).ready(function() {
      loadYears()
      // loadMembers()

      $("#selected-year").on("change", function() {
        var selectedYear = $(this).val();
        if (selectedYear != "") {
          loadYearlyReport(selectedYear)
        } else {
          $("#report-body").html("");
        }

      })

    });

    function loadYearlyReport(selectedYear) {
      $.ajax({
        type: "POST",
        url: "handlers/load-yearly-expense-report.php",
        data: {
          "year": selectedYear
        },
        success: function(response) {
          $("#report-body").html(response)
        }
      });
    }

    function loadYears() {
      $.ajax({
        type: "POST",
        url: "handlers/load-years.php",
        success: function(response) {
          $("#selected-year").html(response)
        }
      });
    }
  </script>



</body>

</html>