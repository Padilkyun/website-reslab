<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Home';
$customCSS = '
/* Hero Section with Animated Background */
.hero-section {
    min-height: 100vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
}

.animated-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 0;
}

.floating-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.6;
    animation: floatOrb 25s infinite ease-in-out;
}

.orb1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(249, 115, 22, 0.4) 0%, transparent 70%);
    top: -10%;
    left: -10%;
    animation-delay: 0s;
}

.orb2 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(251, 146, 60, 0.3) 0%, transparent 70%);
    top: 40%;
    right: -15%;
    animation-delay: 8s;
}

.orb3 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(234, 88, 12, 0.35) 0%, transparent 70%);
    bottom: -10%;
    left: 30%;
    animation-delay: 16s;
}

@keyframes floatOrb {
    0%, 100% { 
        transform: translate(0, 0) scale(1);
    }
    25% { 
        transform: translate(50px, -50px) scale(1.1);
    }
    50% { 
        transform: translate(-30px, 30px) scale(0.9);
    }
    75% { 
        transform: translate(40px, -20px) scale(1.05);
    }
}

.hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
}

.hero-title {
    font-size: clamp(4rem, 12vw, 8rem);
    font-weight: 900;
    letter-spacing: -0.03em;
    background: linear-gradient(135deg, #fff 0%, #f97316 50%, #fb923c 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
    text-shadow: 0 10px 40px rgba(249, 115, 22, 0.3);
}

.hero-subtitle {
    font-size: clamp(1rem, 2vw, 1.5rem);
    color: #fbbf24;
    font-weight: 300;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 3rem;
}

.hero-cards {
    position: relative;
    z-index: 10;
    margin-top: 4rem;
}

.stats-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 2rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.stats-card:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(249, 115, 22, 0.5);
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 60px rgba(249, 115, 22, 0.3);
}

.video-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
}

.video-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    border-color: rgba(249, 115, 22, 0.5);
}

.video-thumbnail {
    position: relative;
    height: 300px;
    background-size: cover;
    background-position: center;
    overflow: hidden;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.video-card:hover .video-overlay {
    opacity: 1;
}

.pulse-ring {
    position: absolute;
    width: 100px;
    height: 100px;
    border: 3px solid rgba(249, 115, 22, 0.8);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(0.8);
        opacity: 1;
    }
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}
';

include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<!-- Hero Section with Animated Background -->
<section class="hero-section">
    <div class="animated-bg">
        <div class="floating-orb orb1"></div>
        <div class="floating-orb orb2"></div>
        <div class="floating-orb orb3"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title" data-aos="fade-up">RESLAB</h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                Robotics and Embedded System Laboratory
            </p>
            
            <div class="row g-4 justify-content-center mt-5" data-aos="fade-up" data-aos-delay="200">
                <!-- Video Profile Card -->
                <div class="col-lg-5 col-md-6">
                    <div class="video-card">
                        <div class="video-thumbnail" style="background-image: url('<?php echo BASE_URL; ?>/public/anggota.JPG');">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <img src="<?php echo BASE_URL; ?>/public/reslabtrans.png" alt="ResLab" style="width: 80px; height: 80px; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.7));">
                            </div>
                            <div class="video-overlay">
                                <div class="pulse-ring"></div>
                                <a href="https://www.youtube.com/watch?v=axBN-QmYBqY&t=1s" target="_blank" class="btn btn-warning btn-lg rounded-circle position-relative" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-play-fill" style="font-size: 2rem;"></i>
                                </a>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <a href="https://www.youtube.com/watch?v=axBN-QmYBqY&t=62s" target="_blank" class="text-white text-decoration-none fw-semibold">
                                <i class="bi bi-play-circle me-2"></i> Video Profile
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Stats Card -->
                <div class="col-lg-5 col-md-6">
                    <div class="stats-card h-100 d-flex flex-column justify-content-around">
                        <div class="text-end">
                            <div class="display-3 fw-bold text-gradient mb-2 counter" data-target="20">0</div>
                            <p class="text-white-50 mb-0 small">Pengabdian Masyarakat</p>
                        </div>
                        <div class="text-end">
                            <div class="display-3 fw-bold text-gradient mb-2 counter" data-target="32">0</div>
                            <p class="text-white-50 mb-0 small">Project and Research</p>
                        </div>
                        <div class="text-end">
                            <div class="display-3 fw-bold text-gradient mb-2 counter" data-target="3">0</div>
                            <p class="text-white-50 mb-0 small">Praktikum</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Expertise Section -->
