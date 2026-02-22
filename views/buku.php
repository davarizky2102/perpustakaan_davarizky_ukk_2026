<?php
$db = new Model();
$semua_buku = $db->getAllBuku();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">📚 Koleksi Buku</h1>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="#" class="btn btn-primary btn-sm shadow-sm">+ Tambah Buku</a>
        <?php endif; ?>
    </div>

    <div class="row">
        <?php while ($buku = mysqli_fetch_assoc($semua_buku)): ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 border-0" style="border-radius: 15px; overflow: hidden;">
                    <img src="assets/img/<?= $buku['cover'] ?? 'no-cover.jpg' ?>" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Cover Buku">
                    
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <?= $buku['kategori'] ?? 'Umum' ?>
                        </div>
                        <h5 class="card-title fw-bold text-dark"><?= $buku['judul'] ?></h5>
                        <p class="card-text text-muted small">Penulis: <?= $buku['penulis'] ?></p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge <?= $buku['stok'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                <?= $buku['stok'] > 0 ? 'Tersedia' : 'Kosong' ?>
                            </span>
                            
                            <?php if ($_SESSION['role'] == 'siswa' && $buku['stok'] > 0): ?>
                                <a href="index.php?page=pinjam&id=<?= $buku['id_buku'] ?>" class="btn btn-outline-primary btn-sm">Pinjam</a>
                            <?php elseif ($_SESSION['role'] == 'admin'): ?>
                                <div>
                                    <button class="btn btn-warning btn-sm text-white">Edit</button>
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>