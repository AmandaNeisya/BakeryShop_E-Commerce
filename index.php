<?php 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Shop — Fresh Everyday</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<header class="header">
    <div class="logo-container">
        <h1>🍞 Bakery Shop</h1>
    </div>
    <nav>
    <a href="#home" class="nav-link active">Home</a>
    <a href="#produk" class="nav-link">Produk</a>
    <a href="#about" class="nav-link">About Us</a> 
    
    <?php 
    if(isset($_SESSION['username'])){
        echo "<span style='color:white; margin-left:15px; font-weight:500;'>Halo, " . $_SESSION['username'] . "!</span>";
    }
    ?>
</nav>
    <div style="display:flex; align-items:center; gap:15px;">
        <a href="javascript:void(0)" onclick="toggleCart()" style="font-size:26px; color:white; text-decoration:none; position:relative;">🛒</a>
        <button onclick="logout()" class="logout-btn">Logout</button>
    </div>
</header>

<!-- HERO SECTION -->
<section id="home" class="section hero">
    <div class="hero-content">
        <h2>Fresh & Handmade Everyday 🍞</h2>
        <p>Nikmati kelembutan roti premium dengan bahan pilihan terbaik, dipanggang langsung untuk kamu hari ini.</p>
        <a href="#produk"><button class="hero-btn">Belanja Sekarang 🛒</button></a>
    </div>
</section>

<!-- PRODUK SECTION -->
<section id="produk" class="section">
    <h2 class="section-title">Produk Kami</h2>
    <div class="products">
        
        <?php
        // AMBIL DATA DARI DATABASE
        $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
        
        // Cek jika ada data
        if(mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_array($query)) {
                // Kita simpan data ke variabel biar gampang dipanggil
                $nama = $row['nama'];
                $harga = $row['harga'];
                $gambar = $row['gambar'];
                $desc = $row['deskripsi'];
        ?>
            <!-- KARTU PRODUK OTOMATIS -->
            <div class="card">
                <img src="<?php echo $gambar; ?>" alt="<?php echo $nama; ?>" 
                     onclick="showDetail('<?php echo $nama; ?>', <?php echo $harga; ?>, '<?php echo $gambar; ?>', '<?php echo $desc; ?>')">
                <h3><?php echo $nama; ?></h3>
                <p>Rp <?php echo number_format($harga, 0, ',', '.'); ?></p>
                <button class="add-btn" onclick="addToCart('<?php echo $nama; ?>', <?php echo $harga; ?>)">Tambah</button>
            </div>
        <?php 
            }
        } else {
            echo "<p style='text-align:center; width:100%; color:#8b5e3c;'>Belum ada produk yang tersedia.</p>";
        }
        ?>

    </div>
</section>

<!-- MODAL DETAIL PRODUK -->
<div id="detailModal" class="modal" style="display:none; position:fixed; z-index:3000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
    <div class="modal-content">
        <span class="close-modal" onclick="closeDetail()" style="cursor:pointer; float:right; font-size:28px;">&times;</span>
        <h2 id="detailTitle" style="color:#8b5e3c; margin-bottom:15px;">Detail Produk</h2>
        <img id="detailImg" src="" style="width:100%; max-height:250px; object-fit:cover; border-radius:15px; margin-bottom:15px;">
        <p id="detailDesc" style="margin-bottom:20px; color:#555;"></p>
        <button id="addFromDetail" class="btn-submit">Tambah ke Keranjang</button>
    </div>
</div>

<!-- ABOUT SECTION -->
<section id="about" class="about-section">
    <div class="about-container">
        <h2>Tentang Kami 🍞</h2>
        <p>Di Bakery Shop, kami percaya setiap gigitan membawa kebahagiaan. Dibuat dengan cinta dan bahan berkualitas tinggi setiap pagi.</p>
        <p style="margin-top: 15px; font-style: italic; color: #bd8c67;">"Fresh Everyday, Baked with Heart." ❤️</p>
        <iframe src="https://www.google.com/maps?q=Universitas+Djuanda&output=embed" width="100%" height="300" style="border:none; border-radius:15px; margin-top:20px;"></iframe>
    </div>
</section>

<footer class="footer">
    <p>Instagram: @bakery_shop</p>
    <p>WhatsApp: 083846707989</p>
    <p>© 2026 Bakery Shop | Universitas Djuanda, Bogor</p>
</footer>

<!-- SIDEBAR KERANJANG & MODAL CHECKOUT TETAP SAMA -->
<div id="cartBox">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3>🛒 Keranjang</h3>
        <span onclick="toggleCart()" style="cursor:pointer; font-size:24px;">&times;</span>
    </div>
    <ul id="cart-list" style="list-style:none; padding:0; height:60vh; overflow-y:auto;"></ul>
    <div id="total" style="font-weight:700; font-size:1.2rem; margin:20px 0; padding-top:10px; border-top:2px solid #eee;">Total: Rp 0</div>
    <button onclick="checkout()" class="btn-submit">Checkout Sekarang</button>
</div>

<div id="checkoutModal" class="modal" style="display:none; position:fixed; z-index:4000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
    <div class="modal-content" style="max-width:500px; width:90%;">
        <h2 style="color:#8b5e3c; margin-bottom:15px;">Konfirmasi Pesanan</h2>
        <div id="modal-cart-list" style="max-height:150px; overflow-y:auto; margin-bottom:15px; text-align:left;"></div>
        <div style="font-weight:700; margin-bottom:15px;">Total Tagihan: <span id="modal-total"></span></div>
        <div class="input-group"><input type="text" id="nama" placeholder="Nama Lengkap"></div>
        <div class="input-group"><input type="text" id="alamat" placeholder="Alamat Pengiriman"></div>
        <div class="input-group">
            <select id="pembayaran" style="width:100%; padding:10px; border-radius:20px; border:1px solid #ddd;">
                <option value="cod">Cash on Delivery (COD)</option>
                <option value="transfer">Transfer Bank</option>
            </select>
        </div>
        <div style="display:flex; gap:10px; margin-top:20px;">
            <button onclick="prosesCheckout()" class="btn-submit" style="flex:1;">Pesan Sekarang</button>
            <button onclick="closeModal()" class="btn-submit" style="flex:1; border-color:#ddd;">Batal</button>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>