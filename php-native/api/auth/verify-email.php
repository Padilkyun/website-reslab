<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';

handleCORS();

try {
    $pdo = getDBConnection();
    
    if (!isset($_GET['token'])) {
        echo "<h2>Invalid verification link</h2>";
        exit;
    }
    
    $token = $_GET['token'];
    
    $stmt = $pdo->prepare("SELECT * FROM User WHERE emailToken = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if (!$user) {
        echo "<h2>Invalid or expired token</h2>";
        exit;
    }
    
    if ($user['emailVerified']) {
        echo "<h2>Email already verified</h2>";
        exit;
    }
    
    // Update user email verification status
    $stmt = $pdo->prepare("UPDATE User SET emailVerified = true, emailToken = NULL WHERE id = ?");
    $stmt->execute([$user['id']]);
    
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Email Verified - ResLab</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
            .container { background: white; padding: 40px; border-radius: 10px; max-width: 500px; margin: 0 auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            h2 { color: #28a745; }
            a { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
            a:hover { background: #0056b3; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>✅ Email Verified Successfully!</h2>
            <p>Your email has been verified. You can now login to your account.</p>
            <a href='" . BASE_URL . "/index.php'>Go to Home</a>
            <a href='" . BASE_URL . "/auth-login.php'>Login</a>
        </div>
    </body>
    </html>
    ";
    
} catch (Exception $e) {
    echo "<h2>Error: " . $e->getMessage() . "</h2>";
}
?>
