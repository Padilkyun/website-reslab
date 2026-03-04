    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo BASE_URL; ?>/public/reslabtrans.png" alt="ResLab Logo" style="height: 50px; width: 50px;" class="me-3">
                        <div>
                            <h5 class="mb-0">RESLAB</h5>
                            <small>Robotics and Embedded System Laboratory</small>
                        </div>
                    </div>
                    <p class="small">Laboratorium penelitian dan pengembangan teknologi robotika dan sistem tertanam di Universitas Andalas.</p>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/index.php" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/about.php" class="text-white-50 text-decoration-none">About</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/praktikum.php" class="text-white-50 text-decoration-none">Praktikum</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/peminjaman.php" class="text-white-50 text-decoration-none">Peminjaman</a></li>
                    </ul>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Contact</h5>
                    <p class="small">
                        <strong>Lokasi:</strong><br>
                        3FM6+VFC, Limau Manis<br>
                        Kec. Pauh, Kota Padang<br>
                        Sumatera Barat 25175
                    </p>
                    <p class="small">
                        <strong>Email:</strong> reslab@unand.ac.id<br>
                        <strong>Phone:</strong> +62 xxx xxxx xxxx
                    </p>
                </div>
            </div>
            
            <hr class="border-secondary">
            
            <div class="row">
                <div class="col-12 text-center">
                    <p class="small mb-0">&copy; <?php echo date('Y'); ?> ResLab - Robotics and Embedded System Laboratory. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo BASE_URL; ?>/php-native/assets/js/main.js"></script>
    
    <?php if (isset($customJS)): ?>
        <script><?php echo $customJS; ?></script>
    <?php endif; ?>
</body>
</html>
