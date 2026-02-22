<?php
session_start();
require_once '../config/database.php';

// A. LOGIKA TAMBAH USER
if (isset($_POST['tambah_user'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role     = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // WAJIB HASH

    // Tambahan: Cek apakah username sudah ada di database
    $cek_user = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah dipakai, silakan cari yang lain!'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO user (username, password, nama, role) VALUES ('$username', '$password', '$nama', '$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Anggota baru berhasil ditambahkan!'); window.location='../index.php?page=user';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

// B. LOGIKA EDIT USER
} elseif (isset($_POST['edit_user'])) {
    $id_user  = $_POST['id_user'];
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role     = $_POST['role'];
    $password = $_POST['password'];

    // Jika password diisi, maka update dengan password baru
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE user SET nama='$nama', username='$username', password='$password_hash', role='$role' WHERE id_user='$id_user'";
    } else {
        // Jika password kosong, jangan ubah password lama
        $query = "UPDATE user SET nama='$nama', username='$username', role='$role' WHERE id_user='$id_user'";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data anggota berhasil diupdate!'); window.location='../index.php?page=user';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

// C. LOGIKA HAPUS USER
} elseif (isset($_GET['hapus_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus_id']);
    
    // Keamanan: Dilarang hapus akun yang sedang dipakai login
    if ($id == $_SESSION['user_id']) {
        echo "<script>alert('Gak bisa hapus akun sendiri men!'); window.location='../index.php?page=user';</script>";
        exit();
    }

    $query_hapus = "DELETE FROM user WHERE id_user = '$id'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('User berhasil dihapus!'); window.location='../index.php?page=user';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    // Jika akses file ini tanpa aksi apa-apa, lempar balik ke halaman user
    header("Location: ../index.php?page=user");
}
?>