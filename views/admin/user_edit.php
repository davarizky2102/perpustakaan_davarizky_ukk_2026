<?php
// 1. CEK KEAMANAN AKSES
if (!defined('AKSES_HALAMAN')) { 
    header("Location: index.php?page=login"); 
    exit; 
}

// 2. AMBIL DATA USER BERDASARKAN ID DI URL
if (isset($_GET['id'])) {
    $id_edit = mysqli_real_escape_string($conn, $_GET['id']);
    $query_user = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_edit'");
    $data = mysqli_fetch_assoc($query_user);

    if (!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='index.php?page=user';</script>";
        exit;
    }
} else {
    header("Location: index.php?page=user");
    exit;
}
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit Anggota</h1>
        <a href="index.php?page=user" class="btn btn-secondary btn-sm rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="core/proses_user.php" method="POST">
                        <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password (Kosongkan jika tidak diganti)</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password baru jika ingin diubah">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Role / Level</label>
                            <select name="role" class="form-select" required>
                                <option value="siswa" <?= ($data['role'] == 'siswa') ? 'selected' : ''; ?>>Siswa</option>
                                <option value="admin" <?= ($data['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>

                        <hr>
                        <div class="d-grid">
                            <button type="submit" name="edit_user" class="btn btn-warning text-white rounded-pill py-2">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>