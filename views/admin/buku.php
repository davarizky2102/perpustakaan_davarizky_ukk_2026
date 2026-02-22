<?php
// 1. SISTEM KUNCI: Cek apakah diakses lewat index.php utama
if (!defined('AKSES_HALAMAN')) { 
    // Pakai jalur absolut biar gak nyasar ke 404
    header("Location: /perpustakaan/index.php?page=login"); 
    exit; 
}

// 2. Panggil modelnya: Cek dulu biar gak error re-declare
if (!function_exists('ambil_semua_buku')) {
    require_once 'models/buku.php'; 
}

// 3. Ambil data lewat fungsi (MVC Style)
$query = ambil_semua_buku($conn);
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 font-weight-bold">Kelola Koleksi Buku</h1>
        <a href="index.php?page=tambah_buku" class="btn btn-success shadow-sm rounded-pill px-4">
            <i class="fas fa-plus fa-sm"></i> Tambah Buku Baru
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Cover</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        while($row = mysqli_fetch_assoc($query)) : 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <img src="assets/img/<?= $row['cover']; ?>" width="50" height="70" class="rounded shadow-sm border" style="object-fit: cover;">
                            </td>
                            <td><strong class="text-dark"><?= htmlspecialchars($row['judul']); ?></strong></td>
                            <td><?= htmlspecialchars($row['penulis']); ?></td>
                            <td>
                                <span class="badge bg-info px-3 py-2 rounded-pill"><?= $row['stok']; ?> Ekspl</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="index.php?page=edit_buku&id=<?= $row['id_buku']; ?>" class="btn btn-sm btn-warning text-white px-3">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="core/proses_buku.php?hapus=<?= $row['id_buku']; ?>" 
                                       class="btn btn-sm btn-danger px-3" 
                                       onclick="return confirm('Yakin mau hapus buku <?= htmlspecialchars($row['judul']); ?>?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>