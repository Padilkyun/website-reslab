<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    if (!isset($_GET['id'])) {
        jsonResponse(['error' => 'ID is required'], 400);
    }
    
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM Project WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();
    
    if (!$project) {
        jsonResponse(['error' => 'Project not found'], 404);
    }
    
    jsonResponse($project);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
