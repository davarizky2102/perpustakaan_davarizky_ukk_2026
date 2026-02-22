<?php
// 1. CEK KAAMANAN
if (!defined('AKSES_HALAMAN')) { 
    header("Location: index.php?page=login"); 
    exit; 
}

// 2. PROTEKSI ADMIN
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=home");
    exit;
}
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Tambah Anggota Anyar</h1>
        <a href="index.php?page=user" class="btn btn-secondary btn-sm rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Balik
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="core/proses_user.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Input ngaran asli" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username keur login" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role / Level</label>
                            <select name="role" class="form-select" required>
                                <option value="siswa">Siswa</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <hr>
                        <div class="d-grid">
                            <button type="submit" name="tambah_user" class="btn btn-primary rounded-pill py-2">
                                <i class="fas fa-save me-1"></i> Simpan Anggota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>