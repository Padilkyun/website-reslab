<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();
    
    $status = isset($_GET['status']) ? $_GET['status'] : 'pending';
    
    $stmt = $pdo->prepare("
        SELECT p.*, u.nama as user_nama, u.email as user_email, u.nim as user_nim
        FROM Peminjaman p
        JOIN User u ON p.userId = u.id
        WHERE p.status = ?
        ORDER BY p.submittedAt DESC
    ");
    $stmt->execute([$status]);
    $peminjaman = $stmt->fetchAll();
    
    // Get items for each peminjaman
    foreach ($peminjaman as &$p) {
        $itemsStmt = $pdo->prepare("
            SELECT pi.*, b.name as barang_name, b.image as barang_image
            FROM PeminjamanItem pi
            JOIN Barang b ON pi.barangId = b.id
            WHERE pi.peminjamanId = ?
        ");
        $itemsStmt->execute([$p['id']]);
        $p['items'] = $itemsStmt->fetchAll();
    }
    
    jsonResponse(['data' => $peminjaman]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
