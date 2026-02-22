<?php
include '../config/database.php'; // Sesuaikan koneksi lu

$id = $_GET['id'];
$action = $_GET['action'];

if ($action == 'setuju') {
    // Admin approve: Status jadi dipinjam, kasih waktu 7 hari buat balikin
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime('+7 days'));
    
    $query = "UPDATE peminjaman SET 
              status = 'dipinjam', 
              tgl_peminjaman = '$tgl_pinjam', 
              tanggal_kembali_seharusnya = '$tgl_kembali' 
              WHERE id_peminjaman = '$id'";
} elseif ($action == 'tolak') {
    // Kalau lu nggak kenal atau bukunya abis, hapus aja request-nya
    $query = "DELETE FROM peminjaman WHERE id_peminjaman = '$id'";
}

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Berhasil diproses men!'); window.location='../index.php?page=peminjaman_all';</script>";
}
?>