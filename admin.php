<?php 
session_start();
if($_SESSION['role'] != "admin"){
    header("location: login.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Bakery Shop</title>
    <link rel="stylesheet" href="style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .admin-container { padding: 120px 8% 50px; }
        .crud-table { width: 100%; border-collapse: collapse; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .crud-table th, .crud-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .crud-table th { background-color: #8b5e3c; color: white; }
        .form-admin { background: #fff5f7; padding: 25px; border-radius: 20px; margin-bottom: 30px; border: 1px solid #ffd1dc; }
        .input-admin { width: 100%; padding: 12px; margin: 10px 0; border-radius: 10px; border: 1px solid #ddd; }
        .btn-edit { background: #ffb6c1; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn-delete { background: #e74c3c; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 14px; }
        label { font-weight: 600; color: #8b5e3c; font-size: 14px; }
    </style>
</head>
<body>

<header class="header">
    <div class="logo-container"><h1>🍞 Admin Panel</h1></div>
    <nav><a href="index.php" class="nav-link">Lihat Toko</a></nav>
    <button onclick="logout()" class="logout-btn">Logout</button>
</header>

<div class="admin-container">
    <h2 style="color: #8b5e3c; margin-bottom: 20px;">Kelola Produk Bakery</h2>

    <!-- FORM TAMBAH PRODUK -->
    <div class="form-admin">
        <h3>Tambah Produk Baru</h3>
        <!-- Action ke file PHP yang tadi kita buat -->
        <form action="tambah_produk.php" method="POST">
            <div style="margin-bottom: 15px;">
                <label>Nama Roti</label>
                <input type="text" name="nama_produk" class="input-admin" placeholder="Contoh: Cheese Lava" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Harga (Rp)</label>
                <input type="number" name="harga_produk" class="input-admin" placeholder="Contoh: 18000" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Link Foto / Nama File</label>
                <input type="text" name="gambar_produk" class="input-admin" placeholder="Contoh: fotoproduk/kbread.jpg">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Deskripsi</label>
                <textarea name="deskripsi_produk" class="input-admin" placeholder="Detail produk..."></textarea>
            </div>
            
            <button type="submit" name="simpan" class="btn-submit" style="width: 200px;">Simpan ke Database</button>
        </form>
    </div>

    <!-- TABEL DATA -->
    <table class="crud-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
       <tbody>
    <?php
    include 'koneksi.php';
    $data = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
    while($row = mysqli_fetch_array($data)){
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><img src="<?php echo $row['gambar']; ?>" width="50" style="border-radius:5px;"></td>
        <td><?php echo $row['nama']; ?></td>
        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
        <td>
            <a href="edit_produk.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
            <a href="hapus_produk.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
    </table>
</div>

<script>
    function logout() {
        window.location.href = 'login.php';
    }
</script>

</body>
</html>