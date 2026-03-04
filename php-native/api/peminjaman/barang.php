<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    $categoryId = isset($_GET['categoryId']) ? (int)$_GET['categoryId'] : 0;
    
    if (!$categoryId) {
        jsonResponse(['error' => 'Category ID required'], 400);
    }
    
    $stmt = $pdo->prepare("SELECT * FROM Barang WHERE categoryId = ? AND quantity > 0 ORDER BY name ASC");
    $stmt->execute([$categoryId]);
    $barang = $stmt->fetchAll();
    
    jsonResponse(['data' => $barang]);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
