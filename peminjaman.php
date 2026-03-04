<?php
require_once __DIR__ . '/php-native/config/database.php';
require_once __DIR__ . '/php-native/includes/auth.php';

if (!isset($_COOKIE['auth_token'])) {
    header('Location: ' . BASE_URL . '/auth-login.php?redirect=peminjaman');
    exit;
}

$user = getUserFromToken();
if (!$user) {
    header('Location: ' . BASE_URL . '/auth-login.php?redirect=peminjaman');
    exit;
}

$pageTitle = 'Peminjaman Alat';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<main class="py-5" style="min-height: 100vh; background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);">
    <div class="container py-5">
        <!-- Header Section -->
        <div class="mb-5" data-aos="fade-up">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="display-5 fw-bold text-white mb-2">Peminjaman Alat</h1>
                    <p class="text-white-50 mb-0">Selamat datang, <strong><?php echo htmlspecialchars($user['nama']); ?></strong></p>
                </div>
                <div class="text-end">
                    <span class="badge bg-warning text-dark px-3 py-2" style="font-size: 1rem;">
                        <i class="bi bi-cart3 me-2"></i>Keranjang: <span id="cartBadge">0</span>
                    </span>
                </div>
            </div>
            <p class="text-white-50">Laboratorium Robotika dan Sistem Tertanam - Universitas Andalas</p>
        </div>

        <!-- Navigation Tabs - Improved -->
        <div class="mb-5">
            <ul class="nav nav-pills gap-2 justify-content-start" id="peminjamanTab" style="flex-wrap: wrap;">
                <li class="nav-item">
                    <button class="nav-link active px-4 py-2" data-bs-toggle="pill" data-bs-target="#katalog">
                        <i class="bi bi-shop me-2"></i> Katalog Barang
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link px-4 py-2" data-bs-toggle="pill" data-bs-target="#cart">
                        <i class="bi bi-cart3 me-2"></i> Keranjang
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link px-4 py-2" data-bs-toggle="pill" data-bs-target="#riwayat">
                        <i class="bi bi-clock-history me-2"></i> Riwayat Peminjaman
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <!-- Katalog Barang Section -->
            <div class="tab-pane fade show active" id="katalog">
                <!-- Filter & View Controls -->
                <div class="row mb-4 align-items-center">
                    <div class="col-lg-6">
                        <select class="form-select form-select-lg bg-dark text-white border-secondary" id="categoryFilter" onchange="filterByCategory()" style="border-color: rgba(255,255,255,0.2) !important;">
                            <option value="">📦 Semua Kategori</option>
                        </select>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <div class="btn-group" role="group" style="background: rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 0.5rem;">
                            <button class="btn btn-outline-light btn-sm active" onclick="setView('grid', this)" title="Grid View">
                                <i class="bi bi-grid-3x3-gap"></i> Grid
                            </button>
                            <button class="btn btn-outline-light btn-sm" onclick="setView('list', this)" title="List View">
                                <i class="bi bi-list-ul"></i> List
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Items Count Info -->
                <div class="alert alert-info mb-4" style="background: rgba(13, 202, 240, 0.2); border-color: rgba(13, 202, 240, 0.3); color: #0dcaf0;">
                    <i class="bi bi-info-circle me-2"></i> Klik tombol "Tambah" untuk menambahkan barang ke keranjang
                </div>
                
                <!-- Barang Grid -->
                <div id="barangGrid" class="row g-4 pb-5">
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-warning"></div>
                        <p class="text-white-50 mt-2">Memuat katalog barang...</p>
                    </div>
                </div>
            </div>

            <!-- Shopping Cart Section -->
            <div class="tab-pane fade" id="cart">
                <div class="row g-4">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="glassmorphism-card">
                            <h5 class="text-white mb-4 pb-3 border-bottom border-secondary" style="border-color: rgba(255,255,255,0.1) !important;">
                                <i class="bi bi-cart3 me-2"></i> Keranjang Peminjaman Anda
                            </h5>
                            <div id="cartItemsDisplay">
                                <div class="text-center py-5">
                                    <i class="bi bi-cart-x" style="font-size: 4rem; color: rgba(255,255,255,0.2);"></i>
                                    <p class="text-white-50 mt-3">Keranjang masih kosong</p>
                                    <p class="text-white-50 small">Tambahkan barang dari katalog untuk memulai peminjaman</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Summary & Checkout -->
                    <div class="col-lg-4">
                        <div class="glassmorphism-card sticky-top" style="top: 120px;">
                            <h5 class="text-white mb-4 pb-3 border-bottom border-secondary" style="border-color: rgba(255,255,255,0.1) !important;">
                                <i class="bi bi-receipt me-2"></i> Ringkasan Peminjaman
                            </h5>
                            
                            <!-- Summary Stats -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                    <span class="text-white-50">
                                        <i class="bi bi-bag me-2"></i>Jumlah Item:
                                    </span>
                                    <span class="text-white fw-bold" id="totalItems">0</span>
                                </div>
                                <div class="d-flex justify-content-between pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                    <span class="text-white-50">
                                        <i class="bi bi-boxes me-2"></i>Total Barang:
                                    </span>
                                    <span class="text-white fw-bold" id="totalBarang">0</span>
                                </div>
                            </div>
                            
                            <!-- Reason Section -->
                            <div class="mb-4">
                                <label class="form-label text-white fw-semibold mb-2">
                                    <i class="bi bi-pencil me-2"></i>Alasan Peminjaman
                                </label>
                                <textarea class="form-control bg-dark text-white border-secondary" id="alasanCart" rows="5" placeholder="Jelaskan keperluan dan tujuan peminjaman barang..." required style="border-color: rgba(255,255,255,0.2) !important;"></textarea>
                                <small class="text-white-50 mt-2 d-block">Minimal deskripsi yang jelas untuk persetujuan admin</small>
                            </div>
                            
                            <!-- Submit Button -->
                            <button class="btn btn-primary w-100 py-3 fw-semibold" id="submitCartBtn" disabled style="background: linear-gradient(135deg, #f97316, #fb923c); border: none;">
                                <i class="bi bi-send me-2"></i> Ajukan Peminjaman
                            </button>
                            
                            <small class="text-white-50 mt-2 d-block text-center">Tunggu persetujuan admin sebelum pengambilan barang</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Section -->
            <div class="tab-pane fade" id="riwayat">
                <div id="riwayatContainer">
                    <div class="text-center py-5">
                        <div class="spinner-border text-warning"></div>
                        <p class="text-white-50 mt-3">Memuat riwayat peminjaman...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Print Resi Modal -->
