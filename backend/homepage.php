<?php
include __DIR__ . '/../backend/db.php';
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 6");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Toymart Homepage</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #fff; color: #333; }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f5f5f5;
            padding: 10px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar .logo { font-size: 20px; font-weight: bold; color: #e91e63; }
        .navbar .menu a {
            margin: 0 12px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        .navbar .icons a {
            margin-left: 15px;
            font-size: 18px;
            text-decoration: none;
        }
        .banner img {
            width: 100%;
            height: auto;
            display: block;
        }
        .section-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 30px 0 10px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            padding: 0 30px 40px;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
            background: #fff;
            transition: box-shadow 0.2s ease;
        }
        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }
        .product-card h4 {
            font-size: 14px;
            margin: 10px 0 5px;
        }
        .product-card p {
            margin: 0;
            font-weight: bold;
            color: #e91e63;
        }
        .product-card a {
            display: inline-block;
            margin-top: 8px;
            text-decoration: none;
            font-size: 13px;
            color: #2196f3;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Toymart</div>
        <div class="menu">
            <a href="#">Home</a>
            <a href="#">Character</a>
            <a href="#">Brand</a>
            <a href="#">Categories</a>
        </div>
        <div class="icons">
            <a href="login.php">👤</a>
            <a href="cart.php">🛒</a>
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

</body>
</html>