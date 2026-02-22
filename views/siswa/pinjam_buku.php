<?php
// 1. SISTEM KUNCI: Cek apakah diakses lewat index.php utama
if (!defined('AKSES_HALAMAN')) {
    header("Location: /perpustakaan/index.php?page=login");
    exit;
}

// 2. Proteksi Role: Cek apakah yang akses benar-benar siswa
$role_check = isset($_SESSION['role']) ? strtolower(trim($_SESSION['role'])) : '';
if ($role_check !== 'siswa') {
    echo "<div class='alert alert-danger'>Akses Ditolak! Form ini cuma buat siswa men.</div>";
    exit;
}

// 3. Ambil data buku untuk dipilih siswa (Hanya yang stoknya ada)
$query_buku = mysqli_query($conn, "SELECT id_buku, judul, stok FROM buku WHERE stok > 0 ORDER BY judul ASC");
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Form Peminjaman Buku</h1>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="core/proses_pinjam.php" method="POST">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Pilih Buku yang Ingin Dipinjam</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-book text-primary"></i></span>
                                <select name="id_buku" class="form-select border-start-0" required>
                                    <option value="">-- Pilih Koleksi Tersedia --</option>
                                    <?php while($buku = mysqli_fetch_assoc($query_buku)) : ?>
                                        <option value="<?= $buku['id_buku']; ?>">
                                            <?= htmlspecialchars($buku['judul']); ?> (Stok: <?= $buku['stok']; ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Tanggal Pinjam</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 bg-white" value="<?= date('d F Y'); ?>" readonly>
                            </div>
                        </div>

                        <div class="card bg-light border-0 mb-4" style="border-radius: 10px;">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center text-primary">
                                    <i class="fas fa-info-circle fa-2x me-3"></i>
                                    <div>
                                        <small class="d-block fw-bold">Informasi Peminjaman:</small>
                                        <small>Batas waktu pengembalian adalah <strong>7 hari</strong>. Telat mengembalikan akan dikenakan denda sesuai aturan perpus.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="proses_pinjam" class="btn btn-primary py-2 rounded-pill shadow-sm fw-bold" onclick="return confirm('Sudah yakin dengan buku yang dipilih?')">
                                <i class="fas fa-paper-plane me-2"></i> Ajukan Pinjaman Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card bg-gradient-primary text-white shadow border-0 p-3" style="border-radius: 15px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                <div class="card-body">
                    <h5 class="fw-bold"><i class="fas fa-lightbulb me-2"></i>Tips Men!</h5>
                    <p class="small opacity-75">Pastikan kamu mengembalikan buku sebelum jatuh tempo ya, biar teman-teman yang lain bisa ikut baca juga.</p>
                    <hr class="bg-white opacity-25">
                    <div class="text-center">
                        <i class="fas fa-user-clock fa-4x my-3 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>