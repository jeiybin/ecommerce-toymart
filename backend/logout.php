<?php
session_start();
session_destroy(); // hapus semua session
header("Location: ../public/login.html"); // langsung arahkan ke login
exit();
?>