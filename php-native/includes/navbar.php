<?php
// Check if user is logged in
$isLoggedIn = false;
$userName = '';

if (isset($_COOKIE['auth_token'])) {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/auth.php';
    $user = getUserFromToken();
    if ($user) {
        $isLoggedIn = true;
        $userName = $user['nama'] ?? $user['email'] ?? 'User';
    }
}

// Get current page for active link
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid px-lg-5">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>/index.php">
            <img src="<?php echo BASE_URL; ?>/public/reslabtrans.png" alt="ResLab Logo" height="45" width="45" class="me-2">
            <div>
                <div class="fw-bold" style="font-size: 1.3rem; line-height: 1.2;">RESLAB</div>
                <div class="small" style="font-size: 0.65rem; opacity: 0.9;">Robotics and Embedded System Laboratory</div>
            </div>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/index.php">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-info-circle me-1"></i> About
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aboutDropdown">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/about.php">
                            <i class="bi bi-bullseye me-2"></i> Visi & Misi
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/struktur-organisasi.php">
                            <i class="bi bi-diagram-3 me-2"></i> Struktur Organisasi
                        </a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'praktikum.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/praktikum.php">
                        <i class="bi bi-book me-1"></i> Praktikum
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-newspaper me-1"></i> Informasi
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="infoDropdown">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/berita.php">
                            <i class="bi bi-newspaper me-2"></i> Berita
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/project.php">
                            <i class="bi bi-lightbulb me-2"></i> Project
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/sop.php">
                            <i class="bi bi-file-text me-2"></i> SOP Labor & Peminjaman
                        </a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'peminjaman.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/peminjaman.php">
                        <i class="bi bi-box-seam me-1"></i> Peminjaman
                    </a>
                </li>
                
                <li class="nav-item ms-lg-3">
                    <?php if ($isLoggedIn): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars(substr($userName, 0, 15)); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile.php">
                                    <i class="bi bi-person me-2"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>/logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/auth-login.php" class="btn btn-outline-light">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
