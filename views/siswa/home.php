<?php
// 1. SISTEM KUNCI: Cek apakah diakses lewat index.php utama
if (!defined('AKSES_HALAMAN')) {
    header("Location: /perpustakaan/index.php?page=login");
    exit;
}

// 2. Pastiin role bersih dari spasi dan huruf kecil semua biar sinkron
$role = isset($_SESSION['role']) ? strtolower(trim($_SESSION['role'])) : '';
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User';

// 3. Ambil data statistik cuma kalo dia admin
if ($role == 'admin') {
    // Pake query count biar lebih ringan dibanding fetch *
    $jml_buku = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM buku"))[0];
    $jml_user = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM user WHERE role='siswa'"))[0];
    $jml_transaksi = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM peminjaman"))[0];
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 fw-bold">Dashboard</h1>

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; background: linear-gradient(to right, #4e73df, #224abe); color: white;">
        <div class="card-body p-4">
            <h5 class="font-weight-bold opacity-75">SELAMAT DATANG KEMBALI!</h5>
            <div class="h3 font-weight-bold mb-2">Halo, <?= htmlspecialchars($nama); ?>! 👋</div>
            <p class="mb-0 opacity-75">Anda masuk sebagai sistem <span class="badge bg-white text-primary fw-bold"><?= strtoupper($role); ?></span>.</p>
        </div>
    </div>

    <div class="row">
        <?php if ($role == 'admin') : ?>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-top: 5px solid #e74a3b;">
                    <div class="card-body">
                        <h6 class="text-danger font-weight-bold text-uppercase small mb-3">Kelola Buku</h6>
                        <h3 class="font-weight-bold"><?= $jml_buku; ?> <small class="text-muted" style="font-size: 14px;">Koleksi</small></h3>
                        <a href="index.php?page=buku" class="btn btn-outline-danger btn-sm w-100 mt-2 rounded-pill">Masuk Kelola Buku</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-top: 5px solid #1cc88a;">
                    <div class="card-body">
                        <h6 class="text-success font-weight-bold text-uppercase small mb-3">Data Siswa</h6>
                        <h3 class="font-weight-bold"><?= $jml_user; ?> <small class="text-muted" style="font-size: 14px;">Anggota</small></h3>
                        <a href="index.php?page=user" class="btn btn-outline-success btn-sm w-100 mt-2 rounded-pill">Lihat Semua Anggota</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-top: 5px solid #f6c23e;">
                    <div class="card-body">
                        <h6 class="text-warning font-weight-bold text-uppercase small mb-3">Transaksi</h6>
                        <h3 class="font-weight-bold"><?= $jml_transaksi; ?> <small class="text-muted" style="font-size: 14px;">Data</small></h3>
                        <a href="index.php?page=peminjaman_all" class="btn btn-outline-warning btn-sm w-100 mt-2 rounded-pill text-dark">Cek Laporan</a>
                    </div>
                </div>
            </div>

        <?php else : ?>
            <div class="col-md-6 mb-4">
                <div class="card bg-success text-white shadow border-0" style="border-radius: 15px; background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold">Cari & Pinjam Buku</h5>
                                <p class="small mb-3">Temukan koleksi buku terbaru perpustakaan.</p>
                                <a href="index.php?page=buku" class="btn btn-light btn-sm fw-bold px-4 rounded-pill">Cari Sekarang</a>
                            </div>
                            <i class="fas fa-book-open fa-3x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card bg-info text-white shadow border-0" style="border-radius: 15px; background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold">Riwayat Pinjaman</h5>
                                <p class="small mb-3">Cek buku apa aja yang lagi lu pinjam.</p>
                                <a href="index.php?page=riwayat" class="btn btn-light btn-sm fw-bold px-4 rounded-pill">Cek Riwayat</a>
                            </div>
                            <i class="fas fa-history fa-3x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>