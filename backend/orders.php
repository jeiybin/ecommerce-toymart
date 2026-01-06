<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.html");
    exit();
}
$name = $_SESSION['name'];
$payment = $_POST['payment'] ?? '';
$status = ($payment === 'va') ? "Belum Bayar (menunggu konfirmasi manual)" : "Dikemas (pembayaran terkonfirmasi)";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Toymart - Pesanan Saya</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="container">
    <h1>Pesanan Saya</h1>
    <p>Metode pembayaran: <b><?php echo htmlspecialchars($payment); ?></b></p>
    <p>Status pesanan: <b><?php echo $status; ?></b></p>

    <?php if ($payment === 'va'): ?>
      <p>Nomor Virtual Account: <b>1234-5678-9012</b></p>
      <form method="post" action="confirmed.php">
        <input type="hidden" name="payment" value="va">
        <button type="submit">Saya sudah bayar</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>