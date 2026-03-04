<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    // Get all projects with pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;
    
    $stmt = $pdo->prepare("SELECT * FROM Project ORDER BY date DESC LIMIT ? OFFSET ?");
    $stmt->execute([$limit, $offset]);
    $projects = $stmt->fetchAll();
    
    // Get total count
    $totalStmt = $pdo->query("SELECT COUNT(*) as total FROM Project");
    $total = $totalStmt->fetch()['total'];
    
    jsonResponse([
        'data' => $projects,
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
