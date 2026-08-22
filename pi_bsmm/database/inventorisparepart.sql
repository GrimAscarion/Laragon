-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for inventorisparepart
-- CREATE DATABASE IF NOT EXISTS `inventorisparepart` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
-- USE `inventorisparepart`;

-- Dumping structure for table inventorisparepart.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table inventorisparepart.categories: ~11 rows (approximately)
INSERT INTO `categories` (`id`, `nama_kategori`, `created_at`) VALUES
	(1, 'Oli Samping', '2026-07-21 15:12:14'),
	(2, 'Oli Mesin', '2026-07-21 15:12:14'),
	(3, 'Minyak', '2026-07-21 15:12:14'),
	(4, 'Mesin', '2026-07-21 15:12:14'),
	(5, 'Aksesoris', '2026-07-21 15:12:14'),
	(6, 'Kelistrikan', '2026-07-21 15:12:14'),
	(7, 'Gasket', '2026-07-21 15:12:14'),
	(8, 'PER', '2026-07-21 15:12:14'),
	(9, 'Rem Cakram', '2026-07-21 15:12:14'),
	(10, 'SEAL', '2026-07-21 15:12:14'),
	(11, 'Bearing', '2026-07-21 15:12:14');

-- Dumping structure for table inventorisparepart.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto_profil` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table inventorisparepart.customers: ~2 rows (approximately)
INSERT INTO `customers` (`id`, `nama_lengkap`, `email`, `password`, `no_telp`, `alamat_lengkap`, `created_at`, `foto_profil`) VALUES
	(1, 'Budi Santoso', 'budi@example.com', 'hashpassword123', '081234567890', 'Jl. Merdeka No.45, Jakarta', '2026-07-21 15:12:15', NULL),
	(2, 'Angga Prawira', 'anggaprawira567@gmail.com', '$2y$10$m90br2RTENDXYsIxkXXOkufher0TCGb0AUKdjJIQ.ZNvChW.wEPum', '08561745303', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur', '2026-07-21 15:12:15', 'profil_2_1783047604.jpg');

-- Dumping structure for table inventorisparepart.keranjang
CREATE TABLE IF NOT EXISTS `keranjang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `sparepart_id` int NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `keranjang_cust` (`customer_id`),
  KEY `keranjang_part` (`sparepart_id`),
  CONSTRAINT `keranjang_cust` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `keranjang_part` FOREIGN KEY (`sparepart_id`) REFERENCES `spareparts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table inventorisparepart.keranjang: ~0 rows (approximately)

-- Dumping structure for table inventorisparepart.spareparts
CREATE TABLE IF NOT EXISTS `spareparts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategori_id` int NOT NULL,
  `nama_sparepart` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `peruntukan_motor` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_modal` int NOT NULL,
  `harga_jual` int NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `min_stok` int NOT NULL DEFAULT '5',
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_kategori` (`kategori_id`),
  CONSTRAINT `fk_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table inventorisparepart.spareparts: ~114 rows (approximately)
