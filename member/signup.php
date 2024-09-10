<?php
session_start();
if (isset($_SESSION["member_id"])) {
    header("LOCATION: ./");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Member Signup</title>
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <h1 class="text-center">Member SignUp</h1>

                            <h6 class="text-center text-danger"><?php if (isset($_GET["err"])) echo $_GET["err"]; ?></h6>
                            <h6 class="text-center text-success"><?php if (isset($_GET["msg"])) echo $_GET["msg"]; ?></h6>

                            <form class="forms-sample" method="POST" action="handlers/signup.php">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" id="user-name" placeholder="Username" required>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                </div>

                                <div class="form-group d-flex justify-content-center">
                                    <button type="submit" class="btn btn-gradient-primary me-2">Signup</button>
                                </div>

                                <h6 class="text-primary text-center">Already have an account? <a href="./login">Login</a></h6>

                            </form>

                        </div>
                    </div>
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