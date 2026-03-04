<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

handleCORS();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $pdo = getDBConnection();
    
    // GET - List all software
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM ParSoftwareReq ORDER BY id ASC");
        $software = $stmt->fetchAll();
        jsonResponse(['data' => $software]);
    }
    
    // POST - Create new software
    elseif ($method === 'POST') {
        // Verify admin token
        $token = $_COOKIE['admin_token'] ?? '';
        $adminData = verifyToken($token);
        if (!$adminData || !$adminData['isAdmin']) {
            jsonResponse(['error' => 'Unauthorized'], 401);
        }
        
        $name = $_POST['name'] ?? '';
        $link = $_POST['link'] ?? null;
        
        if (empty($name)) {
            jsonResponse(['error' => 'Name is required'], 400);
        }
        
        // Handle file upload if present
        $fileName = null;
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $fileName = 'par_software_' . time() . '_' . uniqid() . '.' . $ext;
            $uploadPath = $uploadDir . $fileName;
            
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
                jsonResponse(['error' => 'File upload failed'], 500);
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO ParSoftwareReq (name, link, file) VALUES (?, ?, ?)");
        $stmt->execute([$name, $link, $fileName]);
        
        jsonResponse([
            'success' => true,
            'message' => 'Software created successfully',
            'id' => $pdo->lastInsertId()
        ], 201);
    }
    
    // PUT - Update software
    elseif ($method === 'PUT') {
        // Verify admin token
        $token = $_COOKIE['admin_token'] ?? '';
        $adminData = verifyToken($token);
        if (!$adminData || !$adminData['isAdmin']) {
            jsonResponse(['error' => 'Unauthorized'], 401);
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['id']) || empty($data['name'])) {
            jsonResponse(['error' => 'ID and name are required'], 400);
        }
        
        $stmt = $pdo->prepare("UPDATE ParSoftwareReq SET name = ?, link = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['link'] ?? null, $data['id']]);
        
        jsonResponse([
            'success' => true,
            'message' => 'Software updated successfully'
        ]);
    }
    
    // DELETE - Delete software
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
        $stmt = $pdo->prepare("SELECT file FROM ParSoftwareReq WHERE id = ?");
        $stmt->execute([$id]);
        $software = $stmt->fetch();
        
        // Delete the file if exists
        if ($software && $software['file']) {
            $filePath = __DIR__ . '/../../../../public/uploads/' . $software['file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM ParSoftwareReq WHERE id = ?");
        $stmt->execute([$id]);
        
        jsonResponse([
            'success' => true,
            'message' => 'Software deleted successfully'
        ]);
    }
    
    else {
        jsonResponse(['error' => 'Method not allowed'], 405);
    }
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
