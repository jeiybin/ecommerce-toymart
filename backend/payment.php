<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.html");
    exit();
}
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Toymart - Checkout</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .container { max-width:600px; margin:30px auto; padding:20px; border:1px solid #ccc; background:#fff; }
    h1 { margin-bottom:20px; }
    .method { margin:10px 0; }
    .btn { padding:10px 15px; margin-top:15px; cursor:pointer; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Checkout - Toymart</h1>
    <p>Halo, <?php echo htmlspecialchars($name); ?>. Silakan pilih metode pembayaran:</p>

    <form action="orders.php" method="post">
      <!-- Metode pembayaran -->
      <div class="method">
        <input type="radio" id="va" name="payment" value="va" required>
        <label for="va">Transfer Bank (Virtual Account)</label>
      </div>
      <div class="method">
        <input type="radio" id="ewallet" name="payment" value="ewallet">
        <label for="ewallet">E-Wallet (OVO, GoPay, dll)</label>
      </div>
      <div class="method">
        <input type="radio" id="cod" name="payment" value="cod">
        <label for="cod">Cash on Delivery (COD)</label>
      </div>

      <!-- Tombol buat pesanan -->
      <button type="submit" class="btn">Buat Pesanan</button>
    </form>
  </div>
</body>
</html>