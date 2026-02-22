<?php
session_start();

// --- 1. SET KUNCI KEAMANAN GLOBAL ---
// Supaya file di jero folder views teu bisa dibuka langsung
define('AKSES_HALAMAN', true);

/**
 * KONSEP SALING BERHUBUNGAN (MODULAR)
 * Manggil kabéh dependensi pusat di dieu
 */
require_once 'config/database.php';
require_once 'models/peminjaman.php';
require_once 'core/model.php';
require_once 'core/controller.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// --- 2. PROTEKSI LOGIN ---
if (!isset($_SESSION['user_id']) && !in_array($page, ['login', 'registrasi'])) {
    header("Location: index.php?page=login");
    exit();
}

if (isset($_SESSION['user_id']) && in_array($page, ['login', 'registrasi'])) {
    header("Location: index.php?page=home");
    exit();
}

$role = isset($_SESSION['role']) ? strtolower(trim($_SESSION['role'])) : '';

// --- 3. SWITCH CASE JALUR UTAMA ---
switch ($page) {
    case 'login':
        include 'views/login.php';
        break;

    case 'registrasi': 
        include 'views/registrasi.php';
        break;

    case 'logout': 
        session_unset();
        session_destroy();
        // Bersihkan cookie session supaya benar-benar aman
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        header("Location: index.php?page=login");
        exit();
        break;

    // --- JALUR KHUSUS CETAK (TANPA HEADER/FOOTER) ---
    case 'cetak_laporan':
        if ($role == 'admin') {
            include 'views/admin/cetak_laporan.php';
        } else {
            echo "<script>alert('Akses dilarang!'); window.location='index.php';</script>";
        }
        break;

    case 'cetak_struk':
        include 'views/admin/cetak_struk.php';
        break;

    // --- 4. HALAMAN DENGAN LAYOUT (HEADER & FOOTER) ---
    default:
        include 'views/layout/header.php';
        
        if ($page == 'home') {
            if ($role == 'admin') {
                include 'views/admin/dashboard.php'; 
            } else {
                include 'views/siswa/home.php'; 
            }
        } 
        
        // --- ROUTING ANGGOTA/USER (ADMIN) ---
        elseif ($page == 'user' && $role == 'admin') {
            include 'views/admin/user.php'; 
        } 
        elseif ($page == 'user_tambah' && $role == 'admin') {
            include 'views/admin/user_tambah.php';
        }
        elseif ($page == 'user_edit' && $role == 'admin') {
            include 'views/admin/user_edit.php';
        }

        // --- ROUTING BUKU (FIXED REDIRECT) ---
        // Ditambahkeun alias 'kelola_buku' sangkan sinkron jeung core/proses_buku.php
        elseif (($page == 'buku' || $page == 'kelola_buku')) {
            if ($role == 'admin') {
                include 'views/admin/buku.php';
            } else {
                if (file_exists('views/siswa/buku.php')) {
                    include 'views/siswa/buku.php'; 
                } else {
                    echo "<div class='alert alert-warning m-3'>File views/siswa/buku.php teu kapendak!</div>";
                }
            }
        }
        elseif ($page == 'tambah_buku' && $role == 'admin') {
            include 'views/admin/tambah_buku.php';
        }
        elseif ($page == 'edit_buku' && $role == 'admin') {
            include 'views/admin/edit_buku.php';
        }

        // --- ROUTING LAPORAN & SIRKULASI ---
        elseif (($page == 'laporan' || $page == 'peminjaman_all' || $page == 'sirkulasi') && $role == 'admin') {
            include 'views/admin/laporan.php';
        }

        // --- ROUTING SISWA ---
        elseif ($page == 'pinjam' && $role == 'siswa') {
            include 'views/siswa/pinjam_buku.php'; 
        }
        elseif (($page == 'pengembalian' || $page == 'riwayat' || $page == 'pinjaman_saya') && $role == 'siswa') {
            if (file_exists('views/siswa/riwayat.php')) {
                include 'views/siswa/riwayat.php';
            } else {
                echo "<div class='alert alert-warning m-3'>File riwayat teu kapendak!</div>";
            }
        }

        // --- HALAMAN ERROR ---
        else {
            echo "<div class='alert alert-danger m-3'>Halaman teu kapendak atawa anjeun teu gaduh aksés!</div>";
            echo "<script>setTimeout(function(){ window.location='index.php?page=home'; }, 2000);</script>";
        }

        include 'views/layout/footer.php';
        break;
}
?>