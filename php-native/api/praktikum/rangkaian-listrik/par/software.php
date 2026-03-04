<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    $stmt = $pdo->query("SELECT * FROM ParSoftwareReq ORDER BY id ASC");
    $software = $stmt->fetchAll();
    
    jsonResponse(['data' => $software]);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
