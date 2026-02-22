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
        body { background-color: white !important; font-size: 12px; }
        .table th { background-color: #f8f9fc !important; border-bottom: 2px solid #333; }
        @media print {
            .no-print { display: none; }
            @page { margin: 1cm; }
            body { padding: 0; }
        }
        .header-laporan { border-bottom: 3px double #333; margin-bottom: 20px; padding-bottom: 10px; }
    </style>
</head>
<body onload="window.print()"> <div class="container mt-4">
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
            if (mysqli_num_rows($result) > 0) :
                while($row = mysqli_fetch_assoc($result)) : 
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['judul']); ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['tgl_peminjaman'])); ?></td>
                <td class="text-center">
                    <?= strtoupper(str_replace('_', ' ', $row['status'])); ?>
                </td>
                <td class="text-end">
                    <?= ($row['denda'] > 0) ? 'Rp '.number_format($row['denda']) : '-'; ?>
                </td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="6" class="text-center">Teu aya data transaksi.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="row mt-5">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p>Bandung, <?= date('d F Y'); ?><br>Petugas Perpustakaan,</p>
            <br><br><br>
            <p><strong>( ________________ )</strong></p>
        </div>
    </div>

    <div class="no-print mt-4 text-center">
        <hr>
        <button onclick="window.print()" class="btn btn-primary px-4 rounded-pill">Print Deui</button>
        <button onclick="window.close()" class="btn btn-secondary px-4 rounded-pill">Tutup Halaman</button>
    </div>
</div>

</body>
</html>