<div class="modal fade" id="resiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resi Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="resiContent">
                <!-- Resi content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printResi()">
                    <i class="bi bi-printer me-2"></i> Print Resi
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.nav-pills .nav-link {
    background: rgba(255, 255, 255, 0.03);
    border: 2px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 0.95rem;
}

.nav-pills .nav-link:hover {
    background: rgba(249, 115, 22, 0.15);
    color: white;
    border-color: rgba(249, 115, 22, 0.4);
    transform: translateY(-2px);
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #f97316, #fb923c);
    color: white;
    border-color: transparent;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
}

/* Product Card - Katalog Barang */
.product-card {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-10px);
    border-color: rgba(249, 115, 22, 0.5);
    box-shadow: 0 24px 48px rgba(249, 115, 22, 0.2);
    background: rgba(255, 255, 255, 0.06);
}

.product-img-container {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.02);
}

.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-img {
    transform: scale(1.08);
}

.product-img-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(251, 146, 60, 0.08));
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.2);
    font-size: 3.5rem;
}

.stock-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.75rem;
    backdrop-filter: blur(10px);
    z-index: 10;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.stock-available { 
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.95), rgba(74, 222, 128, 0.85)); 
    color: white; 
}
.stock-low { 
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.95), rgba(253, 224, 71, 0.85)); 
    color: white; 
}
.stock-out { 
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.95), rgba(248, 113, 113, 0.85)); 
    color: white; 
}

.product-body {
    padding: 1.25rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.product-category {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    background: rgba(249, 115, 22, 0.15);
    color: #fb923c;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    border: 1px solid rgba(249, 115, 22, 0.3);
    width: fit-content;
}

.product-title {
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-footer {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Cart Item Card - Enhanced */
.cart-item-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.25rem;
    transition: all 0.3s ease;
}

.cart-item-card:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(249, 115, 22, 0.3);
    box-shadow: 0 8px 24px rgba(249, 115, 22, 0.1);
}

.cart-item-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid rgba(255, 255, 255, 0.1);
}

