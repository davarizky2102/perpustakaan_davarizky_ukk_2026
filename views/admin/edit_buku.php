<?php
// 1. SISTEM KUNCI: Cek apakah diakses lewat index.php utama
if (!defined('AKSES_HALAMAN')) { 
    // Pakai jalur absolut biar gak nyasar ke 404 pas ditembak langsung
    header("Location: /perpustakaan/index.php?page=login"); 
    exit; 
}

// 2. Panggil model: Cek dulu biar gak error re-declare
if (!function_exists('ambil_buku_by_id')) {
    require_once 'models/buku.php'; 
}

// 3. Ambil ID dari URL & Proteksi
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    echo "<script>alert('ID Buku tidak valid!'); window.location='index.php?page=kelola_buku';</script>";
    exit();
}

// 4. Ambil data lewat fungsi model
$data = ambil_buku_by_id($conn, $id);

// Proteksi kalau data tidak ada di database
if (!$data) {
    echo "<script>alert('Data buku tidak ditemukan!'); window.location='index.php?page=kelola_buku';</script>";
    exit();
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Edit Data Buku</h1>
    
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form action="core/proses_buku.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_buku" value="<?= $data['id_buku']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Judul Buku</label>
                        <input type="text" name="judul" class="form-control rounded-pill" value="<?= htmlspecialchars($data['judul']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Penulis</label>
                        <input type="text" name="penulis" class="form-control rounded-pill" value="<?= htmlspecialchars($data['penulis']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control rounded-pill" value="<?= htmlspecialchars($data['penerbit']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control rounded-pill" value="<?= $data['tahun_terbit']; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Stok Buku</label>
                        <input type="number" name="stok" class="form-control rounded-pill" value="<?= $data['stok']; ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold d-block">Cover Buku</label>
                    <div class="d-flex align-items-start gap-3">
                        <?php if(!empty($data['cover'])) : ?>
                            <div class="text-center">
                                <img src="assets/img/<?= $data['cover']; ?>" width="120" class="mb-2 rounded shadow-sm border">
                                <p class="small text-muted">Cover Saat Ini</p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex-grow-1">
                            <input type="file" name="cover" class="form-control rounded-3">
                            <div class="form-text text-danger italic mt-2">
                                <i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengganti cover.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                
                <div class="d-flex gap-2">
                    <button type="submit" name="update_buku" class="btn btn-primary px-5 rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                    <a href="index.php?page=kelola_buku" class="btn btn-outline-secondary px-5 rounded-pill">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>