<?php
require_once __DIR__ . '/../php-native/config/database.php';
require_once __DIR__ . '/../php-native/includes/auth.php';

if (!isset($_COOKIE['admin_token'])) {
    header('Location: ' . BASE_URL . '/admin-login.php');
    exit;
}

$adminData = verifyToken($_COOKIE['admin_token']);
if (!$adminData || !$adminData['isAdmin']) {
    setcookie('admin_token', '', time() - 3600, '/');
    header('Location: ' . BASE_URL . '/admin-login.php');
    exit;
}

$pageTitle = 'Kelola Barang';
$current_page = 'barang';
include __DIR__ . '/../php-native/includes/header.php';
?>
<!-- Admin Dark Theme CSS -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/php-native/assets/css/admin-dark.css">

<?php include __DIR__ . '/includes/admin-nav.php'; ?>
?>

<main class="admin-content-dark">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-white mb-1">Kelola Barang</h2>
                <p class="text-white-50 mb-0">Manage equipment inventory with images</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-warning" onclick="loadData()">
                    <i class="bi bi-arrow-clockwise me-2"></i> Refresh
                </button>
                <button class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#addBarangModal">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Barang
                </button>
            </div>
        </div>
        
        <!-- Filter - Dark -->
        <div class="card-dark mb-4">
            <div class="card-body-dark">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-white mb-2">Filter Kategori:</label>
                        <select class="form-select bg-dark text-white border-secondary" id="filterCategory" onchange="loadData()">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>
                    <div class="col-md-8 text-end">
                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#categoryModal">
                            <i class="bi bi-folder me-1"></i> Kelola Kategori
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Barang Table - Dark -->
        <div class="card-dark">
            <div class="card-body-dark p-0">
                <div id="barangContainer">
                    <div class="text-center py-5">
                        <div class="spinner-border text-warning"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Barang Modal - Dark -->
<div class="modal fade" id="addBarangModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-0 shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle text-warning me-2"></i> Tambah Barang Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addBarangForm">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select bg-dark text-white border-secondary" id="addCategoryId" required>
                            <option value="">-- Pilih Kategori --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="addName" placeholder="Contoh: Arduino Uno" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control bg-dark text-white border-secondary" id="addQuantity" min="0" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Gambar <span class="text-danger">*</span></label>
                        <input type="file" class="form-control bg-dark text-white border-secondary" id="addImage" accept="image/jpeg,image/png,image/jpg,image/gif" required>
                        <small class="text-white-50">Max: 2MB. Format: JPG, PNG, GIF</small>
                        <div id="previewAdd" class="mt-3"></div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="bi bi-save me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Barang Modal - Dark -->
<div class="modal fade" id="editBarangModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-0 shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil text-warning me-2"></i> Edit Barang
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editBarangForm">
                <input type="hidden" id="editId">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select class="form-select bg-dark text-white border-secondary" id="editCategoryId" required>
                            <option value="">-- Pilih Kategori --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Stok</label>
                        <input type="number" class="form-control bg-dark text-white border-secondary" id="editQuantity" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ganti Gambar (Optional)</label>
                        <input type="file" class="form-control bg-dark text-white border-secondary" id="editImage" accept="image/*">
                        <div id="currentImagePreview" class="mt-3"></div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="bi bi-save me-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Category Modal - Dark -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white border-0 shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Kelola Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form class="mb-4" id="addCategoryForm">
                    <div class="input-group">
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="newCategoryName" placeholder="Nama kategori baru..." required>
                        <button type="submit" class="btn btn-warning text-dark">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </form>
                <div id="categoryList" class="text-white-50">
                    <div class="text-center py-3">
                        <div class="spinner-border spinner-border-sm text-warning"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-content-dark {
    min-height: calc(100vh - 60px);
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
}

.card-dark {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.card-header-dark {
    background: rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1.25rem 1.5rem;
}

.card-body-dark {
    padding: 1.5rem;
}

.barang-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.stock-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
}

