<?php
class Controller {
    // Fungsi buat login
    public function login($username, $password) {
        global $conn; // Ambil koneksi database lu

        // 1. Cari user berdasarkan username
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // 2. Cek password (pake password_verify biar aman kayak Dava & Iqbal)
            if (password_verify($password, $row['password'])) {
                // Kalo bener, bikin session buat jaga-jaga pintu masuk
                $_SESSION['user_id'] = $row['id_user']; // Inget, di DB lu namanya id_user
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['role'] = $row['role'];
                return true;
            }
        }
        return false; // Kalo salah, kasih tau gagal
    }
}