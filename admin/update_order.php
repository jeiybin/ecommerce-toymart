<?php
session_start();
include __DIR__ . '/../backend/db.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit();
}

$order_id = (int) $_POST['order_id'];
$status = mysqli_real_escape_string($conn, $_POST['status']);

$sql = "UPDATE orders SET status='$status' WHERE order_id=$order_id";
if (mysqli_query($conn, $sql)) {
    header("Location: orders.php");
    exit();
} else {
    echo "Gagal update status: " . mysqli_error($conn);
}
?>