.cart-item-img-placeholder {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Riwayat Card */
.riwayat-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.riwayat-card:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(249, 115, 22, 0.2);
}

.riwayat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.riwayat-id {
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
}

.riwayat-date {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.85rem;
}

.status-badge {
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
}

.status-pending { background: rgba(251, 191, 36, 0.2); color: #fbbf24; }
.status-approved { background: rgba(34, 197, 94, 0.2); color: #4ade80; }
.status-rejected { background: rgba(239, 68, 68, 0.2); color: #f87171; }

.barang-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
}

.barang-item img {
    width: 28px;
    height: 28px;
    object-fit: cover;
    border-radius: 4px;
}

/* Quantity Control */
.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 0.25rem;
}

.quantity-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    background: rgba(249, 115, 22, 0.5);
}

.quantity-display {
    width: 40px;
    text-align: center;
    color: white;
    font-weight: 600;
}

/* Glassmorphism Card */
.glassmorphism-card {
    background: rgba(255, 255, 255, 0.04);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.resi-card {
    background: rgba(255, 255, 255, 0.98);
    color: #1a1a1a;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.3);
}

/* Print Styles */
@media print {
    body * { visibility: hidden; }
    #resiContent, #resiContent * { visibility: visible; }
    #resiContent { position: absolute; left: 0; top: 0; width: 100%; }
}

/* Responsive */
@media (max-width: 768px) {
    .nav-pills { 
        flex-direction: column; 
        gap: 0.5rem; 
    }
    .nav-pills .nav-link { 
        width: 100%; 
        text-align: center; 
    }
    .product-img-container { 
        height: 160px; 
    }
    .product-body {
        padding: 1rem;
    }
    .sticky-top {
        position: static !important;
        margin-top: 2rem;
    }
}

@media (max-width: 576px) {
    .product-card {
        border-radius: 12px;
    }
    .product-body {
        padding: 0.85rem;
    }
    .glassmorphism-card {
        padding: 1.25rem;
    }
}
</style>

<script>
let cart = [];
let allBarang = [];
let categories = [];

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded fired');
    loadCategories();
    loadAllBarang();
    loadRiwayat();
    
    // Tab handlers
    document.getElementById('peminjamanTab').addEventListener('shown.bs.tab', function(e) {
        if (e.target.getAttribute('data-bs-target') === '#cart') {
            updateCartDisplay();
        } else if (e.target.getAttribute('data-bs-target') === '#riwayat') {
            loadRiwayat();
        }
    });
});

function loadCategories() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/peminjaman/categories.php')
        .then(res => res.json())
        .then(data => {
            if (data.data) {
                categories = data.data;
                const select = document.getElementById('categoryFilter');
                select.innerHTML = '<option value="">Semua Kategori</option>' +
                    data.data.map(cat => `<option value="${cat.id}">${cat.name}</option>`).join('');
            }
        });
}

function loadAllBarang() {
    const container = document.getElementById('barangGrid');
    if (!container) {
        console.error('barangGrid container not found');
        return;
    }

    container.innerHTML = '<div class="col-12 text-center py-5"><div class="spinner-border text-warning"></div></div>';

    console.log('Loading barang from API...');

    // Load all available barang
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

    fetch('<?php echo BASE_URL; ?>/php-native/api/peminjaman/barang-all.php', {
        signal: controller.signal
    })
        .then(res => {
            clearTimeout(timeoutId);
            console.log('API response status:', res.status);
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            console.log('API response data:', data);
            if (data.data && data.data.length > 0) {
                allBarang = data.data;
                displayBarang(allBarang);
            } else {
                container.innerHTML = '<div class="col-12 text-center text-warning py-5">Tidak ada barang tersedia</div>';
            }
        })
        .catch(err => {
            console.error('Error loading barang:', err);
            let errorMessage = err.message;
            if (err.name === 'AbortError') {
                errorMessage = 'Request timeout - API tidak merespons';
            }
            container.innerHTML = '<div class="col-12 text-center text-danger py-5">Error loading barang: ' + errorMessage + '</div>';
        });
}

