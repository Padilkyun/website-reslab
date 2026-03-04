<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'About - Visi Misi';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<div class="min-vh-100 py-5">
    <div class="container">
        <h1 class="display-4 text-white text-center mb-5">Visi & Misi ResLab</h1>
        
        <div class="row">
            <!-- Vision -->
            <div class="col-md-6 mb-4">
                <div class="p-1 rounded" style="background: linear-gradient(135deg, #f97316, #fb923c);">
                    <div class="bg-dark text-white p-5 rounded text-center" style="min-height: 300px; display: flex; flex-direction: column; justify-content: center;">
                        <h2 class="fw-bold mb-4">Visi ResLab</h2>
                        <p class="lead">Menjadi laboratorium terdepan dalam inovasi robotika dan sistem tertanam yang berkontribusi pada kemajuan teknologi dan masyarakat.</p>
                    </div>
                </div>
            </div>
            
            <!-- Missions -->
            <div class="col-md-6">
                <div class="mb-4 p-1 rounded" style="background: linear-gradient(135deg, #f97316, #fb923c);">
                    <div class="bg-dark text-white p-4 rounded">
                        <h4 class="fw-bold mb-3">Misi 1</h4>
                        <p>Melakukan penelitian dan pengembangan teknologi robotika dan sistem tertanam untuk solusi inovatif yang dapat diterapkan dalam berbagai bidang industri dan kehidupan sehari-hari.</p>
                    </div>
                </div>
                
                <div class="mb-4 p-1 rounded" style="background: linear-gradient(135deg, #f97316, #fb923c);">
                    <div class="bg-dark text-white p-4 rounded">
                        <h4 class="fw-bold mb-3">Misi 2</h4>
                        <p>Menyediakan pendidikan dan pelatihan praktis di bidang elektronika, pemrograman, dan sistem tertanam kepada mahasiswa dan masyarakat umum.</p>
                    </div>
                </div>
                
                <div class="mb-4 p-1 rounded" style="background: linear-gradient(135deg, #f97316, #fb923c);">
                    <div class="bg-dark text-white p-4 rounded">
                        <h4 class="fw-bold mb-3">Misi 3</h4>
                        <p>Berkolaborasi dengan industri, institusi pendidikan, dan masyarakat untuk mengembangkan proyek-proyek yang memberikan manfaat nyata dan berkelanjutan.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Info -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="glassmorphism-card text-white">
                    <h3 class="mb-4">Tentang ResLab</h3>
                    <p class="lead mb-3">Laboratorium Robotics and Embedded System (ResLab) adalah fasilitas penelitian dan pengembangan teknologi yang berfokus pada inovasi dan solusi praktis di bidang elektronika, pemrograman, dan sistem tertanam.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <h2 class="display-4 text-gradient fw-bold counter" data-target="20">0</h2>
                                <p>Pengabdian Masyarakat</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <h2 class="display-4 text-gradient fw-bold counter" data-target="32">0</h2>
                                <p>Project & Research</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <h2 class="display-4 text-gradient fw-bold counter" data-target="3">0</h2>
                                <p>Praktikum</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        animateCounter(counter, target);
    });
});
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
