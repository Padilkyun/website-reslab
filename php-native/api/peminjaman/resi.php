<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    $user = requireAuth();
    $pdo = getDBConnection();
    
    if (!isset($_GET['id'])) {
        jsonResponse(['error' => 'ID required'], 400);
    }
    
    $peminjamanId = (int)$_GET['id'];
    
    // Get peminjaman with user info
    $stmt = $pdo->prepare("
        SELECT p.*, u.nama as user_nama, u.nim as user_nim, u.email as user_email
        FROM Peminjaman p
        JOIN User u ON p.userId = u.id
        WHERE p.id = ? AND p.userId = ? AND p.status = 'approved'
    ");
    $stmt->execute([$peminjamanId, $user['id']]);
    $peminjaman = $stmt->fetch();
    
    if (!$peminjaman) {
        jsonResponse(['error' => 'Peminjaman not found or not approved'], 404);
    }
    
    // Get items
    $itemsStmt = $pdo->prepare("
        SELECT pi.*, b.name as barang_name, b.image as barang_image
        FROM PeminjamanItem pi
        JOIN Barang b ON pi.barangId = b.id
        WHERE pi.peminjamanId = ?
    ");
    $itemsStmt->execute([$peminjamanId]);
    $items = $itemsStmt->fetchAll();
    
    $peminjaman['items'] = array_map(function($item) {
        return [
            'quantity' => $item['quantity'],
            'barang' => [
                'name' => $item['barang_name'],
                'image' => $item['barang_image']
            ]
        ];
    }, $items);
    
    jsonResponse(['data' => $peminjaman]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
