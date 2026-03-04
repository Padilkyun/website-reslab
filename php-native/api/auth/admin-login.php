<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $pdo = getDBConnection();
    
    if ($method === 'POST') {
        $data = getRequestData();
        
        if (!isset($data['username']) || !isset($data['password'])) {
            jsonResponse(['error' => 'Username and password are required'], 400);
        }
        
        $stmt = $pdo->prepare("SELECT * FROM Admin WHERE username = ?");
        $stmt->execute([$data['username']]);
        $admin = $stmt->fetch();
        
        if (!$admin) {
            jsonResponse(['error' => 'Username atau password salah'], 401);
        }
        
        if (!verifyPassword($data['password'], $admin['password'])) {
            jsonResponse(['error' => 'Username atau password salah'], 401);
        }
        
        $token = generateToken([
            'id' => $admin['id'],
            'username' => $admin['username'],
            'isAdmin' => true
        ]);
        
        jsonResponse([
            'success' => true,
            'token' => $token,
            'admin' => [
                'id' => $admin['id'],
                'username' => $admin['username']
            ]
        ], 200);
    }
} catch (Exception $e) {
    error_log("Admin login error: " . $e->getMessage());
    jsonResponse(['error' => 'Internal server error'], 500);
}
?>
