<?php
session_start();
include __DIR__ . '/../backend/db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $toy_type = mysqli_real_escape_string($conn, $_POST['toy_type']);
    $character_name = mysqli_real_escape_string($conn, $_POST['character_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (int) $_POST['price'];
    $stock = (int) $_POST['stock'];
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);

    $sql = "INSERT INTO products 
            (name, brand, toy_type, character_name, description, price, stock, image_url, created_at)
            VALUES 
            ('$name', '$brand', '$toy_type', '$character_name', '$description', $price, $stock, '$image_url', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Produk berhasil ditambahkan!'); window.location='products.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        form { max-width: 400px; margin: auto; }
        input, textarea { display: block; width: 100%; margin-bottom: 10px; padding: 8px; }
        button { padding: 8px 16px; }
    </style>
</head>
<body>
    <h2>Tambah Produk Baru</h2>
    <form method="post" action="add_product.php">
        <input type="text" name="name" placeholder="Nama Produk" required>
        <input type="text" name="brand" placeholder="Merek" required>
        <input type="text" name="toy_type" placeholder="Jenis Mainan (Figure/BagCharm/Accessories)" required>
        <input type="text" name="character_name" placeholder="Nama Karakter" required>
        <textarea name="description" placeholder="Deskripsi Produk" required></textarea>
        <input type="number" name="price" placeholder="Harga (angka saja)" required>
        <input type="number" name="stock" placeholder="Stok" required>
        <input type="url" name="image_url" placeholder="Link Gambar (Google Drive)" required>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>