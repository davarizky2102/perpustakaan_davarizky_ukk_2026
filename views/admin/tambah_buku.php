<?php
// 1. SISTEM KUNCI: Cek apakah diakses lewat index.php utama
if (!defined('AKSES_HALAMAN')) { 
    // Pakai jalur absolut biar gak nyasar ke 404
    header("Location: /perpustakaan/index.php?page=login"); 
    exit; 
}
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Tambah Koleksi Buku</h1>
        <a href="index.php?page=kelola_buku" class="btn btn-secondary btn-sm shadow-sm rounded-pill px-3">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form action="core/proses_buku.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Judul Buku</label>
                        <input type="text" name="judul" class="form-control rounded-pill" placeholder="Masukkan judul buku" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Penulis</label>
                        <input type="text" name="penulis" class="form-control rounded-pill" placeholder="Nama penulis" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control rounded-pill" placeholder="Nama penerbit" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control rounded-pill" placeholder="Contoh: 2024" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Stok Buku</label>
                        <input type="number" name="stok" class="form-control rounded-pill" min="1" value="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Upload Cover Buku</label>
                    <div class="input-group">
                        <input type="file" name="cover" class="form-control" accept="image/*" id="inputGroupFile02">
                    </div>
                    <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Format: JPG, PNG, JPEG. Maks: 2MB</small>
                </div>

                <hr class="my-4">
                
                <div class="d-flex gap-2">
                    <button type="submit" name="simpan_buku" class="btn btn-danger px-5 shadow-sm rounded-pill">
                        <i class="fas fa-save mr-1"></i> Simpan Buku
                    </button>
                    <button type="reset" class="btn btn-light px-4 rounded-pill">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>