<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();
    
    // Total Users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM User");
    $totalUsers = $stmt->fetch()['total'];
    
    // Total Barang
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM Barang");
    $totalBarang = $stmt->fetch()['total'];
    
    // Pending Peminjaman
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM Peminjaman WHERE status = 'pending'");
    $pendingPeminjaman = $stmt->fetch()['total'];
    
    // Total Berita
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM Berita");
    $totalBerita = $stmt->fetch()['total'];
    
    jsonResponse([
        'data' => [
            'totalUsers' => $totalUsers,
            'totalBarang' => $totalBarang,
            'pendingPeminjaman' => $pendingPeminjaman,
            'totalBerita' => $totalBerita
        ]
    ]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
