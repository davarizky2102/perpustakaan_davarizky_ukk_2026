<?php
// models/user.php
if (!class_exists('User_model')) {
    class User_model {
        private $db;

        public function __construct() {
            global $conn; // Pastikan di config/database.php namanya $conn
            $this->db = $conn;
        }

        public function getUserByUsername($username) {
            // Cek dulu koneksinya ada gak, biar gak Fatal Error
            if (!$this->db) {
                return false;
            }
            $username = mysqli_real_escape_string($this->db, $username);
            $query = "SELECT * FROM user WHERE username = '$username'";
            $result = mysqli_query($this->db, $query);
            return mysqli_fetch_assoc($result);
        }
    }
}