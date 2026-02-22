<?php
// models/pengembalian.php

/**
 * FUNGSI KONFIRMASI PENGEMBALIAN
 * Gunanya: Update status, Itung denda otomatis, dan Balikin stok buku
 */
function proses_konfirmasi_kembali($conn, $id_peminjaman) {
    // 1. Amankan ID dan ambil detail pinjaman
    $id_safe = mysqli_real_escape_string($conn, $id_peminjaman);
    $q_data = mysqli_query($conn, "SELECT id_buku, tgl_peminjaman FROM peminjaman WHERE id_peminjaman = '$id_safe'");
    $data = mysqli_fetch_assoc($q_data);

    if ($data) {
        $id_buku = $data['id_buku'];
        $tgl_pinjam = $data['tgl_peminjaman'];
        $tgl_sekarang = date('Y-m-d');

        // 2. Hitung Denda (Contoh: Batas 7 hari, denda 1000/hari)
        $diff = strtotime($tgl_sekarang) - strtotime($tgl_pinjam);
        $hari = floor($diff / (60 * 60 * 24));
        $denda = 0;
        if ($hari > 7) {
            $denda = ($hari - 7) * 1000;
        }

        // 3. Update status peminjaman jadi 'kembali'
        mysqli_query($conn, "UPDATE peminjaman SET status = 'kembali' WHERE id_peminjaman = '$id_safe'");

        // 4. Masukkan ke tabel pengembalian (Catat tanggal aktual & denda)
        mysqli_query($conn, "INSERT INTO pengembalian (id_peminjaman, tanggal_kembali_aktual, denda) 
                             VALUES ('$id_safe', '$tgl_sekarang', '$denda')");

        // 5. STOK BUKU DITAMBAH LAGI (Sangat Penting!)
        return mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id_buku = '$id_buku'");
    }
    return false;
}
?>