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

    $title = $_POST['title'] ?? '';
    $date = $_POST['date'] ?? '';
    $content = $_POST['content'] ?? '';

    if (empty($title) || empty($date) || empty($content)) {
        jsonResponse(['error' => 'Judul, tanggal, dan konten wajib diisi'], 400);
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

    // Insert berita
    $stmt = $pdo->prepare("
        INSERT INTO Berita (title, date, content, image)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$title, $date, $content, $imageName]);

    jsonResponse([
        'success' => true,
        'message' => 'Berita berhasil ditambahkan',
        'id' => $pdo->lastInsertId()
    ], 201);

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>