INSERT INTO `spareparts` (`id`, `kategori_id`, `nama_sparepart`, `peruntukan_motor`, `harga_modal`, `harga_jual`, `stok`, `min_stok`, `image_url`, `created_at`) VALUES
	(1, 1, 'CASTROL 2T', 'Motor 2T', 46000, 54000, 10, 5, 'https://images.sip-scootershop.com/cdn-cgi/imagedelivery/7WkrUYN4GAew8Bx4sug9hQ/t9sQdk_x-kCNpNCix4tyUQ/2400x2400', '2026-07-21 15:12:15'),
	(2, 2, 'CASTROL ACTIV 0,8L', 'Bebek', 34000, 45000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/101/MTA-101876518/castrol_oli_castrol_activ_20w40_0-8l_full02_l7xym634.jpg\r\n', '2026-07-21 15:12:15'),
	(3, 2, 'CASTROL ACTIV MATIC', 'Matic', 53000, 53000, 10, 5, 'https://img.lazcdn.com/g/p/9ae22dc449684afe8a709b0c53e2ddfa.jpg_720x720q80.jpg\r\n', '2026-07-21 15:12:15'),
	(4, 2, 'CASTROL GO 0,8', 'Motor 4T', 36000, 45000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7rbk9-matjzvtjayamaa\r\n', '2026-07-21 15:12:15'),
	(5, 2, 'CASTROL MATIC', 'Matic', 42000, 54000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//97/MTA-39624712/castrol_castrol_full01.jpg\r\n', '2026-07-21 15:12:15'),
	(6, 2, 'CASTROL POWER 0,8L', 'Bebek', 42000, 55000, 10, 5, 'https://down-id.img.susercontent.com/file/74c288d9b1c2468f6484601b61572ff3\r\n', '2026-07-21 15:12:15'),
	(7, 2, 'CASTROL POWER 1L', 'Bebek', 50000, 58000, 10, 5, 'https://p16-oec-sg.ibyteimg.com/tos-alisg-i-aphluv4xwc-sg/img/VqbcmM/2025/2/12/1e2d410e-4c3d-440c-825a-69a290e7c212.jpg~tplv-aphluv4xwc-resize-jpeg:700:0.jpg\r\n', '2026-07-21 15:12:15'),
	(8, 2, 'ENDURO 0,8L', 'Bebek', 39000, 47000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7ra0l-mbdmc6euf5w914', '2026-07-21 15:12:15'),
	(9, 2, 'ENDURO 1L', 'Bebek', 45000, 53000, 10, 5, 'https://p16-oec-sg.ibyteimg.com/tos-alisg-i-aphluv4xwc-sg/6992a20704474c52a1b3516c768c22b9~tplv-aphluv4xwc-resize-jpeg:700:0.jpeg\r\n', '2026-07-21 15:12:15'),
	(10, 2, 'ENDURO MATIC 0,8L', 'Matic', 44000, 52000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAP6x-lhnht42S7vLMWceEJtjh45Lmn7JLLBlLifVH28MTCA6y2EYCs5Y&s=10', '2026-07-21 15:12:15'),
	(11, 2, 'ENDURO MATIC 1L', 'Matic', 48000, 57000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7rbk2-m7hpqex3os5xca', '2026-07-21 15:12:15'),
	(12, 2, 'ENDURO RACING 1L', 'Batangan', 56000, 63000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//101/MTA-71541587/enduro_oli-pertamina-enduro-4t-racing-1l-sae-10w-40_full04.jpg', '2026-07-21 15:12:15'),
	(13, 2, 'EVALUBE 2T', 'Bebek 2T', 27000, 35000, 10, 5, 'https://down-id.img.susercontent.com/file/6a11639b2c2e4257f1941866909c0c4d', '2026-07-21 15:12:15'),
	(14, 2, 'EVALUBE 2T PRO', 'Bebek 2T, Mesin Rumput', 34000, 42000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//93/MTA-4737404/evalube_evalube_2t_pro_synthetic_motor_oil_0_7_l__full00.jpg', '2026-07-21 15:12:15'),
	(15, 2, 'EVALUBE MATIC', 'Matic', 34000, 42000, 10, 5, 'https://p16-oec-sg.ibyteimg.com/tos-alisg-i-aphluv4xwc-sg/cee324811a4d46a58173e8fca6fd02b9~tplv-aphluv4xwc-resize-jpeg:700:0.jpeg', '2026-07-21 15:12:15'),
	(16, 2, 'EVALUBE SCOOTER 4T', 'Bebek SCOOTER, Mesin Rumput', 34000, 42000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//95/MTA-39624610/evalube_evalube_full01.jpg', '2026-07-21 15:12:15'),
	(17, 2, 'EVALUBE 4T', 'Bebek 4T', 30000, 38000, 10, 5, 'https://images.tokopedia.net/img/cache/700/product-1/2020/8/6/18170234/18170234_7e94eb47-d8a8-422d-9730-1a7d31d0c65a_700_700.webp', '2026-07-21 15:12:15'),
	(18, 2, 'ENEOS 4T', 'Bebek 4T', 40000, 47000, 10, 5, 'https://eneos-website-dev.s3.amazonaws.com/product/1724921308_4T%20Touring%20SAE%2010W-40%20SL:MA.png', '2026-07-21 15:12:15'),
	(19, 2, 'FEDERAL 0,8L', 'Bebek', 38000, 46000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-8224r-mjl9pm8y88p2cc', '2026-07-21 15:12:15'),
	(20, 2, 'FEDERAL 1L', 'Batangan', 50000, 58000, 10, 5, 'https://sumberbaruban.com/wp-content/uploads/2025/02/RACING-MATIC-10W-40-1-Liter.jpg', '2026-07-21 15:12:15'),
	(21, 2, 'FEDERAL MATIC', 'Matic', 52000, 60000, 10, 5, 'https://federaloil.co.id/assets/captcha/product_image/2026/07/federal-matic-ultratec_600_600.png?v=12', '2026-07-21 15:12:15'),
	(22, 2, 'FEDERAL RACING 1L', 'Batangan', 53000, 65000, 10, 5, 'https://federaloil.co.id/assets/captcha/product_image/2025/01/FederalRacing-mn-10w40_300.png', '2026-07-21 15:12:15'),
	(23, 2, 'FEDERAL XX 0,8L', 'Bebek', 44000, 57000, 10, 5, 'https://sumberbaruban.com/wp-content/uploads/2025/02/9-01.jpg', '2026-07-21 15:12:15'),
	(24, 2, 'FEDERAL XX 1L', 'Batangan', 44000, 53000, 10, 5, 'https://federaloil.co.id/assets/captcha/product_image/2026/07/federal-ultratec-xx_600.png', '2026-07-21 15:12:15'),
	(25, 1, 'INDEMITSU 2T', 'Bebek', 54000, 65000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxfNnSyT-5IwoyYLmnbdIC-LJHXuCj5iuOkIjT4y-fEUANbV5HjcEh3sUq&s=10', '2026-07-21 15:12:15'),
	(26, 2, 'MESRAN 0,8L', 'Bebek', 40000, 48000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQabgTb4p1nfzkZhHgQqWZt7LeicwM4-xdk7iVjW_dpObAoujhWH1OFg4Z_&s=10', '2026-07-21 15:12:15'),
	(27, 2, 'MESRAN 1L', 'Bebek', 42000, 51000, 10, 5, 'https://down-id.img.susercontent.com/file/d1ff3e96870335d0d9bcfe5624980c4a', '2026-07-21 15:12:15'),
	(28, 2, 'MESRAN B', 'Bebek', 40000, 45000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//97/MTA-6696331/pertamina_pertamina_mesran_b40_sae_40_diesel_oil_galon_mobil_4_liter_-dijamin_asli-_full02_bqrpfmtm.jpg', '2026-07-21 15:12:15'),
	(29, 2, 'MOTUL MATIC 0,8L', 'Matic', 51000, 65000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7qula-lkiyaj5elintdc', '2026-07-21 15:12:15'),
	(30, 2, 'MOTUL 1L', 'Batangan', 60000, 100000, 5, 5, 'https://cdn.ruparupa.io/fit-in/850x850/filters:format(webp)/filters:watermark(content.ruparupa.io,products/wm/rr.png,0,-0,0,100,100)/ruparupa-com/image/upload/Products/10071988_1.jpg', '2026-07-21 15:12:15'),
	(31, 2, 'MPX 1 1L', 'Batangan', 55000, 62000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6Lt0Yd4OTQ5iAdFRPvLgPydIz1j0WaqTYJPPjfCJFjaPvwKGPxPi1aqid&s=10', '2026-07-21 15:12:15'),
	(32, 2, 'MPX 1 0,8L', 'Bebek', 49000, 56000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7qul2-lgojv9te0g6j0d', '2026-07-21 15:12:15'),
	(33, 2, 'MPX 2 0,65L', 'Matic', 43000, 55000, 10, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2023/03/MPX2.jpg', '2026-07-21 15:12:15'),
	(34, 2, 'MPX 2 0,8L', 'Matic', 52000, 60000, 10, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2021/04/Oli-MPX2.jpg', '2026-07-21 15:12:15'),
	(35, 2, 'PRIMA XP 1L', 'Batangan', 45000, 53000, 10, 5, 'https://media.monotaro.id/mid01/big/Otomotif%2C%20Truk%20%26%20Sepeda%20Motor/Oli%2C%20Bahan%20Kimia%2C%20Perbaikan/Oli%20Otomotive/Oli%20Mesin/Pertamina%20%C3%8Bngine%20Oil%20Prima%20XP%20Min%2020W-50%20API%20SL%20(Oli%20Mesin)/g6P104857582-1.jpg', '2026-07-21 15:12:15'),
	(36, 2, 'REPSOL 0,8L', 'Bebek', 35000, 45000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtCz6Kzje2gDcwfoFi_igB3in-KVZ8vflewcoZZNKTkLXCwbeLTzb9lzE&s=10', '2026-07-21 15:12:15'),
	(37, 2, 'REPSOL 1L', 'Batangan', 42000, 50000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/96/MTA-139055260/br-m036969-02800_oli-mesin-motor-repsol-mxr-matic-platinum-10w-40-sn-mb-1-liter_full01-64b322e2.jpg', '2026-07-21 15:12:15'),
	(38, 2, 'REPSOL MATIC 0,8L', 'Matic', 35000, 43000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoFElKAlW0S-thUbHkQItbFxPu-HKNo9GIZImbZNudDpEgjMEmiqxtuck&s=10', '2026-07-21 15:12:15'),
	(39, 1, 'SHEL 2T', 'Bebek 2T', 34000, 42000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ38BwiwJ9mRVQGkSmnp7HX4tmt6dbMtKMmRX74JuemXXMRtsa4W0jOwLZ1&s=10', '2026-07-21 15:12:15'),
	(40, 2, 'SHEL AX-7 0,8L', 'Bebek 8L', 52000, 60000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7r992-lrnzriak8mqv23', '2026-07-21 15:12:15'),
	(41, 2, 'SHEL AX-7 1L', 'Batangan', 56000, 65000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/102/MTA-117892362/shell_oli_shell_advance_ax7_matic_10w40_1lt_mb_full01_fgqi0d9f.jpg', '2026-07-21 15:12:15'),
	(42, 2, 'SHEL AX-7 MATIC 1L', 'Matic', 57000, 66000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSk3LHWZzMW5m3bdiMU3GAw0PdUniXmOe4nyUTVmCdXcoZZLSz9Joex2vo&s=10', '2026-07-21 15:12:15'),
	(43, 2, 'SHEL AX-5 0,8L 2T', 'Bebek', 42000, 50000, 10, 5, 'https://down-id.img.susercontent.com/file/2ef932ff25cc134ebaac02a204bad8f2', '2026-07-21 15:12:15'),
	(44, 2, 'SHEL AX-5 0,8L 4T', 'Bebek', 52000, 62000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//95/MTA-53608225/shell_oli-shell-advance-ax5-0-8l_full01.jpg', '2026-07-21 15:12:15'),
	(45, 2, 'SHEL AX-5 1L', 'Batangan', 52000, 65000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQGRZbD7fIvFFL0CWs1Unc4DYDBqv4Dvj_7-B9z3gIqoQd4Sn3Yzba36FQ&s=10', '2026-07-21 15:12:15'),
	(46, 2, 'SHEL AX-5 MATIC', 'Matic', 41000, 50000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQN7UpZY4ozo4D8_n73L6L6I_bAfY1nJphp-8h7R_ba65fORMqFw-DV8G0&s=10', '2026-07-21 15:12:15'),
	(47, 2, 'SHEL HELIX 1L', 'Batangan', 73000, 85000, 5, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//1109/shell_shell-helix-hx5-15w---50-engine-oil-pelumas-mesin--1-liter-_full03.jpg', '2026-07-21 15:12:15'),
	(48, 2, 'SGO 0,8L', 'Bebek', 36000, 46000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJDPQxqJXpWonT7L34R8080VCRy5dKWvdJdDaKKCAp7Gb95dJ6SAah9nOR&s=10', '2026-07-21 15:12:15'),
	(49, 2, 'SGO 1L', 'Batangan', 44000, 53000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/MTA-17931379/sgo_suzuki_sgo_ecstar_sae_20-50_4t_1_liter_-dijamin_asli-_full01_c0mpgkft.jpg', '2026-07-21 15:12:15'),
	(50, 2, 'SPX 1 0,8L', 'Bebek', 52000, 60000, 10, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2021/04/AHM_SPX1_7-8.jpg', '2026-07-21 15:12:15'),
	(51, 2, 'SPX 1 (1200mL)', 'Batangan', 62000, 70000, 10, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2018/01/Oli-SPX1-10W30-SLMA-12L-REP-082342MAK8LN0.jpg', '2026-07-21 15:12:15'),
	(52, 2, 'SPX 2 0,65L', 'Matic', 60000, 67000, 10, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2023/03/SPX2.jpg-IMAGE.jpg', '2026-07-21 15:12:15'),
	(53, 2, 'SPX 2 0,8L', 'Matic', 62000, 69000, 10, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2021/03/SPX2-1.jpg', '2026-07-21 15:12:15'),
	(54, 2, 'TOP 1 0,8L', 'Bebek', 35000, 42000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKzF28DtU7mHwdWDvciTaZm_TiRlkqAVhYQNNkqyXhF1si21l4gHAuzeNk&s=10', '2026-07-21 15:12:15'),
	(55, 2, 'TOP 1 1L', 'Batangan', 35000, 43000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSINAtIbBy0_1TEPcr_IADFZ0wm2Wcm-uq5MBeC0R1GF2tYmO68NfA5Z3A&s=10', '2026-07-21 15:12:15'),
	(56, 2, 'TOP 1 MATIC', 'Matic', 35000, 42000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7rbkd-may0j48i3muj96', '2026-07-21 15:12:15'),
	(57, 2, 'YAMAHALUBE GOLD 0,8L', 'Bebek', 45000, 54000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTeOyfYjRtQ_NdRYpDw6mw4qG48NqdoAChlpWclfs7wU2GMJzmNWig_n0QO&s=10', '2026-07-21 15:12:15'),
	(58, 2, 'YAMAHALUBE MATIC (KUNING)', 'Matic', 43000, 52000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXu5RglUdWACrBayLX82YPmz61IC0w8k3DGcMYC7mEY3dHzFJn-4ayS2E&s=10', '2026-07-21 15:12:15'),
	(59, 2, 'YAMAHALUBE SILVER', 'Bebek', 43000, 52000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSbL1BirUx3uh2wH0Of8VS47pqVXjBmGkO3fZM2TS2BLIlYUjwKGXskhDcL&s=10', '2026-07-21 15:12:15'),
	(60, 2, 'YAMAHALUBE SPORT 1L', 'Batangan', 52000, 62000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJk54QvEv--rV_iZ7LvdAokHXNJODwmh26rc9gYeueRg&s=10', '2026-07-21 15:12:15'),
	(61, 2, 'YAMAHALUBE SUPER MATIC 1L', 'Matic', 66000, 75000, 5, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/MTA-0129102/yamalube_yamalube-super-matic-10w-40-oli-pelumas-motor--1-l-_full03.jpg', '2026-07-21 15:12:15'),
	(62, 2, 'YAMAHALUBE SUPER SPORT 4T', 'Batangan', 75000, 85000, 5, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/114/MTA-155699565/yamaha_yamalube-super-sport_full01.jpg', '2026-07-21 15:12:15'),
	(63, 3, 'Minyak Rem', 'Universal', 5000, 10000, 25, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5aynN8VHKnHWv_IeZ_U4cue1TByoN8hb-gA_94QgLZjeDsWV9vGFn7Ulh&s=10', '2026-07-21 15:12:15'),
	(64, 4, 'Gasket Kanalpot', 'Force 1-F1ZR, GL 100-Pro, dll', 2000, 5000, 30, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2020/01/Gasket-Exh-Pipe-18291KVB900.jpg', '2026-07-21 15:12:15'),
	(65, 4, 'As kick Selah 5TL', 'Mio sporty', 10000, 25000, 5, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7r98v-lvwlg2yaru7gfa', '2026-07-21 15:12:15'),
	(66, 5, 'Kaca Spion', 'Honda', 13000, 35000, 10, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//100/MTA-4938724/best_seller_best_seller_kaca_spion_motor_for_yamaha_mio-_jupiter_z-_nouvo_full03_frk2v8sj.jpg', '2026-07-21 15:12:15'),
	(67, 6, 'Soket Fitting Lampu Sein', 'Universal', 2000, 15000, 30, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8HIXzZwttx8dOtMiBGv1WXfxY4zuw6uu9IeGM5XpkSIaHpPexl9WP4AM&s=10', '2026-07-21 15:12:15'),
	(68, 7, 'Karet head', 'Mio J 54P', 5000, 20000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7r98p-lo7qo4a80gei8e', '2026-07-21 15:12:15'),
	(69, 7, 'Karet Seal head', 'Vario 125 KZR', 5000, 20000, 10, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2017/11/Gasket-Head-Cover-12391GGC900.jpg', '2026-07-21 15:12:15'),
	(70, 8, 'Per As shock depan', 'mio 5TL', 13000, 30000, 6, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2019/05/51401KVY731.jpg', '2026-07-21 15:12:15'),
	(71, 9, 'Piringan disc KVB', 'Vario, Beat', 39000, 60000, 5, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2017/10/Disk-FR-Brake-45351KVB931-600x600.jpg', '2026-07-21 15:12:15'),
	(72, 9, 'Piringan disc 5TP', 'Jupiter Z, Jupiter MX', 47000, 80000, 2, 5, 'https://down-id.img.susercontent.com/file/id-11134207-822wn-mnf9vy4tmz2a09', '2026-07-21 15:12:15'),
	(73, 9, 'Piringan disc 2PV', 'King, Jupiter MX', 74000, 120000, 2, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTmREH3nQgnYrxX_o1PSzNC_1ClMlGO7Y2UfQjTmWpb8pv0EkcoafjUFr0&s=10', '2026-07-21 15:12:15'),
	(74, 8, 'Per Kampas Rem', 'BEAT, VARIO, dll', 2000, 15000, 30, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2019/12/Per-Kampas-Rem-Cakram-Spring-Pad-45108KVBT01.jpg', '2026-07-21 15:12:15'),
	(75, 10, 'Seal Kruk As Kiri K44', 'BEAT POP, BEAT ESP', 3000, 20000, 15, 5, 'https://id-live-01.slatic.net/p/484e0572c252d0d84353a208496d99f8.jpg', '2026-07-21 15:12:15'),
	(76, 6, 'AKI GTZ-7 S', 'VARIO 125/150, dll', 156000, 210000, 3, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-22120-80k56vasjclv13', '2026-07-21 15:12:15'),
	(77, 6, 'Coil Penyalaan 5TL', 'Mio', 25000, 60000, 3, 5, 'https://img.lazcdn.com/g/p/43a8f1b9d89dbf43208f01162627066e.jpg_720x720q80.jpg', '2026-07-21 15:12:15'),
	(78, 4, 'Selahan Engkol', 'VEGA R OLD', 21000, 45000, 3, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHiiw5NBWOS_A2tFZBj_itJipn6oxCwOVCmkh0nT98NtjZ6E5IVBNs-wxU&s=10', '2026-07-21 15:12:15'),
	(79, 6, 'AKI GTZ-6 V', 'Vario 125, SCOOPY FI, dll', 130000, 180000, 23, 5, 'https://www.hondacengkareng.com/wp-content/uploads/2017/11/Battery-GTZ6V-31500KZR602.jpg', '2026-07-21 15:12:15'),
	(80, 5, 'Bohlam LED Osram', 'Universal', 28000, 50000, 6, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7rasm-m4m6bp865bne6b', '2026-07-21 15:12:15'),
	(81, 6, 'Busi NGK D8EA', 'Mega PRO, Tiger', 5000, 25000, 20, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/MTA-17939473/ngk_ngk_d8ea_busi_motor_full01_md4szqcn.jpg', '2026-07-21 15:12:15'),
	(82, 3, 'WD-40 40ML', 'Universal', 40000, 60000, 5, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVSXpyUe77YVYoClqCekqDkqE3Y3WtCxI8d5GwrYtNJKAjSK80SXvRmZQ&s=10', '2026-07-21 15:12:15'),
	(83, 10, 'Threebond 25gr', 'Universal', 9000, 16000, 20, 5, 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/100/MTA-177472530/threebond_lem_gasket_threebond-treebond-3bond_25gr_tb_1104_eco_full01_bli51x6k.jpg', '2026-07-21 15:12:15'),
	(84, 6, 'Busi Z9Y CHAMPIION', 'MIO, JUPITER, dll', 5000, 25000, 20, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7qukx-ljt82c6lknj677', '2026-07-21 15:12:15'),
	(85, 9, 'Kampas Rem Belakang 5MX', 'MIO, JUPITER MX', 31000, 60000, 20, 5, 'https://down-id.img.susercontent.com/file/84c949f8caf7ff5e89104c136cabd9ff', '2026-07-21 15:12:15'),
	(86, 6, 'AKI GTZ-5 S', 'MATIC & BEBEK', 120000, 170000, 3, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBUtQ07M_98UX6ryLkpoMTbrcUI4yDEarcJjO9I7r6lTl7skQoVH6OYmhf&s=10', '2026-07-21 15:12:15'),
	(87, 5, 'AUTOSOL 15gr', 'Universal', 12000, 20000, 30, 5, 'https://down-id.img.susercontent.com/file/7cc917ab1a6237f4bf7afe2e485502d7', '2026-07-21 15:12:15'),
	(88, 5, 'Kawat Seling Gas', 'Universal', 3000, 10000, 20, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-7rdvu-lxybof0at75277', '2026-07-21 15:12:15'),
	(89, 5, 'Ban Luar Honda (90/90-14)', 'Vario 125', 230000, 280000, 5, 5, 'https://down-id.img.susercontent.com/file/74208deccdb6aa1315ce10dbcb1c04ac', '2026-07-21 15:12:15'),
	(90, 11, 'Bearing NKN 6201 ZZ', 'Universal', 8000, 20000, 20, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-7rbmv-llemrgvhqa0k8b', '2026-07-21 15:12:15'),
	(91, 11, 'Bearing NKN 6202 2RS', 'Universal', 12000, 25000, 20, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSab9PBmjYa_84jemTSgPwhVE3qoqcOiAR6c2N95KOaXzP_rZWCDkdhp4A&s=10', '2026-07-21 15:12:15'),
	(92, 11, 'Bearing NKN 6203 ZZ', 'Universal', 12000, 20000, 20, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-7rbm9-lq4hrip2qhs443', '2026-07-21 15:12:15'),
	(93, 11, 'Bearing NKN 6201 2RS', 'Universal', 9000, 20000, 20, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTN3-FK-opr9TZs0JUJL-wSD_bQcSD6SBbS9fVlnhe1tvhaxd2Dl6xLeIty&s=10', '2026-07-21 15:12:15'),
	(94, 11, 'Bearing NKN 6301 2RS', 'Universal', 9000, 20000, 20, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-7rbn7-llom4311n8xx39', '2026-07-21 15:12:15'),
	(95, 11, 'Bearing NKN 6004 ZZ', 'Universal', 12000, 20000, 10, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlV9O-jYb0NOqKI6Kt95Qi5vZm-r0SYGE7gRbgwXDFXA&s=10', '2026-07-21 15:12:15'),
	(96, 11, 'Bearing NKN 6001 2RS', 'Universal', 8000, 20000, 20, 5, 'https://down-id.img.susercontent.com/file/id-11134207-81ztg-mf592ff3bbwp52', '2026-07-21 15:12:15'),
	(97, 11, 'Bearing NKN 6300 2RS', 'Universal', 12000, 20000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7r98o-lzildiskv21466', '2026-07-21 15:12:15'),
	(98, 11, 'Bearing NKN 6206 2RS', 'Universal', 28000, 35000, 10, 5, 'https://down-id.img.susercontent.com/file/5edaed4c00e9483e254fba21678d140f', '2026-07-21 15:12:15'),
	(99, 11, 'Bearing NKN 6304 2RS', 'Universal', 22000, 30000, 10, 5, 'https://down-id.img.susercontent.com/file/19ac636ae20e0bc52aa4065a521eee92', '2026-07-21 15:12:15'),
	(100, 11, 'Bearing NKN 6205 ZZ', 'Universal', 20000, 30000, 10, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-7rcck-lr5n5nyeqbbm22', '2026-07-21 15:12:15'),
	(101, 11, 'Bearing NKN 6300 ZZ', 'Universal', 11000, 20000, 10, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-8259s-mg3fxhfa2k219c', '2026-07-21 15:12:15'),
	(102, 11, 'Bearing NKN 6301 ZZ', 'Universal', 11000, 20000, 10, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-7rcdj-lsus1jp57lyt73', '2026-07-21 15:12:15'),
	(103, 11, 'Bearing NKN 6901 ZZ', 'Universal', 11000, 20000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7rasj-m5yriksuu6c8d5', '2026-07-21 15:12:15'),
	(104, 11, 'Bearing KOYO 6302 RMX', 'Universal', 20000, 30000, 10, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7r98q-lwz9fwu5fay618', '2026-07-21 15:12:15'),
	(105, 11, 'Bearing NKN 6000 ZZ', 'Universal', 7000, 20000, 20, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7qul8-liuwy4ywd4yf07', '2026-07-21 15:12:15'),
	(106, 11, 'Bearing NKN 607 2RS (Mini)', 'Universal', 7000, 20000, 20, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTdE33ycRzyZmtumByr9CXQgO8HwBImkF-SJKWGwFNOBGCZ911IksFwKZAF&s=10', '2026-07-21 15:12:15'),
	(107, 11, 'Bearing NKN 629 2RS (Mini)', 'Universal', 7000, 20000, 20, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXnn52kHZRDLfINiZIY3ZlCffMmJHHff7w-XkfAtXxTSoxjrcEXvsNkvQ&s=10', '2026-07-21 15:12:15'),
	(108, 11, 'Bearing HONDA 63000', 'Universal', 7000, 20000, 20, 5, 'https://down-id.img.susercontent.com/file/id-11134207-7r98x-lz5zx2h5q4f2d0', '2026-07-21 15:12:15'),
	(109, 11, 'Bearing ARTCO Gerobak', 'Universal', 7000, 20000, 20, 5, 'https://down-id.img.susercontent.com/file/id-11134207-8224q-mkxlv4myvojn3e', '2026-07-21 15:12:15'),
	(110, 11, 'Bearing HONDA 6202', 'Universal', 7000, 20000, 20, 5, 'https://down-id.img.susercontent.com/file/105e8553e6e3ea92a30ed1fd583efbe3', '2026-07-21 15:12:15'),
	(111, 11, 'Bearing HONDA 6300', 'Universal', 7000, 20000, 20, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmTvoI2yblFsdGKeXDHCMGtNsw_65UcPrbdU9LY9U5z5mVGbCunIto8k0&s=10', '2026-07-21 15:12:15'),
	(112, 11, 'Bearing HONDA 6301 RS', 'Universal', 7000, 20000, 15, 5, 'https://down-id.img.susercontent.com/file/62d6d7c81c4e32ca399c84cdba870781', '2026-07-21 15:12:15'),
	(113, 11, 'Bearing HONDA 6201', 'Universal', 7000, 20000, 19, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5vGouJaqIrpde1BW7lqmOeCtxR5azNl_Nt0UC5PL6cBm-OYNXO1DQIwNA&s=10', '2026-07-21 15:12:15'),
	(114, 11, 'Bearing NKN 62/22 2RS', 'Universal', 17000, 25000, 15, 5, 'https://down-id.img.susercontent.com/file/sg-11134201-22120-j73xihji7qkvb0', '2026-07-21 15:12:15');

-- Dumping structure for table inventorisparepart.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table inventorisparepart.suppliers: ~2 rows (approximately)
INSERT INTO `suppliers` (`id`, `name`, `contact`, `address`, `created_at`) VALUES
	(1, 'Supplier A', '08123456789', NULL, '2026-07-21 15:12:15'),
	(2, 'Supplier B', '08987654321', NULL, '2026-07-21 15:12:15');

-- Dumping structure for table inventorisparepart.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_id` int NOT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_tagihan` int NOT NULL,
  `metode_pembayaran` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Menunggu Pembayaran',
  `alamat_pengiriman` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trans_cust` (`customer_id`),
  CONSTRAINT `trans_cust` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table inventorisparepart.transaksi: ~8 rows (approximately)
INSERT INTO `transaksi` (`id`, `invoice`, `customer_id`, `tanggal`, `total_tagihan`, `metode_pembayaran`, `status`, `alamat_pengiriman`) VALUES
	(1, 'INV-20260723-788B', 2, '2026-07-23 15:06:32', 25000, 'COD (Bayar di Bengkel)', 'Menunggu Pembayaran', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur'),
	(2, 'INV-20260723-D9AD', 2, '2026-07-23 15:08:57', 25000, 'COD (Bayar di Bengkel)', 'Selesai', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur'),
	(3, 'INV-20260723-640A', 2, '2026-07-23 16:12:03', 80000, 'E-Wallet/QRIS (Mock-up)', 'Menunggu Pembayaran', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur'),
	(4, 'INV-20260725-F7A6', 2, '2026-07-25 12:31:56', 40000, 'QRIS', 'Menunggu Pembayaran', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur'),
	(5, 'INV-20260725-B408', 2, '2026-07-25 12:40:16', 40000, 'Virtual Account BCA', 'Menunggu Pembayaran', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur'),
	(6, 'INV-20260725-FD92', 2, '2026-07-25 12:43:48', 45000, 'COD', 'Menunggu Pembayaran', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur'),
	(7, 'INV-20260725-6701', 2, '2026-07-25 12:48:44', 50000, 'Virtual Account BCA', 'Diproses', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur'),
	(8, 'INV-20260725-E357', 2, '2026-07-25 13:05:28', 35000, 'QRIS', 'Diproses', 'Jl. Kayu Manis VII No. 17, Matraman, Jakarta Timur');

-- Dumping structure for table inventorisparepart.transaksi_detail
CREATE TABLE IF NOT EXISTS `transaksi_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaksi_id` int NOT NULL,
  `sparepart_id` int NOT NULL,
  `qty` int NOT NULL,
  `harga_satuan` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `det_trans` (`transaksi_id`),
  KEY `det_part` (`sparepart_id`),
  CONSTRAINT `det_part` FOREIGN KEY (`sparepart_id`) REFERENCES `spareparts` (`id`),
  CONSTRAINT `det_trans` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table inventorisparepart.transaksi_detail: ~7 rows (approximately)
INSERT INTO `transaksi_detail` (`id`, `transaksi_id`, `sparepart_id`, `qty`, `harga_satuan`) VALUES
	(1, 1, 114, 1, 25000),
	(2, 2, 114, 1, 25000),
	(3, 3, 112, 4, 20000),
	(4, 4, 114, 1, 25000),
	(5, 5, 114, 1, 25000),
	(6, 6, 113, 1, 20000),
	(7, 7, 114, 1, 25000),
	(8, 8, 112, 1, 20000);

-- Dumping structure for table inventorisparepart.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','staff') COLLATE utf8mb4_general_ci DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table inventorisparepart.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `google_id`, `role`, `created_at`) VALUES
	(1, 'admin', 'admin@siskamajumotor.com', 'admin123', NULL, 'admin', '2026-07-21 15:12:15');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
