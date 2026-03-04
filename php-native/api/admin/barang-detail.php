<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();
    
    if (!isset($_GET['id'])) {
        jsonResponse(['error' => 'ID required'], 400);
    }
    
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("
        SELECT b.*, c.name as category_name
        FROM Barang b
        JOIN Category c ON b.categoryId = c.id
        WHERE b.id = ?
    ");
    $stmt->execute([$id]);
    $barang = $stmt->fetch();
    
    if (!$barang) {
        jsonResponse(['error' => 'Barang not found'], 404);
    }
    
    jsonResponse(['data' => $barang]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
