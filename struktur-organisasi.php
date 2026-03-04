<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Struktur Organisasi';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<div class="min-vh-100 py-5">
    <div class="container">
        <h1 class="display-4 text-white text-center mb-5">Struktur Organisasi ResLab</h1>
        
        <div class="glassmorphism-card text-white">
            <div class="text-center mb-5">
                <p class="lead">Tim ResLab terdiri dari para ahli dan praktisi di bidang robotika, sistem tertanam, dan teknologi informasi yang berdedikasi untuk mengembangkan inovasi teknologi.</p>
            </div>
            
            <!-- Organizational Structure -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="card bg-dark border-warning mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning">Kepala Laboratorium</h5>
                            <p class="card-text">Dr. Ir. [Nama Kepala Lab]</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark border-light h-100">
                        <div class="card-body text-center">
                            <h6 class="card-title text-warning">Koordinator Penelitian</h6>
                            <p class="card-text small">[Nama Koordinator]</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark border-light h-100">
                        <div class="card-body text-center">
                            <h6 class="card-title text-warning">Koordinator Praktikum</h6>
                            <p class="card-text small">[Nama Koordinator]</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark border-light h-100">
                        <div class="card-body text-center">
                            <h6 class="card-title text-warning">Koordinator Pengabdian</h6>
                            <p class="card-text small">[Nama Koordinator]</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-3 mb-3">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body text-center">
                            <h6 class="card-title small">Staff Teknis</h6>
                            <p class="card-text small">[Nama Staff]</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body text-center">
                            <h6 class="card-title small">Staff Administrasi</h6>
                            <p class="card-text small">[Nama Staff]</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body text-center">
                            <h6 class="card-title small">Asisten Laboratorium</h6>
                            <p class="card-text small">Tim Asisten</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body text-center">
                            <h6 class="card-title small">Mahasiswa Peneliti</h6>
                            <p class="card-text small">Tim Peneliti</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
