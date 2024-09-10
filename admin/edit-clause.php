<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("LOCATION: login.php");
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("LOCATION: view-clause.php");
}


include_once "classes/db.php";
include_once "classes/clause.php";

$db = new Db();
$id = $_GET["id"];
$clause = new Clause($db->getConnection(), $id);
$row = $clause->getClauseById()->fetch_assoc();

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("LOCATION: view-clause.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Clause</title>
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

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Edit Clause</h4>

                                    <form class="forms-sample" method="POST" action="handlers/edit-clause.php">
                                        <input type="hidden" name="id" value="<?php echo $id ?>">

                                        <div class="form-group">
                                            <label for="clause-name">Clause Name</label>
                                            <input type="text" class="form-control" id="clause-name" placeholder="Clause Name" name="name" value="<?php echo $row["name"] ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="clause-purpose">Purpose</label>
                                            <textarea type="text" class="form-control" id="clause-purpose" placeholder="Purpose" name="purpose" required><?php echo $row["purpose"] ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="clause-amount">Clause Amount</label>
                                            <input type="number" class="form-control" id="clause-amount" placeholder="Clause Amount" name="amount" value="<?php echo $row["amount"] ?>" required>
                                        </div>

                                        <h6 class="text-danger">
                                            <?php if (isset($_GET["err"])) echo $_GET["err"]; ?></h6>
                                        <div class="form-group d-flex justify-content-end">
                                            <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                                        </div>

                                    </form>
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