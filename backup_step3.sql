-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: localhost    Database: saudeosasco
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.10.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cadastro`
--

DROP TABLE IF EXISTS `cadastro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cadastro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `unidade` int NOT NULL,
  `qualificacoes` varchar(255) DEFAULT NULL,
  `especializacoes` varchar(255) DEFAULT NULL,
  `certificacoes` blob,
  `foto` blob,
  `senha` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cadastro`
--

LOCK TABLES `cadastro` WRITE;
/*!40000 ALTER TABLE `cadastro` DISABLE KEYS */;
/*!40000 ALTER TABLE `cadastro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `content` text,
  `comment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendships`
--

DROP TABLE IF EXISTS `friendships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friendships` (
  `friendship_id` int NOT NULL AUTO_INCREMENT,
  `user_id1` int DEFAULT NULL,
  `user_id2` int DEFAULT NULL,
  `status` enum('Pending','Accepted','Rejected') NOT NULL,
  `request_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`friendship_id`),
  KEY `user_id1` (`user_id1`),
  KEY `user_id2` (`user_id2`),
  CONSTRAINT `friendships_ibfk_1` FOREIGN KEY (`user_id1`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `friendships_ibfk_2` FOREIGN KEY (`user_id2`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendships`
--

LOCK TABLES `friendships` WRITE;
/*!40000 ALTER TABLE `friendships` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matricula`
--

DROP TABLE IF EXISTS `matricula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matricula` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `matricula` varchar(7) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `matricula` (`matricula`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matricula`
--

LOCK TABLES `matricula` WRITE;
/*!40000 ALTER TABLE `matricula` DISABLE KEYS */;
INSERT INTO `matricula` VALUES (1,'rrr@gmail.com','11475-f'),(2,'ddd@secretariasaudeosasco.com','11223-s'),(3,'alessandro@secretariasaudeosasco.com','78443-s'),(4,'leandra@secretariasaudeosasco.com','87466-s'),(5,'igor@secretariasaudeosasco.com','63589-s');
/*!40000 ALTER TABLE `matricula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_likes`
--

DROP TABLE IF EXISTS `post_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_likes` (
  `like_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `like_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_likes`
--

LOCK TABLES `post_likes` WRITE;
/*!40000 ALTER TABLE `post_likes` DISABLE KEYS */;
INSERT INTO `post_likes` VALUES (1,8,NULL,'2023-11-10 22:11:37'),(2,8,NULL,'2023-11-10 22:11:39'),(3,8,NULL,'2023-11-10 22:11:40'),(4,8,NULL,'2023-11-10 22:11:42'),(5,8,NULL,'2023-11-10 22:11:42'),(6,8,NULL,'2023-11-10 22:11:43'),(7,8,14,'2023-11-10 22:53:23'),(8,8,14,'2023-11-10 22:53:24'),(9,8,13,'2023-11-10 22:53:28'),(10,8,13,'2023-11-10 22:53:29'),(11,8,13,'2023-11-10 22:53:30'),(12,8,12,'2023-11-10 22:53:32'),(13,8,12,'2023-11-10 22:53:32'),(14,8,12,'2023-11-10 22:53:33'),(15,9,10,'2023-11-10 23:00:39'),(16,9,10,'2023-11-10 23:00:39'),(17,9,10,'2023-11-10 23:00:40'),(18,9,10,'2023-11-10 23:00:41'),(19,9,10,'2023-11-10 23:00:42'),(20,9,10,'2023-11-10 23:00:42'),(21,9,10,'2023-11-10 23:00:42'),(22,9,10,'2023-11-10 23:00:43'),(23,9,10,'2023-11-10 23:00:43'),(24,9,10,'2023-11-10 23:00:43'),(25,9,10,'2023-11-10 23:00:44'),(26,9,10,'2023-11-10 23:00:44'),(27,9,10,'2023-11-10 23:00:44'),(28,9,10,'2023-11-10 23:00:45'),(29,9,10,'2023-11-10 23:00:45'),(30,9,10,'2023-11-10 23:00:45'),(31,9,10,'2023-11-10 23:00:46'),(32,9,10,'2023-11-10 23:00:46'),(33,9,10,'2023-11-10 23:00:46'),(34,9,10,'2023-11-10 23:00:46'),(35,9,10,'2023-11-10 23:00:46'),(36,9,10,'2023-11-10 23:00:47'),(37,9,10,'2023-11-10 23:00:47'),(38,9,10,'2023-11-10 23:00:47'),(39,9,10,'2023-11-10 23:00:47'),(40,9,10,'2023-11-10 23:00:47'),(41,9,10,'2023-11-10 23:00:47'),(42,9,10,'2023-11-10 23:00:48'),(43,9,10,'2023-11-10 23:00:48'),(44,9,10,'2023-11-10 23:00:48'),(45,9,10,'2023-11-10 23:00:48');
/*!40000 ALTER TABLE `post_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `content` text,
  `post_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,3,'olhem esse artigo cientifico:\r\nhttps://revistas.ufrj.br/index.php/rbn','2023-10-29 01:11:01'),(2,3,'o post do momento:\r\ntop 5 neurologia, confira!\r\nhttps://pebmed.com.br/top-5-neurologia-confira-os-artigos-mais-acessados-de-julho-pebmedcast/','2023-10-29 01:14:18'),(3,4,'dattebayo!','2023-10-29 01:19:27'),(4,4,'ha','2023-10-29 01:22:56'),(5,5,'postei e sai correndo','2023-10-29 01:32:16'),(6,6,'temos o melhor site de desenvolvimento abaixo:\r\n\r\nhttps://stackoverflow.com/','2023-10-29 01:45:28'),(7,6,'tentativa de post com link\r\n\r\n<a href=\"https://stackoverflow.com/\">https://stackoverflow.com/</a>','2023-10-29 01:46:03'),(8,7,'primeiro post do raphael','2023-10-30 12:21:48'),(9,8,'eu ja tenho pronto','2023-11-10 20:04:30'),(10,9,'Agua mole em pedra dura tanto bate até que fura\r\n','2023-11-10 21:43:22'),(11,8,'post do momento!','2023-11-10 22:06:20'),(12,8,'a vida é bela','2023-11-10 22:07:28'),(13,8,'boa','2023-11-10 22:20:05'),(14,8,'post de agora\r\n','2023-11-10 22:53:20');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preautenticacao`
--

DROP TABLE IF EXISTS `preautenticacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preautenticacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricula` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preautenticacao`
--

LOCK TABLES `preautenticacao` WRITE;
/*!40000 ALTER TABLE `preautenticacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `preautenticacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro`
--

DROP TABLE IF EXISTS `registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `rg` varchar(12) NOT NULL,
  `cpf` int NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro`
--

LOCK TABLES `registro` WRITE;
/*!40000 ALTER TABLE `registro` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('Doctor','Nurse','Admin','Staff') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'marcelo','$2y$10$UL7NlO.6tIxwEvlJeh3uH.DWyLfZ4ZQWWt.u98dhSplXXDBQdzJK.','marcelo@fatec.sp.gov.br',NULL,'Doctor',NULL,NULL,'2023-10-29 00:19:33'),(2,'natalia','$2y$10$R7J4PUFl7iBzM37FL6tA1ewT5a.OiFcCaGMu7M2dSnJbthdQ8S4S6','nat-bolada@hotmail.com',NULL,'Nurse',NULL,NULL,'2023-10-29 00:27:48'),(3,'rubia','$2y$10$r6wcd9ujyOd54CqUbUI1KuL53AHOMb3pNd92eoqm492EazTzrjv8K','rubia_poderosa@gmail.com',NULL,'Admin',NULL,NULL,'2023-10-29 01:10:11'),(4,'naruto','$2y$10$zOxnMR8ulKCh.5pZkC8bl.qPqc1TtoNB1SCOfBuy5Hv6aJkZ8Go5y','naruto_uzumaki@viladafolha.com',NULL,'Admin',NULL,NULL,'2023-10-29 01:19:05'),(5,'gilmar','$2y$10$7oVpcY.ARjb1fDtlbIBEpuJSo6QwmDnfqD1nOGeJo7W2Y4CHWzvSS','profgilmar@gmail.com',NULL,'Staff',NULL,NULL,'2023-10-29 01:29:04'),(6,'kevin','$2y$10$TAoUdLS1Xe6oUBlI.XW5l.gXwebepr/lf9e8baKUxlQvq8TWij7lS','kevin.berghem@fatec.sp.gov.br',NULL,'Staff',NULL,NULL,'2023-10-29 01:44:06'),(7,'raphael','$2y$10$RjDwxhyybmIG6gviDQKkyeWB5XsGAV8CsPu2VLpZ4qkNzTPgDG1S6','raphael.buiriola@fatec.sp.gov.br',NULL,'Staff',NULL,NULL,'2023-10-30 12:21:04'),(8,'joel','$2y$10$rLwG2LIE8JXYGaOdYMoDjuydojP5dTpWVZ71kEyh20R/YRGiY/ziu','joel@thelastofus.com.br',NULL,'Nurse',NULL,NULL,'2023-11-10 20:03:16'),(9,'Hanz Chucrute','$2y$10$y6ifVK1wYXWRi5BDyDs9hul/7Jp2ilVYSNdwCwhwIL3XfY63jbJaa','chucrute@hotmail.com',NULL,'Doctor',NULL,NULL,'2023-11-10 21:42:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-10 20:10:18