<section class="py-5" style="background: linear-gradient(180deg, #0a0a0a 0%, #1a1a1a 100%);">
    <div class="container py-5">
        <h2 class="display-4 fw-bold text-center text-white mb-5" data-aos="fade-up">Our Expertise</h2>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                <div class="glassmorphism-card text-center h-100">
                    <div class="mb-3">
                        <img src="<?php echo BASE_URL; ?>/public/AI.png" alt="AI" style="height: 80px; width: 80px; object-fit: contain;">
                    </div>
                    <h5 class="text-white fw-semibold">Artificial Intelligence</h5>
                    <p class="text-white-50 small mt-2">Machine Learning & Deep Learning</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="glassmorphism-card text-center h-100">
                    <div class="mb-3">
                        <img src="<?php echo BASE_URL; ?>/public/iot.png" alt="IoT" style="height: 80px; width: 80px; object-fit: contain;">
                    </div>
                    <h5 class="text-white fw-semibold">Internet of Things</h5>
                    <p class="text-white-50 small mt-2">Smart Devices & Connectivity</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="glassmorphism-card text-center h-100">
                    <div class="mb-3">
                        <img src="<?php echo BASE_URL; ?>/public/AR.png" alt="AR/VR" style="height: 80px; width: 80px; object-fit: contain;">
                    </div>
                    <h5 class="text-white fw-semibold">AR/VR Technology</h5>
                    <p class="text-white-50 small mt-2">Augmented & Virtual Reality</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="glassmorphism-card text-center h-100">
                    <div class="mb-3">
                        <img src="<?php echo BASE_URL; ?>/public/3d.png" alt="Robotics" style="height: 80px; width: 80px; object-fit: contain;">
                    </div>
                    <h5 class="text-white fw-semibold">Robotics</h5>
                    <p class="text-white-50 small mt-2">Autonomous Systems & Automation</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sensor Data Section -->
<section class="py-5" style="background: #0a0a0a;">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="0">
                <div class="glassmorphism-card text-center position-relative">
                    <img src="<?php echo BASE_URL; ?>/public/thermometer.png" alt="Temperature" class="position-absolute top-0 start-0 m-3" style="width: 40px; height: 40px; opacity: 0.5;">
                    <div class="liquid-wave rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 160px; height: 160px; background: linear-gradient(135deg, #ea580c, #f97316); box-shadow: 0 10px 40px rgba(234, 88, 12, 0.5);">
                        <h2 class="mb-0 fw-bold text-white" id="temperature" style="z-index: 10; position: relative; font-size: 2rem;">-</h2>
                    </div>
                    <h5 class="text-white fw-semibold mt-3">Temperature</h5>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="glassmorphism-card text-center position-relative">
                    <img src="<?php echo BASE_URL; ?>/public/humidity.png" alt="Humidity" class="position-absolute top-0 start-0 m-3" style="width: 40px; height: 40px; opacity: 0.5;">
                    <div class="liquid-wave rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 160px; height: 160px; background: linear-gradient(135deg, #0284c7, #0ea5e9); box-shadow: 0 10px 40px rgba(14, 165, 233, 0.5);">
                        <h2 class="mb-0 fw-bold text-white" id="humidity" style="z-index: 10; position: relative; font-size: 2rem;">-</h2>
                    </div>
                    <h5 class="text-white fw-semibold mt-3">Humidity</h5>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="glassmorphism-card text-center position-relative">
                    <img src="<?php echo BASE_URL; ?>/public/visitor.png" alt="Visitors" class="position-absolute top-0 start-0 m-3" style="width: 40px; height: 40px; opacity: 0.5;">
                    <div class="liquid-wave rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 160px; height: 160px; background: linear-gradient(135deg, #2563eb, #3b82f6); box-shadow: 0 10px 40px rgba(59, 130, 246, 0.5);">
                        <h2 class="mb-0 fw-bold text-white" id="visitors" style="z-index: 10; position: relative; font-size: 2rem;">-</h2>
                    </div>
                    <h5 class="text-white fw-semibold mt-3">Visitors</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About ResLab Section -->
<section class="py-5" style="background: linear-gradient(180deg, #0a0a0a 0%, #1a1a1a 100%);">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="display-5 fw-bold text-white mb-4">Robotics and Embedded System Laboratory</h2>
                <p class="lead text-white-50 mb-4">Laboratorium ResLab adalah fasilitas penelitian dan pengembangan teknologi yang berfokus pada inovasi dan solusi praktis di bidang elektronika, pemrograman, dan sistem tertanam.</p>
                <p class="text-white-50">Kami menyediakan lingkungan yang mendukung kolaborasi dan eksperimen untuk menghasilkan produk dan pengetahuan yang bermanfaat bagi masyarakat.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="<?php echo BASE_URL; ?>/public/arduinoo.png" alt="Arduino" class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Berita Section -->
