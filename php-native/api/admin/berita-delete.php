<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();

    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(['error' => 'Method not allowed'], 405);
    }

    $id = $_GET['id'] ?? $_POST['id'] ?? '';

    if (empty($id)) {
        jsonResponse(['error' => 'ID berita wajib diisi'], 400);
    }

    // Check if berita exists
    $checkStmt = $pdo->prepare("SELECT id FROM Berita WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        jsonResponse(['error' => 'Berita tidak ditemukan'], 404);
    }

    // Delete berita
    $stmt = $pdo->prepare("DELETE FROM Berita WHERE id = ?");
    $stmt->execute([$id]);

    jsonResponse([
        'success' => true,
        'message' => 'Berita berhasil dihapus'
    ]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>