-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: php2
-- ------------------------------------------------------
-- Server version	9.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bienthe_products`
--

DROP TABLE IF EXISTS `bienthe_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bienthe_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_products` int DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `img` varchar(450) DEFAULT NULL,
  `soluong` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_idx` (`id_products`) /*!80000 INVISIBLE */,
  CONSTRAINT `products` FOREIGN KEY (`id_products`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bienthe_products`
--

LOCK TABLES `bienthe_products` WRITE;
/*!40000 ALTER TABLE `bienthe_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `bienthe_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `giam_gia` int NOT NULL COMMENT 'Số tiền hoặc % giảm',
  `loai` int NOT NULL DEFAULT '1' COMMENT '1: Trừ tiền trực tiếp, 2: Trừ %',
  `ngay_hethan` date DEFAULT NULL,
  `soluong` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `danhmuc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tendanhmuc` varchar(45) DEFAULT NULL,
  `img` varchar(425) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `danhmuc`
--

LOCK TABLES `danhmuc` WRITE;
/*!40000 ALTER TABLE `danhmuc` DISABLE KEYS */;
INSERT INTO `danhmuc` VALUES (6,'Áo nam','ao-khoac-so-mi-caro-cotton-wavy-cut-1_5.png'),(8,'Quần nam','quan_short_cargo_polyamide_fatigue_gray_2_1.webp'),(9,'Quần nữ','150925.hades0285_large_8b291c99306f4d89aa909dff3dcf6688.jpeg');
/*!40000 ALTER TABLE `danhmuc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ma_giam_gia`
--

DROP TABLE IF EXISTS `ma_giam_gia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ma_giam_gia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ma_code` varchar(50) NOT NULL,
  `loai` varchar(10) DEFAULT 'fixed',
  `gia_tri` decimal(10,2) NOT NULL,
  `so_luong` int DEFAULT '0',
  `ngay_het_han` date DEFAULT NULL,
  `trang_thai` tinyint(1) DEFAULT '1',
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ma_code` (`ma_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ma_giam_gia`
--

LOCK TABLES `ma_giam_gia` WRITE;
/*!40000 ALTER TABLE `ma_giam_gia` DISABLE KEYS */;
INSERT INTO `ma_giam_gia` VALUES (1,'SALE20251','percent',10.00,100,'2026-03-30',1,'2026-01-31 15:08:58');
/*!40000 ALTER TABLE `ma_giam_gia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `mota` text,
  `img` varchar(450) DEFAULT NULL,
  `danhmuc_id` int DEFAULT NULL,
  `thuonghieu_id` int DEFAULT NULL,
  `soluong` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (24,'gdrgdrg',70000.00,NULL,'ao_thun_what_it_it_nt_x_abc-mart_da_me_blue_3_1.png',6,1,NULL),(26,'Áo thun',100000.00,'dsfs','ao_thun_what_it_it_nt_x_abc-mart_da_me_blue_1_1.png',NULL,NULL,NULL),(27,'Áo khoác',300000.00,'sgoungosgfs','ao_khoac_boxy_wii_cotton_nylon_5_10_black_1_1_1.jpg',NULL,NULL,NULL),(28,'Quần short',400000.00,'sdfsdfsdfsc','quan_short_cargo_polyamide_fatigue_gray_2_1.png',NULL,NULL,NULL),(29,'Quần dài',100000.00,'ssnjsnd;jnsjf','quan_carpenter_wii_cotton_nylon_relaxed_fit_black2_2.png',NULL,NULL,NULL),(30,'Quần Short',300000.00,'jhđhdkjfhdh','quan_shorts_polyamide_big_logo_black_2_1_3.png',NULL,NULL,NULL),(31,'PK001',43564564.00,'gbfgfnf','Guys, the last photo is my best one ? I’ve never looked so attractive, lol #fyp #alt #altgirl.jpg',6,1,NULL),(32,'Áo phong',50000.00,'yththytht','_dsf7681_large_2de45b553fa84c3a96e4b6a269affc6c.jpeg',6,1,NULL),(33,'Aso thun',500000.00,'gđfdfbd','quan_shorts_polyamide_tagging_logo_black_3_3_1.png',6,1,50),(34,'Quaanf nam',700000.00,'hnfghdghd','quan_short_cargo_polyamide_fatigue_gray_1_1.png',6,1,100);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sinhvien`
--

DROP TABLE IF EXISTS `sinhvien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sinhvien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mssv` varchar(45) DEFAULT NULL,
  `hotensv` varchar(45) DEFAULT NULL,
  `nganh` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sinhvien`
--

LOCK TABLES `sinhvien` WRITE;
/*!40000 ALTER TABLE `sinhvien` DISABLE KEYS */;
INSERT INTO `sinhvien` VALUES (9,'PK001','Y ĐĂNG NIÊ','IT'),(10,'PK002','HUY','Lập Trình Web'),(11,'PK003','Kunas','Marketing'),(12,'PK004','BUINA','Lập Trình Web');
/*!40000 ALTER TABLE `sinhvien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thuonghieu`
--

DROP TABLE IF EXISTS `thuonghieu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thuonghieu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenthuonghieu` varchar(45) DEFAULT NULL,
  `img` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thuonghieu`
--

LOCK TABLES `thuonghieu` WRITE;
/*!40000 ALTER TABLE `thuonghieu` DISABLE KEYS */;
INSERT INTO `thuonghieu` VALUES (1,'Gucci','website_begie_fix_-_tr_c_3.webp'),(2,'Gucci',''),(3,'Balen','website_begie_fix_-_sau_3.webp'),(4,'Balen','quan_carpenter_wii_cotton_nylon_relaxed_fit_black1_2.webp');
/*!40000 ALTER TABLE `thuonghieu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tintuc`
--

DROP TABLE IF EXISTS `tintuc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tintuc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tieude` varchar(45) DEFAULT NULL,
  `mota` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tintuc`
--

LOCK TABLES `tintuc` WRITE;
/*!40000 ALTER TABLE `tintuc` DISABLE KEYS */;
INSERT INTO `tintuc` VALUES (1,'IT 2025 - 2026','fkdjkdfdfdf');
/*!40000 ALTER TABLE `tintuc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `ten` varchar(45) DEFAULT NULL,
  `matkhau` varchar(255) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `img` varchar(455) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (15,NULL,'ydangnie6','$2y$10$bQuODpiJgniB/52pjLY9Z.iM/LwsM4LFORlRgFw5I40EsdaKHJH5G','admin',NULL,NULL),(16,NULL,'ydangnie67','$2y$10$PVb3D7NXEwtMYkqI3a.o2eKz9Nw7tz1z6HUGF8ds0t0HzplRjp1h2',NULL,NULL,NULL),(17,NULL,'ydangnie68','$2y$10$nnb8djn.DG0DXPWH2WpruOt3ZvbeMHGNsX6eZZHFmURFiNUBfL.Ya',NULL,NULL,NULL),(18,NULL,'dangnie999','$2y$10$DnwsY.ZjaA3/ezLqNqx/WOJ0N1lz6MOgebGGuAl8KX3IabRV2xLCe','nguoidung',NULL,NULL),(19,NULL,'Y ĐĂNG NIÊ','$2y$10$WVFSOu5uchg3x3r9rvu5UO/ZIeYNqG4ic204mXyGhQo..H0Z4vFUS','nguoidung',NULL,NULL),(20,'nieydpk04105@gmail.com','ydangnie1','$2y$10$XM8i2i10MrgL98xk29kKUOfBp6bVAGxxBOJDYn4fSR2ctiO7s5hcy',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-31 23:17:40