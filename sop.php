<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'SOP Labor & Peminjaman';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<div class="min-vh-100 py-5">
    <div class="container">
        <h1 class="display-4 text-white text-center mb-5">SOP Labor & SOP Peminjaman</h1>
        
        <div class="row">
            <!-- SOP Labor -->
            <div class="col-md-6 mb-4">
                <div class="glassmorphism-card text-white">
                    <h3 class="mb-4 text-warning">📋 SOP Penggunaan Laboratorium</h3>
                    
                    <h5 class="mt-4">1. Sebelum Masuk Labor</h5>
                    <ul>
                        <li>Mahasiswa wajib mengisi daftar hadir</li>
                        <li>Menggunakan pakaian yang sopan dan rapi</li>
                        <li>Membawa kartu identitas (KTM)</li>
                        <li>Tidak membawa makanan dan minuman</li>
                    </ul>
                    
                    <h5 class="mt-4">2. Selama di Laboratorium</h5>
                    <ul>
                        <li>Menjaga kebersihan dan kerapihan</li>
                        <li>Menggunakan peralatan sesuai prosedur</li>
                        <li>Tidak membuat keributan</li>
                        <li>Bertanggung jawab atas kerusakan yang ditimbulkan</li>
                        <li>Mengikuti instruksi asisten/dosen</li>
                    </ul>
                    
                    <h5 class="mt-4">3. Setelah Selesai</h5>
                    <ul>
                        <li>Mengembalikan peralatan ke tempat semula</li>
                        <li>Membersihkan area kerja</li>
                        <li>Mematikan semua perangkat elektronik</li>
                        <li>Melaporkan jika ada kerusakan</li>
                    </ul>
                </div>
            </div>
            
            <!-- SOP Peminjaman -->
            <div class="col-md-6 mb-4">
                <div class="glassmorphism-card text-white">
                    <h3 class="mb-4 text-warning">📦 SOP Peminjaman Alat</h3>
                    
                    <h5 class="mt-4">1. Prosedur Peminjaman</h5>
                    <ul>
                        <li>Login ke sistem peminjaman</li>
                        <li>Pilih alat yang ingin dipinjam</li>
                        <li>Isi form peminjaman dengan lengkap</li>
                        <li>Tunggu persetujuan dari admin</li>
                        <li>Ambil alat sesuai jadwal yang ditentukan</li>
                    </ul>
                    
                    <h5 class="mt-4">2. Ketentuan Peminjaman</h5>
                    <ul>
                        <li>Maksimal peminjaman: 7 hari</li>
                        <li>Harus mengembalikan tepat waktu</li>
                        <li>Tidak boleh dipinjamkan ke pihak lain</li>
                        <li>Bertanggung jawab atas kehilangan/kerusakan</li>
                        <li>Mengganti biaya jika terjadi kerusakan</li>
                    </ul>
                    
                    <h5 class="mt-4">3. Prosedur Pengembalian</h5>
                    <ul>
                        <li>Kembalikan alat dalam kondisi bersih</li>
                        <li>Pastikan alat dalam kondisi baik</li>
                        <li>Laporkan jika ada kerusakan</li>
                        <li>Konfirmasi pengembalian melalui sistem</li>
                        <li>Tunggu verifikasi dari admin</li>
                    </ul>
                    
                    <div class="mt-4 text-center">
                        <a href="<?php echo BASE_URL; ?>/peminjaman.php" class="btn btn-primary">
                            Ajukan Peminjaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sanksi -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="glassmorphism-card text-white">
                    <h3 class="mb-4 text-danger">⚠️ Sanksi Pelanggaran</h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Pelanggaran Ringan:</h5>
                            <ul>
                                <li>Teguran lisan</li>
                                <li>Teguran tertulis</li>
                                <li>Peringatan I, II, III</li>
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Pelanggaran Berat:</h5>
                            <ul>
                                <li>Skorsing penggunaan laboratorium</li>
                                <li>Penggantian biaya kerusakan</li>
                                <li>Dilaporkan ke fakultas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
