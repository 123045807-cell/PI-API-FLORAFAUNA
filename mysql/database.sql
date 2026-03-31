-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: florayfauna
-- ------------------------------------------------------
-- Server version	8.0.45

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

USE florayfauna;

-- ======================================================
-- Table structure for table `Tipo`
-- ======================================================

DROP TABLE IF EXISTS `Tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tipo` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Tipo` WRITE;
/*!40000 ALTER TABLE `Tipo` DISABLE KEYS */;
INSERT INTO `Tipo` VALUES (1,'Flora'),(2,'Fauna');
/*!40000 ALTER TABLE `Tipo` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Familia`
-- ======================================================

DROP TABLE IF EXISTS `Familia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Familia` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nombre_familia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Familia` WRITE;
/*!40000 ALTER TABLE `Familia` DISABLE KEYS */;
INSERT INTO `Familia` VALUES
(1,'Turdidae'),(2,'Arecaceae'),(3,'Euphorbiaceae'),(4,'Thraupidae'),(5,'Araneidae'),(6,'Lamiaceae'),
(7,'Bromeliaceae'),(8,'Heliotropiaceae'),(9,'Cactaceae'),(10,'Psittacidae'),(11,'Formicidae'),(12,'Hylidae'),
(13,'Nymphalidae'),(14,'Asparagaceae'),(15,'Juglandaceae'),(16,'Corvidae'),(17,'Picidae'),(18,'Onagraceae'),
(19,'Asteraceae'),(20,'Apidae'),(21,'Columbidae'),(22,'Hirundinidae'),(23,'Convolvulaceae'),(24,'Solanaceae'),
(25,'Zingiberaceae'),(26,'Bombacaceae'),(27,'Scarabaeidae'),(28,'Bombyliidae'),(29,'Vespidae'),(30,'Sturnidae'),
(31,'Trochilidae'),(32,'Acrididae'),(33,'Chrysomelidae'),(34,'Loasaceae'),(35,'Orchidaceae'),(36,'Felidae'),
(37,'Rosaceae'),(38,'Poaceae'),(39,'Fabaceae'),(40,'Muridae'),(41,'Pinaceae'),(42,'Phrynosomatidae'),
(43,'Lentibulariaceae'),(44,'Rallidae'),(45,'Fringillidae'),(46,'Anatidae'),(47,'Ardeidae'),(48,'Passerellidae'),
(49,'Crassulaceae'),(50,'Tyrannidae'),(51,'Parulidae'),(52,'Cardinalidae'),(53,'Malvaceae'),(54,'Iguanidae'),
(55,'Polypodiaceae'),(56,'Plantaginaceae'),(57,'Caprifoliaceae'),(58,'Sapindaceae'),(59,'Remizidae'),
(60,'Scolopacidae'),(61,'Apocynaceae'),(62,'Brassicaceae'),(63,'Rhamnaceae'),(64,'Mephitidae'),(65,'Pieridae'),
(66,'Chenopodiaceae'),(67,'Verbenaceae'),(68,'Coccinellidae'),(69,'Cyperaceae'),(70,'Ericaceae'),
(71,'Liliaceae'),(72,'Moraceae'),(73,'Myrtaceae'),(74,'Oleaceae'),(75,'Papaveraceae'),(76,'Rubiaceae'),
(77,'Rutaceae'),(78,'Ulmaceae'),(79,'Vitaceae'),(80,'Xanthorrhoeaceae'),(81,'Zygophyllaceae');
/*!40000 ALTER TABLE `Familia` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Estado_Conservacion`
-- ======================================================

DROP TABLE IF EXISTS `Estado_Conservacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Estado_Conservacion` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Estado_Conservacion` WRITE;
/*!40000 ALTER TABLE `Estado_Conservacion` DISABLE KEYS */;
INSERT INTO `Estado_Conservacion` VALUES
(1,'Preocupación menor'),(2,'Casi amenazado'),(3,'Vulnerable'),(4,'En peligro'),(5,'En peligro crítico');
/*!40000 ALTER TABLE `Estado_Conservacion` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Zonas`
-- ======================================================

