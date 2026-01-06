<?php
// mulai session
session_start();

// panggil koneksi database
include 'db.php';

// cek apakah form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // cari user berdasarkan email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // cek password dengan hash
        if (password_verify($password, $row['password_hash'])) {
            // simpan data user ke session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name']    = $row['name'];
            $_SESSION['role']    = $row['role']; // ambil role dari DB

            // redirect sesuai role
            if ($row['role'] === 'admin') {
                header("Location: ../admin/orders.php");
            } else {
                header("Location: ../backend/homepage.php");
            }
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Email tidak ditemukan!";
    }
}
?>