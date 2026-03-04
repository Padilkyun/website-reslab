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

$pageTitle = 'Kelola Berita';
$current_page = 'berita';
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
                <h2 class="fw-bold text-white mb-1">Kelola Berita</h2>
                <p class="text-white-50 mb-0">Manage news and articles</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-warning" onclick="loadBerita()">
                    <i class="bi bi-arrow-clockwise me-2"></i> Refresh
                </button>
                <button class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#addBeritaModal">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Berita
                </button>
            </div>
        </div>
        
        <div class="card-dark">
            <div class="card-body-dark p-0">
                <div id="beritaContainer">
                    <div class="text-center py-5">
                        <div class="spinner-border text-warning"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Berita Modal - Dark -->
<div class="modal fade" id="addBeritaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white border-0 shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Tambah Berita Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addBeritaForm">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="addTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control bg-dark text-white border-secondary" id="addDate" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konten <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="addContent" rows="6" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar</label>
                        <input type="file" class="form-control bg-dark text-white border-secondary" id="addImageBerita" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="bi bi-save me-2"></i> Publish
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Berita Modal - Dark -->
<div class="modal fade" id="editBeritaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white border-0 shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Edit Berita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editBeritaForm">
                <input type="hidden" id="editId">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="editTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control bg-dark text-white border-secondary" id="editDate" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konten <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="editContent" rows="6" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar</label>
                        <input type="file" class="form-control bg-dark text-white border-secondary" id="editImageBerita" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadBerita();
    document.getElementById('addDate').valueAsDate = new Date();
});

function loadBerita() {
    const container = document.getElementById('beritaContainer');
    
    fetch('<?php echo BASE_URL; ?>/php-native/api/berita/index.php?limit=50')
        .then(res => res.json())
        .then(data => {
            if (data.data && data.data.length > 0) {
                container.innerHTML = `
                    <div class="table-responsive">
                        <table class="table table-dark-custom mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.data.map(item => `
                                    <tr>
                                        <td><span class="badge bg-secondary">#${item.id}</span></td>
                                        <td>
                                            ${item.image ? 
                                                `<img src="<?php echo BASE_URL; ?>/public/uploads/${item.image}" class="barang-img">` : 
                                                '<div class="barang-img d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.1);"><i class="bi bi-image text-white-50"></i></div>'
                                            }
                                        </td>
                                        <td class="fw-semibold text-white">${item.title}</td>
                                        <td class="text-white-50 small">${formatDate(item.date)}</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-warning action-btn me-2" onclick="editBerita(${item.id})">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger action-btn" onclick="deleteBerita(${item.id})">
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
                container.innerHTML = '<p class="text-center text-white-50 py-5">Belum ada berita</p>';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            container.innerHTML = '<p class="text-center text-danger py-5">Error loading berita</p>';
        });
}

document.getElementById('addBeritaForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('title', document.getElementById('addTitle').value);
    formData.append('date', document.getElementById('addDate').value);
    formData.append('content', document.getElementById('addContent').value);

    const imageFile = document.getElementById('addImageBerita').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/admin/berita-create.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showToast('Berita berhasil ditambahkan!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addBeritaModal')).hide();
            this.reset();
            loadBerita();
        } else {
            showToast(data.error || 'Gagal menambahkan berita', 'danger');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat menambahkan berita', 'danger');
    }
});

async function deleteBerita(id) {
    if (confirm('Yakin ingin menghapus berita ini?')) {
        try {
            const response = await fetch(`<?php echo BASE_URL; ?>/php-native/api/admin/berita-delete.php?id=${id}`, {
                method: 'DELETE'
            });

            const data = await response.json();

            if (data.success) {
                showToast('Berita berhasil dihapus!', 'success');
                loadBerita();
            } else {
                showToast(data.error || 'Gagal menghapus berita', 'danger');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat menghapus berita', 'danger');
        }
    }
}

async function editBerita(id) {
    try {
        // Get berita data
        const response = await fetch(`<?php echo BASE_URL; ?>/php-native/api/berita/detail.php?id=${id}`);
        const berita = await response.json();

        if (berita) {
            document.getElementById('editId').value = berita.id;
            document.getElementById('editTitle').value = berita.title;
            document.getElementById('editDate').value = berita.date.split(' ')[0]; // Extract date part
            document.getElementById('editContent').value = berita.content;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
            modal.show();
        } else {
            showToast('Berita tidak ditemukan', 'danger');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat memuat data berita', 'danger');
    }
}

document.getElementById('editBeritaForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('id', document.getElementById('editId').value);
    formData.append('title', document.getElementById('editTitle').value);
    formData.append('date', document.getElementById('editDate').value);
    formData.append('content', document.getElementById('editContent').value);

    const imageFile = document.getElementById('editImageBerita').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/admin/berita-update.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showToast('Berita berhasil diperbarui!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('editBeritaModal')).hide();
            this.reset();
            loadBerita();
        } else {
            showToast(data.error || 'Gagal memperbarui berita', 'danger');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat memperbarui berita', 'danger');
    }
});

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric', month: 'long', day: 'numeric'
    });
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed shadow-lg`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 12px;';
    toast.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

<?php include __DIR__ . '/../php-native/includes/footer.php'; ?>

