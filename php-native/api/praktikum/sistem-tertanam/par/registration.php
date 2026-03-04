<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    $stmt = $pdo->query("SELECT * FROM ParRegistration ORDER BY id DESC LIMIT 1");
    $registration = $stmt->fetchAll();
    
    jsonResponse(['data' => $registration]);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
