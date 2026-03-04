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
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-white mb-3">Peminjaman Alat Laboratorium</h1>
            <p class="text-white-50">Selamat datang, <strong><?php echo htmlspecialchars($user['nama']); ?></strong></p>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills justify-content-center mb-5" id="peminjamanTab">
            <li class="nav-item">
                <button class="nav-link active px-4" data-bs-toggle="pill" data-bs-target="#katalog">
                    <i class="bi bi-shop me-2"></i> Katalog Barang
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link px-4" data-bs-toggle="pill" data-bs-target="#cart">
                    <i class="bi bi-cart3 me-2"></i> Keranjang
                    <span class="badge bg-danger ms-2" id="cartBadge">0</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link px-4" data-bs-toggle="pill" data-bs-target="#riwayat">
                    <i class="bi bi-clock-history me-2"></i> Riwayat
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Katalog Barang (E-commerce Style) -->
            <div class="tab-pane fade show active" id="katalog">
                <!-- Category Filter -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <select class="form-select bg-dark text-white" id="categoryFilter" onchange="filterByCategory()">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>
                    <div class="col-md-8 text-end">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-light btn-sm active" onclick="setView('grid', this)">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </button>
                            <button class="btn btn-outline-light btn-sm" onclick="setView('list', this)">
                                <i class="bi bi-list-ul"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Barang Grid -->
                <div id="barangGrid" class="row g-4">
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-warning"></div>
                    </div>
                </div>
            </div>

            <!-- Shopping Cart -->
            <div class="tab-pane fade" id="cart">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="glassmorphism-card">
                            <h4 class="text-white mb-4">
                                <i class="bi bi-cart3 me-2"></i> Keranjang Peminjaman
                            </h4>
                            <div id="cartItemsDisplay">
                                <div class="text-center py-5 text-white-50">
                                    <i class="bi bi-cart-x display-1 mb-3 d-block"></i>
                                    Keranjang kosong
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="glassmorphism-card sticky-top" style="top: 100px;">
                            <h5 class="text-white mb-4">Ringkasan</h5>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-white-50 mb-2">
                                    <span>Total Items:</span>
                                    <span id="totalItems">0</span>
                                </div>
                                <div class="d-flex justify-content-between text-white-50 mb-3">
                                    <span>Total Barang:</span>
                                    <span id="totalBarang">0</span>
                                </div>
                                <hr style="border-color: rgba(255,255,255,0.1);">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-white fw-semibold">Alasan Peminjaman</label>
                                <textarea class="form-control" id="alasanCart" rows="4" placeholder="Jelaskan tujuan peminjaman..." required></textarea>
                            </div>
                            
                            <button class="btn btn-primary w-100 py-3" id="submitCartBtn" disabled>
                                <i class="bi bi-send me-2"></i> Ajukan Peminjaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat -->
            <div class="tab-pane fade" id="riwayat">
                <div id="riwayatContainer">
                    <div class="text-center py-5">
                        <div class="spinner-border text-warning"></div>
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
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background: rgba(249, 115, 22, 0.3);
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
}

.product-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-8px);
    border-color: rgba(249, 115, 22, 0.5);
    box-shadow: 0 15px 40px rgba(249, 115, 22, 0.2);
}

.product-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: rgba(255, 255, 255, 0.05);
}

.product-img-placeholder {
    width: 100%;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.3);
    font-size: 3rem;
}

.stock-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
    backdrop-filter: blur(10px);
}

.stock-available { background: rgba(34, 197, 94, 0.9); color: white; }
.stock-low { background: rgba(234, 179, 8, 0.9); color: white; }
.stock-out { background: rgba(239, 68, 68, 0.9); color: white; }

.cart-item-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.cart-item-card:hover {
    background: rgba(255, 255, 255, 0.08);
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.1);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    background: rgba(249, 115, 22, 0.3);
    border-color: #f97316;
}

.quantity-display {
    width: 50px;
    text-align: center;
    color: white;
    font-weight: 600;
}

.resi-card {
    background: rgba(255, 255, 255, 0.95);
    color: #333;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

@media print {
    body * {
        visibility: hidden;
    }
    #resiContent, #resiContent * {
        visibility: visible;
    }
    #resiContent {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
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
