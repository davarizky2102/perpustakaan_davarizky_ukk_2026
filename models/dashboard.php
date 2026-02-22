<?php
// models/dashboard.php

function get_dashboard_stats($conn) {
    // Kumpulan query statistik dipusatkan di sini
    $data = [];
    $data['buku']      = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM buku"));
    $data['user']      = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE role='siswa'"));
    $data['berjalan']  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman WHERE status='dipinjam'"));
    $data['transaksi'] = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman"));
    
    return $data;
}
?>