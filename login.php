<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Shop — Fresh Everyday</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

    <div class="login-wrapper">
        <!-- Bagian Kiri: Dekorasi/Gambar -->
        <div class="login-design">
            <h1>Freshly Baked</h1>
            <p>Aroma kebahagiaan dimulai dari sini. Silakan masuk untuk mulai berbelanja roti favoritmu.</p>
        </div>

        <!-- Bagian Kanan: Form Login & Register -->
        <div class="login-form-box">
            <!-- Navigasi Tab -->
            <div class="tabs">
                <button id="tab-login" class="active" onclick="showLogin()">Login</button>
                <button id="tab-register" onclick="showRegister()">Register</button>
            </div>

            <!-- Pesan Notifikasi jika gagal login -->
            <?php if(isset($_GET['pesan']) && $_GET['pesan'] == "gagal"): ?>
                <p style="color: #e74c3c; font-size: 14px; text-align: center;">Username atau Password salah!</p>
            <?php endif; ?>

            <!-- Box Form Login -->
            <div id="login-form" class="auth-form active">
                <form action="cek_login.php" method="POST">
                    <div class="input-group">
                        <label for="login-user">Username</label>
                        <input type="text" name="username" id="login-user" placeholder="Masukkan username" required>
                    </div>
                    <div class="input-group">
                        <label for="login-pass">Password</label>
                        <input type="password" name="password" id="login-pass" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn-submit">Masuk Sekarang</button>
                </form>
            </div>

            <!-- Box Form Register -->
            <div id="register-form" class="auth-form">
                <form action="proses_register.php" method="POST">
                    <div class="input-group">
                        <label for="reg-user">Buat Username</label>
                        <input type="text" name="username" id="reg-user" placeholder="Contoh: amanda_bakery" required>
                    </div>
                    <div class="input-group">
                        <label for="reg-pass">Buat Password</label>
                        <input type="password" name="password" id="reg-pass" placeholder="Minimal 6 karakter" required>
                    </div>
                    <button type="submit" class="btn-submit">Daftar Akun</button>
                </form>
            </div>
            
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>