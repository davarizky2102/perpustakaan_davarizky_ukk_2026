<?php
// 1. KEAMANAN: Mastikeun file diakses liwat index.php
if (!defined('AKSES_HALAMAN')) { 
    header("Location: index.php?page=login"); 
    exit; 
}

// 2. LOAD DATA: Ambil data sirkulasi ti model
if (!function_exists('ambil_laporan_sirkulasi')) {
    require_once 'models/peminjaman.php'; 
}

// Pastikeun fungsi ieu di models/peminjaman.php geus bener JOIN-na
$result = ambil_laporan_sirkulasi($conn);
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">Laporan Sirkulasi Buku</h1>
            <p class="text-muted small">Monitoring data peminjaman sarta konfirmasi transaksi admin.</p>
        </div>
        <a href="index.php?page=cetak_laporan" target="_blank" class="btn btn-sm btn-success shadow-sm rounded-pill px-4 py-2">
            <i class="fas fa-print fa-sm text-white-50 me-2"></i> Cetak Laporan Full
        </a>
    </div>

    <div class="card shadow border-0 mb-4" style="border-radius: 15px;">
        <div class="card-header py-3 bg-white border-bottom-0">
            <h6 class="m-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Data Riwayat Peminjaman & Sirkulasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th width="5%">No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th class="text-center">Status</th>
                            <th>Denda</th>
                            <th class="text-center">Aksi Konfirmasi Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        if ($result && mysqli_num_rows($result) > 0) :
                            while($row = mysqli_fetch_assoc($result)) : 
                                $status = $row['status'];
                                
                                // LOGIKA WARNA BADGE
                                $badgeClass = 'bg-secondary text-white'; 
                                if($status == 'dipinjam') $badgeClass = 'bg-primary text-white';
                                if($status == 'menunggu') $badgeClass = 'bg-warning text-dark';
                                if($status == 'kembali') $badgeClass = 'bg-info text-white';
                                if($status == 'selesai') $badgeClass = 'bg-success text-white';
                                if($status == 'ditolak') $badgeClass = 'bg-danger text-white';
                        ?>
                        <tr>
                            <td class="fw-bold"><?= $no++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light p-2 me-2 text-primary">
                                        <i class="fas fa-user fa-sm"></i>
                                    </div>
                                    <strong><?= htmlspecialchars($row['nama']); ?></strong>
                                </div>
                            </td>
                            <td>
                                <span class="text-dark fw-bold"><?= htmlspecialchars($row['judul']); ?></span>
                            </td>
                            <td>
                                <?php 
                                // FIX: Ngagunakeun 'tanggal_pinjam' sangkan teu error
                                $tgl = $row['tanggal_pinjam']; 
                                if($tgl && $tgl != '0000-00-00') : ?>
                                    <span class="small text-dark"><i class="far fa-calendar-alt me-1"></i> <?= date('d/m/Y', strtotime($tgl)); ?></span>
                                <?php else : ?>
                                    <span class="badge bg-light text-danger border small">Belum Diproses</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge <?= $badgeClass ?> p-2 px-3 rounded-pill shadow-sm" style="min-width: 100px; font-size: 0.75rem;">
                                    <?= strtoupper(str_replace('_', ' ', $status)); ?>
                                </span>
                            </td>
                            <td>
                                <?php if($status == 'selesai' || ($row['denda'] ?? 0) > 0) : ?>
                                    <?= ($row['denda'] > 0) ? '<span class="text-danger fw-bold small">Rp '.number_format($row['denda']).'</span>' : '<span class="text-success small fw-bold"><i class="fas fa-check-circle"></i> Lunas</span>' ?>
                                <?php else : ?>
                                    <span class="text-muted small"><em>Berjalan</em></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($status == 'menunggu') : ?>
                                    <div class="btn-group shadow-sm">
                                        <a href="core/proses_pinjam.php?id=<?= $row['id_peminjaman']; ?>&action=setuju" class="btn btn-sm btn-success px-3 fw-bold">SETUJU</a>
                                        <a href="core/proses_pinjam.php?id=<?= $row['id_peminjaman']; ?>&action=tolak" class="btn btn-sm btn-danger px-3 fw-bold" onclick="return confirm('Tolak pinjaman ini?')">TOLAK</a>
                                    </div>
                                <?php elseif($status == 'dipinjam') : ?>
                                    <span class="text-primary small fw-bold"><i class="fas fa-hand-holding-book"></i> Dipinjam</span>
                                <?php elseif($status == 'kembali') : ?>
                                    <a href="core/proses_pinjam.php?id=<?= $row['id_peminjaman']; ?>&action=konfirmasi_balik" class="btn btn-sm btn-info text-white px-3 rounded-pill shadow-sm fw-bold animate__animated animate__pulse animate__infinite">
                                        <i class="fas fa-check-circle me-1"></i> Konfirmasi Terima
                                    </a>
                                <?php elseif($status == 'selesai') : ?>
                                    <span class="text-success small fw-bold"><i class="fas fa-check-double"></i> SELESAI</span>
                                <?php else : ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-receipt fa-3x mb-3 text-light"></i><br>
                                <p>Belum ada data transaksi sirkulasi.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>