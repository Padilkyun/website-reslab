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

$pageTitle = 'Admin Dashboard';
$current_page = 'dashboard';
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
                <h2 class="fw-bold text-white mb-1">Dashboard</h2>
                <p class="text-white-50 mb-0">Selamat datang kembali, <span class="text-warning"><?php echo htmlspecialchars($adminData['username']); ?></span>!</p>
            </div>
            <button class="btn btn-outline-warning" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise me-2"></i> Refresh
            </button>
        </div>
        
        <!-- Statistics Cards - Dark Theme -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card-dark bg-gradient-primary">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-details">
                        <h3 class="stat-number" id="totalUsers">0</h3>
                        <p class="stat-label">Total Users</p>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stat-card-dark bg-gradient-success">
                    <div class="stat-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="stat-details">
                        <h3 class="stat-number" id="totalBarang">0</h3>
                        <p class="stat-label">Total Barang</p>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stat-card-dark bg-gradient-warning">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-details">
                        <h3 class="stat-number" id="pendingPeminjaman">0</h3>
                        <p class="stat-label">Pending Peminjaman</p>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stat-card-dark bg-gradient-info">
                    <div class="stat-icon">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <div class="stat-details">
                        <h3 class="stat-number" id="totalBerita">0</h3>
                        <p class="stat-label">Total Berita</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity - Dark Theme -->
        <div class="row">
            <div class="col-12">
                <div class="card-dark">
                    <div class="card-header-dark">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="bi bi-activity me-2 text-warning"></i> Peminjaman Terbaru
                        </h5>
                    </div>
                    <div class="card-body-dark">
                        <div id="recentPeminjamanContainer">
                            <div class="text-center py-5">
                                <div class="spinner-border text-warning"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.admin-content-dark {
    min-height: calc(100vh - 60px);
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
}

.stat-card-dark {
    border-radius: 16px;
    padding: 1.5rem;
    color: white;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.stat-card-dark:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
    border-color: rgba(249, 115, 22, 0.5);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.9;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.stat-label {
    font-size: 0.9rem;
    margin: 0;
    opacity: 0.95;
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
}

.table-dark-custom tbody tr {
    background: rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.2s ease;
}

.table-dark-custom tbody tr:hover {
    background: rgba(249, 115, 22, 0.1);
    transform: scale(1.01);
}

.table-dark-custom tbody td {
    color: rgba(255, 255, 255, 0.9);
    border: none;
    vertical-align: middle;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardStats();
    loadRecentPeminjaman();
});

function loadDashboardStats() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/admin/dashboard-stats.php', {
        headers: { 'Authorization': 'Bearer ' + getCookie('admin_token') }
    })
    .then(res => res.json())
    .then(data => {
        if (data.data) {
            animateNumber('totalUsers', data.data.totalUsers || 0);
            animateNumber('totalBarang', data.data.totalBarang || 0);
            animateNumber('pendingPeminjaman', data.data.pendingPeminjaman || 0);
            animateNumber('totalBerita', data.data.totalBerita || 0);
        }
    })
    .catch(err => console.error('Error:', err));
}

function animateNumber(elementId, target) {
    const element = document.getElementById(elementId);
    let current = 0;
    const increment = target / 30;
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.ceil(current);
        }
    }, 30);
}

function loadRecentPeminjaman() {
    const container = document.getElementById('recentPeminjamanContainer');
    
    fetch('<?php echo BASE_URL; ?>/php-native/api/admin/peminjaman-list.php?limit=5', {
        headers: { 'Authorization': 'Bearer ' + getCookie('admin_token') }
    })
    .then(res => res.json())
    .then(data => {
        if (data.data && data.data.length > 0) {
            container.innerHTML = `
                <div class="table-responsive">
                    <table class="table table-dark-custom mb-0">
                        <thead>
                            <tr>
                                <th class="py-3">ID</th>
                                <th class="py-3">User</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Tanggal</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.data.map(item => `
                                <tr>
                                    <td><span class="badge bg-secondary">#${item.id}</span></td>
                                    <td class="fw-semibold">${item.user_nama}</td>
                                    <td class="text-white-50 small">${item.user_email}</td>
                                    <td class="text-white-50 small">${formatDate(item.submittedAt)}</td>
                                    <td><span class="badge bg-${getStatusColor(item.status)}">${getStatusText(item.status)}</span></td>
                                    <td class="text-end">
                                        <a href="<?php echo BASE_URL; ?>/admin/peminjaman.php" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            container.innerHTML = '<p class="text-center text-white-50 py-5">Belum ada peminjaman</p>';
        }
    })
    .catch(err => {
        console.error('Error:', err);
        container.innerHTML = '<p class="text-center text-danger py-5">Error loading data</p>';
    });
}

function getStatusColor(status) {
    const colors = { 'pending': 'warning', 'approved': 'success', 'rejected': 'danger' };
    return colors[status] || 'secondary';
}

function getStatusText(status) {
    const text = { 'pending': 'Pending', 'approved': 'Approved', 'rejected': 'Rejected' };
    return text[status] || status;
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric', month: 'short', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
</script>

<?php include __DIR__ . '/../php-native/includes/footer.php'; ?>

