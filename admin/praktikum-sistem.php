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

$pageTitle = 'Kelola Praktikum Sistem Tertanam';
$current_page = 'praktikum-sistem';
include __DIR__ . '/../php-native/includes/header.php';
?>
<!-- Admin Dark Theme CSS -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/php-native/assets/css/admin-dark.css">

<?php include __DIR__ . '/includes/admin-nav.php'; ?>
?>

<main class="admin-content">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Kelola Praktikum Sistem Tertanam</h2>
                <p class="text-muted mb-0">Manage modules, registration, and software requirements</p>
            </div>
        </div>
        
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#modules">
                    <i class="bi bi-book me-2"></i> Modul
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#registration">
                    <i class="bi bi-clipboard-check me-2"></i> Link Pendaftaran
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#software">
                    <i class="bi bi-laptop me-2"></i> Software
                </button>
            </li>
        </ul>
        
        <div class="tab-content">
            <!-- Modules Tab -->
            <div class="tab-pane fade show active" id="modules">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Modul Praktikum PAR</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModuleModal">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Modul
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="modulesList">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Registration Tab -->
            <div class="tab-pane fade" id="registration">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Link Pendaftaran PAR</h5>
                    </div>
                    <div class="card-body">
                        <div id="registrationContent">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary"></div>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-3" onclick="updateRegistrationLink()">
                            <i class="bi bi-pencil me-2"></i> Update Link
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Software Tab -->
            <div class="tab-pane fade" id="software">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Kebutuhan Software PAR</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSoftwareModal">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Software
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="softwareList">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Module Modal -->
<div class="modal fade" id="addModuleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg" style="background: #1a1a1a !important; border: 1px solid rgba(255, 255, 255, 0.1) !important;">
            <div class="modal-header border-secondary" style="background: rgba(255, 255, 255, 0.03) !important;">
                <h5 class="modal-title fw-bold text-white">Tambah Modul Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addModuleForm" enctype="multipart/form-data">
                <div class="modal-body p-4" style="background: #1a1a1a !important;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-white">Judul Modul</label>
                        <input type="text" class="form-control bg-dark text-white" style="background: rgba(255, 255, 255, 0.05) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; color: white !important;" id="moduleTitle" name="title" placeholder="Contoh: Modul 4: Transistor" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-white">File PDF (Optional)</label>
                        <input type="file" class="form-control bg-dark text-white" style="background: rgba(255, 255, 255, 0.05) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; color: white !important;" id="moduleFile" name="file" accept=".pdf">
                    </div>
                </div>
                <div class="modal-footer border-secondary" style="background: rgba(255, 255, 255, 0.03) !important;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Software Modal -->
<div class="modal fade" id="addSoftwareModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg" style="background: #1a1a1a !important; border: 1px solid rgba(255, 255, 255, 0.1) !important;">
            <div class="modal-header border-secondary" style="background: rgba(255, 255, 255, 0.03) !important;">
                <h5 class="modal-title fw-bold text-white">Tambah Software</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addSoftwareForm">
                <div class="modal-body p-4" style="background: #1a1a1a !important;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-white">Nama Software</label>
                        <input type="text" class="form-control bg-dark text-white" style="background: rgba(255, 255, 255, 0.05) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; color: white !important;" id="softwareName" name="name" placeholder="Contoh: Arduino IDE" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-white">Link Website (Optional)</label>
                        <input type="url" class="form-control bg-dark text-white" style="background: rgba(255, 255, 255, 0.05) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; color: white !important;" id="softwareLink" name="link" placeholder="https://...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-white">File Installer (Optional)</label>
                        <input type="file" class="form-control bg-dark text-white" style="background: rgba(255, 255, 255, 0.05) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; color: white !important;" id="softwareFile" name="file">
                    </div>
                </div>
                <div class="modal-footer border-secondary" style="background: rgba(255, 255, 255, 0.03) !important;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const BASE_URL = '<?php echo BASE_URL; ?>';
document.addEventListener('DOMContentLoaded', function() {
    loadModules();
    loadRegistration();
    loadSoftware();
    
    // Tab click handlers
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            if (e.target.getAttribute('data-bs-target') === '#modules') loadModules();
            if (e.target.getAttribute('data-bs-target') === '#registration') loadRegistration();
            if (e.target.getAttribute('data-bs-target') === '#software') loadSoftware();
        });
    });
    
    // Form handlers
    document.getElementById('addModuleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addModule();
    });
    
    document.getElementById('addSoftwareForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addSoftware();
    });
});

