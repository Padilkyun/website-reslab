<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    $user = requireAuth();
    $pdo = getDBConnection();
    
    // Get user's peminjaman history
    $stmt = $pdo->prepare("
        SELECT p.*, u.nama, u.email
        FROM Peminjaman p
        JOIN User u ON p.userId = u.id
        WHERE p.userId = ?
        ORDER BY p.submittedAt DESC
    ");
    $stmt->execute([$user['id']]);
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
        $items = $itemsStmt->fetchAll();
        
        $p['items'] = array_map(function($item) {
            return [
                'id' => $item['id'],
                'quantity' => $item['quantity'],
                'returnedQuantity' => $item['returnedQuantity'],
                'barang' => [
                    'name' => $item['barang_name'],
                    'image' => $item['barang_image']
                ]
            ];
        }, $items);
    }
    
    jsonResponse(['data' => $peminjaman]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
