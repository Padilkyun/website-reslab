<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();

    // Get all berita for admin
    $stmt = $pdo->prepare("SELECT * FROM Berita ORDER BY date DESC");
    $stmt->execute();
    $berita = $stmt->fetchAll();

    jsonResponse([
        'data' => $berita,
        'total' => count($berita)
    ]);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>