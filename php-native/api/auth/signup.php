<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

$method = $_SERVER['REQUEST_METHOD'];

try {
    $pdo = getDBConnection();
    
    if ($method === 'POST') {
        // User signup/registration
        $data = getRequestData();
        
        $required = ['email', 'nama', 'nim', 'angkatan', 'umur', 'hobi', 'password'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                jsonResponse(['error' => "Field {$field} wajib diisi"], 400);
            }
        }
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM User WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetch()) {
            jsonResponse(['error' => 'Email sudah terdaftar'], 400);
        }
        
        // Check if NIM already exists
        $stmt = $pdo->prepare("SELECT id FROM User WHERE nim = ?");
        $stmt->execute([$data['nim']]);
        if ($stmt->fetch()) {
            jsonResponse(['error' => 'NIM sudah terdaftar'], 400);
        }
        
        // Generate email verification token
        $emailToken = generateRandomToken(32);
        
        // Hash password
        $hashedPassword = hashPassword($data['password']);
        
        // Insert user - Set emailVerified to TRUE for development (skip email verification)
        $stmt = $pdo->prepare("
            INSERT INTO User (email, nama, nim, angkatan, umur, hobi, password, emailToken, emailVerified) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, TRUE)
        ");
        
        $result = $stmt->execute([
            $data['email'],
            $data['nama'],
            $data['nim'],
            $data['angkatan'],
            (int)$data['umur'],
            $data['hobi'],
            $hashedPassword,
            $emailToken
        ]);
        
        if (!$result) {
            throw new Exception('Failed to create user');
        }
        
        // For production, uncomment this to send verification email
        /*
        $verificationLink = BASE_URL . "/php-native/api/auth/verify-email.php?token=" . $emailToken;
        $emailMessage = "
            <h2>Selamat datang di ResLab!</h2>
            <p>Terima kasih telah mendaftar. Silakan klik link di bawah untuk verifikasi email:</p>
            <a href='{$verificationLink}'>{$verificationLink}</a>
        ";
        sendEmail($data['email'], 'Verifikasi Email - ResLab', $emailMessage);
        */
        
        jsonResponse([
            'success' => true,
            'message' => 'Registrasi berhasil! Anda dapat login sekarang.'
        ], 201);
    }
} catch (Exception $e) {
    error_log("Signup error: " . $e->getMessage());
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
