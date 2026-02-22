<?php
// 1. SISTEM KUNCI: Cegah akses langsung ke file layout
if (!defined('AKSES_HALAMAN')) {
    header("Location: /perpustakaan/index.php?page=login");
    exit;
}

// 2. Keamanan Tambahan: Pastikan session data ada
$role = $_SESSION['role'] ?? null;
$page = $_GET['page'] ?? 'home';

if (!$role) {
    header("Location: index.php?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpusku - Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { overflow-x: hidden; font-family: 'Segoe UI', Tahoma, sans-serif; background: #f4f7f6; }
        
        /* SIDEBAR IJO GRADASI */
        #sidebar-wrapper { 
            min-height: 100vh; 
            width: 250px; 
            background: linear-gradient(180deg, #1cc88a 10%, #13855c 100%) !important;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            z-index: 1000;
        }

        .sidebar-heading {
            padding: 2rem 1.25rem;
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .list-group-item { 
            background: transparent !important; 
            color: rgba(255,255,255,.7) !important; 
            border: none; 
            padding: 15px 25px;
            transition: 0.3s;
        }

        .list-group-item:hover { 
            color: #fff !important; 
            background: rgba(255,255,255,0.1) !important; 
            padding-left: 30px;
        }

        .list-group-item.active-menu {
            color: #fff !important;
            background: rgba(255,255,255,0.2) !important;
            font-weight: bold;
            border-left: 4px solid white;
        }

        #page-content-wrapper {
            margin-left: 250px; 
            width: calc(100% - 250px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,.05);
        }
        
        .menu-label {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            padding: 20px 25px 5px;
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <h4 class="fw-bold mb-0">PERPUS<span style="opacity:0.6">KU</span></h4>
            <small class="text-white-50">Hello, <?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?></small>
        </div>
        <div class="list-group list-group-flush mt-3">
            <a href="index.php?page=home" class="list-group-item <?= $page == 'home' ? 'active-menu' : '' ?>">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
            
            <?php if ($role == 'admin'): ?>
                <div class="menu-label">Master Admin</div>
                <a href="index.php?page=buku" class="list-group-item <?= $page == 'buku' ? 'active-menu' : '' ?>">
                    <i class="fas fa-book me-2"></i> Kelola Buku
                </a>
                <a href="index.php?page=user" class="list-group-item <?= $page == 'user' ? 'active-menu' : '' ?>">
                    <i class="fas fa-users me-2"></i> Data Anggota
                </a>
                <a href="index.php?page=peminjaman_all" class="list-group-item <?= $page == 'peminjaman_all' ? 'active-menu' : '' ?>">
                    <i class="fas fa-clipboard-list me-2"></i> Sirkulasi
                </a>
            <?php elseif ($role == 'siswa'): ?>
                <div class="menu-label">Menu Siswa</div>
                <a href="index.php?page=buku" class="list-group-item <?= $page == 'buku' ? 'active-menu' : '' ?>">
                    <i class="fas fa-book-open me-2"></i> Daftar Buku
                </a>
                <a href="index.php?page=riwayat" class="list-group-item <?= ($page == 'riwayat' || $page == 'pengembalian') ? 'active-menu' : '' ?>">
                    <i class="fas fa-history me-2"></i> Pinjaman Saya
                </a>
            <?php endif; ?>
            
            <a href="index.php?page=logout" class="list-group-item text-white mt-5" style="background: rgba(231, 74, 59, 0.2) !important;" onclick="return confirm('Yakin mau keluar?')">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>

    <div id="page-content-wrapper">
        <nav class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-light btn-sm me-3 d-lg-none" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark text-capitalize"><?= str_replace('_', ' ', htmlspecialchars($page)) ?></h5>
            </div>
            <span class="badge bg-success rounded-pill px-3 shadow-sm"><?= strtoupper($role) ?></span>
        </nav>
        <div class="container-fluid p-4">