<?php
/**
 * KONSEP SALING BERHUBUNGAN (MODULAR)
 * Manggil koneksi dumasar kana struktur folder
 */
require_once '../config/database.php';

// --- 1. LOGIKA TAMBAH BUKU ---
if (isset($_POST['simpan_buku'])) {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun    = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $stok     = mysqli_real_escape_string($conn, $_POST['stok']);
    
    $nama_file  = $_FILES['cover']['name'];
    $tmp_name   = $_FILES['cover']['tmp_name'];
    
    if ($nama_file != "") {
        move_uploaded_file($tmp_name, '../assets/img/' . $nama_file);
        $cover = $nama_file;
    } else {
        $cover = 'default.jpg';
    }

    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok, cover) 
              VALUES ('$judul', '$penulis', '$penerbit', '$tahun', '$stok', '$cover')";

    if (mysqli_query($conn, $query)) {
        // FIX: Diarahkeun ka 'page=buku' luyu jeung sidebar
        echo "<script>alert('Buku berhasil ditambah!'); window.location='../index.php?page=buku';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// --- 2. LOGIKA EDIT/UPDATE BUKU ---
elseif (isset($_POST['update_buku'])) {
    $id       = mysqli_real_escape_string($conn, $_POST['id_buku']);
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun    = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $stok     = mysqli_real_escape_string($conn, $_POST['stok']);
    
    $nama_file  = $_FILES['cover']['name'];
    $tmp_name   = $_FILES['cover']['tmp_name'];

    if ($nama_file != "") {
        // Hapus cover lama
        $res_lama = mysqli_query($conn, "SELECT cover FROM buku WHERE id_buku='$id'");
        $lama = mysqli_fetch_assoc($res_lama);
        if ($lama['cover'] != 'default.jpg' && file_exists('../assets/img/' . $lama['cover'])) {
            unlink('../assets/img/' . $lama['cover']);
        }

        move_uploaded_file($tmp_name, '../assets/img/' . $nama_file);
        $query = "UPDATE buku SET 
                  judul='$judul', penulis='$penulis', penerbit='$penerbit', 
                  tahun_terbit='$tahun', stok='$stok', cover='$nama_file' 
                  WHERE id_buku='$id'";
    } else {
        $query = "UPDATE buku SET 
                  judul='$judul', penulis='$penulis', penerbit='$penerbit', 
                  tahun_terbit='$tahun', stok='$stok' 
                  WHERE id_buku='$id'";
    }

    if (mysqli_query($conn, $query)) {
        // FIX: Redirect ka 'page=buku' sangkan teu Error "Halaman Tidak Ditemukan"
        echo "<script>alert('Data buku berhasil diupdate!'); window.location='../index.php?page=buku';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// --- 3. LOGIKA HAPUS BUKU ---
elseif (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    
    $res_data = mysqli_query($conn, "SELECT cover FROM buku WHERE id_buku='$id'");
    $data = mysqli_fetch_assoc($res_data);
    if ($data['cover'] != 'default.jpg' && file_exists('../assets/img/' . $data['cover'])) {
        unlink('../assets/img/' . $data['cover']);
    }

    $query = "DELETE FROM buku WHERE id_buku='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Buku telah dihapus!'); window.location='../index.php?page=buku';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>