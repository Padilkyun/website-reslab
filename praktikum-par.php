<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Praktikum PAR';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<main class="py-5" style="min-height: 100vh; background: rgba(0,0,0,0.3);">
    <div class="container py-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-white mb-3">Praktikum PAR</h1>
            <p class="lead text-white-50">Pengolahan Arus dan Rangkaian</p>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-pills justify-content-center mb-5" id="praktikumTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="modul-tab" data-bs-toggle="pill" data-bs-target="#modul" type="button">
                    <i class="bi bi-book me-2"></i> Modul Praktikum
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pendaftaran-tab" data-bs-toggle="pill" data-bs-target="#pendaftaran" type="button">
                    <i class="bi bi-clipboard-check me-2"></i> Pendaftaran
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="software-tab" data-bs-toggle="pill" data-bs-target="#software" type="button">
                    <i class="bi bi-download me-2"></i> Kebutuhan Software
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="praktikumTabContent">
            <!-- Modul Praktikum -->
            <div class="tab-pane fade show active" id="modul" role="tabpanel">
                <div class="row g-4" id="modulList">
                    <div class="col-12 text-center">
                        <div class="spinner-border text-warning" role="status"></div>
                    </div>
                </div>
            </div>

            <!-- Pendaftaran -->
            <div class="tab-pane fade" id="pendaftaran" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="glassmorphism-card">
                            <h3 class="text-white mb-4">
                                <i class="bi bi-calendar-check me-2"></i> Link Pendaftaran Praktikum PAR
                            </h3>
                            <div id="registrationContent">
                                <div class="text-center">
                                    <div class="spinner-border text-warning" role="status"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kebutuhan Software -->
            <div class="tab-pane fade" id="software" role="tabpanel">
                <div class="row g-4" id="softwareList">
                    <div class="col-12 text-center">
                        <div class="spinner-border text-warning" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.nav-pills .nav-link {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    margin: 0 0.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background: rgba(249, 115, 22, 0.3);
    border-color: var(--primary-color);
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-color: var(--primary-color);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadModules();
    loadRegistration();
    loadSoftware();
});

function loadModules() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/praktikum/par/modules.php')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('modulList');
            if (data.data && data.data.length > 0) {
                container.innerHTML = data.data.map(item => `
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-gradient rounded-circle p-3 me-3">
                                        <i class="bi bi-file-earmark-pdf text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title text-white mb-0">${item.title}</h5>
                                    </div>
                                </div>
                                ${item.file ? `
                                    <a href="<?php echo BASE_URL; ?>/public/uploads/${item.file}" 
                                       class="btn btn-primary w-100" download>
                                        <i class="bi bi-download me-2"></i> Download Modul
                                    </a>
                                ` : '<p class="text-muted small">File belum tersedia</p>'}
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-info glassmorphism border-0">
                            <i class="bi bi-info-circle me-2"></i> Belum ada modul tersedia
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            document.getElementById('modulList').innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger glassmorphism border-0">
                        <i class="bi bi-x-circle me-2"></i> Error loading modules
                    </div>
                </div>
            `;
        });
}

function loadRegistration() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/praktikum/par/registration.php')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('registrationContent');
            if (data.data && data.data.length > 0) {
                const reg = data.data[0];
                container.innerHTML = `
                    <div class="text-center">
                        <p class="text-white-50 mb-4">Silakan klik tombol di bawah untuk mendaftar praktikum PAR</p>
                        <a href="${reg.link}" target="_blank" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-box-arrow-up-right me-2"></i> Daftar Sekarang
                        </a>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="alert alert-warning glassmorphism border-0 mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i> Link pendaftaran belum tersedia
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            document.getElementById('registrationContent').innerHTML = `
                <div class="alert alert-danger glassmorphism border-0 mb-0">
                    <i class="bi bi-x-circle me-2"></i> Error loading registration
                </div>
            `;
        });
}

function loadSoftware() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/praktikum/par/software.php')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('softwareList');
            if (data.data && data.data.length > 0) {
                container.innerHTML = data.data.map(item => `
                    <div class="col-md-6">
                        <div class="card h-100 border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success bg-gradient rounded-circle p-3 me-3">
                                        <i class="bi bi-laptop text-white fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title text-white mb-0">${item.name}</h5>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    ${item.link ? `
                                        <a href="${item.link}" target="_blank" class="btn btn-outline-light btn-sm flex-grow-1">
                                            <i class="bi bi-link-45deg me-1"></i> Website
                                        </a>
                                    ` : ''}
                                    ${item.file ? `
                                        <a href="<?php echo BASE_URL; ?>/public/uploads/${item.file}" 
                                           class="btn btn-primary btn-sm flex-grow-1" download>
                                            <i class="bi bi-download me-1"></i> Download
                                        </a>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-info glassmorphism border-0">
                            <i class="bi bi-info-circle me-2"></i> Belum ada software requirement
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            document.getElementById('softwareList').innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger glassmorphism border-0">
                        <i class="bi bi-x-circle me-2"></i> Error loading software
                    </div>
                </div>
            `;
        });
}
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
