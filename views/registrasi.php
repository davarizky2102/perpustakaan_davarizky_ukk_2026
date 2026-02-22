<?php
// 1. LOGIKA PROSES SIMPAN (Taruh paling atas)
if (isset($_POST['daftar'])) {
    global $conn; // Ambil koneksi dari database.php yang di-load index.php
    
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // WAJIB DI-HASH
    $role     = $_POST['role'];

    $query = "INSERT INTO user (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil Daftar! Silakan Login.'); window.location='index.php?page=login';</script>";
    } else {
        echo "<script>alert('Gagal Daftar: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Perpus Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; border: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 fw-bold text-success">Daftar Akun Baru</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama asli lu" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Buat login" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Rahasia ya" required>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" name="daftar" class="btn btn-success btn-lg">Daftar Sekarang</button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <p class="mb-0 text-muted">Udah punya akun?</p>
                        <a href="index.php?page=login" class="text-decoration-none fw-bold">Login di sini men</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>