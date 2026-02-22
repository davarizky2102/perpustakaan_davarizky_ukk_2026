<?php
// 1. SISTEM KUNCI: Cegah akses langsung ke file layout
if (!defined('AKSES_HALAMAN')) {
    header("Location: /perpustakaan/index.php?page=login");
    exit;
}

// 2. Siapkan variabel biar nggak error
$role_check = isset($_SESSION['role']) ? strtolower(trim($_SESSION['role'])) : ''; 
$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
$nama_user = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User';
?>

<style>
    #sidebar-wrapper {
        background: linear-gradient(180deg, #1cc88a 0%, #13855c 100%) !important;
        min-width: 250px;
        max-width: 250px;
        min-height: 100vh;
        border-right: none !important;
        transition: all 0.3s;
        position: fixed; /* Biar sidebar gak ikut scroll */
        z-index: 1000;
    }

    .sidebar-heading {
        padding: 1.5rem 1.25rem;
        font-size: 1.3rem;
        background-color: transparent !important;
        color: #ffffff !important;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .list-group-item {
        background-color: transparent !important;
        color: rgba(255, 255, 255, 0.8) !important;
        border: none !important;
        padding: 15px 25px !important;
        font-size: 0.95rem;
        transition: 0.3s;
        display: flex;
        align-items: center;
        text-decoration: none !important;
    }

    .list-group-item:hover {
        background-color: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        padding-left: 35px !important;
    }

    .list-group-item.active {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
        font-weight: bold;
        box-shadow: inset 4px 0 0 #ffffff;
    }

    .menu-label {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
        font-weight: 700;
        padding: 25px 25px 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-logout-sidebar {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        transition: 0.3s;
    }

    .btn-logout-sidebar:hover {
        background-color: #e74a3b;
        border-color: #e74a3b;
        color: white;
    }
</style>

<div id="sidebar-wrapper" class="shadow-lg">
    <div class="sidebar-heading">
        <i class="fas fa-book-reader mr-2"></i>PERPUS<span style="color:rgba(255,255,255,0.6)">KU</span>
    </div>

    <div class="px-4 py-3 mb-2" style="background: rgba(0,0,0,0.1);">
        <small style="color: rgba(255,255,255,0.7); display: block;">Halo men,</small>
        <span class="text-white font-weight-bold"><?= htmlspecialchars($nama_user); ?></span>
        <span class="badge badge-light ml-1" style="font-size: 9px; vertical-align: middle;">
            <?= strtoupper($role_check); ?>
        </span>
    </div>

    <div class="list-group list-group-flush mt-2">
        <a href="index.php?page=home" class="list-group-item list-group-item-action <?= ($current_page == 'home') ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>

        <?php if ($role_check == 'admin'): ?>
            <div class="menu-label">Master Data</div>
            <a href="index.php?page=buku" class="list-group-item list-group-item-action <?= ($current_page == 'buku') ? 'active' : ''; ?>">
                <i class="fas fa-book mr-3"></i> Kelola Buku
            </a>
            <a href="index.php?page=user" class="list-group-item list-group-item-action <?= ($current_page == 'user') ? 'active' : ''; ?>">
                <i class="fas fa-users mr-3"></i> Data Anggota
            </a>

            <div class="menu-label">Laporan</div>
            <a href="index.php?page=peminjaman_all" class="list-group-item list-group-item-action <?= ($current_page == 'peminjaman_all') ? 'active' : ''; ?>">
                <i class="fas fa-file-invoice mr-3"></i> Sirkulasi
            </a>

        <?php else: ?>
            <div class="menu-label">Aktivitas Saya</div>
            <a href="index.php?page=buku" class="list-group-item list-group-item-action <?= ($current_page == 'buku') ? 'active' : ''; ?>">
                <i class="fas fa-search mr-3"></i> Daftar Buku
            </a>
            <a href="index.php?page=riwayat" class="list-group-item list-group-item-action <?= ($current_page == 'riwayat') ? 'active' : ''; ?>">
                <i class="fas fa-history mr-3"></i> Pinjaman Saya
            </a>
        <?php endif; ?>

        <div class="mt-5 px-3">
            <a href="index.php?page=logout" class="btn btn-logout-sidebar btn-block btn-sm py-2" style="border-radius: 8px; text-decoration: none; display: block; text-align: center;" onclick="return confirm('Yakin mau logout?')">
                <i class="fas fa-power-off mr-2"></i> Logout
            </a>
        </div>
    </div>
</div>