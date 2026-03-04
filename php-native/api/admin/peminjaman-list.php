<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();
    
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    
    $stmt = $pdo->prepare("
        SELECT p.*, u.nama as user_nama, u.email as user_email
        FROM Peminjaman p
        JOIN User u ON p.userId = u.id
        ORDER BY p.submittedAt DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->execute([$limit, $offset]);
    $peminjaman = $stmt->fetchAll();
    
    jsonResponse(['data' => $peminjaman]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