<section class="py-5" style="background: #0a0a0a;">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-white mb-3">Berita Terbaru</h2>
            <p class="text-white-50">Update terkini dari ResLab</p>
        </div>
        <div class="row g-4" id="beritaList">
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status"></div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="py-5" style="background: #1a1a1a;">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="p-1 rounded-4" style="background: linear-gradient(135deg, #f97316, #fb923c); box-shadow: 0 10px 40px rgba(249, 115, 22, 0.3);">
                    <div class="p-5 rounded-4 text-white text-center d-flex flex-column justify-content-center" style="min-height: 300px; background: rgba(0,0,0,0.85);">
                        <i class="bi bi-bullseye display-4 text-warning mb-3"></i>
                        <h3 class="fw-bold mb-4">Visi ResLab</h3>
                        <p class="lead mb-0">Menjadi laboratorium terdepan dalam inovasi robotika dan sistem tertanam yang berkontribusi pada kemajuan teknologi dan masyarakat.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="mb-3 p-1 rounded-4" style="background: linear-gradient(135deg, #f97316, #fb923c);">
                    <div class="p-4 rounded-4 text-white" style="background: rgba(0,0,0,0.85);">
                        <h5 class="fw-bold mb-3"><i class="bi bi-1-circle me-2 text-warning"></i> Misi 1</h5>
                        <p class="mb-0">Melakukan penelitian dan pengembangan teknologi robotika dan sistem tertanam untuk solusi inovatif.</p>
                    </div>
                </div>
                <div class="mb-3 p-1 rounded-4" style="background: linear-gradient(135deg, #f97316, #fb923c);">
                    <div class="p-4 rounded-4 text-white" style="background: rgba(0,0,0,0.85);">
                        <h5 class="fw-bold mb-3"><i class="bi bi-2-circle me-2 text-warning"></i> Misi 2</h5>
                        <p class="mb-0">Menyediakan pendidikan dan pelatihan praktis di bidang elektronika dan pemrograman.</p>
                    </div>
                </div>
                <div class="mb-3 p-1 rounded-4" style="background: linear-gradient(135deg, #f97316, #fb923c);">
                    <div class="p-4 rounded-4 text-white" style="background: rgba(0,0,0,0.85);">
                        <h5 class="fw-bold mb-3"><i class="bi bi-3-circle me-2 text-warning"></i> Misi 3</h5>
                        <p class="mb-0">Berkolaborasi dengan industri dan masyarakat untuk proyek yang bermanfaat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Project Section -->