DROP TABLE IF EXISTS `Zonas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Zonas` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nombre_region` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Zonas` WRITE;
/*!40000 ALTER TABLE `Zonas` DISABLE KEYS */;
INSERT INTO `Zonas` VALUES
(1,'Jalpan de Serra'),(2,'Landa de Matamoros'),(3,'Arroyo Seco'),(4,'Pinal de Amoles'),
(5,'San Joaquín'),(6,'Peñamiller'),(7,'Cadereyta de Montes'),(8,'Tolimán'),(9,'Colón'),
(10,'Ezequiel Montes'),(11,'Tequisquiapan'),(12,'San Juan del Rio'),(13,'Pedro Escobedo'),
(14,'El Marqués'),(15,'Querétaro'),(16,'Corregidora'),(17,'Huimilpan'),(18,'Amealco de Bonfil');
/*!40000 ALTER TABLE `Zonas` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Estatus`
-- ======================================================

DROP TABLE IF EXISTS `Estatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Estatus` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Estatus` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Estatus` WRITE;
/*!40000 ALTER TABLE `Estatus` DISABLE KEYS */;
INSERT INTO `Estatus` VALUES (1,'Activo'),(2,'Inactivo');
/*!40000 ALTER TABLE `Estatus` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Usuarios`
-- ======================================================

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellidoPaterno` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellidoMaterno` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_correo_unique` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` VALUES
(1,'Juan','García','López','juan.garcia.lopez@gmail.com','7#xK9!pL2q','usuario'),
(2,'María','Martínez','Sánchez','maria.martinez.sanchez@gmail.com','5@mY8zRt4s','usuario'),
(3,'Carlos','Rodríguez','Pérez','carlos.rodriguez.perez@gmail.com','9$fN3kPw6d','usuario'),
(4,'Ana','Hernández','Gómez','ana.hernandez.gomez@gmail.com','2%jH7vQl1m','usuario'),
(5,'Luis','González','Díaz','luis.gonzalez.diaz@gmail.com','8&bV4nXs9c','usuario'),
(6,'Laura','Fernández','Ruiz','laura.fernandez.ruiz@gmail.com','1^gT5mZr3y','usuario'),
(7,'Pedro','López','Alvarez','pedro.lopez.alvarez@gmail.com','6*L8kDf2jH','usuario'),
(8,'Sofía','Díaz','Moreno','sofia.diaz.moreno@gmail.com','3@qW9eRt7p','usuario'),
(9,'Jorge','Pérez','Muñoz','jorge.perez.munoz@gmail.com','4#sK1hJ5lM','usuario'),
(10,'Elena','Sánchez','Jiménez','elena.sanchez.jimenez@gmail.com','0$dF6nG8vB','usuario'),
(11,'Miguel','Ramírez','Torres','miguel.ramirez.torres@gmail.com','5%hJ3kL9pQ','usuario'),
(12,'Isabel','Flores','Ortega','isabel.flores.ortega@gmail.com','9&mN2bV7cX','usuario'),
(13,'Francisco','Gómez','Castillo','francisco.gomez.castillo@gmail.com','2^zR4tY6uI','usuario'),
(14,'Carmen','Torres','Romero','carmen.torres.romero@gmail.com','7*pL5wK3jD','usuario'),
(15,'Alejandro','Ruiz','Navarro','alejandro.ruiz.navarro@gmail.com','3@fH8qM1nS','usuario'),
(16,'Patricia','Ortega','Medina','patricia.ortega.medina@gmail.com','8#xT4vB9mZ','usuario'),
(17,'Ricardo','Vargas','Silva','ricardo.vargas.silva@gmail.com','1$kP6jL2hG','usuario'),
(18,'Adriana','Mendoza','Rios','adriana.mendoza.rios@gmail.com','6%rF3dS8gH','usuario'),
(19,'Fernando','Castro','Guerrero','fernando.castro.guerrero@gmail.com','4&vM7nB1qW','usuario'),
(20,'Gabriela','Reyes','Vega','gabriela.reyes.vega@gmail.com','0^cX9zL5kP','usuario'),
(21,'Roberto','Morales','Campos','roberto.morales.campos@gmail.com','5*bN2mH7jF','usuario'),
(22,'Lucía','Ortiz','Cortes','lucia.ortiz.cortes@gmail.com','9@qK4tR8vD','usuario'),
(23,'Javier','Guzmán','Rojas','javier.guzman.rojas@gmail.com','2#sP6wJ3lG','usuario'),
(24,'Verónica','Juárez','Miranda','veronica.juarez.miranda@gmail.com','7$dH1mK9nV','usuario'),
(25,'Daniel','Salazar','Santos','daniel.salazar.santos@gmail.com','3%fL8jB4pZ','usuario'),
(26,'Teresa','Delgado','Cruz','teresa.delgado.cruz@gmail.com','8^mQ5vT2cX','usuario'),
(27,'Arturo','Vázquez','Méndez','arturo.vazquez.mendez@gmail.com','1*pK7nJ6hG','usuario'),
(28,'Silvia','Iglesias','Rosas','silvia.iglesias.rosas@gmail.com','6@bR3tM9wF','usuario'),
(29,'Raúl','Cortés','Valdez','raul.cortes.valdez@gmail.com','4#zH8kL2vD','usuario'),
(30,'Beatriz','Núñez','Pineda','beatriz.nunez.pineda@gmail.com','0$qN5jP7mB','usuario'),
(31,'Héctor','Espinoza','Aguilar','hector.espinoza.aguilar@gmail.com','5%vF1kR9tL','usuario'),
(32,'Claudia','Valenzuela','León','claudia.valenzuela.leon@gmail.com','9&mX4nH7jD','usuario'),
(33,'Oscar','Molina','Márquez','oscar.molina.marquez@gmail.com','2^pB8wK3qZ','usuario'),
(34,'Diana','Rangel','Gallegos','diana.rangel.gallegos@gmail.com','7*dL6jH1mN','usuario'),
(35,'Manuel','Sosa','Cervantes','manuel.sosa.cervantes@gmail.com','3@fK9tR4vP','usuario'),
(36,'Rosa','Acosta','Montes','rosa.acosta.montes@gmail.com','8#sQ2mJ7nB','usuario'),
(37,'Alberto','Mejía','Ochoa','alberto.mejia.ochoa@gmail.com','1$hN5kL9pV','usuario'),
(38,'Mónica','Rosales','Valencia','monica.rosales.valencia@gmail.com','6%rT3wJ8mZ','usuario'),
(39,'Sergio','Aguirre','Esquivel','sergio.aguirre.esquivel@gmail.com','4&bP7vK2nX','usuario'),
(40,'Norma','Ponce','Padilla','norma.ponce.padilla@gmail.com','0^cM9jL5hF','usuario'),
(41,'Eduardo','Valdez','Cárdenas','eduardo.valdez.cardenas@gmail.com','5*zH3kQ8tD','usuario'),
(42,'Alicia','Franco','Cabrera','alicia.franco.cabrera@gmail.com','9@pB6nV1mJ','usuario'),
(43,'Guillermo','Galván','Villarreal','guillermo.galvan.villarreal@gmail.com','2#fR7kL4jH','usuario'),
(44,'Margarita','Serrano','Zamora','margarita.serrano.zamora@gmail.com','7$dM3tP9wN','usuario'),
(45,'José','Chávez','Lara','jose.chavez.lara@gmail.com','3%vQ8jK5hB','usuario'),
(46,'Lourdes','Camacho','Osorio','lourdes.camacho.osorio@gmail.com','8^mX4nL7pZ','usuario'),
(47,'Felipe','Velázquez','Andrade','felipe.velazquez.andrade@gmail.com','1*bT6kH9jF','usuario'),
(48,'Marisol','Barrios','Maldonado','marisol.barrios.maldonado@gmail.com','6@qP3wR7mD','usuario'),
(49,'Rodrigo','Salinas','Barrera','rodrigo.salinas.barrera@gmail.com','4#zN8jK2vB','usuario'),
(50,'Irene','Cervantes','Tapia','irene.cervantes.tapia@gmail.com','0$hL5mP9tX','usuario'),
(51,'Alfonso','Rivas','Colín','alfonso.rivas.colin@gmail.com','5%fB3kQ7jV','usuario'),
(52,'Rocío','Téllez','Quintero','rocio.tellez.quintero@gmail.com','9&mR6nH1pD','usuario'),
(53,'Gerardo','Lara','Zúñiga','gerardo.lara.zuniga@gmail.com','2^vK8jL4tZ','usuario'),
(54,'Paulina','Miranda','Zavala','paulina.miranda.zavala@gmail.com','7*pX5mH9nB','usuario'),
(55,'Rubén','Rocha','Arellano','ruben.rocha.arellano@gmail.com','3@dQ2kR7jF','usuario'),
(56,'Virginia','Bernal','Corona','virginia.bernal.corona@gmail.com','8#sN4mK1tL','usuario'),
(57,'Marcos','Vega','Castañeda','marcos.vega.castaneda@gmail.com','1$hP7jB5vX','usuario'),
(58,'Yolanda','Márquez','Ibarra','yolanda.marquez.ibarra@gmail.com','6%rL3kM9nD','usuario'),
(59,'Hugo','Orozco','Solís','hugo.orozco.solis@gmail.com','4&bT8vJ2pZ','usuario'),
(60,'Natalia','Solís','Palacios','natalia.solis.palacios@gmail.com','0^cQ5mK7jH','usuario'),
(61,'René','Medina','Pacheco','rene.medina.pacheco@gmail.com','5*zN3kP9tB','usuario'),
(62,'Graciela','Parra','Delarosa','graciela.parra.delarosa@gmail.com','9@fR6jH2mX','usuario'),
(63,'Federico','Bustamante','Contreras','federico.bustamante.contreras@gmail.com','2#vL8kP5nD','usuario'),
(64,'Leticia','Zamora','Galván','leticia.zamora.galvan@gmail.com','7$dM4jB9tQ','usuario'),
(65,'Salvador','Pineda','Reyna','salvador.pineda.reyna@gmail.com','3%pX6nK1mH','usuario'),
(66,'Aurora','Quiroz','Salgado','aurora.quiroz.salgado@gmail.com','8^bT7jL4vD','usuario'),
(67,'Martín','Rosas','Vázquez','martin.rosas.vazquez@gmail.com','1*hQ5kP9nZ','usuario'),
(68,'Luz','Cárdenas','Magaña','luz.cardenas.magana@gmail.com','6@mN3jR7tB','usuario'),
(69,'Feliciano','Maldonado','Campos','feliciano.maldonado.campos@gmail.com','4#zP8kL2vH','usuario'),
(70,'Estela','Corona','Ríos','estela.corona.rios@gmail.com','0$fB5mJ9nX','usuario'),
(71,'Ramiro','Esquivel','Valenzuela','ramiro.esquivel.valenzuela@gmail.com','5%vQ3kR7jD','usuario'),
(72,'Dolores','Padilla','Franco','dolores.padilla.franco@gmail.com','9&mT6nH1pB','usuario'),
(73,'Saúl','Cabrera','Mendoza','saul.cabrera.mendoza@gmail.com','2^dL8jK4tX','usuario'),
(74,'Esperanza','Villarreal','Ortiz','esperanza.villarreal.ortiz@gmail.com','7*pX5mN9jH','usuario'),
(75,'Fermín','Zavala','Sosa','fermin.zavala.sosa@gmail.com','3@bQ2kP7tD','usuario'),
(76,'Isabel','Navarrete',NULL,'isabelnavarrete@florayfauna.com','admi1234','admin'),
(77,'Sara','Méndez','Reyes','sara.mendez.reyes@gmail.com','9@kL4pR7tY','usuario'),
(78,'Alberto','Fuentes','Delgado','alberto.fuentes.delgado@gmail.com','1#mN8vB5cX','usuario'),
(79,'Lucía','Vega','Camacho','lucia.vega.camacho@gmail.com','6$qW2jH9lP','usuario'),
(80,'Emilio','Ríos','Maldonado','emilio.rios.maldonado@gmail.com','3%zT7kM4nD','usuario'),
(81,'Clara','Pacheco','Quintero','clara.pacheco.quintero@gmail.com','8&bV1nX6yL','usuario'),
(82,'Joaquín','Valenzuela','Galindo','joaquin.valenzuela.galindo@gmail.com','2^pK5mJ9rF','usuario'),
(83,'Elena','Delgado','Barrera','elena.delgado.barrera@gmail.com','7*dH3tR6wQ','usuario'),
(84,'Mario','Cervantes','Miranda','mario.cervantes.miranda@gmail.com','4@fL8sG1vN','usuario'),
(85,'Patricia','Zúñiga','Ocampo','patricia.zuniga.ocampo@gmail.com','0$cJ5hM7kP','usuario'),
(86,'Ricardo','Palacios','Tapia','ricardo.palacios.tapia@gmail.com','5%vQ3rT9nB','usuario'),
(87,'Adrián','Huerta','Solis','adrian.huerta.solis@gmail.com','9&mX2kL6pZ','usuario'),
(88,'Mariana','Esparza','Rangel','mariana.esparza.rangel@gmail.com','3^bN7jH4vD','usuario'),
(89,'Felipe','Lozano','Mora','felipe.lozano.mora@gmail.com','8*pK1tR5wF','usuario'),
(90,'Daniela','Caballero','Vargas','daniela.caballero.vargas@gmail.com','1@dM6sJ9qL','usuario'),
(91,'Hugo','Navarrete','Cisneros','hugo.navarrete.cisneros@gmail.com','6#zT4vB7kP','usuario');
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Especies`
-- ======================================================

DROP TABLE IF EXISTS `Especies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Especies` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre_comun` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_cientifico` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` int DEFAULT NULL,
  `id_familia` int DEFAULT NULL,
  `id_zonas` int DEFAULT NULL,
  `id_estado_conservacion` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `especies_tipo_fk` (`tipo`),
  KEY `especies_familia_fk` (`id_familia`),
  KEY `especies_zonas_fk` (`id_zonas`),
  KEY `especies_estado_fk` (`id_estado_conservacion`),
  CONSTRAINT `especies_tipo_fk` FOREIGN KEY (`tipo`) REFERENCES `Tipo` (`ID`),
  CONSTRAINT `especies_familia_fk` FOREIGN KEY (`id_familia`) REFERENCES `Familia` (`ID`),
  CONSTRAINT `especies_zonas_fk` FOREIGN KEY (`id_zonas`) REFERENCES `Zonas` (`ID`),
  CONSTRAINT `especies_estado_fk` FOREIGN KEY (`id_estado_conservacion`) REFERENCES `Estado_Conservacion` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Especies` WRITE;
/*!40000 ALTER TABLE `Especies` DISABLE KEYS */;
INSERT INTO `Especies` VALUES
(1,'Mirlo café','Turdus grayi',2,1,1,1),
(2,'Zanate Mayor','Quiscalus mexicanus',2,2,1,1),
(3,'chamal','Dioon edule',1,3,1,2),
(4,'canelilla','Croton ciliatoglandulifer',1,4,1,3),
(5,'Tangara Azulgrís','Thraupis episcopus',2,5,2,1),
(6,'Araña de Seda dorada','Trichonephila clavipes',2,6,2,3),
(7,'Mirto coral','Salvia coccinea',1,7,2,3),
(8,'Tecolote','Tillandsia imperialis',1,8,2,3),
(9,'alacrancillo','Heliotropium angiospermum',1,9,3,3),
(10,'Biznaga barril espinosa','Ferocactus echidne',1,10,3,3),
(11,'Guacamaya verde','Ara militaris',2,11,3,2),
(12,'Hormiga chicatana negra','Atta mexicana',2,12,3,3),
(13,'calates','Rheohyla miotympanum',2,13,4,3),
(14,'Mariposa parche carmesí','Chlosyne janais',2,14,4,3),
(15,'Maguey de peña','Agave mitis',1,15,4,3),
(16,'Álamo blanco','Platanus mexicana',1,16,4,3),
(17,'Chara pecho gris','Aphelocoma wollweberi',2,17,5,3),
(18,'Carpintero bellotero','Melanerpes formicivorus',2,18,5,3),
(19,'Hierba de golpe','Oenothera rosea',1,19,5,3),
(20,'Mirto chico','Salvia microphylla',1,7,5,3),
(21,'Biznaga burra','Echinocactus platyacanthus',1,10,6,3),
(22,'Peyote de Querétaro','Lophophora diffusa',1,10,6,2),
(23,'Papamoscas negro','Sayornis nigricans',2,20,6,3),
(24,'Zopilote aura','Cathartes aura',2,21,6,1),
(25,'Garambullo','Myrtillocactus geometrizans',1,10,7,3),
(26,'Alicoche cocuá','Echinocereus cinera',1,10,7,3),
(27,'Colibrí pico ancho norteño','Cynanthus latirostris',2,22,7,3),
(28,'Carpintero cheje','Melanerpes aurifrons',2,18,7,3),
(29,'Biznaga partida parada','Coryphantha erecta',1,10,8,3),
(30,'Biznaga comprimida','Mammillaria compresa',1,10,8,3),
(31,'Culebra lineada de bosque','Thamnophis cyrtopsis',2,23,8,3),
(32,'Lagartija esponjosa mexicana','Sceloporus spinosus',2,24,8,3),
(33,'Manzanilla de llano','Senecio inaequidens',1,25,9,3),
(34,'Gallito de monte','Zinnia peruviana',1,25,9,3),
(35,'Mariposa monarca','Danaus plexippus',1,14,11,4),
(36,'Biznaga ganchuda','Ferocactus latispinus',1,10,11,3),
(37,'Centzontle norteño','Mimus polyglottos',2,26,11,3),
(38,'Flor de gallito','Salvia patens',1,7,18,3),
(39,'Dalia roja','Dahlia coccinea',1,25,18,3),
(40,'Zafiro orejas blancas','Basilinna leucotis',2,22,18,3),
(41,'Capulinero gris','Ptiliogonys cinereus',2,27,18,3),
(42,'Ranita de cañón','Hyla arenicolor',2,11,18,3),
(43,'Camaleón de montaña','Phrynosoma orbiculare',2,42,18,3),
(44,'Lagartija espinosa de collar','Sceloporus torquatus',2,42,18,3),
(45,'Lagartija espinosa menor','Sceloporus minor',2,42,10,3),
(46,'Rana arborícola de montaña','Hyla eximia',2,11,18,3),
(47,'Junco ojos de lumbre','Junco phaeonotus',2,1,18,3),
(48,'Gallureta americana','Fulica americana',2,44,18,3),
(49,'Jilguerito dominico','Spinus psaltria',2,45,18,3),
(50,'Pato mexicano','Anas diazi',2,46,18,3),
(51,'Garza ganadera occidental','Ardea ibis',2,47,18,3),
(52,'Piranga encinera','Piranga flava',2,4,18,3),
(53,'Gorrión cantor','Melospiza melodia',2,48,18,3),
(54,'Papamoscas José María','Contopus pertinax',2,50,18,3),
(55,'Papamoscas pecho canela','Empidonax fulvifrons',2,50,18,3),
(56,'Chipe cabeza amarilla','Setophaga accidentalis',2,51,18,3),
(57,'Zacatonero corona canela','Aimophila ruficeps',2,48,18,3),
(58,'Picogordo tigrillo','Pheucticus melanocephalus',2,52,18,3),
(59,'Pingüica','Arctostaphylos pingens',1,37,18,3),
(60,'Tlacote','Salvia mexicana',1,6,18,3),
(61,'Violeta de barranca','Pinguicula moranensis',1,43,18,3),
(62,'Azucena de monte','Govenia capitata',1,35,18,3),
(63,'Conchita','Echeveria secunda',1,49,18,3),
(64,'Madroño mexicano','Arbutus tessellata',1,37,18,3),
(65,'Kalanchoe de Madagascar','Kalanchoe delagiensis',1,49,10,3),
(66,'Cardenche','Cylindropuntia imbricata',1,9,10,3),
(67,'Biznaga barril de acitrón','Ferocactus histrix',1,9,10,3),
(68,'Chilayo','Lophocereus marginatus',1,9,10,3),
(69,'Cinco llagas','Tagetes lunulata',1,19,10,3),
(70,'Mozote amarillo','Sclerocarpus uniserialis',1,19,10,3),
(71,'Tronadora','Tecoma stans',1,39,10,3),
(72,'Hierba del negro','Sphaeralcea angustifolia',1,53,10,3),
(73,'Maguey pulquero','Agave salmiana',1,14,10,3),
(74,'Chapulín arcoíris','Dactylotum bicolor',2,32,10,3),
(75,'Avispa papelera colorada','Polistes canadensis',2,29,10,3),
(76,'Tabaquillo sudamericano','Nicotina glauca',1,24,9,1),
(77,'Biznada ganchuda','Mammillaria uncinata',1,9,9,2),
(78,'ayohuiztle','Solanum rostratum',1,24,9,1),
(79,'Pasto africano rosado','Melinis repens',1,38,9,1),
(80,'paixtle','Tillandsia recurvata',1,7,11,1),
(81,'baloncillo','Auriparus flaviceps',2,59,12,1),
(82,'huizache','Vachellia farnesiana',1,39,12,1),
(83,'chapulixtle','Dodonaea viscosa',1,58,12,1),
(84,'tepenexcomite','Echinofossulocactus pentacanthus',1,9,12,2),
(85,'Cazahuate blanco','Ipomoea murucoides',1,23,13,1),
(86,'azomiate','Barkleyanthus salicifolius',1,19,13,1),
(87,'Amor seco','Gomphrena serrata',1,66,13,1),
(88,'Hierba del cáncer','Salvia amarissima',1,6,13,1),
(89,'Chipe rabadilla amarilla','Setophaga coronata',2,41,14,1),
(90,'Falaropo pico largo','Phalaropus tricolor',2,60,14,1),
(91,'Narciso amarillo','Cascabela thevetioides',1,61,14,1),
(92,'Rucola silvestre','Eruca sativa',1,62,14,1),
(93,'Perico monje argentino','Myiopsitta monachus',2,10,15,1),
(94,'Carpintero cheje v2','Melanerpes aurifrons',2,17,15,1),
(95,'torote','Bursera fagaroides',1,3,15,1),
(96,'Mariposa azufre gigante','Anteos maerula',2,13,15,1),
(97,'Esperanza azteca','Stilpnochlora azteca',2,32,16,1),
(98,'Marquita convergente','Hippodamia convergens',2,68,16,1),
(99,'Mariposa azul marina','Leptotes marina',2,13,16,1),
(100,'tullidora','Karwinskia humboldtiana',1,63,16,2),
(101,'Zorrillo listado sureño','Mephitis macroura',2,64,17,1),
(102,'Saltarina de tablero','Burnsius communis',2,65,17,1),
(103,'Zumbador canelo','Selasphorus rufus',2,31,17,1),
(104,'Mirlo primavera','Turdus migratorius',2,1,17,1);
/*!40000 ALTER TABLE `Especies` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Fotografia`
-- ======================================================

DROP TABLE IF EXISTS `Fotografia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Fotografia` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `url_imagen` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_especie` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fotografia_especie_fk` (`id_especie`),
  CONSTRAINT `fotografia_especie_fk` FOREIGN KEY (`id_especie`) REFERENCES `Especies` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Fotografia` WRITE;
/*!40000 ALTER TABLE `Fotografia` DISABLE KEYS */;
INSERT INTO `Fotografia` VALUES
(1,'C:/imagenes/mirlo cafe 2.jpg',1),(2,'C:/imagenes/zanate mayor 2.jpg',2),
(3,'C:/imagenes/chamal 2.jpg',3),(4,'C:/imagenes/canelilla.jpg',4),
(5,'C:/imagenes/tangara azulgris 2.jpg',5),(6,'C:/imagenes/arana seda dorada.jpg',6),
(7,'C:/imagenes/mirto coral.jpg',7),(8,'C:/imagenes/tecolote.jpg',8),
(9,'C:/imagenes/alacrancillo 2.jpg',9),(10,'C:/imagenes/biznaga barril 2.jpg',10),
(11,'C:/imagenes/guacamaya verde 2.jpg',11),(12,'C:/imagenes/hormiga chicatana 2.jpg',12),
(13,'C:/imagenes/calates 2.jpg',13),(14,'C:/imagenes/mariposa carmesi 2.jpg',14),
(15,'C:/imagenes/maguey pena.jpg',15),(16,'C:/imagenes/alamo blanco.jpg',16),
(17,'C:/imagenes/chara pecho gris.jpg',17),(18,'C:/imagenes/carpintero bellotero 2.jpg',18),
(19,'C:/imagenes/hierba golpe.jpg',19),(20,'C:/imagenes/mirto chico 2.jpg',20),
(21,'C:/imagenes/biznaga burra.jpg',21),(22,'C:/imagenes/peyote.jpg',22),
(23,'C:/imagenes/papamoscas negro.jpg',23),(24,'C:/imagenes/zopilote aura.jpg',24),
(25,'C:/imagenes/garambullo.jpg',25),(26,'C:/imagenes/alicoche.jpg',26),
(27,'C:/imagenes/colibri pico ancho 2.jpg',27),(28,'C:/imagenes/carpintero cheje.jpg',28),
(29,'C:/imagenes/biznaga partida.jpg',29),(30,'C:/imagenes/biznaga comprimida.jpg',30),
(31,'C:/imagenes/culebra lineada.jpg',31),(32,'C:/imagenes/lagartija esponjosa.jpg',32),
(33,'C:/imagenes/manzanilla llano.jpg',33),(34,'C:/imagenes/gallito monte.jpg',34),
(35,'C:/imagenes/mariposa monarca 2.jpg',35),(36,'C:/imagenes/biznaga ganchuda.jpg',36),
(37,'C:/imagenes/centzontle.jpg',37),(38,'C:/imagenes/flor gallito.jpg',38),
(39,'C:/imagenes/dalia roja.jpg',39),(40,'C:/imagenes/zafiro orejas_blancas.jpg',40),
(41,'C:/imagenes/capulinero gris.jpg',41),(42,'C:/imagenes/ranita canyon.jpg',42),
(43,'C:/imagenes/camaleon montana.jpg',43),(44,'C:/imagenes/largartija espinosa collar.jpg',44),
(45,'C:/imagenes/lagartija menor.jpg',45),(46,'C:/imagenes/rana arboricola de montana.jpg',46),
(47,'C:/imagenes/junco ojos de lumbre.jpg',47),(48,'C:/imagenes/gallareta.jpg',48),
(49,'C:/imagenes/jilguerito.jpg',49),(50,'C:/imagenes/pato mexicano.jpg',50),
(51,'C:/imagenes/garza ganadera 2.jpg',51),(52,'C:/imagenes/gorrion cantador.jpg',53),
(53,'C:/imagenes/papamoscas jose maria.jpg',54),(54,'C:/imagenes/papamoscas pecho canela.jpg',55),
(55,'C:/imagenes/chipe cabaeza amarilla.jpg',56),(56,'C:/imagenes/zacatonero corona canela.jpg',57),
(57,'C:/imagenes/picogordo tigrillo.jpg',58),(58,'C:/imagenes/pinguica.jpg',59),
(59,'C:/imagenes/tlacote.jpg',60),(60,'C:/imagenes/violeta de barranca.jpg',61),
(61,'C:/imagenes/azucena de monte.jpg',62),(62,'C:/imagenes/conchita.jpg',63),
(63,'C:/imagenes/madrono mexicano.jpg',64),(64,'C:/imagenes/kalanchoe.jpg',65),
(65,'C:/imagenes/cardenche.jpg',66),(66,'C:/imagenes/biznaga acitron.jpg',67),
(67,'C:/imagenes/chilayo.jpg',68),(68,'C:/imagenes/cinco llagas.jpg',69),
(69,'C:/imagenes/mozote amarillo.jpg',70),(70,'C:/imagenes/tronadora.jpg',71),
(71,'C:/imagenes/hierba negro.jpg',72),(72,'C:/imagenes/maguey pulquero 2.jpg',73),
(73,'C:/imagenes/chapulin arcoiris.jpg',74),(74,'C:/imagenes/avispa papelera.jpg',75),
(75,'C:/imagenes/tabaquillo.jpg',76),(76,'C:/imagenes/biznaga ganchuda.jpg',77),
(77,'C:/imagenes/ayohuiztle.jpg',78),(78,'C:/imagenes/pasto africano.jpg',79),
(79,'C:/imagenes/paixtle.jpeg',80),(80,'C:/imagenes/baloncillo.jpg',81),
(81,'C:/imagenes/huizache.jpeg',82),(82,'C:/imagenes/chapulixtle.jpg',83),
(83,'C:/imagenes/tepenexcomite.jpg',84),(84,'C:/imagenes/Cazahuate.jpg',85),
(85,'C:/imagenes/azomiate.jpg',86),(86,'C:/imagenes/Amor.jpg',87),
(87,'C:/imagenes/HierbaCancer.jpg',88),(88,'C:/imagenes/Chipe.jpg',89),
(89,'C:/imagenes/falaropo.jpg',90),(90,'C:/imagenes/cascabela.jpg',91),
(91,'C:/imagenes/Rucola.jpg',92),(92,'C:/imagenes/monje.jpg',93),
(93,'C:/imagenes/cheje.jpg',94),(94,'C:/imagenes/torote.jpg',95),
(95,'C:/imagenes/azufre.jpg',96),(96,'C:/imagenes/azteca.jpg',97),
(97,'C:/imagenes/Marquita.jpg',98),(98,'C:/imagenes/azul.jpg',99),
(99,'C:/imagenes/tullidora.jpg',100),(100,'C:/imagenes/zorrillo.jpeg',101),
(101,'C:/imagenes/saltarina.jpg',102),(102,'C:/imagenes/zacatonero corona canela.jpg',103),
(103,'C:/imagenes/MirloPrimavera.jpg',104);
/*!40000 ALTER TABLE `Fotografia` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `consejos`
-- ======================================================

DROP TABLE IF EXISTS `consejos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consejos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `zona` int NOT NULL,
  `titulo` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consejo` text COLLATE utf8mb4_unicode_ci,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consejos_zona_fk` (`zona`),
  CONSTRAINT `consejos_zona_fk` FOREIGN KEY (`zona`) REFERENCES `Zonas` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `consejos` WRITE;
/*!40000 ALTER TABLE `consejos` DISABLE KEYS */;
INSERT INTO `consejos` VALUES
(1,1,'Protección del Mirlo café','Evita alimentar a los mirlos con pan o comida humana, ya que puede dañar su salud. Mejor planta arbustos con bayas nativas.','2023-01-15','08:30:00'),
(2,1,'Cuidado del Chamal','No extraigas las hojas del chamal, esta planta crece muy lentamente y es importante para el ecosistema.','2023-02-20','10:15:00'),
(3,1,'Control de residuos','En áreas naturales, lleva contigo una bolsa para recolectar tu basura y la que encuentres en el camino.','2023-03-10','09:00:00'),
(4,1,'Senderos responsables','Camina sólo por los senderos marcados para evitar dañar la vegetación endémica.','2023-04-05','11:45:00'),
(5,1,'Respeto a la fauna','Mantén una distancia adecuada al observar aves y otros animales silvestres.','2023-05-12','07:30:00'),
(6,2,'Protección de la Tangara Azulgrís','Instala bebederos para aves con agua limpia, especialmente en temporada de sequía.','2023-01-22','08:00:00'),
(7,2,'Cuidado del Mirto coral','Si recolectas plantas medicinales, hazlo de forma sostenible, tomando sólo lo necesario.','2023-02-18','14:20:00'),
(8,2,'Arañas benéficas','No destruyas las telarañas de la Araña de Seda dorada, controlan plagas de insectos.','2023-03-15','10:00:00'),
(9,2,'Reforestación responsable','Planta sólo especies nativas al reforestar tu terreno.','2023-05-20','09:15:00'),
(10,3,'Guacamayas verdes','Reporta avistamientos de guacamayas verdes a las autoridades ambientales y Protege su hábitat evitando talar árboles y dejando el área libre de basura.','2023-01-10','07:45:00'),
(11,3,'Hormigas chicatanas','En temporada de lluvias, recolecta sólo lo necesario de estas hormigas para consumo.','2023-03-12','17:00:00'),
(12,3,'Alacrancillo medicinal','Si usas esta planta con fines medicinales, deja siempre suficientes ejemplares para su reproducción.','2023-04-18','08:30:00'),
(13,3,'Control de incendios','No hagas fogatas en zonas no autorizadas, especialmente en temporada seca.','2023-05-22','15:15:00'),
(14,4,'Protección de ranas','Mantén limpios los cuerpos de agua para preservar el hábitat de los calates.','2023-01-05','10:30:00'),
(15,4,'Mariposas en peligro','Planta flores nativas que sirvan de alimento a las mariposas locales.','2023-02-15','11:45:00'),
(16,4,'Álamos blancos','Participa en programas de reforestación con especies nativas como el álamo blanco.','2023-03-20','09:00:00'),
(17,4,'Turismo responsable','Contrata guías locales para excursiones, conocen las normas de protección ambiental.','2023-05-25','16:30:00'),
(18,5,'Chara pecho gris','Instala comederos con semillas de girasol para apoyar a estas aves en invierno.','2023-01-18','08:00:00'),
(19,5,'Carpinteros belloteros','Protege los árboles viejos que tienen cavidades donde anidan los carpinteros.','2023-02-22','10:45:00'),
(20,5,'Mirto chico','Planta esta salvia en tu jardín para atraer polinizadores.','2023-04-12','15:00:00'),
(21,5,'Senderismo responsable','Evita hacer ruido excesivo que pueda alterar a la fauna silvestre.','2023-05-28','07:30:00'),
(22,6,'Peyote protegido','La recolección de peyote está estrictamente regulada, no lo extraigas sin permiso.','2023-02-28','11:30:00'),
(23,6,'Aves insectívoras','Reduce el uso de pesticidas que afectan a aves como el papamoscas negro.','2023-03-14','14:45:00'),
(24,6,'Zopilotes benéficos','No molestes a los zopilotes, cumplen una función vital como limpiadores naturales.','2023-04-16','16:00:00'),
(25,6,'Conservación de suelos','Implementa terrazas y barreras vivas para prevenir erosión en laderas.','2023-05-30','08:30:00'),
(26,7,'Garambullo comestible','Si recolectas frutos de garambullo, deja suficientes para la fauna y reproducción.','2023-01-25','10:00:00'),
(27,7,'Colibríes en peligro','Instala bebederos con agua azucarada (4 partes agua, 1 parte azúcar) sin colorantes.','2023-03-18','15:30:00'),
(28,7,'Carpinteros cheje','Protege los árboles muertos que sirven de hogar a estas aves.','2023-04-20','09:45:00'),
(29,7,'Cactáceas nativas','Si cultivas cactáceas, asegúrate que sean de viveros autorizados, no extraídas.','2023-05-10','11:00:00'),
(30,8,'Biznagas endémicas','Reporta a autoridades cualquier actividad ilegal de extracción de biznagas.','2023-01-08','08:45:00'),
(31,8,'Reptiles protegidos','Si encuentras una culebra lineada, no la mates, aléjate con cuidado.','2023-02-12','13:00:00'),
(32,8,'Conservación de suelos','Implementa prácticas agrícolas sostenibles para proteger el hábitat.','2023-04-25','10:30:00'),
(33,8,'Turismo ecológico','Elige operadores turísticos con certificación ambiental.','2023-05-15','14:45:00'),
(34,9,'Manzanilla de llano','Si recolectas manzanilla, hazlo de forma rotativa para permitir su regeneración.','2023-01-12','09:30:00'),
(35,9,'Gallito de monte','Planta zinnias en tu jardín para apoyar a los polinizadores locales.','2023-02-17','11:45:00'),
(36,9,'Control de especies invasoras','Elimina plantas exóticas que compitan con especies nativas.','2023-03-25','15:00:00'),
(37,9,'Consumo responsable','Prefiere productos locales que no dañen el ecosistema.','2023-04-15','08:15:00'),
(38,10,'Kalanchoe ornamental','Si cultivas esta planta, evita que se propague a áreas naturales.','2023-01-30','10:00:00'),
(39,10,'Biznaga de acitrón','No consumas acitrón ilegal que provenga de biznagas protegidas.','2023-03-05','16:30:00'),
(40,10,'Chapulín arcoíris','Reduce el uso de pesticidas que afectan a estos insectos benéficos.','2023-04-22','09:45:00'),
(41,11,'Mariposa Monarca','Planta algodoncillo nativo para apoyar a las mariposas monarca en su migración.','2023-01-14','08:30:00'),
(42,11,'Biznaga ganchuda','No compras souvenirs hechos con biznagas protegidas.','2023-02-24','12:45:00'),
(43,11,'Centzontle norteño','Reduce la contaminación lumínica que afecta a las aves nocturnas.','2023-03-16','15:00:00'),
(44,11,'Conservación de humedales','Protege los cuerpos de agua que son hábitat de muchas especies.','2023-04-28','10:15:00'),
(45,11,'Agricultura sostenible','Implementa técnicas de riego por goteo para conservar agua.','2023-05-08','14:30:00'),
(46,12,'Jardines polinizadores','Planta flores nativas para apoyar a abejas, mariposas y colibríes.','2023-01-17','09:00:00'),
(47,12,'Árboles nativos','Prefiere árboles como el mezquite o huizache para reforestar.','2023-03-28','16:30:00'),
(48,13,'Control de plagas natural','Atrae aves insectívoras para control de plagas en cultivos.','2023-01-19','10:30:00'),
(49,13,'Setos vivos','Usa plantas nativas como cercos naturales en lugar de muros.','2023-02-26','14:45:00'),
(50,13,'Conservación de suelos','Implementa rotación de cultivos y abonos verdes.','2023-03-17','08:00:00'),
(51,13,'Agua de lluvia','Instala sistemas de captación de agua pluvial.','2023-04-24','12:15:00'),
(52,13,'Biodiversidad agrícola','Mantén variedades tradicionales de cultivos.','2023-05-14','16:30:00'),
(53,14,'Corredores biológicos','Mantén franjas de vegetación nativa entre cultivos.','2023-01-21','11:00:00'),
(54,14,'Techos verdes','Considera instalar vegetación en techos para reducir calor urbano.','2023-02-14','15:15:00'),
(55,14,'Humedales artificiales','Crea pequeñas áreas inundables para fauna acuática.','2023-03-24','09:30:00'),
(56,14,'Control biológico','Usa insectos benéficos en lugar de pesticidas químicos.','2023-04-19','13:45:00'),
(57,14,'Educación ambiental','Organiza talleres sobre conservación en tu comunidad.','2023-05-26','17:00:00'),
(58,15,'Jardines urbanos','Crea espacios verdes con plantas nativas en la ciudad.','2023-01-23','08:45:00'),
(59,15,'Aves urbanas','Instala nidos artificiales para aves nativas en parques.','2023-02-16','12:00:00'),
(60,15,'Movilidad sostenible','Usa bicicleta o transporte público para reducir contaminación.','2023-03-26','15:15:00'),
(61,15,'Árboles urbanos','Riega y cuida los árboles de tu colonia, especialmente en verano.','2023-04-21','09:30:00'),
(62,15,'Reciclaje comunitario','Organiza puntos de reciclaje en tu vecindario.','2023-05-16','13:45:00'),
(63,16,'Corredores verdes','Mantén conexiones de vegetación entre áreas naturales.','2023-01-27','10:15:00'),
(64,16,'Reforestación urbana','Participa en jornadas de plantación de árboles nativos.','2023-03-29','08:45:00'),
(65,16,'Conservación de cerros','Respeta las áreas protegidas y no construyas en zonas restringidas.','2023-04-26','12:00:00'),
(66,16,'Agricultura periurbana','Promueve huertos comunitarios con técnicas orgánicas.','2023-05-19','16:15:00'),
(67,17,'Flor de gallito','Planta esta salvia en tu jardín para atraer colibríes.','2023-01-28','09:45:00'),
(68,17,'Zafiro orejas blancas','Mantén fuentes de agua limpia para estos colibríes.','2023-03-30','16:15:00'),
(69,17,'Capulinero gris','Protege los árboles de capulín que son su fuente de alimento.','2023-04-27','10:30:00'),
(70,17,'Ranita de cañón','Conserva los arroyos y manantiales de la zona.','2023-05-21','14:45:00'),
(71,18,'Carpintero bellotero','Protege los encinos que son vitales para esta especie.','2023-01-29','11:15:00'),
(72,18,'Camaleón de montaña','Si encuentras uno en camino, ayúdalo a cruzar con cuidado.','2023-02-27','15:30:00'),
(73,18,'Junco ojos de lumbre','Mantén humedales y áreas pantanosas que son su hábitat.','2023-03-31','09:45:00'),
(74,18,'Pingüica','No extraigas grandes cantidades de esta planta medicinal.','2023-04-30','13:00:00');
/*!40000 ALTER TABLE `consejos` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Comentario`
-- ======================================================

DROP TABLE IF EXISTS `Comentario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Comentario` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Contenido` text COLLATE utf8mb4_unicode_ci,
  `Fecha_publicacion` date DEFAULT NULL,
  `ID_usuario` int DEFAULT NULL,
  `ID_zona` int DEFAULT NULL,
  `ID_estatus` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `comentario_usuario_fk` (`ID_usuario`),
  KEY `comentario_zona_fk` (`ID_zona`),
  KEY `comentario_estatus_fk` (`ID_estatus`),
  CONSTRAINT `comentario_usuario_fk` FOREIGN KEY (`ID_usuario`) REFERENCES `Usuarios` (`id`),
  CONSTRAINT `comentario_zona_fk` FOREIGN KEY (`ID_zona`) REFERENCES `Zonas` (`ID`),
  CONSTRAINT `comentario_estatus_fk` FOREIGN KEY (`ID_estatus`) REFERENCES `Estatus` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Comentario` WRITE;
/*!40000 ALTER TABLE `Comentario` DISABLE KEYS */;
INSERT INTO `Comentario` VALUES
(1,'Un paisaje espectacular, perfecto para desconectar.','2024-06-15',12,4,1),
(2,'Esperaba más fauna, pero el lugar es tranquilo.','2023-09-30',34,9,2),
(3,'Las rutas de senderismo están bien señalizadas.','2024-02-12',18,3,1),
(4,'Ideal para una escapada de fin de semana.','2023-07-25',21,5,1),
(5,'El agua del río estaba cristalina, una maravilla.','2024-01-18',45,7,1),
(6,'Faltan más zonas de descanso, pero el entorno es inmejorable.','2023-05-22',8,6,2),
(7,'Vi un ciervo en plena naturaleza, fue impresionante.','2024-03-14',27,11,1),
(8,'Demasiada gente en algunas zonas, pero sigue siendo un lugar bonito.','2023-10-10',39,12,2),
(9,'Los caminos necesitan algo de mantenimiento.','2023-08-05',6,15,2),
(10,'Un paraíso natural, sin duda volveré.','2024-04-01',14,2,1),
(11,'El aire puro y el silencio hacen que sea una experiencia única.','2023-11-20',30,18,1),
(12,'Buena señalización, aunque los mapas podrían mejorar.','2024-02-27',17,8,2),
(13,'Fascinante variedad de aves, me encantó la visita.','2023-06-14',9,18,1),
(14,'El acceso es un poco difícil, pero vale la pena.','2023-12-05',42,13,2),
(15,'Me encantó la vegetación, muy bien conservada.','2024-05-07',33,10,1),
(16,'Un sitio ideal para los amantes de la fotografía.','2023-09-29',25,16,1),
(17,'Faltan más papeleras, pero la limpieza es aceptable.','2024-01-30',19,14,2),
(18,'El amanecer desde el mirador es impresionante.','2023-08-22',13,10,1),
(19,'Un refugio natural lleno de paz y belleza.','2024-04-10',11,1,1),
(20,'Las cascadas eran impresionantes, vale la pena la caminata.','2024-06-10',5,3,1),
(21,'Muy buena experiencia, pero haría falta más información en la entrada.','2023-07-20',22,8,2),
(22,'El clima estuvo perfecto, un día inolvidable.','2023-09-05',38,17,1),
(23,'Muchos mosquitos en la zona, hay que llevar repelente.','2024-03-25',10,12,2),
(24,'Genial para ir en familia, espacio amplio y bien cuidado.','2024-01-08',41,6,1),
(25,'Me encontré con una familia de mapaches, una gran sorpresa.','2023-11-14',16,11,1),
(26,'El mirador tiene una de las mejores vistas de la región.','2023-08-30',28,9,1),
(27,'El sonido de los pájaros por la mañana es mágico.','2024-05-18',36,13,1),
(28,'Ideal para practicar fotografía de naturaleza.','2023-12-10',4,14,1),
(29,'Haría falta más señalización en algunos senderos.','2024-02-05',31,15,2),
(30,'El atardecer desde la colina es simplemente mágico.','2023-10-15',7,4,1),
(31,'Encontré algunas rutas cerradas por mantenimiento.','2024-01-22',23,7,2),
(32,'Perfecto para desconectar del estrés diario.','2023-06-30',40,2,1),
(33,'Las instalaciones están algo descuidadas.','2024-03-05',15,10,2),
(34,'Vimos varias especies de mariposas increíbles.','2023-08-12',29,18,1),
(35,'El acceso para personas con movilidad reducida es limitado.','2024-04-18',3,5,2),
(36,'El silencio solo se rompe por los sonidos de la naturaleza.','2023-11-25',37,18,1),
(37,'Algunos senderos están muy erosionados.','2024-02-08',20,16,2),
(38,'La zona de picnic es muy acogedora y limpia.','2023-09-14',44,1,1),
(39,'Faltan más baños públicos en el área.','2023-12-20',9,12,2),
(40,'El guía turístico fue muy informativo y amable.','2024-05-05',26,8,1),
(41,'Demasiado ruido de visitantes en algunas áreas.','2023-07-10',32,14,2),
(42,'El bosque tiene un encanto especial en otoño.','2023-10-28',18,3,1),
(43,'Algunas áreas necesitan más supervisión.','2024-01-15',45,17,2),
(44,'Las flores silvestres en primavera son un espectáculo.','2023-05-20',12,9,1),
(45,'El estacionamiento es demasiado pequeño para fines de semana.','2024-03-12',34,6,2),
(46,'El aire fresco de la montaña es revitalizante.','2023-08-25',21,15,1),
(47,'Algunos carteles informativos están dañados.','2024-04-05',8,11,2),
(48,'El lago refleja el cielo de manera impresionante.','2023-11-10',27,10,1),
(49,'No hay suficiente sombra en los caminos principales.','2023-06-15',39,13,2),
(50,'El canto de los pájaros al amanecer es inolvidable.','2024-02-20',6,4,1),
(51,'Algunas zonas están demasiado concurridas.','2023-09-30',14,7,2),
(52,'Perfecto para practicar yoga al aire libre.','2024-01-05',30,2,1),
(53,'Faltan más fuentes de agua potable.','2023-12-15',17,10,2),
(54,'El sendero botánico es educativo y hermoso.','2024-05-10',25,18,1),
(55,'El camino de tierra se vuelve resbaladizo cuando llueve.','2023-07-25',19,5,2),
(56,'Las vistas panorámicas merecen el esfuerzo de la subida.','2023-10-10',13,18,1),
(57,'Algunos visitantes no respetan las normas del parque.','2024-03-15',11,16,2),
(58,'El aroma de los pinos es relajante.','2023-08-20',5,1,1),
(59,'Los horarios de apertura deberían extenderse.','2024-04-25',22,12,2),
(60,'Ideal para observar estrellas por la noche.','2023-11-30',38,8,1),
(61,'El centro de visitantes necesita renovación.','2024-02-10',10,14,2),
(62,'Las rocas forman figuras interesantes.','2023-06-25',41,3,1),
(63,'Demasiada basura en algunas áreas apartadas.','2023-09-15',16,17,2),
(64,'El sendero junto al río es mi favorito.','2024-01-20',28,6,1),
(65,'Los baños no estaban muy limpios.','2023-12-30',36,9,2),
(66,'La diversidad de árboles es impresionante.','2024-05-15',4,15,1),
(67,'Faltan más áreas de descanso con bancos.','2023-07-30',31,10,2),
(68,'El eco en el cañón es divertido de experimentar.','2023-10-20',7,11,1),
(69,'Algunos puentes necesitan reparaciones.','2024-03-01',23,13,2),
(70,'Perfecto para un picnic romántico.','2023-08-15',40,4,1),
(71,'El museo natural pequeño pero interesante.','2024-04-10',15,7,2),
(72,'El rocío matutino crea un ambiente mágico.','2023-11-05',29,2,1),
(73,'El aparcamiento debería ser gratuito.','2023-06-10',3,10,2),
(74,'Las mariposas monarca son un espectáculo.','2024-02-15',37,18,1),
(75,'El silencio aquí es oro puro, desconexión total.','2023-10-25',42,16,1);
/*!40000 ALTER TABLE `Comentario` ENABLE KEYS */;
UNLOCK TABLES;

-- ======================================================
-- Table structure for table `Likes`
-- ======================================================

DROP TABLE IF EXISTS `Likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_comentario` int DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `likes_comentario_fk` (`id_comentario`),
  KEY `likes_usuario_fk` (`id_usuario`),
  CONSTRAINT `likes_comentario_fk` FOREIGN KEY (`id_comentario`) REFERENCES `Comentario` (`ID`),
  CONSTRAINT `likes_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `Likes` WRITE;
/*!40000 ALTER TABLE `Likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `Likes` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

