-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dieta_sklep_hindus
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opinia`
--

DROP TABLE IF EXISTS `opinia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opinia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_uzytkownika` int(11) NOT NULL,
  `id_produktu` int(11) NOT NULL,
  `tresc` varchar(200) NOT NULL,
  `ocena` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_uzytkownika` (`id_uzytkownika`),
  KEY `id_produktu` (`id_produktu`),
  CONSTRAINT `opinia_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `user_info` (`id`),
  CONSTRAINT `opinia_ibfk_2` FOREIGN KEY (`id_produktu`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opinia`
--

LOCK TABLES `opinia` WRITE;
/*!40000 ALTER TABLE `opinia` DISABLE KEYS */;
INSERT INTO `opinia` VALUES (56,4,1,'super bananki',4);
/*!40000 ALTER TABLE `opinia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(50) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `cena_z_dostawa` double NOT NULL,
  `cena_bez_dostawy` double NOT NULL,
  `opis_duzy` varchar(300) NOT NULL,
  `opis` varchar(200) NOT NULL,
  `rodzaj` varchar(50) NOT NULL,
  `ocena` int(11) NOT NULL,
  `stan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'img/banan.jpg','banan',12,10,'smaczny banan','123','ssss',5,50),(2,'img/jablko.jpg','jablko',8,6,'pyszne jablko','jablko','ligol',4,100),(3,'img/brokul.jpg','brokul',10,7,'pyszny brokul','zly brokul','warzywo',3,100),(4,'img/pomidor.jpg','pomidor',15,14,'pyszny pomidor','pomidor','warzywo',4,50),(5,'img/arbuz.jpg','Arbuz',20,17,'Mega duży i pyszny arbuz z Argentyny','Super Arbuz','Owoc',0,100),(7,'img/brzoskwinia.png','brzoskwinia',5,3,'Jest okrągły, mięsisty, bardzo smaczny, pomarańczowy, często z \"rumieńcem\", z omszoną skórką, z głęboko bruzdowaną, dużą pestką w środku.','Pyszna brzoskwinka','Owoc',1,500),(8,'img/cabula.jpg','cebula',10,8,'Cebula jest popularnym na całym świecie warzywem o silnym, słodkim smaku, niezbędnym w każdej kuchni.','Ludzie po niej płaczą','warzywo',1,250),(9,'img/kiwi.jpg','kiwi',15,13,'to małe owoce, które mają dużo smaku i wiele korzyści zdrowotnych. Ich zielony miąższ jest słodki i cierpki. Jest również pełen składników odżywczych, takich jak witamina C, witamina K, witamina E, kwas foliowy i potas. Mają też dużo przeciwutleniaczy i są dobrym źródłem błonnika.','Pyszny owoc','owoc',1,100),(10,'img/marakuja.png','marakuja',30,26,'Marakuja jest okrągła, wyglądem przypomina śliwkę. Zależnie od odmiany ma pomarańczowo-brązową lub fioletową skórkę, pomarańczowo-czerwony lub fioletowy galaretowaty i kleisty miąższ, w którym znajdują się jadalne pestki. Marakuja fioletowa jest słodka, natomiast marakuja pomarańczowa kwaśna.','Soczysty tropikalny owoc\r\n','owoc',1,50),(11,'img/pomarancze.jpg','pomarancze',20,18,'Pomarańcza jest owocem cytrusowym. Ma pomarańczową skórkę, która jest gruba. Na końcach z obu stron jest jakby takie zakończenie, które jest twarde. W środku pomarańczy znajduje się soczysty owoc, z dużą zawartością soku w sobie.','Pomarańczowy słodko kwaśny','owoc',1,120),(12,'img/porzeczka.jpg','porzeczka',13,10,'Porzeczki to krzewy liściaste o wzniesionym, lekko rozłożystym i krzaczastym pokroju. Dorastają zazwyczaj maksymalnie do 3 m wysokości (zależnie od gatunku i odmiany). Pędy porzeczki są silnie rozgałęzione, liście - duże, 2-7- klapowe, o dłoniastym kształcie, powcinane, ciemnozielone.','Małe słodkie kuleczki','owoc',1,700),(13,'img/rukola.jpg','rukola',18,15,'Rukola to odmiana sałaty z drobnymi, podłużnymi liśćmi o ciemnozielonym kolorze – jej łodyga może dorastać do nawet 60 cm. Roślina charakteryzuje się dość gorzkim, lekko pieprznym, choć dla niektórych – nieco orzechowym smakiem. Rokietta siewna jest rośliną łatwą w uprawie.','liscie dobre','warzywo',1,400);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (3,'id_sponsora','123@gmail.com','81dc9bdb52d04dc20036dbd8313ed055'),(4,'s25946','s25946@pjwstk.edu.pl','81dc9bdb52d04dc20036dbd8313ed055');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zamowienie`
--

DROP TABLE IF EXISTS `zamowienie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zamowienie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `koszt` double NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `ulica` varchar(50) NOT NULL,
  `miasto` varchar(50) NOT NULL,
  `kod_pocz` varchar(6) NOT NULL,
  `metoda_plat` varchar(20) NOT NULL,
  `metoda_dost` varchar(20) NOT NULL,
  `numer` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zamowienie`
--

LOCK TABLES `zamowienie` WRITE;
/*!40000 ALTER TABLE `zamowienie` DISABLE KEYS */;
INSERT INTO `zamowienie` VALUES (1,12,'qwe','ew','qeqw','qwe','eq','Za pobraniem','Paczkomat',0,'2026-06-22 17:50:53','ewa@ewa.pl'),(2,12,'Mateusz','Placha','123','123','123','BLIK','Kurier',123,'2026-06-22 17:54:07','ewa@ewa.pl'),(3,14,'sad','asd','ddsd','sdds','dd','Za pobraniem','Paczkomat',990333333,'2026-06-22 18:28:54','ewa@ewa.pl'),(4,14,'dads','asda','asd','sda','32-222','Za pobraniem','Paczkomat',123456789,'2026-06-22 18:33:24','ewa@ewa.pl'),(5,14,'Mateusz','Placha','s','sz','3','BLIK','Kurier',0,'2026-06-22 18:35:56','ewa@ewa.pl'),(6,14,'Mateusz','placha','asda','asd','71-221','Za pobraniem','Paczkomat',123456789,'2026-06-22 18:39:23','ewa@ewa.pl'),(7,12,'Mateusz','sda','adasda','sz','32-222','BLIK','Paczkomat',123456789,'2026-06-22 20:15:51','mateusz.placha36@gmail.com');
/*!40000 ALTER TABLE `zamowienie` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-27  1:55:08
