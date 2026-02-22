<?php
session_start();
// Hapus semua data session
session_destroy();

// Tendang balik ke index.php (nanti index.php bakal otomatis arahin ke login)
header("Location: ../index.php?page=login");
exit();
?>