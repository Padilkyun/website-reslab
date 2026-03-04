-- Script to add new admin user
-- Run this in your MySQL database (phpMyAdmin or command line)

-- Password hash for 'reslab123' (using bcrypt)
-- Generated using: password_hash('reslab123', PASSWORD_DEFAULT)
INSERT INTO `Admin` (`username`, `password`) VALUES 
('adminlab', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Verify the insertion
SELECT id, username, created_at FROM Admin;

