<?php
session_start();
require_once 'config/database.php';

// Cek jika belum login, arahkan ke login (Sesuai Flowmap)
if (!isset($_SESSION['username'])) {
    include 'views/login.php';
} else {
    include 'views/layout/header.php';
    include 'views/home.php';
    include 'views/layout/footer.php';
}
?>