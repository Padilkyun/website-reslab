<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    $stmt = $pdo->query("SELECT * FROM ParModule ORDER BY id ASC");
    $modules = $stmt->fetchAll();
    
    jsonResponse(['data' => $modules]);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
