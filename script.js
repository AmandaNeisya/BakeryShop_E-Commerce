// ====================== AUTH & LOGIN SYSTEM ======================
// Sekarang fungsi login & register pindah ke PHP (cek_login.php & proses_register.php)
// JS di sini fokus untuk animasi perpindahan form saja

function showLogin() {
    const loginForm = document.getElementById("login-form");
    const regForm = document.getElementById("register-form");
    const tabLogin = document.getElementById("tab-login");
    const tabReg = document.getElementById("tab-register");

    if (loginForm && regForm) {
        loginForm.classList.add("active");
        regForm.classList.remove("active");
        tabLogin?.classList.add("active");
        tabReg?.classList.remove("active");
    }
}

function showRegister() {
    const loginForm = document.getElementById("login-form");
    const regForm = document.getElementById("register-form");
    const tabLogin = document.getElementById("tab-login");
    const tabReg = document.getElementById("tab-register");

    if (loginForm && regForm) {
        loginForm.classList.remove("active");
        regForm.classList.add("active");
        tabLogin?.classList.remove("active");
        tabReg?.classList.add("active");
    }
}

// Fungsi logout sekarang menghancurkan session di PHP
function logout() {
    if (confirm("Yakin mau keluar, Amanda?")) {
        window.location.href = "logout.php";
    }
}

// ====================== SHOPPING CART SYSTEM ======================
// Keranjang masih boleh pakai localStorage agar cepat, tapi checkout-nya nanti lapor ke database
let cart = [];

function loadCart() {
    const saved = localStorage.getItem("cart");
    cart = saved ? JSON.parse(saved) : [];
    renderCart();
}

function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

function addToCart(name, price) {
    cart.push({ name, price });
    saveCart();
    renderCart();
    alert(name + " berhasil ditambah ke keranjang!");
}

function renderCart() {
    const list = document.getElementById("cart-list");
    const totalEl = document.getElementById("total");
    if (!list) return;

    list.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
        total += item.price;
        const li = document.createElement("li");
        li.style.cssText = "display:flex; justify-content:space-between; margin-bottom:15px; border-bottom: 1px solid #eee; padding-bottom: 5px;";
        li.innerHTML = `
            <span>${item.name}</span>
            <span>Rp ${item.price.toLocaleString('id-ID')} 
                <button onclick="removeItem(${index})" style="color:red; border:none; background:none; cursor:pointer; font-weight:bold; margin-left:10px;">x</button>
            </span>
        `;
        list.appendChild(li);
    });

    if (totalEl) {
        totalEl.innerHTML = `Total: <strong>Rp ${total.toLocaleString('id-ID')}</strong>`;
    }
}

function removeItem(index) {
    cart.splice(index, 1);
    saveCart();
    renderCart();
}

function toggleCart() {
    const box = document.getElementById("cartBox");
    if (box) {
        // Logika geser sidebar
        if (box.style.right === "0px") {
            box.style.right = "-360px";
        } else {
            box.style.right = "0px";
        }
    }
}

// ====================== MODAL & DETAIL SYSTEM ======================
function showDetail(name, price, img, desc) {
    const modal = document.getElementById('detailModal');
    if (modal) {
        document.getElementById('detailTitle').innerText = name;
        document.getElementById('detailImg').src = img;
        document.getElementById('detailDesc').innerText = desc;
        document.getElementById('addFromDetail').onclick = () => { 
            addToCart(name, price); 
            closeDetail(); 
        };
        modal.style.display = "flex";
    }
}

function closeDetail() { 
    const modal = document.getElementById('detailModal');
    if(modal) modal.style.display = "none"; 
}

function checkout() {
    if (cart.length === 0) return alert("Keranjang masih kosong nih!");
    
    let html = ""; 
    let total = 0;
    cart.forEach(item => { 
        html += `<div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                    <span>${item.name}</span>
                    <span>Rp ${item.price.toLocaleString('id-ID')}</span>
                 </div>`; 
        total += item.price; 
    });

    document.getElementById("modal-cart-list").innerHTML = html;
    document.getElementById("modal-total").innerText = `Rp ${total.toLocaleString('id-ID')}`;
    document.getElementById("checkoutModal").style.display = "flex";
}

function closeModal() { 
    document.getElementById("checkoutModal").style.display = "none"; 
}

function prosesCheckout() {
    const nama = document.getElementById("nama").value;
    const alamat = document.getElementById("alamat").value;
    
    if (!nama || !alamat) return alert("Isi nama dan alamat pengiriman dulu ya!");
    
    alert("Pesanan kamu sudah kami terima, " + nama + "! Kami akan segera memprosesnya.");
    localStorage.removeItem("cart");
    location.reload();
}

// ====================== UI INTERACTION ======================
// Update Navigasi Aktif Saat Scroll
window.addEventListener("scroll", () => {
    let current = "";
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".nav-link");

    sections.forEach(s => {
        const sectionTop = s.offsetTop;
        if (pageYOffset >= sectionTop - 150) {
            current = s.getAttribute("id");
        }
    });

    navLinks.forEach(a => {
        a.classList.remove("active");
        if (a.getAttribute("href").includes(current)) {
            a.classList.add("active");
        }
    });
});

// Klik di luar modal untuk menutup
window.onclick = (e) => {
    if (e.target.classList.contains('modal')) {
        closeDetail();
        closeModal();
    }
};

// Pastikan keranjang di-load saat buka halaman
document.addEventListener("DOMContentLoaded", loadCart);