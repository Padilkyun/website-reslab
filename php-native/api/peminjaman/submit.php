<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    $user = requireAuth();
    $pdo = getDBConnection();
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(['error' => 'Method not allowed'], 405);
    }
    
    $data = getRequestData();
    
    if (!isset($data['alasan']) || !isset($data['items']) || empty($data['items'])) {
        jsonResponse(['error' => 'Alasan dan items required'], 400);
    }
    
    // Begin transaction
    $pdo->beginTransaction();
    
    try {
        // Create peminjaman
        $stmt = $pdo->prepare("
            INSERT INTO Peminjaman (userId, alasan, status, submittedAt) 
            VALUES (?, ?, 'pending', NOW())
        ");
        $stmt->execute([$user['id'], $data['alasan']]);
        $peminjamanId = $pdo->lastInsertId();
        
        // Insert peminjaman items
        $stmt = $pdo->prepare("
            INSERT INTO PeminjamanItem (peminjamanId, barangId, quantity) 
            VALUES (?, ?, ?)
        ");
        
        foreach ($data['items'] as $item) {
            // Check stock
            $checkStmt = $pdo->prepare("SELECT quantity FROM Barang WHERE id = ?");
            $checkStmt->execute([$item['barangId']]);
            $barang = $checkStmt->fetch();
            
            if (!$barang || $barang['quantity'] < $item['quantity']) {
                throw new Exception('Stok tidak mencukupi untuk barang: ' . $item['name']);
            }
            
            $stmt->execute([$peminjamanId, $item['barangId'], $item['quantity']]);
        }
        
        $pdo->commit();
        
        jsonResponse([
            'message' => 'Peminjaman berhasil diajukan. Menunggu persetujuan admin.',
            'peminjamanId' => $peminjamanId
        ], 201);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
