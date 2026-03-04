<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';

handleCORS();

try {
    $sensorData = [
        'temperature' => rand(20, 70),
        'humidity' => rand(30, 80),
        'visitors' => rand(1, 20), 
    ];
    
    jsonResponse($sensorData);
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
