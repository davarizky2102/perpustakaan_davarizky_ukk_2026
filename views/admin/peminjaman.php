<?php
// 1. SYSTEM KUAT: Cek naha diakses liwat index utama
if (!defined("AKSES_HALAMAN")) {
    header("Location: ../index.php?page=login");
    exit;
}

// 2. QUERY MANUAL (Ieu kunci ambeh tabel kaga kosong deui)
// Urang ganti fungsi ambil_antrean_konfirmasi ku query nu narik kabeh status
$query = mysqli_query($conn, "SELECT peminjaman.*, buku.judul, user.nama 
         FROM peminjaman 
         JOIN buku ON peminjaman.id_buku = buku.id_buku 
         JOIN user ON peminjaman.id_user = user.id_user 
         ORDER BY id_peminjaman DESC");
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Konfirmasi & Laporan Sirkulasi</h1>
        <a href="index.php?page=cetak_laporan" class="btn btn-sm btn-success shadow-sm rounded-pill px-3">
            <i class="fas fa-print fa-sm text-white-50 mr-1"></i> Cetak Laporan
        </a>
    </div>

    <div class="card shadow border-0 mb-4" style="border-radius: 15px;">
        <div class="card-header py-3 bg-white border-bottom-0">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Peminjaman</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Status</th>
                            <th>Aksi Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($query) > 0) :
                            while ($row = mysqli_fetch_assoc($query)) : 
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="font-weight-bold text-primary"><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($row['tgl_peminjaman'])); ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 'menunggu') : ?>
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">MENUNGGU ACC</span>
                                <?php elseif ($row['status'] == 'dipinjam') : ?>
                                    <span class="badge bg-primary text-white px-3 rounded-pill">DIPINJAM</span>
                                <?php elseif ($row['status'] == 'kembali') : ?>
                                    <span class="badge bg-info text-white px-3 rounded-pill">PROSES BALIK</span>
                                <?php else : ?>
                                    <span class="badge bg-success text-white px-3 rounded-pill">SELESAI</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($row['status'] == 'menunggu') : ?>
                                    <div class="btn-group shadow-sm">
                                        <a href="core/proses_pinjam.php?id=<?= $row['id_peminjaman']; ?>&action=setuju" class="btn btn-sm btn-success px-3" onclick="return confirm('Setujui peminjaman ini?')">Setuju</a>
                                        <a href="core/proses_pinjam.php?id=<?= $row['id_peminjaman']; ?>&action=tolak" class="btn btn-sm btn-danger px-3" onclick="return confirm('Tolak request ini?')">Tolak</a>
                                    </div>
                                <?php elseif ($row['status'] == 'kembali') : ?>
                                    <a href="core/proses_pinjam.php?id=<?= $row['id_peminjaman']; ?>&action=konfirmasi_balik" class="btn btn-sm btn-info text-white px-3 rounded-pill shadow-sm" onclick="return confirm('Konfirmasi bahwa buku sudah diterima fisik?')">
                                        <i class="fas fa-check-circle mr-1"></i> Terima Buku
                                    </a>
                                <?php else : ?>
                                    <span class="text-muted small"><i class="fas fa-check-double text-success"></i> Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        else : 
                        ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                Belum ada data transaksi sirkulasi.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>