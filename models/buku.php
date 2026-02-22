<?php
// models/buku.php

/**
 * 1. Ambil Semua Buku (Untuk Tabel Kelola Buku Admin)
 */
function ambil_semua_buku($conn) {
    $sql = "SELECT * FROM buku ORDER BY id_buku DESC";
    return mysqli_query($conn, $sql);
}

/**
 * 2. Ambil Koleksi Buku (Untuk Katalog Siswa)
 * Fungsi ini sama dengan ambil_semua_buku, tapi dipisah 
 * biar kalau nanti mau ditambahin filter kategori jadi gampang.
 */
function ambil_koleksi_buku($conn) {
    $sql = "SELECT * FROM buku ORDER BY id_buku DESC";
    return mysqli_query($conn, $sql);
}

/**
 * 3. Ambil 1 Buku Berdasarkan ID (Untuk Halaman Edit)
 */
function ambil_buku_by_id($conn, $id) {
    $id_safe = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM buku WHERE id_buku = '$id_safe'";
    $query = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($query);
}

/**
 * 4. Fungsi Tambahan: Update Stok Manual
 * Berguna kalau lu butuh sinkronisasi stok di luar proses pinjam otomatis.
 */
function update_stok_buku($conn, $id_buku, $jumlah) {
    $id_safe = mysqli_real_escape_string($conn, $id_buku);
    $sql = "UPDATE buku SET stok = '$jumlah' WHERE id_buku = '$id_safe'";
    return mysqli_query($conn, $sql);
}
?>