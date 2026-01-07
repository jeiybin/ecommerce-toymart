<?php
session_start();
include __DIR__ . '/../backend/db.php';

// Ambil produk terbaru
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 6");

// Ambil isi keranjang user (kalau sudah login)
$user_id = $_SESSION['user_id'] ?? 0;
$cart = mysqli_query($conn, "SELECT c.*, p.name, p.price, p.image_url 
                             FROM cart_items c 
                             JOIN products p ON c.product_id=p.product_id 
                             WHERE c.user_id=$user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Toymart Homepage</title>
    <style>
        body { margin:0; font-family:'Segoe UI',sans-serif; background:#fff; color:#333; }
        .topbar {
            background:#fefefe; padding:12px 30px;
            display:flex; justify-content:space-between; align-items:center;
            border-bottom:1px solid #eee;
        }
        .logo { font-size:20px; font-weight:bold; color:#e91e63; }
        .menu a {
            margin-right:20px; text-decoration:none; color:#333;
            font-weight:500; font-size:14px;
        }
        .icons a { margin-left:15px; font-size:18px; text-decoration:none; }
        .banner img { width:100%; height:auto; display:block; }
        .section-title { text-align:center; font-size:22px; font-weight:bold; margin:30px 0 10px; }
        .product-grid {
            display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
            gap:20px; padding:0 30px 40px;
        }
        .product-card {
            border:1px solid #eee; border-radius:8px; padding:12px;
            text-align:center; background:#fafafa; transition:box-shadow .2s ease;
        }
        .product-card:hover { box-shadow:0 4px 12px rgba(0,0,0,0.1); }
        .product-card img { width:100%; height:auto; border-radius:6px; }
        .product-card h4 { font-size:14px; margin:10px 0 5px; }
        .product-card p { margin:0; font-weight:bold; color:#e91e63; }
        .product-card a {
            display:inline-block; margin-top:8px; text-decoration:none;
            font-size:13px; color:#2196f3; border:1px solid #2196f3;
            padding:4px 10px; border-radius:4px;
        }
        /* Cart Popup */
        .cart-popup {
            display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); z-index:999;
        }
        .cart-content {
            background:#fff; width:400px; margin:80px auto; padding:20px;
            border-radius:8px; position:relative;
        }
        .cart-content h3 { margin-top:0; }
        .cart-item { display:flex; align-items:center; margin-bottom:10px; }
        .cart-item img { width:50px; height:auto; margin-right:10px; }
        .cart-item span { margin-right:10px; font-size:13px; }
        .close {
            position:absolute; right:10px; top:10px; cursor:pointer; font-size:20px;
        }
        .checkout-btn {
            display:block; margin-top:15px; padding:8px; text-align:center;
            background:#2196f3; color:#fff; text-decoration:none; border-radius:4px;
        }
    </style>
</head>
<body>

    <!-- Top Navigation -->
    <div class="topbar">
        <div class="logo">Toymart</div>
        <div class="menu">
            <a href="homepage.php">Home</a>
            <a href="#">Character</a>
            <a href="#">Brand</a>
            <a href="#">Categories</a>
        </div>
        <div class="icons">
            <a href="login.php">👤</a>
            <a href="#" onclick="toggleCart()">🛒</a>
        </div>
    </div>

    <!-- Banner -->
    <div class="banner">
        <img src="assets/banner_sonny_angel.jpg" alt="Sonny Angel Santa Series">
    </div>

    <!-- Produk Baru -->
    <div class="section-title">NEW ARRIVALS</div>
    <div class="product-grid">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                <h4><?= htmlspecialchars($row['name']) ?></h4>
                <p>Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                <a href="product_detail.php?id=<?= $row['product_id'] ?>">View Detail</a>
            </div>
        <?php } ?>
    </div>

    <!-- Pop-up Cart -->
    <div id="cartPopup" class="cart-popup">
        <div class="cart-content">
            <span class="close" onclick="toggleCart()">&times;</span>
            <h3>Keranjang Belanja</h3>
            <div id="cartItems">
                <?php
                if (mysqli_num_rows($cart) === 0) {
                    echo "<p>Keranjang kosong.</p>";
                } else {
                    while ($item = mysqli_fetch_assoc($cart)) {
                        echo "<div class='cart-item'>
                                <img src='".htmlspecialchars($item['image_url'])."' alt='gambar'>
                                <span>".$item['name']."</span>
                                <span>Qty: ".$item['quantity']."</span>
                                <span>Rp ".number_format($item['price'],0,',','.')."</span>
                              </div>";
                    }
                }
                ?>
            </div>
            <a href="checkout.php" class="checkout-btn">Checkout</a>
        </div>
    </div>

    <script>
    function toggleCart() {
        const popup = document.getElementById("cartPopup");
        popup.style.display = (popup.style.display === "block") ? "none" : "block";
    }
    // Tutup kalau klik di luar modal
    window.onclick = function(event) {
        const popup = document.getElementById("cartPopup");
        if (event.target === popup) {
            popup.style.display = "none";
        }
    }
    </script>

</body>
</html>