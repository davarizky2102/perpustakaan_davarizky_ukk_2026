<?php
/**
 * HALAMAN RIWAYAT PINJAMAN SISWA
 */
// 1. KEAMANAN: Mastikeun file diakses liwat index.php
if (!defined('AKSES_HALAMAN')) { 
    header("Location: index.php?page=login"); 
    exit; 
}

// 2. AMBIL DATA dumasar Session User
$id_user = $_SESSION['user_id']; 
$query = "SELECT p.*, b.judul 
          FROM peminjaman p
          JOIN buku b ON p.id_buku = b.id_buku 
          WHERE p.id_user = '$id_user' 
          ORDER BY p.id_peminjaman DESC"; 

$result = mysqli_query($conn, $query);
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Status Peminjaman Buku</h1>
    </div>

    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-header py-3 bg-white border-bottom-0">
            <h6 class="m-0 fw-bold text-primary">Riwayat Pinjaman Anjeun</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status & Denda</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(mysqli_num_rows($result) > 0) :
                            while($row = mysqli_fetch_assoc($result)) : 
                                $status = $row['status'];
                                $tgl_pinjam = $row['tanggal_pinjam']; 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong class="text-primary"><?= htmlspecialchars($row['judul']); ?></strong></td>
                            <td>
                                <?php 
                                // Logic nembongkeun tanggal atawa status nunggu ACC
                                if($status == 'menunggu' || !$tgl_pinjam || $tgl_pinjam == '0000-00-00') : ?>
                                    <span class="badge bg-light text-warning border small">
                                        <i class="fas fa-hourglass-half me-1"></i> Menunggu ACC...
                                    </span>
                                <?php else : ?>
                                    <i class="far fa-calendar-alt me-1 text-muted"></i> 
                                    <?= date('d M Y', strtotime($tgl_pinjam)); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                // Badge Status dumasar Database
                                if($status == 'menunggu') : ?>
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">MENUNGGU ACC</span>
                                <?php elseif($status == 'dipinjam') : ?>
                                    <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm text-white">BUKU DI ANJEUN</span>
                                <?php elseif($status == 'kembali') : ?>
                                    <span class="badge bg-info px-3 py-2 rounded-pill shadow-sm text-white">DICEK PETUGAS</span>
                                <?php elseif($status == 'selesai') : ?>
                                    <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm text-white">SELESAI</span>
                                <?php elseif($status == 'ditolak') : ?>
                                    <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm text-white">DITOLAK</span>
                                <?php endif; ?>
                                
                                <?php if(isset($row['denda']) && $row['denda'] > 0) : ?>
                                    <div class="small text-danger fw-bold mt-1">
                                        <i class="fas fa-exclamation-circle"></i> Denda: Rp <?= number_format($row['denda']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($status == 'dipinjam') : ?>
                                    <a href="core/proses_pinjam.php?kembali_id=<?= $row['id_peminjaman']; ?>" 
                                       class="btn btn-sm btn-success rounded-pill px-4 shadow-sm"
                                       onclick="return confirm('Yakin hoyong mulangkeun buku ieu?')">
                                        <i class="fas fa-undo me-1"></i> Kembalikan
                                    </a>
                                <?php elseif($status == 'selesai') : ?>
                                    <span class="text-success"><i class="fas fa-check-circle fa-lg"></i></span>
                                <?php elseif($status == 'kembali') : ?>
                                    <div class="spinner-border spinner-border-sm text-info" role="status"></div>
                                    <span class="text-info ms-1 small">Verifikasi...</span>
                                <?php else : ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 text-light"></i><br>
                                Teu acan aya data riwayat pinjaman.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>