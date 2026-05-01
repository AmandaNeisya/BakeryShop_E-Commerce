<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = "DELETE FROM produk WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    header("Location: admin.php");
} else {
    echo "Gagal menghapus: " . mysqli_error($conn);
}
?>