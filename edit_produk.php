<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
$row = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk — Bakery Shop</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container { padding: 100px 8%; }
        .form-admin { background: #fff5f7; padding: 25px; border-radius: 20px; border: 1px solid #ffd1dc; max-width: 600px; margin: auto; }
        .input-admin { width: 100%; padding: 12px; margin: 10px 0; border-radius: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
<div class="admin-container">
    <div class="form-admin">
        <h3 style="color: #8b5e3c;">Edit Data Roti</h3>
        <form action="proses_edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            <label>Nama Roti</label>
            <input type="text" name="nama" class="input-admin" value="<?php echo $row['nama']; ?>" required>
            
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="input-admin" value="<?php echo $row['harga']; ?>" required>
            
            <label>Link Foto</label>
            <input type="text" name="gambar" class="input-admin" value="<?php echo $row['gambar']; ?>">
            
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="input-admin"><?php echo $row['deskripsi']; ?></textarea>
            
            <button type="submit" name="update" class="btn-submit" style="width: 100%; margin-top: 10px;">Update Data</button>
            <a href="admin.php" style="display: block; text-align: center; margin-top: 15px; color: #8b5e3c; text-decoration: none;">Batal</a>
        </form>
    </div>
</div>
</body>
</html>