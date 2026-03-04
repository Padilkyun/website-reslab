<?php
// Script to add new admin user
// Run this file once in browser: http://localhost/reslab/add-admin.php

require_once __DIR__ . '/php-native/config/database.php';
require_once __DIR__ . '/php-native/includes/auth.php';

try {
    $pdo = getDBConnection();
    
    // Check if adminlab already exists
    $stmt = $pdo->prepare("SELECT id FROM Admin WHERE username = ?");
    $stmt->execute(['adminlab']);
    
    if ($stmt->fetch()) {
        echo "Admin 'adminlab' already exists!";
        return;
    }
    
    // Hash password
    $password = 'reslab123';
    $hashedPassword = hashPassword($password);
    
    // Insert new admin
    $stmt = $pdo->prepare("INSERT INTO Admin (username, password) VALUES (?, ?)");
    $stmt->execute(['adminlab', $hashedPassword]);
    
    echo "Success! Admin 'adminlab' has been added.";
    echo "<br>Username: adminlab";
    echo "<br>Password: reslab123";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

