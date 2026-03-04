<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    $stmt = $pdo->query("SELECT * FROM Category ORDER BY name ASC");
    $categories = $stmt->fetchAll();
    
    jsonResponse(['data' => $categories]);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
