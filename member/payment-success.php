<?php
session_start();
if (!isset($_SESSION["member_id"])) {
  header("LOCATION: login.php");
}

if (!isset($_GET["amount"])) {
  header("LOCATION: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Payment Confirmed</title>
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>
  body {
    text-align: center;
    padding: 40px 0;
    background: #EBF0F5;
  }

  h1 {
    color: #88B04B;
    font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
    font-weight: 900;
    font-size: 40px;
    margin-bottom: 10px;
  }

  p {
    color: #404F5E;
    font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
    font-size: 20px;
    margin: 0;
  }

  i {
    color: #9ABC66;
    font-size: 100px;
    line-height: 200px;
    margin-left: -15px;
  }

  .card {
    background: white;
    padding: 60px;
    border-radius: 4px;
    box-shadow: 0 2px 3px #C8D0D8;
    display: inline-block;
    margin: 0 auto;
  }
</style>

<body>
  <div class="card">
    <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
      <i class="checkmark">✓</i>
    </div>
    <h1>Success</h1>
    <p>Your payment of <strong>$<?php echo $_GET["amount"]; ?></strong> has been successfully transferred.<br> Thank you for your transaction!</p>
    <a href="deposit-ledger.php" class="btn">Back to Home Page</a>
  </div>
</body>

</html>