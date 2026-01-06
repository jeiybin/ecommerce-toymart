<?php
session_start();
include __DIR__ . '/../backend/db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit();
}

$id = (int) $_GET['id'];

// Cek apakah produk masih dipakai di order_items
$check = mysqli_query($conn, "SELECT * FROM order_items WHERE product_id = $id");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Produk tidak bisa dihapus karena masih dipakai di order_items!'); window.location='products.php';</script>";
    exit();
}

// Kalau aman, hapus produk
$sql = "DELETE FROM products WHERE product_id = $id";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Produk berhasil dihapus!'); window.location='products.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>