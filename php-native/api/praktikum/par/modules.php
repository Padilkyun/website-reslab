<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

handleCORS();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $pdo = getDBConnection();
    
    // GET - List all modules
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM ParModule ORDER BY id ASC");
        $modules = $stmt->fetchAll();
        jsonResponse(['data' => $modules]);
    }
    
    // POST - Create new module
    elseif ($method === 'POST') {
        // Verify admin token
        $token = $_COOKIE['admin_token'] ?? '';
        $adminData = verifyToken($token);
        if (!$adminData || !$adminData['isAdmin']) {
            jsonResponse(['error' => 'Unauthorized'], 401);
        }
        
        $title = $_POST['title'] ?? '';
        
        if (empty($title)) {
            jsonResponse(['error' => 'Title is required'], 400);
        }
        
        // Handle file upload if present
        $fileName = null;
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $fileName = 'par_module_' . time() . '_' . uniqid() . '.' . $ext;
            $uploadPath = $uploadDir . $fileName;
            
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
                jsonResponse(['error' => 'File upload failed'], 500);
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO ParModule (title, file) VALUES (?, ?)");
        $stmt->execute([$title, $fileName]);
        
        jsonResponse([
            'success' => true,
            'message' => 'Module created successfully',
            'id' => $pdo->lastInsertId()
        ], 201);
    }
    
    // PUT - Update module
    elseif ($method === 'PUT') {
        // Verify admin token
        $token = $_COOKIE['admin_token'] ?? '';
        $adminData = verifyToken($token);
        if (!$adminData || !$adminData['isAdmin']) {
            jsonResponse(['error' => 'Unauthorized'], 401);
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['id']) || empty($data['title'])) {
            jsonResponse(['error' => 'ID and title are required'], 400);
        }
        
        $stmt = $pdo->prepare("UPDATE ParModule SET title = ? WHERE id = ?");
        $stmt->execute([$data['title'], $data['id']]);
        
        jsonResponse([
            'success' => true,
            'message' => 'Module updated successfully'
        ]);
    }
    
    // DELETE - Delete module
    elseif ($method === 'DELETE') {
        // Verify admin token
        $token = $_COOKIE['admin_token'] ?? '';
        $adminData = verifyToken($token);
        if (!$adminData || !$adminData['isAdmin']) {
            jsonResponse(['error' => 'Unauthorized'], 401);
        }
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            jsonResponse(['error' => 'ID is required'], 400);
        }
        
        // Get file name before deleting
        $stmt = $pdo->prepare("SELECT file FROM ParModule WHERE id = ?");
        $stmt->execute([$id]);
        $module = $stmt->fetch();
        
        // Delete the file if exists
        if ($module && $module['file']) {
            $filePath = __DIR__ . '/../../../../public/uploads/' . $module['file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM ParModule WHERE id = ?");
        $stmt->execute([$id]);
        
        jsonResponse([
            'success' => true,
            'message' => 'Module deleted successfully'
        ]);
    }
    
    else {
        jsonResponse(['error' => 'Method not allowed'], 405);
    }
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
