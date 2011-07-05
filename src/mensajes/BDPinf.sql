-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Pinf
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Mensaje`
--
CREATE SCHEMA IF NOT EXISTS `Pinf`;
USE Pinf;
DROP TABLE IF EXISTS `Mensaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Mensaje` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `asunto` varchar(100) NOT NULL,
  `texto` text NOT NULL,
  `emisor` varchar(30) NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `fk_Mensaje_1` (`emisor`),
  CONSTRAINT `fk_Mensaje_1` FOREIGN KEY (`emisor`) REFERENCES `Perfil` (`user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Mensaje`
--

LOCK TABLES `Mensaje` WRITE;
/*!40000 ALTER TABLE `Mensaje` DISABLE KEYS */;
INSERT INTO `Mensaje` VALUES (1,'Bienvenido a Pinf!','Hola Carlos! QuÃ© bien que hayas decidido unirte a la red social computista mÃ¡s importante de la USB. AquÃ­ podrÃ¡ hablar con tus amigos, compartir fotos, mantenerte informado y mÃ¡s!','simon',0),(2,'Proyecto de traductores','Mira Carlos, el proyecto de traductores es para este domingo. Ya estuve trabajando en las gramÃ¡ticas pero aÃºn estamos demasiado crudos, podemos reunirnos maÃ±ana a eso de las 8 de la maÃ±ana para trabajar? Yo ya montÃ© un repositorio Git en Github con las cosas que llevo hechas. Cualquier cosa mandame un mensaje o llamame al cel.','jose',0),(3,'FWD: Proyecto de traductores','Dale tranquilo, nos vemos maÃ±ana. Yo estoy dispuesto a darle todo el fin de semana.','carlos',0);
/*!40000 ALTER TABLE `Mensaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MensajeRecibido`
--

DROP TABLE IF EXISTS `MensajeRecibido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MensajeRecibido` (
  `mid` int(11) NOT NULL,
  `destinatario` varchar(30) NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `leido` tinyint(1) NOT NULL,
  PRIMARY KEY (`mid`,`destinatario`),
  KEY `fk_MensajeRecibido_1` (`mid`),
  KEY `fk_MensajeRecibido_2` (`destinatario`),
  CONSTRAINT `fk_MensajeRecibido_1` FOREIGN KEY (`mid`) REFERENCES `Mensaje` (`mid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_MensajeRecibido_2` FOREIGN KEY (`destinatario`) REFERENCES `Perfil` (`user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MensajeRecibido`
--

LOCK TABLES `MensajeRecibido` WRITE;
/*!40000 ALTER TABLE `MensajeRecibido` DISABLE KEYS */;
INSERT INTO `MensajeRecibido` VALUES (1,'carlos',0,1),(2,'carlos',0,0),(3,'jose',0,0);
/*!40000 ALTER TABLE `MensajeRecibido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Perfil`
--

/*DROP TABLE IF EXISTS `Perfil`;*/
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS`Perfil` (
  `user` varchar(30) NOT NULL,
  `contrasena` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `fechaNac` varchar(30) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `idMuro` int(11) NOT NULL,
  `idSeguridad` int(11) NOT NULL,
  `Is_Admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Perfil`
--

LOCK TABLES `Perfil` WRITE;
/*!40000 ALTER TABLE `Perfil` DISABLE KEYS */;
INSERT INTO `Perfil` VALUES ('carlos','carlos','Carlos','Rodriguez','5/8/89','carlos@gmail.com',1,1,0),('jose','jose','Jose','Sevilla','9/3/91','jose@gmail.com',2,2,0),('simon','simon','Simon','Rojas','10/10/86','simon@gmail.com',0,0,0);
/*!40000 ALTER TABLE `Perfil` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-24 21:27:14
