-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Mar 2026 pada 08.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reslab`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2, 'adminlab', '$2y$10$UjY6MpA41mqSIKr4n.dYbusC/OtkAvahnpf9Vawn9KLIN3LFs0V9.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `categoryId` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `name`, `image`, `quantity`, `categoryId`, `createdAt`, `updatedAt`) VALUES
(1, 'Arduino Uno', NULL, 10, 1, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(2, 'Arduino Mega', NULL, 5, 1, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(3, 'Raspberry Pi 4', NULL, 3, 1, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(4, 'ESP32', NULL, 15, 1, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(5, 'Sensor DHT22', NULL, 20, 2, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(6, 'Sensor Ultrasonic', NULL, 15, 2, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(7, 'Sensor PIR', NULL, 10, 2, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(8, 'Servo Motor', NULL, 25, 3, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(9, 'DC Motor', NULL, 30, 3, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(10, 'Multimeter', NULL, 5, 4, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(11, 'Breadboard', NULL, 20, 4, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(12, 'Kabel Jumper Male-Male', NULL, 50, 5, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(13, 'Kabel Jumper Female-Female', NULL, 50, 5, '2026-03-04 07:27:03', '2026-03-04 07:27:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `title`, `date`, `content`, `image`, `createdAt`, `updatedAt`) VALUES
(1, 'Workshop IoT untuk Mahasiswa', '2026-03-04 14:27:03', 'ResLab mengadakan workshop Internet of Things untuk mahasiswa Teknik Elektro. Workshop ini membahas dasar-dasar IoT dan implementasinya.', NULL, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(2, 'Penelitian AI Terbaru ResLab', '2026-02-25 14:27:03', 'Tim ResLab berhasil menyelesaikan penelitian tentang penerapan Artificial Intelligence dalam sistem embedded.', NULL, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(3, 'Kerjasama dengan Industri', '2026-02-18 14:27:03', 'ResLab menjalin kerjasama dengan beberapa industri untuk pengembangan teknologi robotika.', NULL, '2026-03-04 07:27:03', '2026-03-04 07:27:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`id`, `name`, `createdAt`, `updatedAt`) VALUES
(1, 'Microcontroller', '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(2, 'Sensor', '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(3, 'Actuator', '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(4, 'Tools', '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(5, 'Cable & Connector', '2026-03-04 07:27:03', '2026-03-04 07:27:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `parmodule`
--

CREATE TABLE `parmodule` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `parmodule`
--

INSERT INTO `parmodule` (`id`, `title`, `file`, `createdAt`, `updatedAt`) VALUES
(1, 'Modul 1: Pengenalan Rangkaian Arus', NULL, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(2, 'Modul 2: Hukum Ohm dan Kirchhoff', NULL, '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(3, 'Modul 3: Rangkaian Seri dan Paralel', NULL, '2026-03-04 07:27:03', '2026-03-04 07:27:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `parregistration`
--

CREATE TABLE `parregistration` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `praktikumType` varchar(100) DEFAULT 'par',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `parregistration`
--

INSERT INTO `parregistration` (`id`, `link`, `praktikumType`, `createdAt`, `updatedAt`) VALUES
(1, 'https://forms.google.com/par-registration', 'par', '2026-03-04 07:27:03', '2026-03-04 07:27:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `parsoftwarereq`
--

CREATE TABLE `parsoftwarereq` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `parsoftwarereq`
--

INSERT INTO `parsoftwarereq` (`id`, `name`, `link`, `file`, `createdAt`, `updatedAt`) VALUES
(1, 'LTSpice', 'https://www.analog.com/en/design-center/design-tools-and-calculators/ltspice-simulator.html', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(2, 'Proteus', 'https://www.labcenter.com/', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(3, 'Multisim', 'https://www.ni.com/multisim/', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `alasan` text DEFAULT NULL,
  `rejectionReason` text DEFAULT NULL,
  `submittedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `approvedAt` datetime DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjamanitem`
--

CREATE TABLE `peminjamanitem` (
  `id` int(11) NOT NULL,
  `peminjamanId` int(11) NOT NULL,
  `barangId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `returnRequestedQuantity` int(11) DEFAULT 0,
  `returnedQuantity` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `project`
