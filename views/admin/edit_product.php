<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        form { max-width: 400px; margin: auto; }
        input, textarea { display: block; width: 100%; margin-bottom: 10px; padding: 8px; }
        button { padding: 8px 16px; }
        .btn-back {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 8px;
            font-size: 14px;
            text-decoration: none;
            border: 1px solid #333;
            background: #eee;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Tombol kecil di kiri atas -->
    <a href="products.php" class="btn-back">←</a>

<?php
session_start();
include __DIR__ . '/../backend/db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit();
}

$id = (int) $_GET['id'];

// Ambil data produk
$result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $toy_type = mysqli_real_escape_string($conn, $_POST['toy_type']);
    $character_name = mysqli_real_escape_string($conn, $_POST['character_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (int) $_POST['price'];
    $stock = (int) $_POST['stock'];
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);

    $sql = "UPDATE products SET 
                name='$name',
                brand='$brand',
                toy_type='$toy_type',
                character_name='$character_name',
                description='$description',
                price=$price,
                stock=$stock,
                image_url='$image_url'
            WHERE product_id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Produk berhasil diupdate!'); window.location='products.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

    <form method="post" action="edit_product.php?id=<?= $id ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>
        <input type="text" name="toy_type" value="<?= htmlspecialchars($product['toy_type']) ?>" required>
        <input type="text" name="character_name" value="<?= htmlspecialchars($product['character_name']) ?>" required>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
        <input type="number" name="price" value="<?= $product['price'] ?>" required>
        <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
        <input type="url" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>