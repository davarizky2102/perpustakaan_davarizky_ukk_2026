<?php
session_start();

// 1. Ambil koneksi database
require_once __DIR__ . '/../config/database.php'; 

// 2. Ambil modelnya
require_once __DIR__ . '/../models/user.php';

if (!isset($conn)) {
    die("Error: Koneksi database gagal!");
}

$userModel = new User_model();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $userModel->getUserByUsername($username);

    if ($user) {
        // MODIFIKASI DI SINI MEN:
        // Cek pake password_verify (buat Dava/Iqbal) ATAU cek teks biasa (buat Admin lu)
        if (password_verify($password, $user['password']) || $password == $user['password']) {
            
            $_SESSION['user_id'] = $user['id_user']; // Inget pake id_user sesuai DB
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['role']; 
            
            header("Location: ../index.php?page=home");
            exit();
        } else {
            echo "<script>alert('Password lu salah men!'); window.location='../index.php?page=login';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Username kagak ada!'); window.location='../index.php?page=login';</script>";
        exit();
    }
}