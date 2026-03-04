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
        
        if (!isset($data['email']) || !isset($data['password'])) {
            jsonResponse(['error' => 'Email and password are required'], 400);
        }
        
        $stmt = $pdo->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch();
        
        if (!$user) {
            jsonResponse(['error' => 'Email atau password salah'], 401);
        }
        
        if (!verifyPassword($data['password'], $user['password'])) {
            jsonResponse(['error' => 'Email atau password salah'], 401);
        }
        
        // Skip email verification for development
        // if (!$user['emailVerified']) {
        //     jsonResponse(['error' => 'Email belum diverifikasi. Silakan cek email Anda.'], 401);
        // }
        
        $token = generateToken([
            'id' => $user['id'],
            'email' => $user['email'],
            'nama' => $user['nama'],
            'isAdmin' => false
        ]);
        
        jsonResponse([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'nama' => $user['nama'],
                'nim' => $user['nim'],
                'angkatan' => $user['angkatan'],
                'umur' => $user['umur'],
                'hobi' => $user['hobi']
            ]
        ], 200);
    }
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    jsonResponse(['error' => 'Internal server error'], 500);
}
?>
