<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    // Get all berita with pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    
    $stmt = $pdo->prepare("SELECT * FROM Berita ORDER BY date DESC LIMIT ? OFFSET ?");
    $stmt->execute([$limit, $offset]);
    $berita = $stmt->fetchAll();
    
    // Get total count
    $totalStmt = $pdo->query("SELECT COUNT(*) as total FROM Berita");
    $total = $totalStmt->fetch()['total'];
    
    jsonResponse([
        'data' => $berita,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'totalPages' => ceil($total / $limit)
        ]
    ]);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
