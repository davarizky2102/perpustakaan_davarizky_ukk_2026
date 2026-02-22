<?php
// 1. PROTEKSI: Cek apakah diakses lewat index.php. Kalau nembak langsung, tendang ke login!
if (!isset($page)) {
    header("Location: ../../index.php?page=login");
    exit();
}

// 2. Cegah error path: Karena index.php sudah panggil database & model, 
// kita cuma panggil model kalau fungsinya belum ada.
if (!function_exists('hitung_statistik_dashboard')) {
    require_once 'models/peminjaman.php';
}

// 3. Ambil data statistik
$stats = hitung_statistik_dashboard($conn);
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard Administrator</h1>
    </div>

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; background: linear-gradient(45deg, #1cc88a, #13855c); color: white;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="font-weight-bold">SELAMAT DATANG KEMBALI!</h5>
                    <div class="h4 font-weight-bold">Halo, <?= $_SESSION['nama']; ?>! 👋</div>
                    <p class="mb-0 opacity-75">Kelola data perpustakaan dengan mudah dan cepat melalui panel ini.</p>
                </div>
                <div class="col-md-4 text-right d-none d-md-block text-end">
                    <i class="fas fa-user-shield fa-5x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow h-100 border-0" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Buku</div>
                            <div class="h3 mb-0 font-weight-bold"><?= $stats['buku']; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-book fa-3x opacity-50"></i></div>
                    </div>
                </div>
                <a href="index.php?page=buku" class="card-footer text-white small z-1 d-flex align-items-center justify-content-between border-0" style="background: rgba(0,0,0,0.1); border-radius: 0 0 12px 12px; text-decoration: none;">
                    <span>Lihat Detail</span> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow h-100 border-0" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Anggota</div>
                            <div class="h3 mb-0 font-weight-bold"><?= $stats['anggota']; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-3x opacity-50"></i></div>
                    </div>
                </div>
                <a href="index.php?page=user" class="card-footer text-white small z-1 d-flex align-items-center justify-content-between border-0" style="background: rgba(0,0,0,0.1); border-radius: 0 0 12px 12px; text-decoration: none;">
                    <span>Lihat Detail</span> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow h-100 border-0" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Sirkulasi Berjalan</div>
                            <div class="h3 mb-0 font-weight-bold"><?= $stats['sirkulasi']; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-sync fa-3x opacity-50"></i></div>
                    </div>
                </div>
                <a href="index.php?page=peminjaman_all" class="card-footer text-white small z-1 d-flex align-items-center justify-content-between border-0" style="background: rgba(0,0,0,0.1); border-radius: 0 0 12px 12px; text-decoration: none;">
                    <span>Lihat Detail</span> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-danger text-white shadow h-100 border-0" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Transaksi</div>
                            <div class="h3 mb-0 font-weight-bold"><?= $stats['transaksi']; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-file-invoice fa-3x opacity-50"></i></div>
                    </div>
                </div>
                <a href="index.php?page=peminjaman_all" class="card-footer text-white small z-1 d-flex align-items-center justify-content-between border-0" style="background: rgba(0,0,0,0.1); border-radius: 0 0 12px 12px; text-decoration: none;">
                    <span>Lihat Detail</span> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>