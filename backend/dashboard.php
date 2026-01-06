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
  <title>Toymart - Dashboard</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .navbar {
      display:flex; justify-content:space-between;
      background:#eee; padding:10px;
    }
    .navbar ul {
      list-style:none; display:flex; gap:15px;
      margin:0; padding:0;
    }
    .navbar ul li { cursor:pointer; }
    #overlay {
      display:none; position:fixed; top:0; left:0;
      width:100%; height:100%;
      background:rgba(0,0,0,0.3);
      z-index:999;
    }
    .popup {
      display:none; position:fixed; top:20%; left:50%;
      transform:translateX(-50%);
      background:#fff; border:1px solid #ccc; padding:20px;
      z-index:1000; box-shadow:0 0 10px rgba(0,0,0,0.2);
    }
    .popup.active { display:block; }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <ul>
      <li onclick="showCategory('Character')">Character</li>
      <li onclick="showCategory('Brand')">Brand</li>
      <li onclick="showCategory('Categories')">Categories</li>
    </ul>
    <div>
      <button onclick="toggleCart()">🛒 Keranjang</button>
      <button onclick="toggleAccount()">👤 Akun</button>
    </div>
  </div>

  <!-- Konten utama -->
  <div class="container">
    <p>Pilih kategori di atas untuk melihat produk.</p>
    <div id="category-content"></div>
  </div>

  <!-- Overlay -->
  <div id="overlay"></div>

  <!-- Popup Keranjang -->
  <div id="cart-popup" class="popup">
    <h2>Keranjang Belanja</h2>
    <p>Daftar produk yang kamu pilih akan muncul di sini.</p>
    <button onclick="checkout()">Checkout</button>
  </div>

  <!-- Popup Akun -->
  <div id="account-popup" class="popup">
    <p><?php echo htmlspecialchars($name); ?></p>
    <a href="orders.php">Pesanan Saya</a><br>
    <a href="logout.php" onclick="return confirm('Apakah anda yakin ingin logout?')">Logout</a>
  </div>

  <script>
    // tampilkan kategori
    function showCategory(cat) {
      document.getElementById('category-content').innerHTML =
      cat + "</h2><p>Produk kategori <b>" + cat + "</b> akan ditampilkan di sini.</p>";
    }

    // toggle popup keranjang
    function toggleCart() {
      const cart = document.getElementById('cart-popup');
      const overlay = document.getElementById('overlay');
      cart.classList.toggle('active');
      overlay.style.display = cart.classList.contains('active') ? 'block' : 'none';
    }

    // toggle popup akun
    function toggleAccount() {
      const account = document.getElementById('account-popup');
      const overlay = document.getElementById('overlay');
      account.classList.toggle('active');
      overlay.style.display = account.classList.contains('active') ? 'block' : 'none';
    }

    // checkout
    function checkout() {
      window.location.href = "checkout.php";
    }

    // klik overlay = tutup semua popup
    document.getElementById('overlay').addEventListener('click', function() {
      document.getElementById('cart-popup').classList.remove('active');
      document.getElementById('account-popup').classList.remove('active');
      this.style.display = 'none';
    });
  </script>
</body>
</html>