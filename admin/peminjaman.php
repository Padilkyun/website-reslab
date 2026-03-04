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

$pageTitle = 'Kelola Peminjaman';
$current_page = 'peminjaman';
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
                <h2 class="fw-bold text-white mb-1">Kelola Peminjaman</h2>
                <p class="text-white-50 mb-0">Manage user borrowing requests</p>
            </div>
            <button class="btn btn-outline-warning" onclick="loadAllData()">
                <i class="bi bi-arrow-clockwise me-2"></i> Refresh
            </button>
        </div>
        
        <!-- Filter Tabs - Dark -->
        <ul class="nav nav-tabs-dark mb-4" id="statusTabs">
            <li class="nav-item">
                <button class="nav-link active" data-status="pending" onclick="filterByStatus('pending', this)">
                    <i class="bi bi-clock me-1"></i> Pending
                    <span class="badge bg-warning text-dark ms-2" id="badge-pending">0</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-status="approved" onclick="filterByStatus('approved', this)">
                    <i class="bi bi-check-circle me-1"></i> Approved
                    <span class="badge bg-success ms-2" id="badge-approved">0</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-status="rejected" onclick="filterByStatus('rejected', this)">
                    <i class="bi bi-x-circle me-1"></i> Rejected
                    <span class="badge bg-danger ms-2" id="badge-rejected">0</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-status="all" onclick="filterByStatus('all', this)">
                    <i class="bi bi-list me-1"></i> All
                </button>
            </li>
        </ul>
        
        <!-- Peminjaman List -->
        <div id="peminjamanContainer">
            <div class="text-center py-5">
                <div class="spinner-border text-warning"></div>
            </div>
        </div>
    </div>
</main>

<!-- Modals - Dark Theme -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-0 shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-check-circle text-success me-2"></i> Konfirmasi Persetujuan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3">Apakah Anda yakin ingin menyetujui peminjaman ini?</p>
                <div class="alert alert-warning">
                    <small><strong><i class="bi bi-exclamation-triangle me-2"></i>Perhatian:</strong> Stok barang akan berkurang setelah disetujui.</small>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="confirmApprove">
                    <i class="bi bi-check-circle me-2"></i> Ya, Setujui
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-0 shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-x-circle text-danger me-2"></i> Konfirmasi Penolakan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea class="form-control bg-dark text-white border-secondary" id="rejectionReason" rows="4" placeholder="Masukkan alasan penolakan..." required style="resize: none;"></textarea>
                    <small class="text-white-50">Alasan akan dikirim ke user</small>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmReject">
                    <i class="bi bi-x-circle me-2"></i> Ya, Tolak
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.nav-tabs-dark {
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.nav-tabs-dark .nav-link {
    border: none;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    background: transparent;
    border-radius: 12px 12px 0 0;
}

.nav-tabs-dark .nav-link:hover {
    color: #f97316;
    background: rgba(249, 115, 22, 0.1);
}

.nav-tabs-dark .nav-link.active {
    color: #f97316;
    background: rgba(249, 115, 22, 0.15);
    font-weight: 600;
}

.nav-tabs-dark .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, #f97316, #fb923c);
}

.peminjaman-card-dark {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.peminjaman-card-dark:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
    border-color: rgba(249, 115, 22, 0.5);
}

.item-pill-dark {
    display: inline-block;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 0.4rem 1rem;
    margin: 0.25rem;
    font-size: 0.9rem;
    color: white;
}
</style>

<script>
let currentPeminjamanId = null;
let currentFilter = 'pending';

document.addEventListener('DOMContentLoaded', function() {
    loadAllData();
});

function loadAllData() {
    filterByStatus(currentFilter);
}

