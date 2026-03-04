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
    
    $stmt = $pdo->prepare("SELECT * FROM Berita WHERE id = ?");
    $stmt->execute([$id]);
    $berita = $stmt->fetch();
    
    if (!$berita) {
        jsonResponse(['error' => 'Berita not found'], 404);
    }
    
    jsonResponse($berita);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
