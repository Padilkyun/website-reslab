CREATE DATABASE IF NOT EXISTS reslab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE reslab;

SET FOREIGN_KEY_CHECKS=0;


DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `nama` VARCHAR(255) NOT NULL,
    `nim` VARCHAR(50) NOT NULL UNIQUE,
    `angkatan` VARCHAR(20) NOT NULL,
    `umur` INT NOT NULL,
    `hobi` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `emailVerified` BOOLEAN DEFAULT TRUE,
    `emailToken` VARCHAR(255) UNIQUE,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (`email`),
    INDEX idx_nim (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Table
DROP TABLE IF EXISTS `Admin`;
CREATE TABLE `Admin` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    INDEX idx_username (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin (username: admin, password: admin123)
INSERT INTO `Admin` (`username`, `password`) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Category Table
DROP TABLE IF EXISTS `Category`;
CREATE TABLE `Category` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) UNIQUE NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Category` (`name`) VALUES 
('Microcontroller'),
('Sensor'),
('Actuator'),
('Tools'),
('Cable & Connector');

-- Barang Table
DROP TABLE IF EXISTS `Barang`;
CREATE TABLE `Barang` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `image` VARCHAR(255),
    `quantity` INT NOT NULL DEFAULT 0,
    `categoryId` INT NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`categoryId`) REFERENCES `Category`(`id`) ON DELETE CASCADE,
    INDEX idx_category (`categoryId`),
    INDEX idx_name (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Barang` (`name`, `categoryId`, `quantity`) VALUES 
('Arduino Uno', 1, 10),
('Arduino Mega', 1, 5),
('Raspberry Pi 4', 1, 3),
('ESP32', 1, 15),
('Sensor DHT22', 2, 20),
('Sensor Ultrasonic', 2, 15),
('Sensor PIR', 2, 10),
('Servo Motor', 3, 25),
('DC Motor', 3, 30),
('Multimeter', 4, 5),
('Breadboard', 4, 20),
('Kabel Jumper Male-Male', 5, 50),
('Kabel Jumper Female-Female', 5, 50);

-- Peminjaman Table
DROP TABLE IF EXISTS `Peminjaman`;
CREATE TABLE `Peminjaman` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `userId` INT NOT NULL,
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `alasan` TEXT,
    `rejectionReason` TEXT,
    `submittedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `approvedAt` DATETIME,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`userId`) REFERENCES `User`(`id`) ON DELETE CASCADE,
    INDEX idx_user (`userId`),
    INDEX idx_status (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PeminjamanItem Table
DROP TABLE IF EXISTS `PeminjamanItem`;
CREATE TABLE `PeminjamanItem` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `peminjamanId` INT NOT NULL,
    `barangId` INT NOT NULL,
    `quantity` INT NOT NULL,
    `returnRequestedQuantity` INT DEFAULT 0,
    `returnedQuantity` INT DEFAULT 0,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`peminjamanId`) REFERENCES `Peminjaman`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`barangId`) REFERENCES `Barang`(`id`) ON DELETE CASCADE,
    INDEX idx_peminjaman (`peminjamanId`),
    INDEX idx_barang (`barangId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Resi Table
DROP TABLE IF EXISTS `Resi`;
CREATE TABLE `Resi` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `peminjamanId` INT UNIQUE NOT NULL,
    `printableData` TEXT NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`peminjamanId`) REFERENCES `Peminjaman`(`id`) ON DELETE CASCADE,
    INDEX idx_peminjaman (`peminjamanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Berita Table
DROP TABLE IF EXISTS `Berita`;
CREATE TABLE `Berita` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `date` DATETIME NOT NULL,
    `content` TEXT NOT NULL,
    `image` VARCHAR(255),
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Berita` (`title`, `date`, `content`) VALUES 
('Workshop IoT untuk Mahasiswa', NOW(), 'ResLab mengadakan workshop Internet of Things untuk mahasiswa Teknik Elektro. Workshop ini membahas dasar-dasar IoT dan implementasinya.'),
('Penelitian AI Terbaru ResLab', DATE_SUB(NOW(), INTERVAL 7 DAY), 'Tim ResLab berhasil menyelesaikan penelitian tentang penerapan Artificial Intelligence dalam sistem embedded.'),
('Kerjasama dengan Industri', DATE_SUB(NOW(), INTERVAL 14 DAY), 'ResLab menjalin kerjasama dengan beberapa industri untuk pengembangan teknologi robotika.');

-- Project Table
DROP TABLE IF EXISTS `Project`;
CREATE TABLE `Project` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `image` VARCHAR(255),
    `date` DATETIME NOT NULL,
    `description` TEXT NOT NULL,
    `type` VARCHAR(100) NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_type (`type`),
    INDEX idx_date (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Project` (`title`, `date`, `description`, `type`) VALUES 
('Smart Home Automation System', NOW(), 'Sistem otomasi rumah pintar menggunakan IoT dan AI untuk kontrol perangkat elektronik.', 'research'),
('Line Follower Robot', DATE_SUB(NOW(), INTERVAL 30 DAY), 'Robot pengikut garis dengan sensor infrared dan kontrol PID.', 'product'),
('Pengabdian Masyarakat: Workshop Arduino', DATE_SUB(NOW(), INTERVAL 60 DAY), 'Pelatihan Arduino untuk guru-guru SMA di Padang.', 'pengabdian');

-- PAR Tables
DROP TABLE IF EXISTS `ParModule`;
CREATE TABLE `ParModule` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `file` VARCHAR(255),
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ParModule` (`title`) VALUES 
('Modul 1: Pengenalan Rangkaian Arus'),
('Modul 2: Hukum Ohm dan Kirchhoff'),
('Modul 3: Rangkaian Seri dan Paralel');

DROP TABLE IF EXISTS `ParRegistration`;
CREATE TABLE `ParRegistration` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `link` VARCHAR(255) NOT NULL,
    `praktikumType` VARCHAR(100) DEFAULT 'par',
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ParRegistration` (`link`) VALUES 
('https://forms.google.com/par-registration');

DROP TABLE IF EXISTS `ParSoftwareReq`;
CREATE TABLE `ParSoftwareReq` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `link` VARCHAR(255),
    `file` VARCHAR(255),
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ParSoftwareReq` (`name`, `link`) VALUES 
('LTSpice', 'https://www.analog.com/en/design-center/design-tools-and-calculators/ltspice-simulator.html'),
('Proteus', 'https://www.labcenter.com/'),
('Multisim', 'https://www.ni.com/multisim/');

-- Rangkaian Listrik Tables
DROP TABLE IF EXISTS `RangkaianListrikModule`;
CREATE TABLE `RangkaianListrikModule` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `file` VARCHAR(255),
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `RangkaianListrikModule` (`title`) VALUES 
('Modul 1: Dasar Rangkaian Listrik'),
('Modul 2: Analisis Rangkaian DC'),
('Modul 3: Rangkaian AC');

DROP TABLE IF EXISTS `RangkaianListrikRegistration`;
CREATE TABLE `RangkaianListrikRegistration` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `link` VARCHAR(255) NOT NULL,
    `praktikumType` VARCHAR(100) DEFAULT 'rangkaian-listrik',
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `RangkaianListrikRegistration` (`link`) VALUES 
('https://forms.google.com/rangkaian-registration');

DROP TABLE IF EXISTS `RangkaianListrikSoftwareReq`;
CREATE TABLE `RangkaianListrikSoftwareReq` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `link` VARCHAR(255),
    `file` VARCHAR(255),
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `RangkaianListrikSoftwareReq` (`name`, `link`) VALUES 
('PSPICE', 'https://www.pspice.com/'),
('CircuitLab', 'https://www.circuitlab.com/');

-- Sistem Tertanam Tables
DROP TABLE IF EXISTS `SistemTertanamModule`;
CREATE TABLE `SistemTertanamModule` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `file` VARCHAR(255),
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `SistemTertanamModule` (`title`) VALUES 
('Modul 1: Pengenalan Embedded System'),
('Modul 2: Mikrokontroler dan Pemrograman'),
('Modul 3: IoT dan Komunikasi');

DROP TABLE IF EXISTS `SistemTertanamRegistration`;
CREATE TABLE `SistemTertanamRegistration` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `link` VARCHAR(255) NOT NULL,
    `praktikumType` VARCHAR(100) DEFAULT 'sistem-tertanam',
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `SistemTertanamRegistration` (`link`) VALUES 
('https://forms.google.com/sistem-registration');

DROP TABLE IF EXISTS `SistemTertanamSoftwareReq`;
CREATE TABLE `SistemTertanamSoftwareReq` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `link` VARCHAR(255),
    `file` VARCHAR(255),
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `SistemTertanamSoftwareReq` (`name`, `link`) VALUES 
('Arduino IDE', 'https://www.arduino.cc/en/software'),
('PlatformIO', 'https://platformio.org/'),
('Keil uVision', 'https://www.keil.com/');

SET FOREIGN_KEY_CHECKS=1;
