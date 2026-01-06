<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.html");
    exit();
}
$name = $_SESSION['name'];
$username = "akhaf"; // contoh, bisa ambil dari DB
$email = "akhaf@gmail.com";
$phone = "08963449835";
$gender = "Laki - laki";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Akun Saya - Toymart</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { display:flex; font-family:sans-serif; }
    .sidebar {
      width:200px; background:#f0f0f0; padding:20px;
    }
    .sidebar a { display:block; margin-bottom:10px; text-decoration:none; color:#333; }
    .content {
      flex:1; padding:30px;
    }
    input[type="text"], input[type="email"], input[type="tel"] {
      width:100%; padding:8px; margin-bottom:10px;
    }
    .gender { margin-bottom:10px; }
    .btn { padding:10px 15px; background:#007bff; color:#fff; border:none; cursor:pointer; }
  </style>
</head>
<body>
  <div class="sidebar">
    <h3>Toymart</h3>
    <a href="account.php">Akun Saya</a>
    <a href="orders.php">Pesanan Saya</a>
    <a href="logout.php">Log out</a>
  </div>

  <div class="content">
    <h1>Profil Saya</h1>
    <form method="post" action="save_profile.php">
      <label>Nama Akun:</label>
      <input type="text" name="username" value="<?php echo $username; ?>" readonly>

      <label>Nama:</label>
      <input type="text" name="name" value="<?php echo $name; ?>">

      <label>Email:</label>
      <input type="email" name="email" value="<?php echo $email; ?>">

      <label>Nomor Telepon:</label>
      <input type="tel" name="phone" value="<?php echo $phone; ?>">

      <div class="gender">
        <label>Jenis Kelamin:</label><br>
        <input type="radio" name="gender" value="Laki - laki" checked> Laki - laki
        <input type="radio" name="gender" value="Perempuan"> Perempuan
        <input type="radio" name="gender" value="Lainnya"> Lainnya
      </div>

      <button type="submit" class="btn">Simpan</button>
    </form>

    <br>
    <form action="address.php">
      <button type="submit" class="btn">Alamat Saya</button>
    </form>
  </div>
</body>
</html>