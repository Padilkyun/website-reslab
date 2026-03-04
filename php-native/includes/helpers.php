<?php
// Common helper functions
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function handleCORS() {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0);
    }
}

function getRequestData() {
    $method = $_SERVER['REQUEST_METHOD'];
    
    if ($method === 'GET') {
        return $_GET;
    }
    
    $data = file_get_contents('php://input');
    $json = json_decode($data, true);
    
    if ($json !== null) {
        return $json;
    }
    
    return $_POST;
}

function uploadFile($file, $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf']) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload failed');
    }
    
    $fileType = $file['type'];
    if (!in_array($fileType, $allowedTypes)) {
        throw new Exception('Invalid file type');
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '_' . time() . '.' . $extension;
    $uploadPath = UPLOAD_DIR . $fileName;
    
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return $fileName;
    }
    
    throw new Exception('Failed to move uploaded file');
}

function deleteFile($fileName) {
    if (!$fileName) return false;
    
    $filePath = UPLOAD_DIR . $fileName;
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    
    return false;
}

function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function sendEmail($to, $subject, $message, $fromEmail = null, $fromName = null) {
    require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
    require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;
        
        $mail->setFrom($fromEmail ?? SMTP_FROM_EMAIL, $fromName ?? SMTP_FROM_NAME);
        $mail->addAddress($to);
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}

function generateRandomToken($length = 32) {
    return bin2hex(random_bytes($length));
}
?>
