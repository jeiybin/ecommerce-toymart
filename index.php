<?php
session_start();
include "backend/db.php";

$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

if ($selectedCategory) {
    $query = mysqli_query(
        $conn,
        "SELECT * FROM products WHERE category='$selectedCategory'"
    );
} else {
    $query = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Toymart - Homepage</title>
  <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <div class="nav-logo">TOYMART</div>

  <nav class="nav-menu">
    <a href="index.php">Collection</a>
    <a href="index.php?category=Brand">Brand</a>
    <a href="#categories">Categories</a>
  </nav>

  <div class="nav-actions">
    <button class="nav-btn">Keranjang</button>
    <button class="nav-btn secondary">Akun</button>
  </div>
</header>

<main class="dashboard-main">

  <!-- HERO -->
  <section class="hero">
    <div class="hero-main">
      <p class="hero-badge">New Arrival • Limited Series</p>
      <h1>Santa's Little Helper Series 🎄</h1>
      <p class="hero-text">
        Koleksi Labubu & teman-teman edisi spesial dengan detail super lucu.
      </p>
      <button class="hero-btn" onclick="location.href='#categories'">Shop Now</button>
    </div>

    <div class="hero-side">
      <div class="hero-side-img">
        Banner image
      </div>
      <p class="hero-side-caption">Promo akhir tahun • Diskon hingga 30%</p>
    </div>
  </section>

  <!-- CATEGORIES -->
  <section class="categories-chips" id="categories">
    <div class="section-header">
      <h2>Categories</h2>
      <span class="section-subtitle">Pilih kategori</span>
    </div>

    <div class="chip-list">
      <button class="chip" onclick="location.href='index.php'">All</button>
      <button class="chip" onclick="location.href='index.php?category=Character'">Character</button>
      <button class="chip" onclick="location.href='index.php?category=Brand'">Brand</button>
      <button class="chip" onclick="location.href='index.php?category=Limited Edition'">Limited Edition</button>
    </div>
  </section>

  <!-- PRODUK -->
  <section class="products-section">
    <div class="section-header">
      <h2>
        Produk <?= $selectedCategory ? htmlspecialchars($selectedCategory) : 'Terbaru'; ?>
      </h2>
      <span class="section-subtitle">
        <?= $selectedCategory ? 'Kategori terpilih' : 'Rekomendasi Toymart'; ?>
      </span>
    </div>

    <div class="product-grid">
      <?php while ($p = mysqli_fetch_assoc($query)) { ?>
        <div class="product-card">
          <img
            src="public/images/produk/<?= $p['image_url']; ?>"
            class="product-img"
            alt="<?= htmlspecialchars($p['name']); ?>"
          >
          <h3><?= htmlspecialchars($p['name']); ?></h3>
          <p class="product-price">
            Rp <?= number_format($p['price'], 0, ',', '.'); ?>
          </p>
          <button class="product-btn">+ Keranjang</button>
        </div>
      <?php } ?>
    </div>
  </section>

</main>
</body>
</html>
