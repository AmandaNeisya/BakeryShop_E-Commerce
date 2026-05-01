<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama      = $_POST['nama_produk'];
    $harga     = $_POST['harga_produk'];
    $gambar    = $_POST['gambar_produk'];
    $deskripsi = $_POST['deskripsi_produk'];

    // Perintah SQL untuk masukkan data
    $query = "INSERT INTO produk (nama, harga, gambar, deskripsi) 
              VALUES ('$nama', '$harga', '$gambar', '$deskripsi')";
    
    if (mysqli_query($conn, $query)) {
        // Kalau berhasil, balik lagi ke halaman admin
        header("Location: admin.html");
    } else {
        echo "Gagal tambah data: " . mysqli_error($conn);
    }
}
?>