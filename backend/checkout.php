<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.html");
    exit();
}
$name = $_SESSION['name'];


$total = 0;
foreach ($produk as $p) {
  $total += $p["harga"] * $p["jumlah"];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Toymart</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .container { max-width:700px; margin:30px auto; padding:20px; background:#fff; border:1px solid #ccc; }
    h1 { margin-bottom:20px; }
    .produk { margin-bottom:15px; }
    .btn { padding:10px 20px; background:#007bff; color:#fff; border:none; cursor:pointer; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Checkout</h1>

    <h3>📍Alamat Pengiriman</h3>
    <p><?php echo $alamat; ?></p>

    <h3>Pesanan</h3>
    <?php foreach ($produk as $p): ?>
      <div class="produk">
        <strong><?php echo $p["nama"]; ?></strong><br>
        Harga Satuan: Rp. <?php echo number_format($p["harga"], 0, ',', '.'); ?><br>
        Jumlah: <?php echo $p["jumlah"]; ?><br>
        Subtotal Produk: Rp. <?php echo number_format($p["harga"] * $p["jumlah"], 0, ',', '.'); ?>
      </div>
    <?php endforeach; ?>

    <h3>Total Pesanan: Rp. <?php echo number_format($total, 0, ',', '.'); ?></h3>

    <form action="payment.php" method="post">
      <input type="hidden" name="total" value="<?php echo $total; ?>">
      <button type="submit" class="btn">Pembayaran</button>
    </form>
  </div>
</body>
</html>