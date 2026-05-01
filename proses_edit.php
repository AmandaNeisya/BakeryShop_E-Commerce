<?php
include 'koneksi.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_POST['gambar'];
    $deskripsi = $_POST['deskripsi'];

    $query = "UPDATE produk SET nama='$nama', harga='$harga', gambar='$gambar', deskripsi='$deskripsi' WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: admin.php");
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>