--

INSERT INTO `project` (`id`, `title`, `image`, `date`, `description`, `type`, `createdAt`, `updatedAt`) VALUES
(1, 'Smart Home Automation System', NULL, '2026-03-04 14:27:03', 'Sistem otomasi rumah pintar menggunakan IoT dan AI untuk kontrol perangkat elektronik.', 'research', '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(2, 'Line Follower Robot', NULL, '2026-02-02 14:27:03', 'Robot pengikut garis dengan sensor infrared dan kontrol PID.', 'product', '2026-03-04 07:27:03', '2026-03-04 07:27:03'),
(3, 'Pengabdian Masyarakat: Workshop Arduino', NULL, '2026-01-03 14:27:03', 'Pelatihan Arduino untuk guru-guru SMA di Padang.', 'pengabdian', '2026-03-04 07:27:03', '2026-03-04 07:27:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rangkaianlistrikmodule`
--

CREATE TABLE `rangkaianlistrikmodule` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rangkaianlistrikmodule`
--

INSERT INTO `rangkaianlistrikmodule` (`id`, `title`, `file`, `createdAt`, `updatedAt`) VALUES
(1, 'Modul 1: Dasar Rangkaian Listrik', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(2, 'Modul 2: Analisis Rangkaian DC', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(3, 'Modul 3: Rangkaian AC', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rangkaianlistrikregistration`
--

CREATE TABLE `rangkaianlistrikregistration` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `praktikumType` varchar(100) DEFAULT 'rangkaian-listrik',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rangkaianlistrikregistration`
--

INSERT INTO `rangkaianlistrikregistration` (`id`, `link`, `praktikumType`, `createdAt`, `updatedAt`) VALUES
(1, 'https://forms.google.com/rangkaian-registration', 'rangkaian-listrik', '2026-03-04 07:27:04', '2026-03-04 07:27:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rangkaianlistriksoftwarereq`
--

CREATE TABLE `rangkaianlistriksoftwarereq` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rangkaianlistriksoftwarereq`
--

INSERT INTO `rangkaianlistriksoftwarereq` (`id`, `name`, `link`, `file`, `createdAt`, `updatedAt`) VALUES
(1, 'PSPICE', 'https://www.pspice.com/', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(2, 'CircuitLab', 'https://www.circuitlab.com/', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resi`
--

CREATE TABLE `resi` (
  `id` int(11) NOT NULL,
  `peminjamanId` int(11) NOT NULL,
  `printableData` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistemtertanammodule`
--

CREATE TABLE `sistemtertanammodule` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sistemtertanammodule`
--

INSERT INTO `sistemtertanammodule` (`id`, `title`, `file`, `createdAt`, `updatedAt`) VALUES
(1, 'Modul 1: Pengenalan Embedded System', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(2, 'Modul 2: Mikrokontroler dan Pemrograman', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(3, 'Modul 3: IoT dan Komunikasi', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistemtertanamregistration`
--

CREATE TABLE `sistemtertanamregistration` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `praktikumType` varchar(100) DEFAULT 'sistem-tertanam',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sistemtertanamregistration`
--

INSERT INTO `sistemtertanamregistration` (`id`, `link`, `praktikumType`, `createdAt`, `updatedAt`) VALUES
(1, 'https://forms.google.com/sistem-registration', 'sistem-tertanam', '2026-03-04 07:27:04', '2026-03-04 07:27:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistemtertanamsoftwarereq`
--

CREATE TABLE `sistemtertanamsoftwarereq` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sistemtertanamsoftwarereq`
--

INSERT INTO `sistemtertanamsoftwarereq` (`id`, `name`, `link`, `file`, `createdAt`, `updatedAt`) VALUES
(1, 'Arduino IDE', 'https://www.arduino.cc/en/software', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(2, 'PlatformIO', 'https://platformio.org/', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04'),
(3, 'Keil uVision', 'https://www.keil.com/', NULL, '2026-03-04 07:27:04', '2026-03-04 07:27:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `angkatan` varchar(20) NOT NULL,
  `umur` int(11) NOT NULL,
  `hobi` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `emailVerified` tinyint(1) DEFAULT 1,
  `emailToken` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `nama`, `nim`, `angkatan`, `umur`, `hobi`, `password`, `emailVerified`, `emailToken`, `createdAt`, `updatedAt`) VALUES
(1, 'fadhilrk089@gmail.com', 'fadhil', '2211511014', '2022', 43, 'fd', '$2y$10$Qf4iw6aamv5dXG0Pcrje8OLAG7y5/ZldY4OzVul72XaxmopCw6JFO', 1, '18ebca7712b2a8a65783fada5c55746e1ec5b5b12f5c1534b6fb90c7f15457a9', '2026-03-04 07:45:26', '2026-03-04 07:45:26');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`categoryId`),
  ADD KEY `idx_name` (`name`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_date` (`date`);

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `idx_name` (`name`);

--
-- Indeks untuk tabel `parmodule`
--
ALTER TABLE `parmodule`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `parregistration`
--
ALTER TABLE `parregistration`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `parsoftwarereq`
--
ALTER TABLE `parsoftwarereq`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`userId`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `peminjamanitem`
--
ALTER TABLE `peminjamanitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_peminjaman` (`peminjamanId`),
  ADD KEY `idx_barang` (`barangId`);

--
-- Indeks untuk tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_date` (`date`);

--
-- Indeks untuk tabel `rangkaianlistrikmodule`
--
ALTER TABLE `rangkaianlistrikmodule`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rangkaianlistrikregistration`
--
ALTER TABLE `rangkaianlistrikregistration`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rangkaianlistriksoftwarereq`
--
ALTER TABLE `rangkaianlistriksoftwarereq`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `resi`
--
ALTER TABLE `resi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peminjamanId` (`peminjamanId`),
  ADD KEY `idx_peminjaman` (`peminjamanId`);

--
-- Indeks untuk tabel `sistemtertanammodule`
--
ALTER TABLE `sistemtertanammodule`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sistemtertanamregistration`
--
ALTER TABLE `sistemtertanamregistration`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sistemtertanamsoftwarereq`
--
ALTER TABLE `sistemtertanamsoftwarereq`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `emailToken` (`emailToken`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_nim` (`nim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `parmodule`
--
ALTER TABLE `parmodule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `parregistration`
--
ALTER TABLE `parregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `parsoftwarereq`
--
ALTER TABLE `parsoftwarereq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `peminjamanitem`
--
ALTER TABLE `peminjamanitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rangkaianlistrikmodule`
--
ALTER TABLE `rangkaianlistrikmodule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rangkaianlistrikregistration`
--
ALTER TABLE `rangkaianlistrikregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rangkaianlistriksoftwarereq`
--
ALTER TABLE `rangkaianlistriksoftwarereq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `resi`
--
ALTER TABLE `resi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sistemtertanammodule`
--
ALTER TABLE `sistemtertanammodule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sistemtertanamregistration`
--
ALTER TABLE `sistemtertanamregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sistemtertanamsoftwarereq`
--
ALTER TABLE `sistemtertanamsoftwarereq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjamanitem`
--
ALTER TABLE `peminjamanitem`
  ADD CONSTRAINT `peminjamanitem_ibfk_1` FOREIGN KEY (`peminjamanId`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjamanitem_ibfk_2` FOREIGN KEY (`barangId`) REFERENCES `barang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `resi`
--
ALTER TABLE `resi`
  ADD CONSTRAINT `resi_ibfk_1` FOREIGN KEY (`peminjamanId`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
