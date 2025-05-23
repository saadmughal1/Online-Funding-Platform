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
    <title>Edit Member</title>
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
                                    <h4 class="card-title">Edit Member</h4>

                                    <form class="forms-sample" method="POST" action="handlers/edit-member.php">
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <input type="hidden" name="old_email" value="<?php echo $row["email"] ?>">

                                        <div class="form-group">
                                            <label for="user-name">Username</label>
                                            <input type="text" class="form-control" name="username" id="user-name" placeholder="Username" value="<?php echo $row["username"] ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $row["email"] ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $row["password"] ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="initial-amount">Initial Amount</label>
                                            <input type="number" class="form-control" name="initial-amount" id="initial-amount" placeholder="Initial Amount" value="<?php echo $row["initial_amount"]; ?>" required>
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