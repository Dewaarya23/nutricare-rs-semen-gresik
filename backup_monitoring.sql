-- MySQL dump 10.13  Distrib 8.4.7, for Win64 (x86_64)
--
-- Host: localhost    Database: kp_rs_gizi
-- ------------------------------------------------------
-- Server version	8.4.7

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ringkasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diet_logs`
--

DROP TABLE IF EXISTS `diet_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diet_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tujuan_diet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_factor` double NOT NULL,
  `target_kkal` double NOT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `diet_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `diet_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diet_logs`
--

LOCK TABLES `diet_logs` WRITE;
/*!40000 ALTER TABLE `diet_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `diet_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disease_menu`
--

DROP TABLE IF EXISTS `disease_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disease_menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disease_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `disease_menu_menu_id_disease_id_unique` (`menu_id`,`disease_id`),
  KEY `disease_menu_disease_id_foreign` (`disease_id`),
  CONSTRAINT `disease_menu_disease_id_foreign` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`id`) ON DELETE CASCADE,
  CONSTRAINT `disease_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`kode_menu`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disease_menu`
--

LOCK TABLES `disease_menu` WRITE;
/*!40000 ALTER TABLE `disease_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `disease_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disease_user`
--

DROP TABLE IF EXISTS `disease_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disease_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `disease_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `disease_user_user_id_disease_id_unique` (`user_id`,`disease_id`),
  KEY `disease_user_disease_id_foreign` (`disease_id`),
  CONSTRAINT `disease_user_disease_id_foreign` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`id`) ON DELETE CASCADE,
  CONSTRAINT `disease_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disease_user`
--

LOCK TABLES `disease_user` WRITE;
/*!40000 ALTER TABLE `disease_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `disease_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diseases`
--

DROP TABLE IF EXISTS `diseases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diseases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_penyakit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `diseases_kode_penyakit_unique` (`kode_penyakit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diseases`
--

LOCK TABLES `diseases` WRITE;
/*!40000 ALTER TABLE `diseases` DISABLE KEYS */;
INSERT INTO `diseases` VALUES (1,'D001','Obesitas',NULL,NULL),(2,'D002','Diabetes',NULL,NULL);
/*!40000 ALTER TABLE `diseases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food_logs`
--

DROP TABLE IF EXISTS `food_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `food_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint unsigned NOT NULL,
  `menu_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_makan` enum('pagi','siang','malam') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` double NOT NULL,
  `gram_total` double NOT NULL,
  `kkal_total` double NOT NULL,
  `karbo_total` double NOT NULL,
  `protein_total` double NOT NULL,
  `lemak_total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `food_logs_patient_id_foreign` (`patient_id`),
  KEY `food_logs_menu_id_foreign` (`menu_id`),
  CONSTRAINT `food_logs_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`kode_menu`) ON DELETE CASCADE,
  CONSTRAINT `food_logs_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food_logs`
--

LOCK TABLES `food_logs` WRITE;
/*!40000 ALTER TABLE `food_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `food_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_weight_options`
--

DROP TABLE IF EXISTS `menu_weight_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_weight_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_berat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gram` double NOT NULL,
  `kkal_urt` double NOT NULL DEFAULT '0',
  `karbo_urt` double NOT NULL DEFAULT '0',
  `protein_urt` double NOT NULL DEFAULT '0',
  `lemak_urt` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_weight_options_kode_menu_foreign` (`kode_menu`),
  CONSTRAINT `menu_weight_options_kode_menu_foreign` FOREIGN KEY (`kode_menu`) REFERENCES `menus` (`kode_menu`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_weight_options`
--

LOCK TABLES `menu_weight_options` WRITE;
/*!40000 ALTER TABLE `menu_weight_options` DISABLE KEYS */;
INSERT INTO `menu_weight_options` VALUES (1,'k1','Gelas',0.5,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(2,'k1','Gram',1,0,0.5,0.04,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(3,'k2','Gelas',1,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(4,'k2','Gram',1,0,0.25,0.02,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(5,'k3','Gelas',2,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(6,'k3','Gram',1,0,0.125,0.01,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(7,'k4','Gelas',0.75,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(8,'k4','Gram',1,0,0.5,0.04,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(9,'k5','Biji sedang',4,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:52:02'),(10,'k5','Gram',1,0,0.25,0.02,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(11,'k6','Potong sedang',1,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(12,'k6','Gram',1,0,0.5,0.04,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(13,'k7','Biji sedang',1,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(14,'k7','Gram',1,0,0.25,0.02,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(15,'k8','Biji sedang',1,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(16,'k8','Gram',1,0,0.333333333,0.026666667,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(17,'k9','Buah',4,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(18,'k9','Gram',1,0,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(19,'k10','Buah besar',5,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(20,'k10','Gram',1,0,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(21,'k11','Iris',4,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(22,'k11','Gram',1,0,0.625,0.05,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(23,'k12','Gelas',1,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(24,'k12','Gram',1,0,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(25,'k13','Gelas',1.5,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(26,'k13','Gram',1,0,0.5,0.04,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(27,'k14','Gelas',0.5,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(28,'k14','Gram',1,0,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(29,'k15','Sendok (sdm)',8,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(30,'k15','Gram',1,0,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(31,'k16','Sendok (sdm)',8,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(32,'k16','Gram',1,0,1.25,0.1,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(33,'k17','Sendok (sdm)',8,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(34,'k17','Gram',1,0,1.25,0.1,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(35,'k18','Sendok (sdm)',7,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(36,'k18','Gram',1,0,1.25,0.1,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(37,'k19','Sendok (sdm)',8,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(38,'k19','Gram',1,0,1.25,0.1,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(39,'k20','Sendok (sdm)',8,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(40,'k20','Gram',1,0,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(41,'k21','Sendok (sdm)',6,175,50,4,0,'2026-04-13 03:05:55','2026-04-13 06:49:56'),(42,'k21','Gram',1,0,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(43,'PHR1','Potong sedang',1,50,0,7,2,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(44,'PHR1','Gram',1,0,0,0.175,0.05,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(45,'PHR2','Potong sedang',1,50,0,7,2,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(46,'PHR2','Gram',1,0,0,0.14,0.04,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(47,'PHR3','Potong kecil',1,50,0,7,2,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(48,'PHR3','Gram',1,0,0,0.466666667,0.133333333,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(49,'PHS1','Biji kecil',10,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(50,'PHS1','Gram',1,0,0,0.07,0.05,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(51,'PHS2','Potong sedang',1,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(52,'PHS2','Gram',1,0,0,0.175,0.125,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(53,'PHS3','Potong sedang',1,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(54,'PHS3','Gram',1,0,0,0.2,0.142857143,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(55,'PHS4','Buah sedang',1,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(56,'PHS4','Gram',1,0,0,0.233333333,0.166666667,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(57,'PHS5','Potong besar',1,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(58,'PHS5','Gram',1,0,0,0.107692308,0.076923077,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(59,'PHS6','Potong sedang',1,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(60,'PHS6','Gram',1,0,0,0.175,0.125,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(61,'PHS7','Bulatan',3,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(62,'PHS7','Gram',1,0,0,0.093333333,0.066666667,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(63,'PHS8','Butir',1,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(64,'PHS8','Gram',1,0,0,0.14,0.1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(65,'PHS9','Butir kecil',5,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(66,'PHS9','Gram',1,0,0,0.116666667,0.083333333,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(67,'PHS10','Gelas',0.25,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(68,'PHS10','Gram',1,0,0,0.14,0.1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(69,'PHS11','Ekor',1,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(70,'PHS11','Gram',1,0,0,0.14,0.1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(71,'PHS12','Gelas',0.5,75,0,7,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(72,'PHS12','Gram',1,0,0,0.077777778,0.055555556,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(73,'PST1','Potong sedang',1,150,0,7,13,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(74,'PST1','Gram',1,0,0,0.155555556,0.288888889,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(75,'PST2','Sendok (sdm)',3,150,0,7,13,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(76,'PST2','Gram',1,0,0,0.155555556,0.288888889,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(77,'PST3','Potong sedang',1,150,0,7,13,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(78,'PST3','Gram',1,0,0,0.127272727,0.236363636,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(79,'PST4','Potong sedang',1,150,0,7,13,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(80,'PST4','Gram',1,0,0,0.14,0.26,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(81,'PST5','Potong sedang',0.5,150,0,7,13,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(82,'PST5','Gram',1,0,0,0.14,0.26,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(83,'PST6','Butir',2,150,0,7,13,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(84,'PST6','Gram',1,0,0,0.155555556,0.288888889,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(85,'PN1','Potong sedang',2,80,8,6,3,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(86,'PN1','Gram',1,0,0.16,0.12,0.06,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(87,'PN2','Potong sedang',1,80,8,6,3,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(88,'PN2','Gram',1,0,0.08,0.06,0.03,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(89,'PN3','Potong sedang',2,80,8,6,3,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(90,'PN3','Gram',1,0,0.16,0.12,0.06,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(91,'PN4','Sendok (sdm)',2.5,80,8,6,3,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(92,'PN4','Gram',1,0,0.32,0.24,0.12,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(93,'PN5','Sendok (sdm)',2.5,80,8,6,3,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(94,'PN5','Gram',1,0,0.32,0.24,0.12,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(95,'PN6','Sendok (sdm)',2.5,80,8,6,3,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(96,'PN6','Gram',1,0,0.32,0.24,0.12,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(97,'PN7','Sendok (sdm)',2.5,80,8,6,3,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(98,'PN7','Gram',1,0,0.32,0.24,0.12,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(99,'PN8','Sendok (sdm)',2,80,8,6,3,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(100,'PN8','Gram',1,0,0.4,0.3,0.15,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(101,'S1','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(102,'S2','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(103,'S3','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(104,'S4','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(105,'S5','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(106,'S6','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(107,'S7','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(108,'S8','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(109,'S9','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(110,'S10','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(111,'S11','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(112,'S12','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(113,'S13','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(114,'S14','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(115,'S15','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(116,'S16','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(117,'S17','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(118,'S18','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(119,'S19','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(120,'S20','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(121,'S21','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(122,'S22','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(123,'S23','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(124,'S24','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(125,'S25','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(126,'S26','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(127,'S27','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(128,'S28','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(129,'S29','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(130,'S30','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(131,'S31','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(132,'S32','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(133,'S33','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(134,'S34','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(135,'S35','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(136,'S36','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(137,'S37','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(138,'S38','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(139,'S39','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(140,'S40','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(141,'S41','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(142,'S42','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(143,'S43','Gram',1,0,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(144,'BG1','Buah sedang',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(145,'BG1','Gram',1,0,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(146,'BG2','Biji',3,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(147,'BG2','Gram',1,0,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(148,'BG3','Buah',8,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(149,'BG3','Gram',1,0,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(150,'BG4','Gelas',0.5,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(151,'BG4','Gram',1,0,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(152,'BG5','Buah',0.1667,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(153,'BG5','Gram',1,0,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(154,'BG6','Buah',10,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(155,'BG6','Gram',1,0,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(156,'BG7','Buah',10,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(157,'BG7','Gram',1,0,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(158,'BG8','Biji',3,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(159,'BG8','Gram',1,0,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(160,'BG9','Buah',2,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(161,'BG9','Gram',1,0,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(162,'BG10','Buah',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(163,'BG10','Gram',1,0,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(164,'BG11','Buah sedang',2,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(165,'BG11','Gram',1,0,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(166,'BG12','Buah sedang',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(167,'BG12','Gram',1,0,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(168,'BG13','Buah sedang',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(169,'BG13','Gram',1,0,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(170,'BG14','Buah sedang',2,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(171,'BG14','Gram',1,0,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(172,'BG15','Potong',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(173,'BG15','Gram',1,0,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(174,'BG16','Buah besar',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(175,'BG16','Gram',1,0,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(176,'BG17','Buah besar',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(177,'BG17','Gram',1,0,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(178,'BG18','Potong',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(179,'BG18','Gram',1,0,0.08,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(180,'BG19','Potong',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(181,'BG19','Gram',1,0,0.06,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(182,'BG20','Potong',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(183,'BG20','Gram',1,0,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(184,'BG21','Buah kecil',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(185,'BG21','Gram',1,0,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(186,'BG22','Buah',0.5,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(187,'BG22','Gram',1,0,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(188,'BG23','Buah',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(189,'BG23','Gram',1,0,0.096,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(190,'BG24','Buah',0.5,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(191,'BG24','Gram',1,0,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(192,'BG25','Buah',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(193,'BG25','Gram',1,0,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(194,'BG26','Buah besar',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(195,'BG26','Gram',1,0,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(196,'BG27','Buah sedang',2,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(197,'BG27','Gram',1,0,0.096,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(198,'BG28','Sendok (sdm)',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(199,'BG28','Gram',1,0,0.8,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(200,'BG29','Sendok (sdm)',1,50,12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(201,'BG29','Gram',1,0,1.2,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(202,'STL1','Gelas',1,70,11,7,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(203,'STL1','Gram',1,0,0.055,0.035,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(204,'STL2','Sendok (sdm)',4,70,11,7,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(205,'STL2','Gram',1,0,0.55,0.35,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(206,'STL3','Gelas',0.67,70,11,7,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(207,'STL3','Gram',1,0,0.091666667,0.058333333,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(208,'SRL1','Potong kecil',1,125,10,7,6,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(209,'SRL1','Gram',1,0,0.285714286,0.2,0.171428571,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(210,'SRL2','Gelas',0.75,125,10,7,6,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(211,'SRL2','Gram',1,0,0.060606061,0.042424242,0.036363636,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(212,'SRL3','Gelas',1,125,10,7,6,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(213,'SRL3','Gram',1,0,0.05,0.035,0.03,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(214,'SRL4','Gelas',1,125,10,7,6,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(215,'SRL4','Gram',1,0,0.05,0.035,0.03,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(216,'SRL5','Sendok (sdm)',4,125,10,7,6,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(217,'SRL5','Gram',1,0,0.4,0.28,0.24,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(218,'SRL6','Gelas',1,125,10,7,6,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(219,'SRL6','Gram',1,0,0.05,0.035,0.03,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(220,'STIL1','Sendok (sdm)',6,150,10,7,10,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(221,'STIL1','Gram',1,0,0.333333333,0.233333333,0.333333333,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(222,'M1','Sendok teh',1,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(223,'M1','Gram',1,0,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(224,'M2','Sendok teh',1,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(225,'M2','Gram',1,0,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(226,'M3','Sendok teh',1,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(227,'M3','Gram',1,0,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(228,'M4','Sendok teh',1,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(229,'M4','Gram',1,0,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(230,'M5','Sendok teh',1,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(231,'M5','Gram',1,0,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(232,'M6','Sendok (sdm)',5,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(233,'M6','Gram',1,0,0,0,0.2,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(234,'M7','Sendok (sdm)',4,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(235,'M7','Gram',1,0,0,0,0.125,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(236,'M8','Sendok (sdm)',1.5,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(237,'M8','Gram',1,0,0,0,0.333333333,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(238,'M9','Potong kecil',1,45,0,0,5,'2026-04-13 03:05:55','2026-04-13 03:05:55'),(239,'M9','Gram',1,0,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55');
/*!40000 ALTER TABLE `menu_weight_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `kode_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('K','PN','PHR','PHS','PST','S','BG','M','STL','SRL','STIL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kkal_per_gram` double NOT NULL,
  `karbo_per_gram` double NOT NULL,
  `protein_per_gram` double NOT NULL,
  `lemak_per_gram` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kode_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES ('BG1','BG','Mangga',1,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG10','BG','Jeruk keprok',0.5,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG11','BG','Jambu air',0.5,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG12','BG','Jambu biji',0.5,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG13','BG','Jambu bol',0.66666666666667,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG14','BG','Kedondong',0.5,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG15','BG','Pepaya',0.5,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG16','BG','Salak',0.66666666666667,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG17','BG','Sawo',1,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG18','BG','Semangka',0.33333333333333,0.08,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG19','BG','Melon',0.25,0.06,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG2','BG','Nangka masak',1,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG20','BG','Blewah',0.5,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG21','BG','Apel',0.66666666666667,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG22','BG','Alpukat',1,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG23','BG','Belimbing',0.4,0.096,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG24','BG','Pear',0.66666666666667,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG25','BG','Pisang ambon',1,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG26','BG','Pisang kepok',1,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG27','BG','Tomat masak',0.4,0.096,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG28','BG','Madu',3.3333333333333,0.8,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG29','BG','Gula',5,1.2,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG3','BG','Rambutan',0.66666666666667,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG4','BG','Sirsak',1,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG5','BG','Nanas',0.66666666666667,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG6','BG','Anggur',0.66666666666667,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG7','BG','Duku',0.66666666666667,0.16,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG8','BG','Durian',1,0.24,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('BG9','BG','Jeruk manis',0.5,0.12,0,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k1','K','Nasi',1.75,0.5,0.04,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k10','K','Krakers',3.5,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k11','K','Roti putih',2.1875,0.625,0.05,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k12','K','Mi kering',3.5,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k13','K','Mi basah',1.75,0.5,0.04,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k14','K','Bihun',3.5,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k15','K','Tepung beras',3.5,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k16','K','Maizena',4.375,1.25,0.1,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k17','K','Tepung hunkwee',4.375,1.25,0.1,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k18','K','Tepung sagu',4.375,1.25,0.1,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k19','K','Tepung singkong',4.375,1.25,0.1,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k2','K','Nasi Tim',0.875,0.25,0.02,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k20','K','Tepung terigu',3.5,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k21','K','Havermout',3.5,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k3','K','Bubur beras',0.4375,0.125,0.01,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k4','K','Nasi Jagung',1.75,0.5,0.04,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k5','K','Kentang',0.875,0.25,0.02,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k6','K','Singkong',1.75,0.5,0.04,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k7','K','Talas',0.875,0.25,0.02,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k8','K','Ubi',1.1666666666667,0.333333333,0.026666667,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('k9','K','Biskuit meja',3.5,1,0.08,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M1','M','Minyak kelapa',9,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M2','M','Minyak ikan',9,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M3','M','Minyak kelapa sawit',9,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M4','M','Mentega',9,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M5','M','Margarin',9,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M6','M','Kelapa parut',1.8,0,0,0.2,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M7','M','Santan encer',1.125,0,0,0.125,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M8','M','Santan kental',3,0,0,0.333333333,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('M9','M','Lemak sapi/gajih',9,0,0,1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHR1','PHR','Ayam tanpa kulit',1.25,0,0.175,0.05,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHR2','PHR','Ikan segar',1,0,0.14,0.04,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHR3','PHR','Ikan kering',3.3333333333333,0,0.466666667,0.133333333,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS1','PHS','Bakso',0.75,0,0.07,0.05,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS10','PHS','Udang',1.5,0,0.14,0.1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS11','PHS','Kepiting',1.5,0,0.14,0.1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS12','PHS','Kerang',0.83333333333333,0,0.077777778,0.055555556,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS2','PHS','Daging kambing',1.875,0,0.175,0.125,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS3','PHS','Daging sapi',2.1428571428571,0,0.2,0.142857143,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS4','PHS','Hati ayam',2.5,0,0.233333333,0.166666667,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS5','PHS','Otak',1.1538461538462,0,0.107692308,0.076923077,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS6','PHS','Babat',1.875,0,0.175,0.125,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS7','PHS','Usus sapi',1,0,0.093333333,0.066666667,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS8','PHS','Telur ayam',1.5,0,0.14,0.1,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PHS9','PHS','Telur puyuh',1.25,0,0.116666667,0.083333333,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PN1','PN','Tempe',1.6,0.16,0.12,0.06,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PN2','PN','Tahu',0.8,0.08,0.06,0.03,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PN3','PN','Oncom',1.6,0.16,0.12,0.06,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PN4','PN','Kacang Hijau',3.2,0.32,0.24,0.12,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PN5','PN','Kacang Tolo',3.2,0.32,0.24,0.12,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PN6','PN','Kacang kedelai',3.2,0.32,0.24,0.12,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PN7','PN','Kacang merah',3.2,0.32,0.24,0.12,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PN8','PN','Kacang Tanah',4,0.4,0.3,0.15,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PST1','PST','Bebek',3.3333333333333,0,0.155555556,0.288888889,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PST2','PST','Corned beef',3.3333333333333,0,0.155555556,0.288888889,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PST3','PST','Ayam dan kulit',2.7272727272727,0,0.127272727,0.236363636,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PST4','PST','Daging babi',3,0,0.14,0.26,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PST5','PST','Sosis',3,0,0.14,0.26,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('PST6','PST','Kuning telur',3.3333333333333,0,0.155555556,0.288888889,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S1','S','Bayam',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S10','S','Jantung pisang',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S11','S','Genjer',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S12','S','Kacang panjang',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S13','S','Kacang kapri',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S14','S','Katuk',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S15','S','Kucai',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S16','S','Labu siam',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S17','S','Daun bawang',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S18','S','Jamur segar',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S19','S','Oyong',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S2','S','Bayam merah',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S20','S','Kangkung',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S21','S','Ketimun',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S22','S','Tomat',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S23','S','Kubis(Kol)',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S24','S','Caisim',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S25','S','Taoge',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S26','S','Kembang kol',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S27','S','Brokoli',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S28','S','Labu air',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S29','S','Lobak',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S3','S','Biet',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S30','S','Pepaya muda',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S31','S','Rebung',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S32','S','Sawi',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S33','S','Selada',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S34','S','Terong',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S35','S','Daun pakis',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S36','S','Daun singkong',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S37','S','Daun pepaya',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S38','S','Daun talas',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S39','S','Kluwih',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S4','S','Buncis',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S40','S','Labu puih',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S41','S','Nangka muda',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S42','S','Pare',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S43','S','Wortel',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S5','S','Daun beluntas',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S6','S','Daun ketela rambat',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S7','S','Daun kecipir',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S8','S','Daun blinjo',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('S9','S','Jagung muda',0.5,0.1,0.03,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('SRL1','SRL','Keju',3.5714285714286,0.285714286,0.2,0.171428571,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('SRL2','SRL','Susu kambing',0.75757575757576,0.060606061,0.042424242,0.036363636,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('SRL3','SRL','Susu sapi',0.625,0.05,0.035,0.03,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('SRL4','SRL','Yoghurt (whole)',0.625,0.05,0.035,0.03,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('SRL5','SRL','Sari kedelai',5,0.4,0.28,0.24,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('SRL6','SRL','Bubuk susu kedelai',0.625,0.05,0.035,0.03,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('STIL1','STIL','Tepung susu full cream',5,0.333333333,0.233333333,0.333333333,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('STL1','STL','Susu skim cair',0.35,0.055,0.035,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('STL2','STL','Tepung susu skim',3.5,0.55,0.35,0,'2026-04-13 03:05:55','2026-04-13 03:05:55'),('STL3','STL','Yogurt non fat',0.58333333333333,0.091666667,0.058333333,0,'2026-04-13 03:05:55','2026-04-13 03:05:55');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2026_02_02_015000_create_users_table',1),(4,'2026_02_02_015700_create_patients_table',1),(5,'2026_02_02_015720_create_menus_table',1),(6,'2026_02_02_015730_create_menu_weight_options_table',1),(7,'2026_02_02_015837_create_food_logs_table',1),(8,'2026_02_02_015850_create_nutrition_targets_table',1),(9,'2026_02_02_034932_create_sessions_table',1),(10,'2026_02_04_030530_create_diseases_table',1),(11,'2026_02_04_030639_create_disease_menu_table',1),(12,'2026_02_06_032822_add_tipe_user_to_users_table',1),(13,'2026_02_06_074559_create_disease_user_table',1),(14,'2026_02_09_090411_create_monitorings_table',1),(15,'2026_02_09_090551_create_monitoring_details_table',1),(16,'2026_02_09_090731_create_monitoring_items_table',1),(17,'2026_02_11_095914_change_qty_to_decimal_on_monitoring_items_table',1),(18,'2026_02_13_012629_add_photo_to_users_table',1),(19,'2026_02_19_025437_add_defisit_and_activity_to_users_table',1),(20,'2026_02_20_003317_create_diet_logs_table',1),(21,'2026_02_20_092817_change_tanggal_columns_in_diet_logs',1),(22,'2026_02_26_094905_add_columns_to_nutrition_targets_table',1),(23,'2026_02_26_122938_add_target_to_monitorings_table',1),(24,'2026_03_02_083137_create_articles_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monitoring_details`
--

DROP TABLE IF EXISTS `monitoring_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitoring_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `monitoring_id` bigint unsigned NOT NULL,
  `jenis_makan` enum('pagi','siang','malam') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_kkal` double NOT NULL DEFAULT '0',
  `total_karbo` double NOT NULL DEFAULT '0',
  `total_protein` double NOT NULL DEFAULT '0',
  `total_lemak` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `monitoring_details_monitoring_id_foreign` (`monitoring_id`),
  CONSTRAINT `monitoring_details_monitoring_id_foreign` FOREIGN KEY (`monitoring_id`) REFERENCES `monitorings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monitoring_details`
--

LOCK TABLES `monitoring_details` WRITE;
/*!40000 ALTER TABLE `monitoring_details` DISABLE KEYS */;
INSERT INTO `monitoring_details` VALUES (28,1,'pagi',1750,500,40,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(51,8,'pagi',1280,128,96,48,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(52,8,'siang',2150,430,129,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(53,8,'malam',2900.99,696.24,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(54,7,'pagi',7350,2100,168,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(55,7,'siang',3900,0,294,288,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(56,7,'malam',2220,206,140,92,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(59,3,'pagi',3850,1100,88,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(60,3,'siang',810,0,0,90,'2026-04-14 11:47:19','2026-04-14 11:47:19');
/*!40000 ALTER TABLE `monitoring_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monitoring_items`
--

DROP TABLE IF EXISTS `monitoring_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitoring_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `monitoring_detail_id` bigint unsigned NOT NULL,
  `kode_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_berat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` decimal(8,2) NOT NULL,
  `gram` double NOT NULL,
  `kkal` double NOT NULL,
  `karbo` double NOT NULL,
  `protein` double NOT NULL,
  `lemak` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `monitoring_items_monitoring_detail_id_foreign` (`monitoring_detail_id`),
  CONSTRAINT `monitoring_items_monitoring_detail_id_foreign` FOREIGN KEY (`monitoring_detail_id`) REFERENCES `monitoring_details` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1596 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monitoring_items`
--

LOCK TABLES `monitoring_items` WRITE;
/*!40000 ALTER TABLE `monitoring_items` DISABLE KEYS */;
INSERT INTO `monitoring_items` VALUES (585,28,'k1','Gelas',0.50,0.25,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(586,28,'k1','Gram',100.00,100,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(587,28,'k2','Gelas',1.00,1,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(588,28,'k2','Gram',200.00,200,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(589,28,'k3','Gelas',2.00,4,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(590,28,'k3','Gram',400.00,400,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(591,28,'k4','Gelas',0.75,0.5625,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(592,28,'k4','Gram',100.00,100,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(593,28,'k5','Biji sedang',4.00,16,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(594,28,'k5','Gram',200.00,200,175,50,4,0,'2026-04-14 09:08:40','2026-04-14 09:08:40'),(1295,51,'PN1','Potong sedang',2.00,4,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1296,51,'PN1','Gram',50.00,50,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1297,51,'PN2','Potong sedang',1.00,1,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1298,51,'PN2','Gram',100.00,100,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1299,51,'PN3','Potong sedang',2.00,4,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1300,51,'PN3','Gram',50.00,50,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1301,51,'PN4','Sendok (sdm)',2.50,6.25,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1302,51,'PN4','Gram',25.00,25,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1303,51,'PN5','Sendok (sdm)',2.50,6.25,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1304,51,'PN5','Gram',25.00,25,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1305,51,'PN6','Sendok (sdm)',2.50,6.25,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1306,51,'PN6','Gram',25.00,25,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1307,51,'PN7','Sendok (sdm)',2.50,6.25,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1308,51,'PN7','Gram',25.00,25,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1309,51,'PN8','Sendok (sdm)',2.00,4,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1310,51,'PN8','Gram',20.00,20,80,8,6,3,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1311,52,'S1','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1312,52,'S2','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1313,52,'S3','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1314,52,'S4','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1315,52,'S5','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1316,52,'S6','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1317,52,'S7','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1318,52,'S8','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1319,52,'S9','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1320,52,'S10','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1321,52,'S11','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1322,52,'S12','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1323,52,'S13','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1324,52,'S14','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1325,52,'S15','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1326,52,'S16','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1327,52,'S17','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1328,52,'S18','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1329,52,'S19','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1330,52,'S20','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1331,52,'S21','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1332,52,'S22','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1333,52,'S23','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1334,52,'S24','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1335,52,'S25','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1336,52,'S26','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1337,52,'S27','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1338,52,'S28','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1339,52,'S29','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1340,52,'S30','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1341,52,'S31','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1342,52,'S32','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1343,52,'S33','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1344,52,'S34','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1345,52,'S35','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1346,52,'S36','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1347,52,'S37','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1348,52,'S38','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1349,52,'S39','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1350,52,'S40','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1351,52,'S41','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1352,52,'S42','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1353,52,'S43','Gram',100.00,100,50,10,3,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1354,53,'BG1','Buah sedang',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1355,53,'BG1','Gram',50.00,50,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1356,53,'BG2','Biji',3.00,9,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1357,53,'BG2','Gram',50.00,50,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1358,53,'BG3','Buah',8.00,64,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1359,53,'BG3','Gram',75.00,75,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1360,53,'BG4','Gelas',0.50,0.25,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1361,53,'BG4','Gram',50.00,50,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1362,53,'BG5','Buah',0.17,0.028339,50.99,12.24,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1363,53,'BG5','Gram',75.00,75,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1364,53,'BG6','Buah',10.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1365,53,'BG6','Gram',75.00,75,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1366,53,'BG7','Buah',10.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1367,53,'BG7','Gram',75.00,75,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1368,53,'BG8','Biji',3.00,9,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1369,53,'BG8','Gram',50.00,50,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1370,53,'BG9','Buah',2.00,4,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1371,53,'BG9','Gram',100.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1372,53,'BG10','Buah',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1373,53,'BG10','Gram',100.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1374,53,'BG11','Buah sedang',2.00,4,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1375,53,'BG11','Gram',100.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1376,53,'BG12','Buah sedang',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1377,53,'BG12','Gram',100.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1378,53,'BG13','Buah sedang',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1379,53,'BG13','Gram',75.00,75,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1380,53,'BG14','Buah sedang',2.00,4,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1381,53,'BG14','Gram',100.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1382,53,'BG15','Potong',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1383,53,'BG15','Gram',100.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1384,53,'BG16','Buah besar',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1385,53,'BG16','Gram',75.00,75,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1386,53,'BG17','Buah besar',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1387,53,'BG17','Gram',50.00,50,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1388,53,'BG18','Potong',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1389,53,'BG18','Gram',150.00,150,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1390,53,'BG19','Potong',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1391,53,'BG19','Gram',200.00,200,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1392,53,'BG20','Potong',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1393,53,'BG20','Gram',100.00,100,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1394,53,'BG21','Buah kecil',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1395,53,'BG21','Gram',75.00,75,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1396,53,'BG22','Buah',0.50,0.25,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1397,53,'BG22','Gram',50.00,50,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1398,53,'BG23','Buah',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1399,53,'BG23','Gram',125.00,125,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1400,53,'BG24','Buah',0.50,0.25,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1401,53,'BG24','Gram',75.00,75,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1402,53,'BG25','Buah',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1403,53,'BG25','Gram',50.00,50,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1404,53,'BG26','Buah besar',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1405,53,'BG26','Gram',50.00,50,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1406,53,'BG27','Buah sedang',2.00,4,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1407,53,'BG27','Gram',125.00,125,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1408,53,'BG28','Sendok (sdm)',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1409,53,'BG28','Gram',15.00,15,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1410,53,'BG29','Sendok (sdm)',1.00,1,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1411,53,'BG29','Gram',10.00,10,50,12,0,0,'2026-04-14 11:24:45','2026-04-14 11:24:45'),(1412,54,'k1','Gelas',0.50,0.25,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1413,54,'k1','Gram',100.00,100,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1414,54,'k2','Gelas',1.00,1,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1415,54,'k2','Gram',200.00,200,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1416,54,'k3','Gelas',2.00,4,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1417,54,'k3','Gram',400.00,400,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1418,54,'k4','Gelas',0.75,0.5625,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1419,54,'k4','Gram',100.00,100,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1420,54,'k5','Biji sedang',4.00,16,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1421,54,'k5','Gram',200.00,200,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1422,54,'k6','Potong sedang',1.00,1,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1423,54,'k6','Gram',100.00,100,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1424,54,'k7','Biji sedang',1.00,1,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1425,54,'k7','Gram',200.00,200,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1426,54,'k8','Biji sedang',1.00,1,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1427,54,'k8','Gram',150.00,150,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1428,54,'k9','Buah',4.00,16,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1429,54,'k9','Gram',50.00,50,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1430,54,'k10','Buah besar',5.00,25,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1431,54,'k10','Gram',50.00,50,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1432,54,'k11','Iris',4.00,16,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1433,54,'k11','Gram',80.00,80,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1434,54,'k12','Gelas',1.00,1,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1435,54,'k12','Gram',50.00,50,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1436,54,'k13','Gelas',1.50,2.25,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1437,54,'k13','Gram',100.00,100,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1438,54,'k14','Gelas',0.50,0.25,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1439,54,'k14','Gram',50.00,50,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1440,54,'k15','Sendok (sdm)',8.00,64,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1441,54,'k15','Gram',50.00,50,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1442,54,'k16','Sendok (sdm)',8.00,64,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1443,54,'k16','Gram',40.00,40,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1444,54,'k17','Sendok (sdm)',8.00,64,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1445,54,'k17','Gram',40.00,40,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1446,54,'k18','Sendok (sdm)',7.00,49,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1447,54,'k18','Gram',40.00,40,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1448,54,'k19','Sendok (sdm)',8.00,64,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1449,54,'k19','Gram',40.00,40,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1450,54,'k20','Sendok (sdm)',8.00,64,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1451,54,'k20','Gram',50.00,50,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1452,54,'k21','Sendok (sdm)',6.00,36,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1453,54,'k21','Gram',50.00,50,175,50,4,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1454,55,'PHR1','Potong sedang',1.00,1,50,0,7,2,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1455,55,'PHR1','Gram',40.00,40,50,0,7,2,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1456,55,'PHR2','Potong sedang',1.00,1,50,0,7,2,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1457,55,'PHR2','Gram',50.00,50,50,0,7,2,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1458,55,'PHR3','Potong kecil',1.00,1,50,0,7,2,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1459,55,'PHR3','Gram',15.00,15,50,0,7,2,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1460,55,'PHS1','Biji kecil',10.00,100,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1461,55,'PHS1','Gram',100.00,100,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1462,55,'PHS2','Potong sedang',1.00,1,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1463,55,'PHS2','Gram',40.00,40,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1464,55,'PHS3','Potong sedang',1.00,1,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1465,55,'PHS3','Gram',35.00,35,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1466,55,'PHS4','Buah sedang',1.00,1,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1467,55,'PHS4','Gram',30.00,30,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1468,55,'PHS5','Potong besar',1.00,1,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1469,55,'PHS5','Gram',65.00,65,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1470,55,'PHS6','Potong sedang',1.00,1,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1471,55,'PHS6','Gram',40.00,40,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1472,55,'PHS7','Bulatan',3.00,9,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1473,55,'PHS7','Gram',75.00,75,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1474,55,'PHS8','Butir',1.00,1,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1475,55,'PHS8','Gram',50.00,50,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1476,55,'PHS9','Butir kecil',5.00,25,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1477,55,'PHS9','Gram',60.00,60,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1478,55,'PHS10','Gelas',0.25,0.0625,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1479,55,'PHS10','Gram',50.00,50,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1480,55,'PHS11','Ekor',1.00,1,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1481,55,'PHS11','Gram',50.00,50,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1482,55,'PHS12','Gelas',0.50,0.25,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1483,55,'PHS12','Gram',90.00,90,75,0,7,5,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1484,55,'PST1','Potong sedang',1.00,1,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1485,55,'PST1','Gram',45.00,45,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1486,55,'PST2','Sendok (sdm)',3.00,9,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1487,55,'PST2','Gram',45.00,45,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1488,55,'PST3','Potong sedang',1.00,1,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1489,55,'PST3','Gram',55.00,55,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1490,55,'PST4','Potong sedang',1.00,1,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1491,55,'PST4','Gram',50.00,50,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1492,55,'PST5','Potong sedang',0.50,0.25,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1493,55,'PST5','Gram',50.00,50,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1494,55,'PST6','Butir',2.00,4,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1495,55,'PST6','Gram',45.00,45,150,0,7,13,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1496,56,'STL1','Gelas',1.00,1,70,11,7,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1497,56,'STL1','Gram',200.00,200,70,11,7,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1498,56,'STL2','Sendok (sdm)',4.00,16,70,11,7,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1499,56,'STL2','Gram',20.00,20,70,11,7,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1500,56,'STL3','Gelas',0.67,0.4489,70,11,7,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1501,56,'STL3','Gram',120.00,120,70,11,7,0,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1502,56,'SRL1','Potong kecil',1.00,1,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1503,56,'SRL1','Gram',35.00,35,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1504,56,'SRL2','Gelas',0.75,0.5625,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1505,56,'SRL2','Gram',165.00,165,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1506,56,'SRL3','Gelas',1.00,1,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1507,56,'SRL3','Gram',200.00,200,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1508,56,'SRL4','Gelas',1.00,1,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1509,56,'SRL4','Gram',200.00,200,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1510,56,'SRL5','Sendok (sdm)',4.00,16,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1511,56,'SRL5','Gram',25.00,25,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1512,56,'SRL6','Gelas',1.00,1,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1513,56,'SRL6','Gram',200.00,200,125,10,7,6,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1514,56,'STIL1','Sendok (sdm)',6.00,36,150,10,7,10,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1515,56,'STIL1','Gram',30.00,30,150,10,7,10,'2026-04-14 11:36:05','2026-04-14 11:36:05'),(1556,59,'k1','Gelas',0.50,0.25,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1557,59,'k1','Gram',100.00,100,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1558,59,'k2','Gelas',1.00,1,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1559,59,'k2','Gram',200.00,200,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1560,59,'k3','Gelas',2.00,4,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1561,59,'k3','Gram',400.00,400,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1562,59,'k4','Gelas',0.75,0.5625,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1563,59,'k4','Gram',100.00,100,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1564,59,'k5','Biji sedang',4.00,16,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1565,59,'k5','Gram',200.00,200,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1566,59,'k6','Potong sedang',1.00,1,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1567,59,'k6','Gram',100.00,100,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1568,59,'k7','Biji sedang',1.00,1,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1569,59,'k7','Gram',200.00,200,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1570,59,'k8','Biji sedang',1.00,1,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1571,59,'k8','Gram',150.00,150,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1572,59,'k9','Buah',4.00,16,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1573,59,'k9','Gram',50.00,50,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1574,59,'k10','Buah besar',5.00,25,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1575,59,'k10','Gram',50.00,50,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1576,59,'k11','Iris',4.00,16,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1577,59,'k11','Gram',80.00,80,175,50,4,0,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1578,60,'M1','Sendok teh',1.00,1,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1579,60,'M1','Gram',5.00,5,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1580,60,'M2','Sendok teh',1.00,1,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1581,60,'M2','Gram',5.00,5,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1582,60,'M3','Sendok teh',1.00,1,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1583,60,'M3','Gram',5.00,5,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1584,60,'M4','Sendok teh',1.00,1,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1585,60,'M4','Gram',5.00,5,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1586,60,'M5','Sendok teh',1.00,1,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1587,60,'M5','Gram',5.00,5,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1588,60,'M6','Sendok (sdm)',5.00,25,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1589,60,'M6','Gram',25.00,25,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1590,60,'M7','Sendok (sdm)',4.00,16,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1591,60,'M7','Gram',40.00,40,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1592,60,'M8','Sendok (sdm)',1.50,2.25,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1593,60,'M8','Gram',15.00,15,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1594,60,'M9','Potong kecil',1.00,1,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19'),(1595,60,'M9','Gram',5.00,5,45,0,0,5,'2026-04-14 11:47:19','2026-04-14 11:47:19');
/*!40000 ALTER TABLE `monitoring_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monitorings`
--

DROP TABLE IF EXISTS `monitorings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitorings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `total_kkal` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `target_kkal` double DEFAULT NULL,
  `target_karbo` double DEFAULT NULL,
  `target_protein` double DEFAULT NULL,
  `target_lemak` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `monitorings_user_id_tanggal_unique` (`user_id`,`tanggal`),
  CONSTRAINT `monitorings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monitorings`
--

LOCK TABLES `monitorings` WRITE;
/*!40000 ALTER TABLE `monitorings` DISABLE KEYS */;
INSERT INTO `monitorings` VALUES (1,4,'2026-04-10',0,'2026-04-13 04:15:12','2026-04-14 09:08:40',NULL,NULL,NULL,NULL),(3,4,'2026-04-11',0,'2026-04-13 07:51:34','2026-04-14 09:08:47',NULL,NULL,NULL,NULL),(7,4,'2026-04-12',0,'2026-04-13 14:17:01','2026-04-14 09:08:56',NULL,NULL,NULL,NULL),(8,4,'2026-04-13',0,'2026-04-14 09:45:36','2026-04-14 09:45:36',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `monitorings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nutrition_targets`
--

DROP TABLE IF EXISTS `nutrition_targets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nutrition_targets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `target_kkal` int NOT NULL,
  `target_karbo` double DEFAULT NULL,
  `target_protein` double DEFAULT NULL,
  `target_lemak` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nutrition_targets_user_id_foreign` (`user_id`),
  CONSTRAINT `nutrition_targets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nutrition_targets`
--

LOCK TABLES `nutrition_targets` WRITE;
/*!40000 ALTER TABLE `nutrition_targets` DISABLE KEYS */;
/*!40000 ALTER TABLE `nutrition_targets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `usia` int NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `bb` double NOT NULL COMMENT 'Berat Badan (kg)',
  `tb` double NOT NULL COMMENT 'Tinggi Badan (cm)',
  `imt` double NOT NULL,
  `bbi` double NOT NULL,
  `abv` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patients_user_id_foreign` (`user_id`),
  CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('QYi7lVPzucUmDhaHSOuFtXLAYYi6R1YH2iCHV49M',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNWo2alA5WUNUbWVLbE5YNGJRMURnbnRqSm51MVRaaFBTRFZrVDB6TyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MDoiaHR0cDovL3Npc3RlbXBlcmhpdHVuZ2FuZ2l6aWtwcnMudGVzdC91c2VyL21vbml0b3JpbmcvNy9lZGl0Ijt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9zaXN0ZW1wZXJoaXR1bmdhbmdpemlrcHJzLnRlc3QvdXNlci9tb25pdG9yaW5nLzgvZWRpdCI7czo1OiJyb3V0ZSI7czoyMDoidXNlci5tb25pdG9yaW5nLmVkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=',1776178556);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berat_badan` double DEFAULT NULL,
  `tinggi_badan` double DEFAULT NULL,
  `defisit` enum('Menurunkan','Stabil','Menaikkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Stabil',
  `activity_factor` double NOT NULL DEFAULT '1.3',
  `ada_riwayat` enum('ya','tidak') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `riwayat_penyakit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `tipe_user` enum('pasien','pegawai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pasien',
  `nomor_anggota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ADMINGIZI1','Admin Gizi','ADMINGIZI1',NULL,'$2y$12$LdoEeSOFRrX0N0jNqBah.eBBLc3Ph.Y/J0e/PD3vqAiYCF0MH.Gta','2026-04-13','-','L',0,0,'Stabil',1.3,'tidak',NULL,'admin','pasien',NULL,NULL,NULL,'2026-04-13 03:05:53','2026-04-13 03:05:53'),(2,'ADMINGIZI2','Admin Gizi','ADMINGIZI2',NULL,'$2y$12$0ono/iRnWt.WyCnJ9NB8Ten5zbjOYQE0.XipF7XUeMfY0HDjck40W','2026-04-13','-','L',0,0,'Stabil',1.3,'tidak',NULL,'admin','pasien',NULL,NULL,NULL,'2026-04-13 03:05:54','2026-04-13 03:05:54'),(3,'ADMINGIZI3','Admin Gizi','ADMINGIZI3',NULL,'$2y$12$.xiVWfoNToSTetR./P2ajOg.goYzXj1erjds2CeyZHFf9uo4eJ2Ua','2026-04-13','-','L',0,0,'Stabil',1.3,'tidak',NULL,'admin','pasien',NULL,NULL,NULL,'2026-04-13 03:05:54','2026-04-13 03:05:54'),(4,NULL,'R. Gusti Aryakusuma Dewa Wijaya','dewaarya1294@gmail.com',NULL,'$2y$12$9Ifudg4LJZ5eX9XMuaCVzecd.reUd/rVqJ2XLBoetBzXKUEHdBqk2','2004-12-17','085852248999','L',65,165,'Stabil',1.3,'tidak',NULL,'user','pasien',NULL,NULL,NULL,'2026-04-13 03:06:56','2026-04-13 03:06:56');
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

-- Dump completed on 2026-04-14 22:22:37
