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
    $name = $_POST['name'] ?? '';
    $categoryId = $_POST['categoryId'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;
    
    if (empty($id) || empty($name) || empty($categoryId)) {
        jsonResponse(['error' => 'ID, nama, dan kategori wajib diisi'], 400);
    }
    
    // Get current barang info
    $stmt = $pdo->prepare("SELECT image FROM Barang WHERE id = ?");
    $stmt->execute([$id]);
    $current = $stmt->fetch();
    
    if (!$current) {
        jsonResponse(['error' => 'Barang not found'], 404);
    }
    
    $imageName = $current['image'];
    
    // Handle new image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        try {
            // Delete old image if exists
            if ($imageName) {
                deleteFile($imageName);
            }
            
            $imageName = uploadFile($_FILES['image'], ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Image upload failed: ' . $e->getMessage()], 400);
        }
    }
    
    // Update barang
    $stmt = $pdo->prepare("
        UPDATE Barang 
        SET name = ?, categoryId = ?, quantity = ?, image = ?
        WHERE id = ?
    ");
    $stmt->execute([$name, $categoryId, $quantity, $imageName, $id]);
    
    jsonResponse([
        'success' => true,
        'message' => 'Barang berhasil diupdate'
    ]);
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
