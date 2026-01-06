<?php
session_start();
include __DIR__ . '/../backend/db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit();
}

// ambil filter dari URL
$status = $_GET['status'] ?? 'all';
$order_number = $_GET['order_number'] ?? '';
$sort = $_GET['sort'] ?? 'oldest';

// query dasar
$sql = "SELECT * FROM orders WHERE 1";

// filter status
if ($status !== 'all') {
    $sql .= " AND status='$status'";
}

// filter no pesanan
if (!empty($order_number)) {
    $sql .= " AND order_id LIKE '%$order_number%'";
}

// sorting
$order_by = ($sort === 'newest') ? "DESC" : "ASC";
$sql .= " ORDER BY created_at $order_by";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pesanan</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .tabs a { margin-right: 10px; text-decoration: none; padding: 6px 12px; border: 1px solid #ccc; background: #eee; }
        .tabs a.active { background: #333; color: #fff; }
        form { margin: 20px 0; }
        input, select, button { margin-right: 10px; padding: 6px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f2f2f2; }
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
    <div class="menu-container">
        <button class="menu-button" onclick="toggleMenu()">⋮</button>
        <div class="menu-popup" id="menuPopup">
            <a href="orders.php">Kelola Pesanan</a>
            <a href="products.php">Kelola Produk</a>
        </div>
    </div>

    <h2>Kelola Pesanan</h2>

    <div class="tabs">
        <?php
        $tabs = ['all' => 'Semua', 'unpaid' => 'Belum Bayar', 'ready' => 'Perlu Dikirim', 'shipped' => 'Dikirim', 'completed' => 'Selesai'];
        foreach ($tabs as $key => $label) {
            $active = ($status === $key) ? 'active' : '';
            echo "<a href='orders.php?status=$key' class='$active'>$label</a>";
        }
        ?>
    </div>

    <form method="get" action="orders.php">
        <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">
        <input type="text" name="order_number" placeholder="No. Pesanan" value="<?= htmlspecialchars($order_number) ?>">
        <select name="sort">
            <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>Terlama ke Terbaru</option>
            <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Terbaru ke Terlama</option>
        </select>
        <button type="submit">Terapkan</button>
        <a href="orders.php" class="btn">Reset</a>
    </form>

    <table>
        <tr>
            <th>No. Pesanan</th>
            <th>Produk</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php if (mysqli_num_rows($result) === 0) { ?>
            <tr><td colspan="5">Tidak ada pesanan.</td></tr>
        <?php } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $summary = $row['product_summary'] ?? '(produk belum dirangkum)';
                $total = $row['total_amount'] ?? $row['price'] ?? 0;
        ?>
            <tr>
                <td>#<?= $row['order_id'] ?></td>
                <td><?= htmlspecialchars($summary) ?></td>
                <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <form method="post" action="update_order.php" style="margin:0;">
                        <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="unpaid" <?= $row['status'] === 'unpaid' ? 'selected' : '' ?>>Belum Bayar</option>
                            <option value="ready" <?= $row['status'] === 'ready' ? 'selected' : '' ?>>Perlu Dikirim</option>
                            <option value="shipped" <?= $row['status'] === 'shipped' ? 'selected' : '' ?>>Dikirim</option>
                            <option value="completed" <?= $row['status'] === 'completed' ? 'selected' : '' ?>>Selesai</option>
                            <option value="cancelled" <?= $row['status'] === 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </form>
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