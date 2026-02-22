<?php
// 1. Start session buat ngecek login
session_start();

// 2. Proteksi 1: Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    die("Akses ditolak! Login dulu men.");
}

// 3. Panggil koneksi (Sesuai struktur folder: views/siswa/ ke config/)
require_once '../../config/database.php';

// 4. Pastiin ID ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Struk tidak ditemukan men!");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$id_session = $_SESSION['id_user'];
$role_session = $_SESSION['role'];

// 5. Query lengkap ambil data relasi
$query = "SELECT pengembalian.*, peminjaman.tgl_peminjaman, buku.judul, user.nama, user.id_user as owner_id
          FROM pengembalian 
          JOIN peminjaman ON pengembalian.id_peminjaman = peminjaman.id_peminjaman
          JOIN buku ON peminjaman.id_buku = buku.id_buku
          JOIN user ON peminjaman.id_user = user.id_user
          WHERE pengembalian.id_pengembalian = '$id'";

$result = mysqli_query($conn, $query);
$d = mysqli_fetch_assoc($result);

// 6. Proteksi 2: Kalau data kaga ada di DB
if (!$d) {
    die("Data tidak ditemukan di database!");
}

// 7. Proteksi 3: Siswa kaga boleh ngintip struk denda orang lain
if ($role_session !== 'admin' && $d['owner_id'] !== $id_session) {
    die("Lu kaga punya izin buat liat struk ini men!");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk_Kembali_<?= htmlspecialchars($d['nama']) ?></title>
    <style>
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 280px; 
            margin: 0 auto; 
            padding: 10px; 
            font-size: 12px;
            color: #000;
        }
        .center { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 8px 0; }
        .bold { font-weight: bold; }
        .flex { display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; }
        
        @media print {
            @page { margin: 0; size: 80mm auto; }
            body { margin: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <strong style="font-size: 16px;">PERPUS DIGITAL</strong><br>
        Bukti Pengembalian Buku
    </div>
    
    <div class="line"></div>
    
    <div>
        No. Reff: #KMB-<?= str_pad($d['id_pengembalian'], 5, '0', STR_PAD_LEFT) ?><br>
        Tanggal : <?= date('d/m/Y H:i') ?><br>
        Petugas : <?= ($role_session == 'admin') ? strtoupper($_SESSION['nama']) : 'Sistem Otomatis'; ?>
    </div>
    
    <div class="line"></div>
    
    <table>
        <tr><td width="30%">Nama</td><td>: <?= strtoupper(htmlspecialchars($d['nama'])) ?></td></tr>
        <tr><td>Buku</td><td>: <?= htmlspecialchars($d['judul']) ?></td></tr>
        <tr><td>Pinjam</td><td>: <?= date('d/m/Y', strtotime($d['tgl_peminjaman'])) ?></td></tr>
        <tr><td>Balik</td><td>: <?= date('d/m/Y', strtotime($d['tanggal_kembali_aktual'])) ?></td></tr>
    </table>
    
    <div class="line"></div>
    
    <div class="flex bold">
        <span>TOTAL DENDA</span>
        <span>Rp <?= number_format($d['denda'], 0, ',', '.') ?></span>
    </div>
    
    <div class="line"></div>
    
    <div class="center">
        <?php if($d['denda'] > 0): ?>
            DENDA SUDAH DIBAYAR LUNAS<br>
        <?php endif; ?>
        TERIMA KASIH MEN!<br>
        Jangan Telat Lagi Ya.<br>
        --- Perpus Digital ---
    </div>

    <div class="no-print center" style="margin-top: 20px;">
        <button onclick="window.print()">Cetak Ulang</button>
        <button onclick="window.close()">Tutup</button>
    </div>
</body>
</html>