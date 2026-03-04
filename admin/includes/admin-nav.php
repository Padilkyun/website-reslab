<?php
$current_page = $current_page ?? basename($_SERVER['PHP_SELF'], '.php');
?>

<!-- Admin Navbar - Dark Theme -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-bottom: 2px solid #f97316;">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?php echo BASE_URL; ?>/admin/dashboard.php">
            <img src="<?php echo BASE_URL; ?>/public/reslabtrans.png" alt="ResLab" height="35" class="me-2">
            <span class="text-gradient">ResLab Admin</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/dashboard.php">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['berita', 'project']) ? 'active' : ''; ?>" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-newspaper me-1"></i> Konten
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/berita.php">
                            <i class="bi bi-newspaper me-2"></i> Berita
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/project.php">
                            <i class="bi bi-lightbulb me-2"></i> Project
                        </a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'barang' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/barang.php">
                        <i class="bi bi-box-seam me-1"></i> Barang
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'peminjaman' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/peminjaman.php">
                        <i class="bi bi-clipboard-check me-1"></i> Peminjaman
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['praktikum-par', 'praktikum-rangkaian', 'praktikum-sistem']) ? 'active' : ''; ?>" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-book me-1"></i> Praktikum
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/praktikum-par.php">
                            <i class="bi bi-cpu me-2"></i> PAR
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/praktikum-rangkaian.php">
                            <i class="bi bi-lightning me-2"></i> Rangkaian Listrik
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/praktikum-sistem.php">
                            <i class="bi bi-gear me-2"></i> Sistem Tertanam
                        </a></li>
                    </ul>
                </li>
            </ul>
            
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i>
                        <?php echo htmlspecialchars($adminData['username']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <li><h6 class="dropdown-header text-warning">Admin Account</h6></li>
                        <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>/logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
.text-gradient {
    background: linear-gradient(135deg, #f97316, #fb923c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.navbar-dark .nav-link {
    color: rgba(255, 255, 255, 0.85);
    transition: all 0.3s ease;
    position: relative;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    margin: 0 0.25rem;
}

.navbar-dark .nav-link:hover {
    color: #f97316;
    background: rgba(249, 115, 22, 0.1);
}

.navbar-dark .nav-link.active {
    color: #f97316;
    background: rgba(249, 115, 22, 0.15);
    font-weight: 600;
}

.dropdown-menu-dark {
    background: #2d2d2d;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    border-radius: 12px;
    padding: 0.5rem;
}

.dropdown-menu-dark .dropdown-item {
    color: rgba(255, 255, 255, 0.85);
    border-radius: 8px;
    padding: 0.6rem 1rem;
    transition: all 0.2s ease;
}

.dropdown-menu-dark .dropdown-item:hover {
    background: rgba(249, 115, 22, 0.2);
    color: #f97316;
}

.dropdown-menu-dark .dropdown-header {
    color: rgba(255, 255, 255, 0.6);
}
</style>
