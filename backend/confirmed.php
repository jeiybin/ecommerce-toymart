<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.html");
    exit();
}
$name = $_SESSION['name'];
$payment = $_POST['payment'] ?? '';
$status = "Dikemas (pembayaran terkonfirmasi)";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan Terkonfirmasi - Toymart</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="container">
    <h1>Pesanan Terkonfirmasi</h1>
    <p>Metode pembayaran: <b><?php echo htmlspecialchars($payment); ?></b></p>
    <p>Status pesanan: <b><?php echo $status; ?></b></p>
  </div>
</body>
</html>