function filterByCategory() {
    const categoryId = document.getElementById('categoryFilter').value;
    const filtered = categoryId ? allBarang.filter(item => item.categoryId == categoryId) : allBarang;
    displayBarang(filtered);
}

function displayBarang(items) {
    const container = document.getElementById('barangGrid');

    console.log('Displaying items:', items);

    if (!container) {
        console.error('barangGrid container not found in displayBarang');
        return;
    }

    if (items && items.length > 0) {
        container.innerHTML = items.map(item => `
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="product-card">
                    <div class="position-relative">
                        <img src="<?php echo BASE_URL; ?>/public/uploads/${item.image || ''}" class="product-img" alt="${item.name}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="product-img-placeholder" style="display: none;"><i class="bi bi-box"></i></div>
                        <span class="stock-badge stock-available">
                            Stok: ${item.quantity}
                        </span>
                    </div>
                    <div class="p-3">
                        <div class="mb-2">
                            <span class="badge" style="background: rgba(249, 115, 22, 0.2); color: #fb923c; font-size: 0.75rem;">
                                ${item.categoryName}
                            </span>
                        </div>
                        <h6 class="text-white fw-semibold mb-3">${item.name}</h6>

                        <div class="d-flex align-items-center gap-2">
                            <input type="number" class="form-control form-control-sm"
                                   id="qty-${item.id}" min="1" max="${item.quantity}" value="1"
                                   style="width: 70px; background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: white;">
                            <button class="btn btn-primary btn-sm flex-grow-1" onclick="addToCart(${item.id}, '${item.name.replace(/'/g, '\\\'')}', '${item.image || ''}', ${item.quantity})">
                                <i class="bi bi-cart-plus me-1"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    } else {
        container.innerHTML = '<div class="col-12 text-center text-white-50 py-5">Tidak ada barang tersedia</div>';
    }
}

function getStockClass(quantity) {
    if (quantity > 5) return 'stock-available';
    if (quantity > 0) return 'stock-low';
    return 'stock-out';
}

function addToCart(id, name, image, maxStock) {
    const qtyInput = document.getElementById(`qty-${id}`);
    const quantity = parseInt(qtyInput.value) || 1;

    if (quantity <= 0) {
        showToast('Jumlah harus lebih dari 0!', 'warning');
        qtyInput.value = 1;
        return;
    }

    if (quantity > maxStock) {
        showToast('Jumlah melebihi stok tersedia!', 'warning');
        return;
    }
    
    const existingIndex = cart.findIndex(item => item.barangId === id);
    
    if (existingIndex >= 0) {
        cart[existingIndex].quantity += quantity;
        if (cart[existingIndex].quantity > maxStock) {
            cart[existingIndex].quantity = maxStock;
        }
    } else {
        cart.push({
            barangId: id,
            name: name,
            image: image,
            quantity: quantity,
            maxStock: maxStock
        });
    }
    
    updateCartBadge();
    showToast(`${name} ditambahkan ke keranjang!`, 'success');
    qtyInput.value = 1;
}

function updateCartBadge() {
    document.getElementById('cartBadge').textContent = cart.length;
    document.getElementById('submitCartBtn').disabled = cart.length === 0;
}

function updateCartDisplay() {
    const container = document.getElementById('cartItemsDisplay');
    const totalItemsEl = document.getElementById('totalItems');
    const totalBarangEl = document.getElementById('totalBarang');
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 text-white-50">
                <i class="bi bi-cart-x display-1 mb-3 d-block"></i>
                <p>Keranjang masih kosong</p>
                <button class="btn btn-outline-light mt-2" onclick="document.querySelector('[data-bs-target=\\'#katalog\\']').click()">
                    <i class="bi bi-shop me-2"></i> Mulai Belanja
                </button>
            </div>
        `;
        totalItemsEl.textContent = 0;
        totalBarangEl.textContent = 0;
        return;
    }
    
    const totalQty = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    container.innerHTML = cart.map((item, index) => `
        <div class="cart-item-card">
            <div class="row align-items-center">
                <div class="col-auto">
                    ${item.image ? 
                        `<img src="<?php echo BASE_URL; ?>/public/uploads/${item.image}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px;">` : 
                        `<div style="width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-box text-white-50 fs-3"></i>
                        </div>`
                    }
                </div>
                <div class="col">
                    <h6 class="text-white fw-semibold mb-1">${item.name}</h6>
                    <p class="text-white-50 small mb-0">Max: ${item.maxStock} pcs</p>
                </div>
                <div class="col-auto">
                    <div class="quantity-control">
                        <button class="quantity-btn" onclick="updateCartQty(${index}, -1)">
                            <i class="bi bi-dash"></i>
                        </button>
                        <div class="quantity-display">${item.quantity}</div>
                        <button class="quantity-btn" onclick="updateCartQty(${index}, 1)">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
    
    totalItemsEl.textContent = cart.length;
    totalBarangEl.textContent = totalQty;
}

function updateCartQty(index, change) {
    cart[index].quantity += change;
    
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    } else if (cart[index].quantity > cart[index].maxStock) {
        cart[index].quantity = cart[index].maxStock;
        showToast('Jumlah maksimal: ' + cart[index].maxStock, 'warning');
    }
    
    updateCartBadge();
    updateCartDisplay();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartBadge();
    updateCartDisplay();
    showToast('Item dihapus dari keranjang', 'info');
}

document.getElementById('submitCartBtn').addEventListener('click', async function() {
    const alasan = document.getElementById('alasanCart').value.trim();
    
    if (!alasan) {
        showToast('Alasan peminjaman wajib diisi!', 'warning');
        return;
    }
    
    if (cart.length === 0) {
        showToast('Keranjang masih kosong!', 'warning');
        return;
    }
    
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengirim...';
    
    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/peminjaman/submit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getCookie('auth_token')
            },
            body: JSON.stringify({
                alasan: alasan,
                items: cart.map(item => ({
                    barangId: item.barangId,
                    name: item.name,
                    quantity: item.quantity
                }))
            })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            showToast('Peminjaman berhasil diajukan! Menunggu persetujuan admin.', 'success');
            cart = [];
            updateCartBadge();
            updateCartDisplay();
            document.getElementById('alasanCart').value = '';
            
            // Switch to riwayat tab
            setTimeout(() => {
                document.querySelector('[data-bs-target="#riwayat"]').click();
                loadRiwayat();
            }, 1500);
        } else {
            throw new Error(data.error || 'Gagal mengajukan peminjaman');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'danger');
    } finally {
        this.disabled = false;
        this.innerHTML = '<i class="bi bi-send me-2"></i> Ajukan Peminjaman';
    }
});

function loadRiwayat() {
    const container = document.getElementById('riwayatContainer');
    container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-warning"></div></div>';
    
    fetch('<?php echo BASE_URL; ?>/php-native/api/peminjaman/riwayat.php', {
        headers: { 'Authorization': 'Bearer ' + getCookie('auth_token') }
    })
    .then(res => res.json())
    .then(data => {
        if (data.data && data.data.length > 0) {
            container.innerHTML = data.data.map(item => `
                <div class="glassmorphism-card mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="text-white mb-2">
                                        <i class="bi bi-receipt me-2"></i> Peminjaman #${item.id}
                                    </h5>
                                    <p class="text-white-50 small mb-0">
                                        <i class="bi bi-calendar me-1"></i> ${formatDateTime(item.submittedAt)}
                                    </p>
                                </div>
                                <span class="badge bg-${getStatusColor(item.status)} px-3 py-2">
                                    ${getStatusText(item.status)}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <p class="text-white-50 small mb-1"><strong>Alasan:</strong></p>
                                <p class="text-white">${item.alasan || '-'}</p>
                            </div>
                            
                            ${item.rejectionReason ? `
                                <div class="alert alert-danger mb-3">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>Ditolak:</strong> ${item.rejectionReason}
                                </div>
                            ` : ''}
                            
                            <div class="mb-0">
                                <p class="text-white-50 small mb-2"><strong>Barang:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    ${item.items.map(barang => `
                                        <div class="d-flex align-items-center gap-2 px-3 py-2 rounded" style="background: rgba(255,255,255,0.1);">
                                            ${barang.barang.image ? 
                                                `<img src="<?php echo BASE_URL; ?>/public/uploads/${barang.barang.image}" style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px;">` : 
                                                '<i class="bi bi-box text-white-50"></i>'
                                            }
                                            <span class="text-white small">${barang.barang.name}</span>
                                            <span class="badge bg-primary">${barang.quantity}</span>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 text-end">
                            ${item.status === 'approved' ? `
                                <button class="btn btn-success mb-2 w-100" onclick="printResiPeminjaman(${item.id})">
                                    <i class="bi bi-printer me-2"></i> Cetak Resi
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = `
                <div class="glassmorphism-card text-center py-5">
                    <i class="bi bi-inbox display-1 text-white-50 mb-3 d-block"></i>
                    <p class="text-white-50 mb-0">Belum ada riwayat peminjaman</p>
                </div>
            `;
        }
    })
    .catch(err => {
        console.error('Error:', err);
        container.innerHTML = '<div class="alert alert-danger">Error loading riwayat</div>';
    });
}

function printResiPeminjaman(peminjamanId) {
    fetch(`<?php echo BASE_URL; ?>/php-native/api/peminjaman/resi.php?id=${peminjamanId}`, {
        headers: { 'Authorization': 'Bearer ' + getCookie('auth_token') }
    })
    .then(res => res.json())
    .then(data => {
        if (data.data) {
            const resi = data.data;
            document.getElementById('resiContent').innerHTML = `
                <div class="resi-card">
                    <div class="text-center mb-4">
                        <img src="<?php echo BASE_URL; ?>/public/reslabtrans.png" height="60" class="mb-3">
                        <h4 class="fw-bold">RESI PEMINJAMAN</h4>
                        <p class="text-muted">Robotics and Embedded System Laboratory</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-6">
                            <p class="mb-1"><strong>No. Resi:</strong></p>
                            <h5 class="text-primary">#${resi.id}</h5>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-1"><strong>Tanggal:</strong></p>
                            <p class="mb-0">${formatDate(resi.approvedAt)}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Peminjam:</h6>
                        <p class="mb-1"><strong>Nama:</strong> ${resi.user_nama}</p>
                        <p class="mb-1"><strong>NIM:</strong> ${resi.user_nim}</p>
                        <p class="mb-0"><strong>Email:</strong> ${resi.user_email}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Barang yang Dipinjam:</h6>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${resi.items.map((item, idx) => `
                                    <tr>
                                        <td>${idx + 1}</td>
                                        <td>${item.barang.name}</td>
                                        <td class="text-center"><strong>${item.quantity}</strong></td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mb-4">
                        <p class="mb-1"><strong>Alasan Peminjaman:</strong></p>
                        <p class="text-muted">${resi.alasan}</p>
                    </div>
                    
                    <div class="alert alert-warning">
                        <small><strong>Catatan:</strong> Harap mengembalikan barang dalam kondisi baik. Kerusakan atau kehilangan akan dikenakan sanksi.</small>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-6">
                            <p class="mb-5">Peminjam,</p>
                            <p class="fw-bold">${resi.user_nama}</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-5">Admin ResLab,</p>
                            <p class="fw-bold">_____________</p>
                        </div>
                    </div>
                </div>
            `;
            
            new bootstrap.Modal(document.getElementById('resiModal')).show();
        }
    })
    .catch(err => {
        console.error('Error:', err);
        showToast('Error loading resi', 'danger');
    });
}

function printResi() {
    window.print();
}

function setView(view, btn) {
    document.querySelectorAll('.btn-group button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    // Implement grid/list view toggle if needed
}

function getStatusColor(status) {
    const colors = { 'pending': 'warning', 'approved': 'success', 'rejected': 'danger' };
    return colors[status] || 'secondary';
}

function getStatusText(status) {
    const text = { 'pending': 'Menunggu', 'approved': 'Disetujui', 'rejected': 'Ditolak' };
    return text[status] || status;
}

function formatDateTime(dateString) {
    return new Date(dateString).toLocaleString('id-ID', {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric', month: 'long', day: 'numeric'
    });
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed shadow-lg`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 12px;';
    toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
