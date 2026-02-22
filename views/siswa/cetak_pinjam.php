<?php
// 1. Wajib start session karena file ini dibuka mandiri (tab baru)
session_start();

// 2. Proteksi 1: Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    die("Akses ditolak! Login dulu men.");
}

// 3. Panggil koneksi (Sesuai screenshot folder lu: views/siswa/ ke config/)
require_once '../../config/database.php';

// 4. Validasi ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Pinjam kaga ada men!");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$id_session = $_SESSION['id_user'];
$role_session = $_SESSION['role'];

// 5. Query dengan Join (Tabel: peminjaman, buku, user)
$query = "SELECT peminjaman.*, buku.judul, user.nama 
          FROM peminjaman 
          JOIN buku ON peminjaman.id_buku = buku.id_buku
          JOIN user ON peminjaman.id_user = user.id_user
          WHERE peminjaman.id_peminjaman = '$id'";

// Proteksi 2: Siswa kaga boleh liat struk orang lain
if ($role_session !== 'admin') {
    $query .= " AND peminjaman.id_user = '$id_session'";
}

$res = mysqli_query($conn, $query);
$d = mysqli_fetch_assoc($res);

// Proteksi 3: Cek apakah datanya beneran ada
if (!$d) {
    die("Data kaga ketemu atau lu kaga punya izin akses men!");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk_<?= htmlspecialchars($d['id_peminjaman']) ?></title>
    <style>
        /* Style ala struk kasir */
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 250px; 
            padding: 5px; 
            font-size: 11px; 
            color: #000;
        }
        .center { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; }
        .no-print { margin-top: 20px; }
        
        @media print {
            @page { margin: 0; size: 58mm auto; } /* Optimal buat printer thermal */
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <strong>PERPUS DIGITAL</strong><br>
        BUKTI PINJAM BUKU<br>
        <small><?= date('d/m/Y H:i') ?></small>
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <td width="35%">No. Reff</td>
            <td>: #PJ-<?= str_pad($d['id_peminjaman'], 4, '0', STR_PAD_LEFT) ?></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: <?= strtoupper(htmlspecialchars($d['nama'])) ?></td>
        </tr>
        <tr>
            <td>Pinjam</td>
            <td>: <?= date('d/m/Y', strtotime($d['tgl_peminjaman'])) ?></td>
        </tr>
    </table>

    <div class="line"></div>
    
    <strong>BUKU:</strong><br>
    <?= htmlspecialchars($d['judul']) ?>

    <div class="line"></div>

    <div class="center">
        ** PERINGATAN **<br>
        Kembalikan tepat waktu!<br>
        Jangan sampai kena denda.<br>
        <br>
        Terima Kasih Men!
    </div>

    <div class="no-print center">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>
</body>
</html>