<section class="py-5 bg-black">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold text-white mb-3">Project Terbaru</h2>
            <p class="text-white-50">Inovasi dan penelitian ResLab</p>
        </div>
        <div class="row g-4" id="projectList">
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status"></div>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="py-5" style="background: linear-gradient(180deg, #0a0a0a 0%, #1a1a1a 100%);">
    <div class="container py-5">
        <!-- Header -->
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f97316, #fb923c); box-shadow: 0 8px 32px rgba(249, 115, 22, 0.3);">
                <i class="bi bi-geo-alt-fill text-white" style="font-size: 2.5rem;"></i>
            </div>
            <h2 class="display-4 fw-bold text-white mb-3">Lokasi ResLab</h2>
            <p class="lead text-white-50">Laboratorium Robotika dan Sistem Tertanam - Universitas Andalas</p>
        </div>

        <!-- Main Card -->
        <div class="row g-4 mb-5">
            <!-- Info Section -->
            <div class="col-lg-6" data-aos="fade-right">
                <div style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 2.5rem; height: 100%;">
                    <h5 class="text-white fw-bold mb-4">
                        <i class="bi bi-info-circle me-2" style="color: #fb923c;"></i> Informasi Lokasi
                    </h5>
                    
                    <div class="d-flex flex-column gap-4">
                        <!-- Gedung Info -->
                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3" style="min-width: 60px; width: 60px; height: 60px; background: rgba(249, 115, 22, 0.2); border: 2px solid rgba(249, 115, 22, 0.4);">
                                <i class="bi bi-building text-warning" style="font-size: 1.8rem;"></i>
                            </div>
                            <div>
                                <p class="text-white-50 small fw-500 mb-1">GEDUNG</p>
                                <h6 class="text-white fw-bold mb-0">Fakultas Teknik</h6>
                                <p class="text-white-50 small mb-0">Lantai 3, Ruang Lab Elektronika</p>
                            </div>
                        </div>

                        <!-- Alamat Info -->
                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3" style="min-width: 60px; width: 60px; height: 60px; background: rgba(59, 130, 246, 0.2); border: 2px solid rgba(59, 130, 246, 0.4);">
                                <i class="bi bi-geo-alt text-info" style="font-size: 1.8rem;"></i>
                            </div>
                            <div>
                                <p class="text-white-50 small fw-500 mb-1">ALAMAT</p>
                                <h6 class="text-white fw-bold mb-0">3FM6+VFC, Limau Manis</h6>
                                <p class="text-white-50 small mb-0">Pauh, Padang 25163</p>
                            </div>
                        </div>

                        <!-- Kota Info -->
                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3" style="min-width: 60px; width: 60px; height: 60px; background: rgba(34, 197, 94, 0.2); border: 2px solid rgba(34, 197, 94, 0.4);">
                                <i class="bi bi-map text-success" style="font-size: 1.8rem;"></i>
                            </div>
                            <div>
                                <p class="text-white-50 small fw-500 mb-1">KOTA</p>
                                <h6 class="text-white fw-bold mb-0">Padang, Sumatera Barat</h6>
                                <p class="text-white-50 small mb-0">Indonesia</p>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color: rgba(255, 255, 255, 0.1); margin: 2rem 0;">

                    <a href="https://maps.google.com/?q=3FM6+VFC,+Limau+Manis,+Pauh,+Padang" target="_blank" class="btn btn-primary btn-lg w-100" style="background: linear-gradient(135deg, #f97316, #fb923c); border: none; padding: 0.75rem;">
                        <i class="bi bi-map me-2"></i> Buka di Google Maps
                    </a>
                </div>
            </div>

            <!-- Features Section -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3 h-100">
                    <!-- Robotics Lab -->
                    <div class="col-sm-6">
                        <div style="background: linear-gradient(135deg, rgba(249, 115, 22, 0.15) 0%, rgba(251, 146, 60, 0.1) 100%); border: 2px solid rgba(249, 115, 22, 0.3); border-radius: 20px; padding: 2rem; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease;" class="feature-card">
                            <i class="bi bi-robot text-warning mb-3" style="font-size: 3rem;"></i>
                            <h6 class="text-white fw-bold mb-2">Robotics Lab</h6>
                            <p class="text-white-50 small mb-0">Robot dan Otomasi Industri</p>
                        </div>
                    </div>

                    <!-- Embedded Systems -->
                    <div class="col-sm-6">
                        <div style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(96, 165, 250, 0.1) 100%); border: 2px solid rgba(59, 130, 246, 0.3); border-radius: 20px; padding: 2rem; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease;" class="feature-card">
                            <i class="bi bi-cpu text-info mb-3" style="font-size: 3rem;"></i>
                            <h6 class="text-white fw-bold mb-2">Embedded Systems</h6>
                            <p class="text-white-50 small mb-0">Mikrokontroller & IoT</p>
                        </div>
                    </div>

                    <!-- Electronic Lab -->
                    <div class="col-sm-6">
                        <div style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(74, 222, 128, 0.1) 100%); border: 2px solid rgba(34, 197, 94, 0.3); border-radius: 20px; padding: 2rem; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease;" class="feature-card">
                            <i class="bi bi-lightning-charge text-success mb-3" style="font-size: 3rem;"></i>
                            <h6 class="text-white fw-bold mb-2">Electronic Lab</h6>
                            <p class="text-white-50 small mb-0">Rangkaian Listrik</p>
                        </div>
                    </div>

                    <!-- Research Area -->
                    <div class="col-sm-6">
                        <div style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(196, 181, 253, 0.1) 100%); border: 2px solid rgba(168, 85, 247, 0.3); border-radius: 20px; padding: 2rem; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease;" class="feature-card">
                            <i class="bi bi-flask text-light mb-3" style="font-size: 3rem;"></i>
                            <h6 class="text-white fw-bold mb-2">Research Area</h6>
                            <p class="text-white-50 small mb-0">Inovasi & Pengembangan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="row g-4">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 1.5rem; text-align: center;">
                    <i class="bi bi-telephone text-warning mb-2" style="font-size: 2rem;"></i>
                    <h6 class="text-white fw-bold mb-2">Telepon</h6>
                    <p class="text-white-50 small mb-0">+62 751 72907</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 1.5rem; text-align: center;">
                    <i class="bi bi-clock text-info mb-2" style="font-size: 2rem;"></i>
                    <h6 class="text-white fw-bold mb-2">Jam Operasional</h6>
                    <p class="text-white-50 small mb-0">08:00 - 17:00 WIB</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 1.5rem; text-align: center;">
                    <i class="bi bi-envelope text-success mb-2" style="font-size: 2rem;"></i>
                    <h6 class="text-white fw-bold mb-2">Email</h6>
                    <p class="text-white-50 small mb-0">reslab@unand.ac.id</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.feature-card:hover {
    transform: translateY(-8px);
    border-color: rgba(249, 115, 22, 0.6);
    background: linear-gradient(135deg, rgba(249, 115, 22, 0.25) 0%, rgba(251, 146, 60, 0.15) 100%) !important;
    box-shadow: 0 16px 40px rgba(249, 115, 22, 0.2);
}
</style>

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
// Initialize AOS
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 100
});

