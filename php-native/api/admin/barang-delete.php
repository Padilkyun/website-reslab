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
    
    if (!isset($data['id'])) {
        jsonResponse(['error' => 'ID required'], 400);
    }
    
    $id = (int)$data['id'];
    
    // Get barang info (to delete image if exists)
    $stmt = $pdo->prepare("SELECT image FROM Barang WHERE id = ?");
    $stmt->execute([$id]);
    $barang = $stmt->fetch();
    
    if ($barang && $barang['image']) {
        deleteFile($barang['image']);
    }
    
    // Delete barang
    $stmt = $pdo->prepare("DELETE FROM Barang WHERE id = ?");
    $stmt->execute([$id]);
    
    jsonResponse([
        'success' => true,
        'message' => 'Barang berhasil dihapus'
    ]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
