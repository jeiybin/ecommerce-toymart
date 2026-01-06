<?php
session_start();
include __DIR__ . '/../backend/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { max-width: 60px; }
        .btn { padding: 6px 12px; margin: 2px; text-decoration: none; border: 1px solid #333; background: #eee; }
        .menu-container { position: absolute; top: 10px; right: 10px; }
        .menu-button { font-size: 24px; cursor: pointer; background: none; border: none; }
        .menu-popup { display: none; position: absolute; right: 0; top: 30px; background: #fff; border: 1px solid #ccc;
                      box-shadow: 0 2px 6px rgba(0,0,0,0.2); border-radius: 4px; min-width: 150px; z-index: 100; }
        .menu-popup a { display: block; padding: 10px; text-decoration: none; color: #333; }
        .menu-popup a:hover { background: #f2f2f2; }
    </style>
</head>
<body>
    <!-- Titik tiga menu -->
    <div class="menu-container">
        <button class="menu-button" onclick="toggleMenu()">⋮</button>
        <div class="menu-popup" id="menuPopup">
            <a href="orders.php">Kelola Pesanan</a>
            <a href="products.php">Kelola Produk</a>
        </div>
    </div>

    <h2>Dashboard Admin - Daftar Produk</h2>
    <a href="add_product.php" class="btn">+ Tambah Produk</a>

    <table>
        <tr>
            <th>Nama</th>
            <th>Merek</th>
            <th>Jenis</th>
            <th>Karakter</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        <?php if (mysqli_num_rows($result) === 0) { ?>
            <tr><td colspan="9">Belum ada produk.</td></tr>
        <?php } else {
            while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['brand']) ?></td>
                <td><?= htmlspecialchars($row['toy_type']) ?></td>
                <td><?= htmlspecialchars($row['character_name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                <td><?= $row['stock'] ?></td>
                <td>
                    <img src="uploads/<?= htmlspecialchars($row['image_url']) ?>" alt="gambar">
                </td>
                <td>
                    <a href="edit_product.php?id=<?= $row['product_id'] ?>" class="btn">✏️</a>
                    <a href="delete_product.php?id=<?= $row['product_id'] ?>" class="btn" onclick="return confirm('Yakin hapus produk ini?')">🗑️</a>
                </td>
            </tr>
        <?php }} ?>
    </table>

    <script>
        function toggleMenu() {
            const popup = document.getElementById("menuPopup");
            popup.style.display = (popup.style.display === "block") ? "none" : "block";
        }
        document.addEventListener("click", function(event) {
            const popup = document.getElementById("menuPopup");
            const button = document.querySelector(".menu-button");
            if (!popup.contains(event.target) && !button.contains(event.target)) {
                popup.style.display = "none";
            }
        });
    </script>
</body>
</html>