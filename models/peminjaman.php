<?php
// Logika simpan pinjaman
if (isset($_POST['pinjam'])) {
    $user_id = $_SESSION['user_id'];
    $buku_id = $_POST['buku_id'];
    $tgl = date('Y-m-d');
    
    mysqli_query($conn, "INSERT INTO peminjaman (user_id, buku_id, tgl_pinjam, status) VALUES ('$user_id', '$buku_id', '$tgl', 'dipinjam')");
    mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id = '$buku_id'");
    echo "<script>alert('Berhasil Pinjam!'); window.location='index.php';</script>";
}
?>
<h3>Form Peminjaman Buku</h3>
<form method="POST">
    <label>Pilih Buku:</label>
    <select name="buku_id" required>
        <?php
        $buku = mysqli_query($conn, "SELECT * FROM buku WHERE stok > 0");
        while($b = mysqli_fetch_assoc($buku)) {
            echo "<option value='".$b['id']."'>".$b['judul']." (Stok: ".$b['stok'].")</option>";
        }
        ?>
    </select>
    <button type="submit" name="pinjam">Klik Pinjam</button>
</form>