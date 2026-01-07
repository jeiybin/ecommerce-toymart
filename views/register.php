<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $phone    = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '';

    // enkripsi password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // simpan ke database
    $sql = "INSERT INTO users (name, email, password_hash, phone)
            VALUES ('$name', '$email', '$password_hash', '$phone')";

    if (mysqli_query($conn, $sql)) {
        echo "<!DOCTYPE html>
        <html lang='id'>
        <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Registrasi Berhasil</title>
          <link rel='stylesheet' href='../style.css'>
        </head>
        <body>
          <div class='container'>
            <h2>Registrasi berhasil!</h2>
            <p>Akun anda telah dibuat, silahkan <a href='../public/login.html'>login</a> untuk masuk ke Toymart.</p>
          </div>
        </body>
        </html>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>