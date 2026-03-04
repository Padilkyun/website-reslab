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

$pageTitle = 'Kelola Project';
$current_page = 'project';
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
                <h2 class="fw-bold text-dark mb-1">Kelola Project</h2>
                <p class="text-muted mb-0">Manage research projects</p>
            </div>
            <button class="btn btn-primary" onclick="showToast('Fitur ini dalam pengembangan', 'info')">
                <i class="bi bi-plus-circle me-2"></i> Tambah Project
            </button>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-center text-muted py-5">
                    <i class="bi bi-wrench display-1 mb-3 d-block"></i>
                    Halaman ini sedang dalam pengembangan
                </p>
            </div>
        </div>
    </div>
</main>

<script>
function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed shadow-lg`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 12px;';
    toast.innerHTML = `<i class="bi bi-info-circle me-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

<?php include __DIR__ . '/../php-native/includes/footer.php'; ?>

