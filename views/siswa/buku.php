<?php
// 1. SISTEM KUNCI: Cek apakah diakses lewat index.php utama
if (!defined('AKSES_HALAMAN')) { 
    header("Location: index.php?page=login"); 
    exit; 
}

// 2. Panggil model buku
if (file_exists('models/buku.php')) {
    require_once 'models/buku.php';
} else {
    echo "<div class='alert alert-danger'>Error: File model buku tidak ditemukan!</div>";
    exit;
}

// 3. Ambil data koleksi lewat fungsi model
$query = ambil_koleksi_buku($conn);
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Koleksi Buku Perpustakaan</h1>
    </div>

    <div class="row">
        <?php if (mysqli_num_rows($query) > 0) : ?>
            <?php while($row = mysqli_fetch_assoc($query)) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                        <?php 
                            $cover = !empty($row['cover']) ? 'assets/img/buku/' . $row['cover'] : 'assets/img/buku/default.jpg';
                        ?>
                        <img src="<?= $cover; ?>" class="card-img-top" alt="Cover Buku" style="height: 250px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark"><?= htmlspecialchars($row['judul']); ?></h5>
                            <p class="card-text text-muted small mb-1">Penulis: <?= htmlspecialchars($row['penulis']); ?></p>
                            <p class="card-text text-muted small mb-3">Stok: 
                                <span class="badge <?= ($row['stok'] > 0) ? 'bg-success' : 'bg-danger'; ?> rounded-pill">
                                    <?= $row['stok']; ?> Tersedia
                                </span>
                            </p>

                            <div class="mt-auto">
                                <?php if($row['stok'] > 0) : ?>
                                    <form action="core/proses_pinjam.php" method="POST">
                                        <input type="hidden" name="id_user" value="<?= $_SESSION['user_id']; ?>">
                                        <input type="hidden" name="id_buku" value="<?= $row['id_buku']; ?>">
                                        
                                        <button type="submit" name="proses_pinjam" class="btn btn-primary w-100 rounded-pill shadow-sm" onclick="return confirm('Ajukan peminjaman buku ini?')">
                                            <i class="fas fa-bookmark me-1"></i> Pinjam Buku
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <button class="btn btn-secondary w-100 rounded-pill" disabled>
                                        <i class="fas fa-times-circle me-1"></i> Stok Habis
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-book-open fa-4x text-light mb-3"></i>
                <p class="text-muted">Belum ada koleksi buku saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
</style>