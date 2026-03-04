<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();
    
    $stmt = $pdo->query("
        SELECT b.*, c.name as category_name
        FROM Barang b
        JOIN Category c ON b.categoryId = c.id
        ORDER BY c.name, b.name ASC
    ");
    $barang = $stmt->fetchAll();
    
    jsonResponse(['data' => $barang]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
