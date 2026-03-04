<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Praktikum';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<main class="py-5" style="min-height: 100vh; background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bold text-white mb-3">Praktikum ResLab</h1>
            <p class="lead text-white-50">Pilih praktikum yang ingin Anda ikuti</p>
        </div>
        
        <div class="row g-4">
            <!-- PAR -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <a href="<?php echo BASE_URL; ?>/praktikum-par.php" class="text-decoration-none">
                    <div class="glassmorphism-card text-center h-100" style="min-height: 350px; display: flex; flex-direction: column; justify-content: center;">
                        <div class="mb-4">
                            <div class="bg-primary bg-gradient rounded-circle d-inline-flex p-4">
                                <i class="bi bi-cpu text-white" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h3 class="text-white fw-bold mb-3">PAR</h3>
                        <p class="text-white-50 mb-4">Praktikum Pengolahan Arus dan Rangkaian</p>
                        <div class="mt-auto">
                            <span class="btn btn-primary">
                                Lihat Detail <i class="bi bi-arrow-right ms-2"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Rangkaian Listrik -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <a href="<?php echo BASE_URL; ?>/praktikum-rangkaian-listrik.php" class="text-decoration-none">
                    <div class="glassmorphism-card text-center h-100" style="min-height: 350px; display: flex; flex-direction: column; justify-content: center;">
                        <div class="mb-4">
                            <div class="bg-warning bg-gradient rounded-circle d-inline-flex p-4">
                                <i class="bi bi-lightning text-white" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h3 class="text-white fw-bold mb-3">Rangkaian Listrik</h3>
                        <p class="text-white-50 mb-4">Praktikum Rangkaian Listrik dan Elektronika</p>
                        <div class="mt-auto">
                            <span class="btn btn-primary">
                                Lihat Detail <i class="bi bi-arrow-right ms-2"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Sistem Tertanam -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <a href="<?php echo BASE_URL; ?>/praktikum-sistem-tertanam.php" class="text-decoration-none">
                    <div class="glassmorphism-card text-center h-100" style="min-height: 350px; display: flex; flex-direction: column; justify-content: center;">
                        <div class="mb-4">
                            <div class="bg-success bg-gradient rounded-circle d-inline-flex p-4">
                                <i class="bi bi-gear text-white" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h3 class="text-white fw-bold mb-3">Sistem Tertanam</h3>
                        <p class="text-white-50 mb-4">Praktikum Embedded System dan IoT</p>
                        <div class="mt-auto">
                            <span class="btn btn-primary">
                                Lihat Detail <i class="bi bi-arrow-right ms-2"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Info Section -->
        <div class="row mt-5">
            <div class="col-12" data-aos="fade-up">
                <div class="glassmorphism-card">
                    <h3 class="text-white mb-4">
                        <i class="bi bi-info-circle me-2"></i> Informasi Praktikum
                    </h3>
                    <p class="lead text-white-50 mb-4">ResLab menyediakan 3 praktikum utama yang dirancang untuk memberikan pengalaman hands-on dalam bidang elektronika dan sistem tertanam.</p>
                    
                    <div class="row g-4 mt-4">
                        <div class="col-md-6">
                            <div class="p-4 rounded-3" style="background: rgba(249, 115, 22, 0.1); border: 1px solid rgba(249, 115, 22, 0.3);">
                                <h5 class="text-warning mb-3">
                                    <i class="bi bi-clipboard-check me-2"></i> Persyaratan
                                </h5>
                                <ul class="text-white-50 mb-0">
                                    <li>Mahasiswa aktif Teknik Elektro</li>
                                    <li>Telah lulus mata kuliah prasyarat</li>
                                    <li>Mendaftar sesuai jadwal yang ditentukan</li>
                                    <li>Mengikuti SOP laboratorium</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="p-4 rounded-3" style="background: rgba(251, 146, 60, 0.1); border: 1px solid rgba(251, 146, 60, 0.3);">
                                <h5 class="text-warning mb-3">
                                    <i class="bi bi-calendar-event me-2"></i> Jadwal
                                </h5>
                                <ul class="text-white-50 mb-0">
                                    <li>Pendaftaran: Awal semester</li>
                                    <li>Pelaksanaan: Sesuai jadwal kuliah</li>
                                    <li>Durasi: 1 semester (14 pertemuan)</li>
                                    <li>Ujian: Akhir semester</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true
});
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
