-- MySQL dump 10.13  Distrib 8.0.16, for macos10.14 (x86_64)
--
-- Host: localhost    Database: tax
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `counties`
--

DROP TABLE IF EXISTS `counties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `counties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `initial` varchar(100) NOT NULL,
  `tax_rate` decimal(4,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counties`
--

LOCK TABLES `counties` WRITE;
/*!40000 ALTER TABLE `counties` DISABLE KEYS */;
INSERT INTO `counties` VALUES (1,3,'Tehran','TH',12.40),(2,4,'München Stadt','MS',8.00),(3,4,'Nürnberg','NB',8.00),(4,4,'München','MN',10.00),(5,4,'Bayern','BY',10.00),(6,4,'Augsburg','AG',10.40),(7,7,'Hessen','HE',7.50),(8,7,'Offenbach','OB',12.20),(9,7,'Wetteraukreis','WT',10.00),(10,7,'Lahn-Dill-Kreis','LDK',14.20),(11,7,'Gießen','GI',13.60),(12,1,'Ammerland','AM',10.20),(13,1,'Aurich','AU',8.30),(14,1,'Braunschweig','BR',9.30),(15,1,'Celle','CL',9.20),(16,1,'Cloppenburg','CB',10.30),(17,6,'Altenburger Land','AL',10.50),(18,6,'Eichsfeld','EF',10.90),(19,6,'Gotha','GT',3.90),(20,6,'Greiz','GR',8.30),(21,6,'Hildburghausen','HG',12.60),(22,5,'Oder-Spree','OS',10.80),(23,5,'Märkisch-Oderland','MO',10.40),(24,5,'Potsdam-Mittelmark','PM',10.60),(25,5,'Oberhavel','OH',10.90),(26,5,'Uckermark','UR',10.90),(27,11,'Jahrom','JH',4.00),(28,11,'Khonj','KH',4.10),(29,11,'Shiraz','SH',6.00),(30,11,'Rostam','RS',5.00),(31,11,'Pasargad','PS',5.50),(32,8,'Amlash','AM',4.00),(33,8,'Rasht','RS',7.20),(34,8,'Masal','MS',4.60),(35,8,'Talesh','TL',5.30),(36,8,'Rudbar','RB',3.40),(37,10,'Yazd','YZ',8.20),(38,10,'Abarkuh','AK',6.20),(39,10,'Ardakan','AD',4.60),(40,10,'Ashkezar','AZ',3.70),(41,10,'Bafq','BQ',4.20),(42,3,'Damavand','DM',9.20),(43,3,'Firuzkuh','FZ',9.00),(44,3,'Shemiranat','SH',10.40),(45,3,'Pakdasht','PK',8.20),(46,9,'Isfahan','IS',8.30),(47,9,'Ardestan','AR',8.00),(48,9,'Fereydunshahr','FR',7.20),(49,9,'Golpayegan','GP',7.00),(50,9,'Natanz','NT',6.80),(51,12,'São Paulo','SP',12.00),(52,12,'Santos','SN',11.20),(53,12,'Santa Isabel','SI',10.40),(54,12,'Santa Branca','SB',10.10),(55,12,'Sabino','SB',10.00),(56,14,'Porto Velho','PV',10.40),(57,14,'Ji-Paraná','JP',10.10),(58,14,'Ariquemes','AR',10.00),(59,14,'Cacoal','CC',9.80),(60,14,'Vilhena','VH',9.40),(61,16,'Porto Alegre','PA',7.20),(62,16,'Caxias do Sul','CS',7.10),(63,16,'Canoas','CN',6.20),(64,16,'Pelotas','PT',6.50),(65,16,'Novo Hamburgo','NH',6.30),(66,15,'Salvador','SL',10.80),(67,15,'Feira de Santana','FS',10.60),(68,15,'Vitória da Conquista','VC',10.70),(69,15,'Itabuna','IT',10.50),(70,15,'Ilhéus','IH',10.30),(71,13,'Belo Horizonte','BH',10.30),(72,13,'Contagem','CT',10.20),(73,13,'Uberlândia','UL',10.10),(74,13,'Juiz de Fora','JF',10.00),(75,13,'Betim','BT',9.80),(76,21,'Halifax','HL',12.50),(77,21,'Cape Breton','CB',10.40),(78,21,'Kings','KN',10.30),(79,21,'Colchester','CH',10.20),(80,21,'Lunenburg','LB',10.10),(81,18,'Simcoe','SM',12.80),(82,18,'Middlesex','MS',12.70),(83,18,'Essex','ES',12.50),(84,18,'Toronto','TN',12.90),(85,18,'York','YK',12.20),(86,20,'Moncton','MN',10.50),(87,20,'Saint John','SJ',10.40),(88,20,'Fredericton','FD',10.30),(89,20,'Bathurst','BT',10.20),(90,20,'Miramichi','MI',10.10),(91,19,'Montréal','MN',13.70),(92,19,'Québec','QC',12.60),(93,19,'Laval','LV',12.30),(94,19,'Longueuil','LN',12.10),(95,19,'Gatineau','GT',11.40),(96,17,'Greater Vancouver','GV',13.60),(97,17,'Capital','CP',13.50),(98,17,'Fraser Valley','FV',13.40),(99,17,'Central Okanagan','CO',13.30),(100,17,'Nanaimo','NN',13.20),(101,22,'Los Angeles','LA',11.70),(102,22,'San Diego','SD',10.40),(103,22,'Orange','OR',10.40),(104,22,'Riverside','RS',10.10),(105,22,'San Bernardino','SB',10.00),(106,23,'Harris','HR',10.50),(107,23,'Dallas','DL',10.40),(108,23,'Tarrant','TR',10.30),(109,23,'Bexar','BX',10.20),(110,23,'Travis','TR',10.10),(111,24,'Miami-Dade','MD',11.60),(112,24,'Broward','BR',11.50),(113,24,'Palm Beach','PB',11.40),(114,24,'Hillsborough','HB',11.30),(115,24,'Orange','OR',11.20),(116,25,'Kings','KN',14.60),(117,25,'Queens','QU',14.50),(118,25,'New York','NY',14.20),(119,25,'Suffolk','SF',13.40),(120,25,'Bronx','BR',13.50),(121,26,'Philadelphia','PH',13.50),(122,26,'Allegheny','AL',13.40),(123,26,'Montgomery','MT',13.30),(124,26,'Bucks','BK',13.20),(125,26,'Delaware','DL',13.10);
/*!40000 ALTER TABLE `counties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `initial` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (2,'Iran','IR'),(3,'Brazil','BR'),(4,'Germany','GR'),(5,'Canada','CA'),(6,'United States','US');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `county_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `tax` decimal(18,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,23.00,2.85),(2,1,400.00,49.60),(3,38,800.00,49.60),(4,39,1234.00,56.76),(5,40,1234.00,45.66),(6,41,8436.00,354.31),(7,37,992.00,81.34),(8,122,7465.00,1000.31),(9,124,73654.00,9722.33),(10,125,2345.00,307.20),(11,123,1234.00,164.12),(12,121,986.00,133.11),(13,17,2344.00,246.12),(14,18,1234.00,134.51),(15,19,3455.00,134.75),(16,20,4556.00,378.15),(17,20,455.00,37.77),(18,21,5676.00,715.18),(19,32,433.00,17.32),(20,34,234.00,10.76),(21,33,235.00,16.92),(22,36,44.00,1.50),(23,35,3444.00,182.53),(24,12,1234.00,125.87),(25,13,884.00,73.37),(26,14,8456.00,786.41),(27,15,6465.00,594.78),(28,16,665.00,68.50),(29,47,645.00,51.60),(30,48,345.00,24.84),(31,49,2343.00,164.01),(32,46,3455.00,286.77),(33,50,1222.00,83.10),(34,58,5657.00,565.70),(35,75,45678.00,4476.44),(36,72,345.00,35.19),(37,74,4566.00,456.60),(38,60,565.00,53.11),(39,6,455.00,47.32),(40,89,546.00,55.69),(41,88,4566.00,470.30),(42,90,3446.00,348.05),(43,97,345.00,46.58),(44,91,35656.00,4884.87),(45,82,456.00,57.91),(46,67,6754.00,715.92),(47,66,466.00,50.33),(48,51,3455.00,414.60),(49,111,3556.00,412.50),(50,113,4545.00,518.13),(51,101,34562.00,4043.75),(52,105,3567.00,356.70),(53,29,4566.00,273.96),(54,31,4556.00,250.58),(55,23,3455.00,359.32),(56,23,3455.00,359.32),(57,7,4566.00,342.45),(58,11,4566.00,620.98),(59,10,5677.00,806.13),(60,118,34542.00,4904.96),(61,116,4677.00,682.84),(62,76,4666.00,583.25),(63,79,3456.00,352.51),(64,63,456457.00,28300.33),(65,62,45566.00,3235.19),(66,109,46777.00,4771.25),(67,107,35436.00,3685.34),(68,5,2345.00,234.50),(69,71,34556.00,3559.27),(70,120,23425.00,3162.38),(71,112,345345.00,39714.68),(72,59,2345.00,229.81),(73,77,23534.00,2447.54),(74,99,232.00,30.86),(75,42,54466.00,5010.87),(76,83,3545.00,443.13),(77,43,23455.00,2110.95),(78,98,23546.00,3155.16),(79,95,34534.00,3936.88),(80,96,34666.00,4714.58),(81,106,3436.00,360.78),(82,114,23425.00,2647.03),(83,70,32534.00,3351.00),(84,69,234.00,24.57),(85,27,23455.00,938.20),(86,57,2345.00,236.85),(87,28,23255.00,953.46),(88,116,2355.00,343.83),(89,93,2335.00,287.21),(90,94,2355.00,284.96),(91,80,2356.00,237.96),(92,86,2355.00,247.28),(93,4,2345.00,234.50),(94,2,2355.00,188.40),(95,100,2355.00,310.86),(96,65,45435.00,2862.41),(97,3,23545.00,1883.60),(98,25,345345.00,37642.61),(99,22,35345.00,3817.26),(100,8,3256.00,397.23),(101,115,235346.00,26358.75),(102,103,345456.00,35927.42),(103,45,45345.00,3718.29),(104,64,23565.00,1531.73),(105,61,34534.00,2486.45),(106,56,35345.00,3675.88),(107,24,2353.00,249.42),(108,92,34533.00,4351.16),(109,117,34546.00,5009.17),(110,104,2355.00,237.86),(111,30,4566.00,228.30),(112,55,3456.00,345.60),(113,87,3466.00,360.46),(114,85,345346.00,42132.21),(115,9,3454.00,345.40),(116,68,3456.00,369.79),(117,26,34555.00,3766.50),(118,73,3456.00,349.06),(119,110,3466.00,350.07),(120,84,45666.00,5890.91),(121,108,4564.00,470.09),(122,119,3466.00,464.44),(123,81,2356.00,301.57),(124,44,34534.00,3591.54),(125,52,3456.00,387.07),(126,53,3456.00,359.42),(127,54,3456.00,349.06),(128,102,345666.00,35949.26),(129,116,23435.00,3421.51),(130,78,3566.00,367.30);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `initial` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,4,'Lower Saxony','SX'),(3,2,'Tehran','TH'),(4,4,'Bavaria','BV'),(5,4,'Brandenburg','BR'),(6,4,'Thüringen','TH'),(7,4,'Hesse','HS'),(8,2,'Gilan','GL'),(9,2,'Isfahan','IS'),(10,2,'Yazd','YZ'),(11,2,'Fars','FR'),(12,3,'São Paulo','SP'),(13,3,'Minas Gerais','MG'),(14,3,'Rio de Janeiro','RJ'),(15,3,'Bahia','BH'),(16,3,'Rio Grande do Sul','RGS'),(17,5,'British Columbia','BC'),(18,5,'Ontario','ON'),(19,5,'Québec','QUE'),(20,5,'New Brunswick','NB'),(21,5,'Nova Scotia','NS'),(22,6,'California','CA'),(23,6,'Texas','TX'),(24,6,'Florida','FL'),(25,6,'New York','NY'),(26,6,'Pennsylvania','PA');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-24 15:36:05
