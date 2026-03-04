<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

handleCORS();

try {
    requireAdmin();
    $pdo = getDBConnection();
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(['error' => 'Method not allowed'], 405);
    }
    
    $data = getRequestData();
    
    if (!isset($data['peminjamanId'])) {
        jsonResponse(['error' => 'Peminjaman ID required'], 400);
    }
    
    $peminjamanId = (int)$data['peminjamanId'];
    
    // Begin transaction
    $pdo->beginTransaction();
    
    try {
        // Check if peminjaman exists and is pending
        $stmt = $pdo->prepare("SELECT * FROM Peminjaman WHERE id = ? AND status = 'pending'");
        $stmt->execute([$peminjamanId]);
        $peminjaman = $stmt->fetch();
        
        if (!$peminjaman) {
            throw new Exception('Peminjaman tidak ditemukan atau sudah diproses');
        }
        
        // Get items
        $itemsStmt = $pdo->prepare("SELECT * FROM PeminjamanItem WHERE peminjamanId = ?");
        $itemsStmt->execute([$peminjamanId]);
        $items = $itemsStmt->fetchAll();
        
        // Reduce stock for each item
        $updateStockStmt = $pdo->prepare("UPDATE Barang SET quantity = quantity - ? WHERE id = ?");
        
        foreach ($items as $item) {
            // Check stock availability
            $checkStmt = $pdo->prepare("SELECT quantity FROM Barang WHERE id = ?");
            $checkStmt->execute([$item['barangId']]);
            $barang = $checkStmt->fetch();
            
            if (!$barang || $barang['quantity'] < $item['quantity']) {
                throw new Exception('Stok tidak mencukupi');
            }
            
            $updateStockStmt->execute([$item['quantity'], $item['barangId']]);
        }
        
        // Update peminjaman status
        $stmt = $pdo->prepare("UPDATE Peminjaman SET status = 'approved', approvedAt = NOW() WHERE id = ?");
        $stmt->execute([$peminjamanId]);
        
        $pdo->commit();
        
        jsonResponse([
            'success' => true,
            'message' => 'Peminjaman berhasil disetujui'
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
    
} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
?>