.stock-high { background: rgba(34, 197, 94, 0.2); color: #86efac; border: 1px solid rgba(34, 197, 94, 0.3); }
.stock-medium { background: rgba(234, 179, 8, 0.2); color: #fcd34d; border: 1px solid rgba(234, 179, 8, 0.3); }
.stock-low { background: rgba(239, 68, 68, 0.2); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); }

.table-dark-custom {
    color: #fff;
}

.table-dark-custom thead {
    background: rgba(249, 115, 22, 0.2);
    border-bottom: 2px solid rgba(249, 115, 22, 0.5);
}

.table-dark-custom thead th {
    color: #fff;
    font-weight: 600;
    border: none;
    padding: 1rem;
}

.table-dark-custom tbody tr {
    background: rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.2s ease;
}

.table-dark-custom tbody tr:hover {
    background: rgba(249, 115, 22, 0.15);
    transform: scale(1.01);
}

.table-dark-custom tbody td {
    color: rgba(255, 255, 255, 0.9);
    border: none;
    vertical-align: middle;
    padding: 1rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.action-btn:hover {
    transform: scale(1.1);
}

.form-control:focus, .form-select:focus {
    background: rgba(255, 255, 255, 0.1) !important;
    border-color: #f97316 !important;
    color: white !important;
    box-shadow: 0 0 0 0.25rem rgba(249, 115, 22, 0.25) !important;
}
</style>

<script>
let allBarang = [];

document.addEventListener('DOMContentLoaded', function() {
    loadCategories();
    loadData();
    
    // Image preview
    document.getElementById('addImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2097152) {
                showToast('Ukuran file maksimal 2MB!', 'warning');
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewAdd').innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail bg-dark border-secondary" style="max-height: 150px;">
                `;
            };
            reader.readAsDataURL(file);
        }
    });
});

function loadCategories() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/peminjaman/categories.php')
        .then(res => res.json())
        .then(data => {
            if (data.data) {
                const options = data.data.map(cat => `<option value="${cat.id}">${cat.name}</option>`).join('');
                document.getElementById('addCategoryId').innerHTML = '<option value="">-- Pilih Kategori --</option>' + options;
                document.getElementById('editCategoryId').innerHTML = '<option value="">-- Pilih Kategori --</option>' + options;
                document.getElementById('filterCategory').innerHTML = '<option value="">Semua Kategori</option>' + options;
                
                // Category list
                document.getElementById('categoryList').innerHTML = data.data.map(cat => `
                    <div class="d-flex justify-content-between align-items-center p-2 mb-2 rounded" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <span class="text-white">${cat.name}</span>
                        <span class="badge bg-warning text-dark">${cat.id}</span>
                    </div>
                `).join('');
            }
        });
}

function loadData() {
    const container = document.getElementById('barangContainer');
    const filterCat = document.getElementById('filterCategory').value;
    
    container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-warning"></div></div>';
    
    fetch('<?php echo BASE_URL; ?>/php-native/api/admin/barang-list.php', {
        headers: { 'Authorization': 'Bearer ' + getCookie('admin_token') }
    })
    .then(res => res.json())
    .then(data => {
        if (data.data) {
            allBarang = data.data;
            let filtered = filterCat ? data.data.filter(item => item.categoryId == filterCat) : data.data;
            
            if (filtered.length > 0) {
                container.innerHTML = `
                    <div class="table-responsive">
                        <table class="table table-dark-custom mb-0">
                            <thead>
                                <tr>
                                    <th width="80">ID</th>
                                    <th width="100">Gambar</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th width="120">Stok</th>
                                    <th width="150" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${filtered.map(item => `
                                    <tr>
                                        <td><span class="badge bg-secondary">#${item.id}</span></td>
                                        <td>
                                            ${item.image ? 
                                                `<img src="<?php echo BASE_URL; ?>/public/uploads/${item.image}" class="barang-img" alt="${item.name}">` : 
                                                '<div class="barang-img d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.1);"><i class="bi bi-image text-white-50 fs-4"></i></div>'
                                            }
                                        </td>
                                        <td class="fw-semibold text-white">${item.name}</td>
                                        <td><span class="badge bg-info">${item.category_name}</span></td>
                                        <td>
                                            <span class="stock-badge ${getStockClass(item.quantity)}">
                                                ${item.quantity}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-warning btn-sm action-btn me-1 text-dark" onclick="editBarang(${item.id})" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm action-btn" onclick="deleteBarang(${item.id}, '${item.name.replace(/'/g, "\\'")}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
            } else {
                container.innerHTML = '<p class="text-center text-white-50 py-5">Tidak ada barang dalam kategori ini</p>';
            }
        }
    })
    .catch(err => {
        console.error('Error:', err);
        container.innerHTML = '<p class="text-center text-danger py-5">Error loading data</p>';
    });
}

function getStockClass(quantity) {
    if (quantity > 10) return 'stock-high';
    if (quantity > 0) return 'stock-medium';
    return 'stock-low';
}

// Add Barang
document.getElementById('addBarangForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('name', document.getElementById('addName').value);
    formData.append('categoryId', document.getElementById('addCategoryId').value);
    formData.append('quantity', document.getElementById('addQuantity').value);
    
    const imageFile = document.getElementById('addImage').files[0];
    if (!imageFile) {
        showToast('Gambar wajib diupload!', 'warning');
        return;
    }
    
    if (imageFile.size > 2097152) {
        showToast('Ukuran file maksimal 2MB!', 'warning');
        return;
    }
    
    formData.append('image', imageFile);
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
    
    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/admin/barang-create.php', {
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + getCookie('admin_token') },
            body: formData
        });
        
        const data = await response.json();
        
        if (response.ok) {
            bootstrap.Modal.getInstance(document.getElementById('addBarangModal')).hide();
            showToast('Barang berhasil ditambahkan dengan gambar!', 'success');
            this.reset();
            document.getElementById('previewAdd').innerHTML = '';
            setTimeout(() => loadData(), 500);
        } else {
            throw new Error(data.error || 'Failed');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'danger');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-save me-2"></i> Simpan';
    }
});

// Edit Barang
function editBarang(id) {
    fetch(`<?php echo BASE_URL; ?>/php-native/api/admin/barang-detail.php?id=${id}`, {
        headers: { 'Authorization': 'Bearer ' + getCookie('admin_token') }
    })
    .then(res => res.json())
    .then(data => {
        if (data.data) {
            document.getElementById('editId').value = data.data.id;
            document.getElementById('editName').value = data.data.name;
            document.getElementById('editCategoryId').value = data.data.categoryId;
            document.getElementById('editQuantity').value = data.data.quantity;
            
            if (data.data.image) {
                document.getElementById('currentImagePreview').innerHTML = `
                    <p class="small text-white-50 mb-2">Gambar saat ini:</p>
                    <img src="<?php echo BASE_URL; ?>/public/uploads/${data.data.image}" 
                         class="img-thumbnail bg-dark border-secondary" style="max-width: 200px;">
                `;
            } else {
                document.getElementById('currentImagePreview').innerHTML = '<p class="text-white-50 small">Belum ada gambar</p>';
            }
            
            new bootstrap.Modal(document.getElementById('editBarangModal')).show();
        }
    })
    .catch(err => showToast('Error loading data', 'danger'));
}

document.getElementById('editBarangForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('id', document.getElementById('editId').value);
    formData.append('name', document.getElementById('editName').value);
    formData.append('categoryId', document.getElementById('editCategoryId').value);
    formData.append('quantity', document.getElementById('editQuantity').value);
    
    const imageFile = document.getElementById('editImage').files[0];
    if (imageFile) {
        if (imageFile.size > 2097152) {
            showToast('Ukuran file maksimal 2MB!', 'warning');
            return;
        }
        formData.append('image', imageFile);
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Updating...';
    
    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/admin/barang-update.php', {
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + getCookie('admin_token') },
            body: formData
        });
        
        const data = await response.json();
        
        if (response.ok) {
            bootstrap.Modal.getInstance(document.getElementById('editBarangModal')).hide();
            showToast('Barang berhasil diupdate!', 'success');
            setTimeout(() => loadData(), 500);
        } else {
            throw new Error(data.error || 'Failed');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'danger');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-save me-2"></i> Update';
    }
});

// Delete Barang
function deleteBarang(id, name) {
    if (!confirm(`Yakin ingin menghapus "${name}"?\n\nGambar juga akan dihapus.`)) return;
    
    fetch('<?php echo BASE_URL; ?>/php-native/api/admin/barang-delete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + getCookie('admin_token')
        },
        body: JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('Barang berhasil dihapus!', 'success');
            setTimeout(() => loadData(), 500);
        } else {
            throw new Error(data.error);
        }
    })
    .catch(err => showToast('Error: ' + err.message, 'danger'));
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
    toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'x-circle'} me-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

<?php include __DIR__ . '/../php-native/includes/footer.php'; ?>