function filterByStatus(status, buttonElement) {
    currentFilter = status;
    
    document.querySelectorAll('#statusTabs .nav-link').forEach(btn => {
        btn.classList.remove('active');
    });
    if (buttonElement) {
        buttonElement.classList.add('active');
    }
    
    const container = document.getElementById('peminjamanContainer');
    container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-warning"></div></div>';
    
    const url = status === 'all' 
        ? '<?php echo BASE_URL; ?>/php-native/api/admin/peminjaman-all.php'
        : `<?php echo BASE_URL; ?>/php-native/api/admin/peminjaman-status.php?status=${status}`;
    
    fetch(url, {
        headers: { 'Authorization': 'Bearer ' + getCookie('admin_token') }
    })
    .then(res => res.json())
    .then(data => {
        updateBadgeCounts(data.data || []);
        
        if (data.data && data.data.length > 0) {
            container.innerHTML = data.data.map(item => `
                <div class="peminjaman-card-dark">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold text-white mb-1">
                                        <i class="bi bi-receipt me-2 text-warning"></i> Peminjaman #${item.id}
                                    </h5>
                                    <p class="text-white-50 small mb-0">
                                        <i class="bi bi-person me-1"></i> <strong>${item.user_nama}</strong> (${item.user_nim})
                                    </p>
                                    <p class="text-white-50 small mb-0">
                                        <i class="bi bi-envelope me-1"></i> ${item.user_email}
                                    </p>
                                </div>
                                <span class="badge bg-${getStatusColor(item.status)} px-3 py-2">
                                    ${getStatusText(item.status)}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <p class="text-white-50 small mb-1">
                                    <i class="bi bi-calendar me-1"></i> <strong>Diajukan:</strong> ${formatDateTime(item.submittedAt)}
                                </p>
                                ${item.approvedAt ? `<p class="text-white-50 small mb-0"><i class="bi bi-check me-1"></i> <strong>Diproses:</strong> ${formatDateTime(item.approvedAt)}</p>` : ''}
                            </div>
                            
                            <div class="mb-3">
                                <p class="text-white-50 small mb-1"><strong>Alasan:</strong></p>
                                <p class="text-white">${item.alasan || '-'}</p>
                            </div>
                            
                            ${item.rejectionReason ? `
                                <div class="alert alert-danger mb-3">
                                    <small><i class="bi bi-x-circle me-2"></i><strong>Ditolak:</strong> ${item.rejectionReason}</small>
                                </div>
                            ` : ''}
                            
                            <div class="mb-0">
                                <p class="text-white-50 small mb-2"><strong>Barang:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    ${item.items.map(barang => `
                                        <span class="item-pill-dark">
                                            <i class="bi bi-box me-1"></i> ${barang.barang_name} 
                                            <span class="badge bg-warning text-dark ms-1">${barang.quantity}</span>
                                        </span>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 text-end">
                            ${item.status === 'pending' ? `
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" onclick="showApprovalModal(${item.id})">
                                        <i class="bi bi-check-circle me-2"></i> Setujui
                                    </button>
                                    <button class="btn btn-danger" onclick="showRejectionModal(${item.id})">
                                        <i class="bi bi-x-circle me-2"></i> Tolak
                                    </button>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = `
                <div class="card-dark text-center py-5">
                    <i class="bi bi-inbox text-white-50" style="font-size: 4rem;"></i>
                    <p class="text-white-50 mt-3 mb-0">Tidak ada data peminjaman</p>
                </div>
            `;
        }
    })
    .catch(err => {
        console.error('Error:', err);
        container.innerHTML = '<div class="alert alert-danger">Error loading data</div>';
    });
}

function updateBadgeCounts(allData) {
    const pending = allData.filter(item => item.status === 'pending').length;
    const approved = allData.filter(item => item.status === 'approved').length;
    const rejected = allData.filter(item => item.status === 'rejected').length;
    
    document.getElementById('badge-pending').textContent = pending;
    document.getElementById('badge-approved').textContent = approved;
    document.getElementById('badge-rejected').textContent = rejected;
}

function showApprovalModal(id) {
    currentPeminjamanId = id;
    new bootstrap.Modal(document.getElementById('approvalModal')).show();
}

function showRejectionModal(id) {
    currentPeminjamanId = id;
    document.getElementById('rejectionReason').value = '';
    new bootstrap.Modal(document.getElementById('rejectionModal')).show();
}

document.getElementById('confirmApprove').addEventListener('click', async function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
    
    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/admin/peminjaman-approve.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getCookie('admin_token')
            },
            body: JSON.stringify({ peminjamanId: currentPeminjamanId })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            bootstrap.Modal.getInstance(document.getElementById('approvalModal')).hide();
            showToast('Peminjaman berhasil disetujui! Stok telah dikurangi.', 'success');
            setTimeout(() => loadAllData(), 500);
        } else {
            throw new Error(data.error || 'Failed to approve');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'danger');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Ya, Setujui';
    }
});

document.getElementById('confirmReject').addEventListener('click', async function() {
    const reason = document.getElementById('rejectionReason').value.trim();
    
    if (!reason) {
        showToast('Alasan penolakan wajib diisi!', 'warning');
        return;
    }
    
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
    
    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/admin/peminjaman-reject.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getCookie('admin_token')
            },
            body: JSON.stringify({ 
                peminjamanId: currentPeminjamanId,
                rejectionReason: reason
            })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            bootstrap.Modal.getInstance(document.getElementById('rejectionModal')).hide();
            showToast('Peminjaman berhasil ditolak.', 'success');
            setTimeout(() => loadAllData(), 500);
        } else {
            throw new Error(data.error || 'Failed to reject');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'danger');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-x-circle me-2"></i> Ya, Tolak';
    }
});

function getStatusColor(status) {
    return { 'pending': 'warning', 'approved': 'success', 'rejected': 'danger' }[status] || 'secondary';
}

function getStatusText(status) {
    return { 'pending': 'Pending', 'approved': 'Disetujui', 'rejected': 'Ditolak' }[status] || status;
}

function formatDateTime(dateString) {
    return new Date(dateString).toLocaleString('id-ID', {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
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
    toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : type === 'danger' ? 'x-circle' : 'exclamation-triangle'} me-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

<?php include __DIR__ . '/../php-native/includes/footer.php'; ?>

