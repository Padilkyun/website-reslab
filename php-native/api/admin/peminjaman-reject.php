<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(['error' => 'Method not allowed'], 405);
    }
    
    $data = getRequestData();
    
    if (!isset($data['peminjamanId']) || !isset($data['rejectionReason'])) {
        jsonResponse(['error' => 'Peminjaman ID and rejection reason required'], 400);
    }
    
    $peminjamanId = (int)$data['peminjamanId'];
    $rejectionReason = trim($data['rejectionReason']);
    
    if (empty($rejectionReason)) {
        jsonResponse(['error' => 'Alasan penolakan wajib diisi'], 400);
    }
    
    // Check if peminjaman exists and is pending
    $stmt = $pdo->prepare("SELECT * FROM Peminjaman WHERE id = ? AND status = 'pending'");
    $stmt->execute([$peminjamanId]);
    $peminjaman = $stmt->fetch();
    
    if (!$peminjaman) {
        jsonResponse(['error' => 'Peminjaman tidak ditemukan atau sudah diproses'], 404);
    }
    
    // Update peminjaman status
    $stmt = $pdo->prepare("
        UPDATE Peminjaman 
        SET status = 'rejected', rejectionReason = ?, approvedAt = NOW() 
        WHERE id = ?
    ");
    $stmt->execute([$rejectionReason, $peminjamanId]);
    
    jsonResponse([
        'success' => true,
        'message' => 'Peminjaman berhasil ditolak'
    ]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
