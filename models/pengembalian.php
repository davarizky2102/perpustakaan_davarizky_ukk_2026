<?php
$user_id = $_SESSION['user_id'];
$data = mysqli_query($conn, "SELECT p.*, b.judul FROM peminjaman p JOIN buku b ON p.buku_id = b.id WHERE p.user_id = '$user_id' AND p.status = 'dipinjam'");

if (isset($_GET['kembali'])) {
    $id_p = $_GET['id'];
    $id_b = $_GET['buku'];
    $tgl = date('Y-m-d');

    mysqli_query($conn, "UPDATE peminjaman SET tgl_kembali='$tgl', status='dikembalikan' WHERE id='$id_p'");
    mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id = '$id_b'");
    echo "<script>alert('Buku dikembalikan!'); window.location='index.php';</script>";
}
?>
<h3>Buku yang Anda Pinjam</h3>
<table border="1" width="100%" cellpadding="10">
    <tr><th>Judul</th><th>Tgl Pinjam</th><th>Aksi</th></tr>
    <?php while($r = mysqli_fetch_assoc($data)): ?>
    <tr>
        <td><?= $r['judul'] ?></td>
        <td><?= $r['tgl_pinjam'] ?></td>
        <td><a href="index.php?page=pengembalian&kembali=true&id=<?= $r['id'] ?>&buku=<?= $r['buku_id'] ?>">Kembalikan</a></td>
    </tr>
    <?php endwhile; ?>
</table>