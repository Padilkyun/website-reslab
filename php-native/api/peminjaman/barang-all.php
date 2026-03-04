<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();

    // Get all available barang (quantity > 0) with category info
    $stmt = $pdo->prepare("
        SELECT b.*, c.name as categoryName
        FROM Barang b
        JOIN Category c ON b.categoryId = c.id
        WHERE b.quantity > 0
        ORDER BY c.name ASC, b.name ASC
    ");
    $stmt->execute();
    $barang = $stmt->fetchAll();

    jsonResponse(['data' => $barang]);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>