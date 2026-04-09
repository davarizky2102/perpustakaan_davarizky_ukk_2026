<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// 1. KONEKSI & MODEL
require_once '../config/database.php'; 
require_once '../models/peminjaman.php'; 

// --- A. PROSES SISWA PINJAM BUKU ---
if (isset($_POST['proses_pinjam'])) {
    $id_user = $_SESSION['user_id'];
    $id_buku = mysqli_real_escape_string($conn, $_POST['id_buku']);

    // Cek stok buku bisi geus beak
    $cek_stok = mysqli_query($conn, "SELECT stok FROM buku WHERE id_buku = '$id_buku'");
    $s = mysqli_fetch_assoc($cek_stok);
    if ($s['stok'] < 1) {
        echo "<script>alert('Aduh mang, stok bukuna nuju seep!'); window.location='../index.php?page=buku';</script>";
        exit();
    }

    // Cek bisi pinjam buku nu sarua dua kali sarta masih diproses
    if (mysqli_num_rows(cek_request_double($conn, $id_user, $id_buku)) > 0) {
        echo "<script>alert('Sabar men, request lu masih diproses admin!'); window.location='../index.php?page=buku';</script>";
        exit();
    }

    // Jieun request (tanggal_pinjam masih kosong/0000 kusabab nunggu ACC)
    if (buat_request_pinjam($conn, $id_user, $id_buku)) {
        echo "<script>alert('Request terkirim! Cek status di menu Riwayat.'); window.location='../index.php?page=riwayat';</script>";
    }

// --- B. PROSES ADMIN (SETUJU / TOLAK / TERIMA / BAYAR DENDA) ---
} elseif (isset($_GET['id']) && isset($_GET['action'])) {
    $id_peminjaman = mysqli_real_escape_string($conn, $_GET['id']);
    $action = $_GET['action'];

    if ($action == 'setuju') {
        $tgl_skrg = date('Y-m-d');
        // LOGIKA: Tanggal Pinjam ayeuna, Wates Balik +7 poe
        $tgl_kembali_seharusnya = date('Y-m-d', strtotime('+7 days', strtotime($tgl_skrg)));
        
        // Ambil id_buku keur motong stok
        $data_p = mysqli_query($conn, "SELECT id_buku FROM peminjaman WHERE id_peminjaman = '$id_peminjaman'");
        $row_p = mysqli_fetch_assoc($data_p);
        $id_b = $row_p['id_buku'];
        
        // 1. Kurangan stok buku
        mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id_buku = '$id_b'");
        
        // 2. Update status sarta tanggal pinjam
        $sql = "UPDATE peminjaman SET 
                status = 'dipinjam', 
                tanggal_pinjam = '$tgl_skrg', 
                tanggal_kembali_seharusnya = '$tgl_kembali_seharusnya' 
                WHERE id_peminjaman = '$id_peminjaman'";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Pinjaman disetujui!'); window.location='../index.php?page=sirkulasi';</script>";
        }

    } elseif ($action == 'tolak') {
        mysqli_query($conn, "UPDATE peminjaman SET status = 'ditolak' WHERE id_peminjaman = '$id_peminjaman'");
        echo "<script>alert('Pinjaman ditolak!'); window.location='../index.php?page=sirkulasi';</script>";

    } elseif ($action == 'konfirmasi_balik') {
        $data_p = mysqli_query($conn, "SELECT id_buku FROM peminjaman WHERE id_peminjaman = '$id_peminjaman'");
        $row_p = mysqli_fetch_assoc($data_p);
        $id_b = $row_p['id_buku'];
        
        // Tambahkeun deui stok buku
        mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id_buku = '$id_b'");
        
        // Update status jadi SELESAI
        $sql = "UPDATE peminjaman SET status='selesai' WHERE id_peminjaman='$id_peminjaman'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Buku ditarima!'); window.location='../index.php?page=sirkulasi';</script>";
        }

    } 
    // --- FITUR ANYAR: KONFIRMASI BAYAR DENDA ---
    elseif ($action == 'bayar_denda') {
        // Query pikeun mupus denda (dianggap geus bayar tunai ka petugas)
        $sql = "UPDATE peminjaman SET denda = 0 WHERE id_peminjaman = '$id_peminjaman'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Denda berhasil dilunasi!'); window.location='../index.php?page=sirkulasi';</script>";
        }
    }

// --- C. PROSES SISWA BALIKIN BUKU ---
} elseif (isset($_GET['kembali_id'])) {
    $id_peminjaman = mysqli_real_escape_string($conn, $_GET['kembali_id']);
    
    // Cokot tanggal wates pikeun itung denda
    $res = mysqli_query($conn, "SELECT tanggal_kembali_seharusnya FROM peminjaman WHERE id_peminjaman = '$id_peminjaman'");
    $data = mysqli_fetch_assoc($res);

    if ($data) {
        $tgl_sekarang = date('Y-m-d');
        $tgl_wates = $data['tanggal_kembali_seharusnya'];
        
        $denda = 0;
        // Mun mulangkeun ngaliwatan wates waktu
        if ($tgl_sekarang > $tgl_wates && $tgl_wates != '0000-00-00') {
            $t1 = new DateTime($tgl_wates);
            $t2 = new DateTime($tgl_sekarang);
            $selisih = $t2->diff($t1)->days;
            $denda = $selisih * 2000; 
        }

        $sql_update = "UPDATE peminjaman SET 
                       status = 'kembali', 
                       tgl_pengembalian = '$tgl_sekarang', 
                       denda = '$denda' 
                       WHERE id_peminjaman = '$id_peminjaman'";

        if (mysqli_query($conn, $sql_update)) {
            echo "<script>alert('Berhasil! Mangga pasrahkeun bukuna ka petugas.'); window.location='../index.php?page=riwayat';</script>";
        }
    }
}
?>