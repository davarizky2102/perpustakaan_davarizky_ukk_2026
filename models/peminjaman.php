<?php
// models/peminjaman.php

/**
 * 1. FUNGSI STATISTIK (Dashboard)
 */
function hitung_statistik_dashboard($conn) {
    $q_buku = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
    $buku = mysqli_fetch_assoc($q_buku);
    $q_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM user WHERE role = 'siswa'");
    $anggota = mysqli_fetch_assoc($q_user);
    
    // Sirkulasi nyaéta anu tacan 'selesai'
    $q_sirku = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status != 'selesai'");
    $sirkulasi = mysqli_fetch_assoc($q_sirku);
    
    $q_trans = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman");
    $transaksi = mysqli_fetch_assoc($q_trans);

    return [
        'buku' => $buku['total'] ?? 0,
        'anggota' => $anggota['total'] ?? 0,
        'sirkulasi' => $sirkulasi['total'] ?? 0,
        'transaksi' => $transaksi['total'] ?? 0
    ];
}

/**
 * 2. FUNGSI ANTREAN KONFIRMASI (Sirkulasi Admin)
 */
function ambil_antrean_konfirmasi($conn) {
    $sql = "SELECT peminjaman.*, user.nama, buku.judul 
            FROM peminjaman 
            JOIN user ON peminjaman.id_user = user.id_user 
            JOIN buku ON peminjaman.id_buku = buku.id_buku 
            ORDER BY peminjaman.id_peminjaman DESC";
    return mysqli_query($conn, $sql);
}

/**
 * 3. DETAIL PINJAM
 * Fix Ngaran Kolom: tgl_peminjaman -> tanggal_pinjam
 */
function ambil_detail_pinjam($conn, $id_peminjaman) {
    $id_safe = mysqli_real_escape_string($conn, $id_peminjaman);
    $sql = "SELECT id_buku, tanggal_pinjam, status FROM peminjaman WHERE id_peminjaman = '$id_safe'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

/**
 * 4. REQUEST PINJAM (Siswa klik tombol Pinjam)
 * Fix Ngaran Kolom: tgl_peminjaman -> tanggal_pinjam
 */
function buat_request_pinjam($conn, $id_user, $id_buku) {
    $u_safe = mysqli_real_escape_string($conn, $id_user);
    $b_safe = mysqli_real_escape_string($conn, $id_buku);
    
    // Nalika request, tanggal_pinjam diantep 0000-00-00 heula nunggu di-ACC
    $query = "INSERT INTO peminjaman (id_user, id_buku, tanggal_pinjam, status) 
              VALUES ('$u_safe', '$b_safe', '0000-00-00', 'menunggu')";
    
    return mysqli_query($conn, $query);
}

/**
 * 5. CEK REQUEST DOUBLE
 */
function cek_request_double($conn, $id_user, $id_buku) {
    $u_safe = mysqli_real_escape_string($conn, $id_user);
    $b_safe = mysqli_real_escape_string($conn, $id_buku);
    // Cék buku anu sarua anu can 'selesai' atawa 'ditolak'
    return mysqli_query($conn, "SELECT * FROM peminjaman 
                                WHERE id_user = '$u_safe' 
                                AND id_buku = '$b_safe' 
                                AND status NOT IN ('selesai', 'ditolak')");
}

/**
 * 6. FUNGSI LAPORAN SIRKULASI (Admin)
 * Ngahijikeun data peminjaman pikeun tampilan tabel
 */
function ambil_laporan_sirkulasi($conn) {
    $sql = "SELECT peminjaman.*, user.nama, buku.judul 
            FROM peminjaman 
            JOIN user ON peminjaman.id_user = user.id_user 
            JOIN buku ON peminjaman.id_buku = buku.id_buku 
            ORDER BY peminjaman.id_peminjaman DESC";
    return mysqli_query($conn, $sql);
}
?>