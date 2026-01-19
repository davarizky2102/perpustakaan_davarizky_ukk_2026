<?php
function getSemuaBuku($conn) {
    $sql = "SELECT * FROM buku";
    return mysqli_query($conn, $sql);
}

function cariBuku($conn, $keyword) {
    $sql = "SELECT * FROM buku WHERE judul LIKE '%$keyword%'";
    return mysqli_query($conn, $sql);
}
?>