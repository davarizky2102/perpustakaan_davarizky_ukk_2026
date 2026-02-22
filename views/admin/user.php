<?php
// 1. SISTEM KUNCI: Memastikan file dibuka melalui index.php utama
if (!defined('AKSES_HALAMAN')) { 
    header("Location: index.php?page=login"); 
    exit; 
}

// 2. Proteksi Admin: Hanya Role Admin yang bisa masuk ke halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.location='index.php?page=home';</script>";
    exit();
}

// 3. Ambil data user dari database
$query = "SELECT * FROM user ORDER BY role ASC";
$result = mysqli_query($conn, $query);

// Ambil username login untuk pengaman agar tidak bisa menghapus diri sendiri
$user_login = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Anggota</h1>
        <a href="index.php?page=user_tambah" class="btn btn-primary btn-sm shadow-sm rounded-pill px-4">
            <i class="fas fa-user-plus fa-sm text-white-50 me-1"></i> Tambah Anggota
        </a>
    </div>

    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-header py-3 bg-white border-bottom-0" style="border-radius: 15px 15px 0 0;">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna Sistem</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" width="100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role / Level</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        if(mysqli_num_rows($result) > 0) :
                            while($row = mysqli_fetch_assoc($result)) : 
                                // Inisialisasi data baris
                                $username_tabel = isset($row['username']) ? $row['username'] : '-';
                                $id_u = $row['id_user'];
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><strong><?= htmlspecialchars($username_tabel); ?></strong></td>
                            <td>
                                <?php if(strtolower($row['role']) == 'admin'): ?>
                                    <span class="badge bg-danger px-3 rounded-pill">ADMIN</span>
                                <?php else: ?>
                                    <span class="badge bg-success px-3 rounded-pill">SISWA</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="index.php?page=user_edit&id=<?= $id_u; ?>" class="btn btn-sm btn-warning text-white px-3 shadow-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <?php if($username_tabel !== $user_login) : ?>
                                    <a href="core/proses_user.php?hapus_id=<?= $id_u; ?>" 
                                       class="btn btn-sm btn-danger px-3 shadow-sm" 
                                       onclick="return confirm('Yakin ingin menghapus <?= htmlspecialchars($row['nama']); ?>?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary px-3" disabled title="Ini Akun Anda">
                                            <i class="fas fa-user-check"></i> Aktif
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        else : 
                        ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data anggota di database.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>