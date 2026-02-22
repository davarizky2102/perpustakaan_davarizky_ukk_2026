<?php
// core/model.php

// Cek dulu biar nggak error redeclare
if (!class_exists('Model')) {

    class Model {
        private $db;

        public function __construct() {
            // Ngambil koneksi database yang udah lu buat
            global $conn;
            $this->db = $conn;
        }

        // --- FUNGSI BUAT USER (LOGIN) ---
        public function getUserByUsername($username) {
            if ($this->db) {
                $username = mysqli_real_escape_string($this->db, $username);
                $query = "SELECT * FROM user WHERE username = '$username'";
                $result = mysqli_query($this->db, $query);
                return mysqli_fetch_assoc($result);
            }
            return false;
        }

        // --- FUNGSI BUAT BUKU (TAMBAHIN INI MEN) ---
        public function getAllBuku() {
            if ($this->db) {
                // Tarik data dari tabel buku lu
                $query = "SELECT * FROM buku";
                return mysqli_query($this->db, $query);
            }
            return false;
        }
    }
}