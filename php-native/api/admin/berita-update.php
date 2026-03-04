<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(['error' => 'Method not allowed'], 405);
    }

    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $date = $_POST['date'] ?? '';
    $content = $_POST['content'] ?? '';

    if (empty($id) || empty($title) || empty($date) || empty($content)) {
        jsonResponse(['error' => 'ID, judul, tanggal, dan konten wajib diisi'], 400);
    }

    // Check if berita exists
    $checkStmt = $pdo->prepare("SELECT id FROM Berita WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        jsonResponse(['error' => 'Berita tidak ditemukan'], 404);
    }

    $imageName = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        try {
            $imageName = uploadFile($_FILES['image'], ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Image upload failed: ' . $e->getMessage()], 400);
        }
    }

    // Update berita
    if ($imageName) {
        $stmt = $pdo->prepare("
            UPDATE Berita SET title = ?, date = ?, content = ?, image = ?, updatedAt = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        $stmt->execute([$title, $date, $content, $imageName, $id]);
    } else {
        $stmt = $pdo->prepare("
            UPDATE Berita SET title = ?, date = ?, content = ?, updatedAt = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        $stmt->execute([$title, $date, $content, $id]);
    }

    jsonResponse([
        'success' => true,
        'message' => 'Berita berhasil diperbarui'
    ]);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>