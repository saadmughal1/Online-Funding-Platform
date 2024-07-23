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
  <title>Monthly Report</title>
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
                    <h4 class="card-title">Monthly Expense Report</h4>
                    <form action="">
                      <div class="container-fluid p-0">
                        <div class="row mb-4">


                          <div class="col-md-4  d-flex align-items-center flex-wrap mb-2">
                            <label for="start-date" class="pe-2"><b>Start Date: </b></label>
                            <input type="date" name="" id="start-date">
                          </div>

                          <div class="col-md-4  d-flex align-items-center flex-wrap mb-2">
                            <label for="end-date" class="pe-2"><b>End Date: </b></label>
                            <input type="date" name="" id="end-date">
                          </div>

                          <div class="col-md-4 d-flex align-items-center mb-2">
                            <button class="btn btn-gradient-primary me-2" id="search-btn">Search</button>
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
      $("#search-btn").click(function(e) {
        e.preventDefault()
        var startDate = $("#start-date").val()
        var endDate = $("#end-date").val()

        if (startDate == "") {
          $("#modal-body-text").text("Please select starting date")
          $('#alert-modal').modal('show');
          return
        }

        if (endDate == "") {
          $("#modal-body-text").text("Please select ending date")
          $('#alert-modal').modal('show');
          return
        }


        var startDateObj = new Date(startDate);
        var endDateObj = new Date(endDate);

        if (endDateObj < startDateObj) {
          $("#modal-body-text").text("Ending date cannot be smaller than the starting date");
          $('#alert-modal').modal('show');
          return;
        }



        $.ajax({
          type: "POST",
          url: "handlers/load-monthly-expense-report.php",
          data: {
            "start-date": startDate,
            "end-date": endDate
          },
          success: function(response) {
            $("#report-body").html(response);
          }
        });


      })









      $('#close-btn').on('click', function() {
        $('#alert-modal').modal('hide');
      });
    });
  </script>


</body>

</html>