function loadModules() {
    const container = document.getElementById('modulesList');
    
    fetch(BASE_URL + '/php-native/api/praktikum/sistem-tertanam/modules.php')
        .then(res => res.json())
        .then(data => {
            if (data.data && data.data.length > 0) {
                container.innerHTML = `
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: rgba(249, 115, 22, 0.2) !important;">
                                <tr>
                                    <th class="py-3">ID</th>
                                    <th class="py-3">Judul</th>
                                    <th class="py-3">File</th>
                                    <th class="py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.data.map(item => `
                                    <tr>
                                        <td><span class="badge bg-secondary">#${item.id}</span></td>
                                        <td class="fw-semibold">${item.title}</td>
                                        <td>
                                            ${item.file ? 
                                                `<a href="${BASE_URL}/public/uploads/${item.file}" target="_blank" class="text-primary">
                                                    <i class="bi bi-file-pdf me-1"></i> View File
                                                </a>` : 
                                                '<span class="text-muted small">Belum ada file</span>'
                                            }
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-danger" onclick="deleteModule(${item.id})">
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
                container.innerHTML = '<p class="text-center text-muted py-4">Belum ada modul</p>';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            container.innerHTML = '<p class="text-center text-danger py-4">Error loading modules</p>';
        });
}

function loadRegistration() {
    const container = document.getElementById('registrationContent');
    
    fetch(BASE_URL + '/php-native/api/praktikum/sistem-tertanam/registration.php')
        .then(res => res.json())
        .then(data => {
            if (data.data && data.data.length > 0) {
                const reg = data.data[0];
                container.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-white">Link Pendaftaran Aktif:</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-dark text-white" style="background: rgba(255, 255, 255, 0.05) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; color: white !important;" value="${reg.link}" readonly>
                            <a href="${reg.link}" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                        <small class="text-muted">Last updated: ${formatDate(reg.updatedAt)}</small>
                    </div>
                `;
            } else {
                container.innerHTML = '<p class="text-muted">Belum ada link pendaftaran</p>';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            container.innerHTML = '<p class="text-danger">Error loading registration</p>';
        });
}

function loadSoftware() {
    const container = document.getElementById('softwareList');
    
    fetch(BASE_URL + '/php-native/api/praktikum/sistem-tertanam/software.php')
        .then(res => res.json())
        .then(data => {
            if (data.data && data.data.length > 0) {
                container.innerHTML = `
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: rgba(249, 115, 22, 0.2) !important;">
                                <tr>
                                    <th class="py-3">ID</th>
                                    <th class="py-3">Nama Software</th>
                                    <th class="py-3">Link</th>
                                    <th class="py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.data.map(item => `
                                    <tr>
                                        <td><span class="badge bg-secondary">#${item.id}</span></td>
                                        <td class="fw-semibold">${item.name}</td>
                                        <td>
                                            ${item.link ? 
                                                `<a href="${item.link}" target="_blank" class="text-primary small">
                                                    <i class="bi bi-link-45deg me-1"></i> ${item.link.substring(0, 40)}...
                                                </a>` : 
                                                '<span class="text-muted small">No link</span>'
                                            }
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-danger" onclick="deleteSoftware(${item.id})">
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
                container.innerHTML = '<p class="text-center text-muted py-4">Belum ada software requirement</p>';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            container.innerHTML = '<p class="text-center text-danger py-4">Error loading software</p>';
        });
}

function addModule() {
    const formData = new FormData(document.getElementById('addModuleForm'));
    
    fetch(BASE_URL + '/php-native/api/praktikum/sistem-tertanam/modules.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('Modul berhasil ditambahkan!', 'success');
            document.getElementById('addModuleForm').reset();
            bootstrap.Modal.getInstance(document.getElementById('addModuleModal')).hide();
            loadModules();
        } else {
            showToast(data.error || 'Gagal menambahkan modul', 'error');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        showToast('Terjadi kesalahan', 'error');
    });
}

function addSoftware() {
    const formData = new FormData(document.getElementById('addSoftwareForm'));
    
    fetch(BASE_URL + '/php-native/api/praktikum/sistem-tertanam/software.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('Software berhasil ditambahkan!', 'success');
            document.getElementById('addSoftwareForm').reset();
            bootstrap.Modal.getInstance(document.getElementById('addSoftwareModal')).hide();
            loadSoftware();
        } else {
            showToast(data.error || 'Gagal menambahkan software', 'error');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        showToast('Terjadi kesalahan', 'error');
    });
}

function updateRegistrationLink() {
    const newLink = prompt('Masukkan link pendaftaran baru (Google Form):');
    if (newLink) {
        fetch(BASE_URL + '/php-native/api/praktikum/sistem-tertanam/registration.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ link: newLink })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Link pendaftaran berhasil diupdate!', 'success');
                loadRegistration();
            } else {
                showToast(data.error || 'Gagal update link', 'error');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showToast('Terjadi kesalahan', 'error');
        });
    }
}

function deleteModule(id) {
    if (confirm('Yakin ingin menghapus modul ini?')) {
        fetch(BASE_URL + '/php-native/api/praktikum/sistem-tertanam/modules.php?id=' + id, {
            method: 'DELETE'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Modul berhasil dihapus!', 'success');
                loadModules();
            } else {
                showToast(data.error || 'Gagal menghapus modul', 'error');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showToast('Terjadi kesalahan', 'error');
        });
    }
}

function deleteSoftware(id) {
    if (confirm('Yakin ingin menghapus software ini?')) {
        fetch(BASE_URL + '/php-native/api/praktikum/sistem-tertanam/software.php?id=' + id, {
            method: 'DELETE'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Software berhasil dihapus!', 'success');
                loadSoftware();
            } else {
                showToast(data.error || 'Gagal menghapus software', 'error');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showToast('Terjadi kesalahan', 'error');
        });
    }
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID');
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
    toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

<?php include __DIR__ . '/../php-native/includes/footer.php'; ?>


