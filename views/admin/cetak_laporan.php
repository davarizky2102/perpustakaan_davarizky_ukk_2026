<?php
// 1. KAAMANAN: Pastikeun file diakses liwat index.php
if (!defined('AKSES_HALAMAN')) { 
    header("Location: index.php?page=login"); 
    exit; 
}

// 2. LOAD DATA: Ambil fungsi laporan sirkulasi
if (!function_exists('ambil_laporan_sirkulasi')) {
    require_once 'models/peminjaman.php'; 
}

$result = ambil_laporan_sirkulasi($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Sirkulasi - Perpusku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: white !important; font-size: 12px; font-family: 'Times New Roman', Times, serif; }
        .table th { background-color: #f8f9fc !important; border: 1px solid #333 !important; }
        .table td { border: 1px solid #333 !important; }
        @media print {
            .no-print { display: none; }
            @page { margin: 1cm; size: landscape; }
            body { padding: 0; }
        }
        .header-laporan { border-bottom: 3px double #333; margin-bottom: 20px; padding-bottom: 10px; }
    </style>
</head>
<body onload="window.print()"> 
<div class="container mt-4">
    <div class="header-laporan text-center">
        <h2 class="fw-bold mb-0">LAPORAN SIRKULASI PERPUSTAKAAN</h2>
        <p class="mb-0">Sistem Informasi Digital Library - Perpusku</p>
        <small class="text-muted">Dicetak dina tanggal: <?= date('d/m/Y H:i'); ?></small>
    </div>

    <table class="table table-bordered align-middle">
        <thead>
            <tr class="text-center">
                <th width="5%">No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            if ($result && mysqli_num_rows($result) > 0) :
                while($row = mysqli_fetch_assoc($result)) : 
                    // Cek naha kolom tanggal aya? Mun euweuh pake '-' meh teu error 1970
                    $tgl_tampil = (isset($row['tgl_peminjaman']) && $row['tgl_peminjaman'] != '0000-00-00') 
                                  ? date('d/m/Y', strtotime($row['tgl_peminjaman'])) 
                                  : '-';
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama'] ?? $row['nama_lengkap'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($row['judul'] ?? $row['judul_buku'] ?? '-'); ?></td>
                <td class="text-center"><?= $tgl_tampil; ?></td>
                <td class="text-center">
                    <span class="badge text-dark border border-dark">
                        <?= strtoupper(str_replace('_', ' ', $row['status'] ?? '-')); ?>
                    </span>
                </td>
                <td class="text-end">
                    <?= (isset($row['denda']) && $row['denda'] > 0) ? 'Rp '.number_format($row['denda'], 0, ',', '.') : '-'; ?>
                </td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="6" class="text-center py-4">Teu aya data transaksi anu tiasa dicitak.</td>
            </tr>
            <?php endif; ?>
        </tbody> 
    </table>

    <div class="row mt-5">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p>Bandung, <?= date('d F Y'); ?><br>Petugas Perpustakaan,</p>
            <br><br><br>
            <p><strong>( <?= $_SESSION['nama_lengkap'] ?? '________________'; ?> )</strong></p>
        </div>
    </div>

    <div class="no-print mt-4 text-center">
        <hr>
        <button onclick="window.print()" class="btn btn-primary px-4 rounded-pill">Print Deui</button>
        <button onclick="window.history.back()" class="btn btn-secondary px-4 rounded-pill">Balik deui</button>
    </div>
</div>

</body>
</html>