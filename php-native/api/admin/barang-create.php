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
    
    $name = $_POST['name'] ?? '';
    $categoryId = $_POST['categoryId'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;
    
    if (empty($name) || empty($categoryId)) {
        jsonResponse(['error' => 'Nama dan kategori wajib diisi'], 400);
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
    
    // Insert barang
    $stmt = $pdo->prepare("
        INSERT INTO Barang (name, categoryId, quantity, image) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$name, $categoryId, $quantity, $imageName]);
    
    jsonResponse([
        'success' => true,
        'message' => 'Barang berhasil ditambahkan',
        'id' => $pdo->lastInsertId()
    ], 201);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
