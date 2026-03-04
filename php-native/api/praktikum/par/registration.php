<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

handleCORS();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $pdo = getDBConnection();
    
    // GET - Get registration link
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM ParRegistration ORDER BY id DESC LIMIT 1");
        $registration = $stmt->fetchAll();
        jsonResponse(['data' => $registration]);
    }
    
    // POST - Create or update registration link
    elseif ($method === 'POST') {
        // Verify admin token
        $token = $_COOKIE['admin_token'] ?? '';
        $adminData = verifyToken($token);
        if (!$adminData || !$adminData['isAdmin']) {
            jsonResponse(['error' => 'Unauthorized'], 401);
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['link'])) {
            jsonResponse(['error' => 'Link is required'], 400);
        }
        
        // Check if registration link exists
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM ParRegistration");
        $count = $stmt->fetch()['count'];
        
        if ($count > 0) {
            // Update existing
            $stmt = $pdo->prepare("UPDATE ParRegistration SET link = ?, updatedAt = NOW() WHERE id = (SELECT id FROM (SELECT id FROM ParRegistration LIMIT 1) AS temp)");
            $stmt->execute([$data['link']]);
        } else {
            // Insert new
            $stmt = $pdo->prepare("INSERT INTO ParRegistration (link) VALUES (?)");
            $stmt->execute([$data['link']]);
        }
        
        jsonResponse([
            'success' => true,
            'message' => 'Registration link updated successfully'
        ]);
    }
    
    else {
        jsonResponse(['error' => 'Method not allowed'], 405);
    }
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