// Counter animation with Intersection Observer
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                animateCounter(entry.target);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => observer.observe(counter));
    
    // Fetch data
    fetchSensorData();
    setInterval(fetchSensorData, 30000);
    fetchBerita();
    fetchProjects();
});

function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000;
    const increment = target / (duration / 16);
    let current = 0;
    
    const updateCounter = () => {
        if (current < target) {
            current += increment;
            element.textContent = Math.ceil(current);
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target;
        }
    };
    
    updateCounter();
}

function fetchSensorData() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/sensor.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('temperature').textContent = data.temperature + '°C';
            document.getElementById('humidity').textContent = data.humidity + '%';
            document.getElementById('visitors').textContent = data.visitors;
        })
        .catch(err => console.error('Error:', err));
}

function fetchBerita() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/berita/index.php?limit=3')
        .then(res => res.json())
        .then(response => {
            const container = document.getElementById('beritaList');
            if (response.data && response.data.length > 0) {
                container.innerHTML = response.data.map((item, index) => `
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100 border-0">
                            ${item.image ? 
                                `<div style="height: 220px; overflow: hidden; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                                    <img src="<?php echo BASE_URL; ?>/public/uploads/${item.image}" class="w-100 h-100" alt="${item.title}" style="object-fit: cover;">
                                </div>` : 
                                '<div class="bg-secondary" style="height: 220px; border-top-left-radius: 16px; border-top-right-radius: 16px;"></div>'
                            }
                            <div class="card-body">
                                <h5 class="card-title text-white mb-3">${item.title}</h5>
                                <p class="small text-white-50 mb-3">
                                    <i class="bi bi-calendar3 me-1"></i> ${formatDate(item.date)}
                                </p>
                                <a href="<?php echo BASE_URL; ?>/berita-detail.php?id=${item.id}" class="btn btn-primary btn-sm">
                                    Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                container.innerHTML = '<div class="col-12 text-center text-white-50"><p>Belum ada berita tersedia</p></div>';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            document.getElementById('beritaList').innerHTML = '<div class="col-12 text-center text-danger"><p>Error loading berita</p></div>';
        });
}

function fetchProjects() {
    fetch('<?php echo BASE_URL; ?>/php-native/api/projects/index.php?limit=3')
        .then(res => res.json())
        .then(response => {
            const container = document.getElementById('projectList');
            if (response.data && response.data.length > 0) {
                container.innerHTML = response.data.map((item, index) => `
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100 border-0">
                            ${item.image ? 
                                `<div style="height: 220px; overflow: hidden; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                                    <img src="<?php echo BASE_URL; ?>/public/uploads/${item.image}" class="w-100 h-100" alt="${item.title}" style="object-fit: cover;">
                                </div>` : 
                                '<div class="bg-secondary" style="height: 220px; border-top-left-radius: 16px; border-top-right-radius: 16px;"></div>'
                            }
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">${item.type}</span>
                                <h5 class="card-title text-white mb-3">${item.title}</h5>
                                <p class="small text-white-50 mb-3">
                                    <i class="bi bi-calendar3 me-1"></i> ${formatDate(item.date)}
                                </p>
                                <a href="<?php echo BASE_URL; ?>/project-detail.php?id=${item.id}" class="btn btn-primary btn-sm">
                                    View Details <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                container.innerHTML = '<div class="col-12 text-center text-white-50"><p>Belum ada project tersedia</p></div>';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            document.getElementById('projectList').innerHTML = '<div class="col-12 text-center text-danger"><p>Error loading projects</p></div>';
        });
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
