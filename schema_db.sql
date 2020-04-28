-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: test02_my
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

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
-- Table structure for table `courses_achats`
--

DROP TABLE IF EXISTS `courses_achats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses_achats` (
  `liste_id` mediumint(9) NOT NULL,
  `produit_id` mediumint(9) NOT NULL,
  `unite_id` tinyint(4) DEFAULT NULL,
  `achat_quantite` decimal(10,3) NOT NULL,
  `achat_date_creation` datetime NOT NULL,
  `achat_date_suppression` datetime DEFAULT NULL,
  KEY `liste_id` (`liste_id`),
  KEY `produit_id` (`produit_id`),
  KEY `unite_id` (`unite_id`),
  CONSTRAINT `courses_achats_ibfk_1` FOREIGN KEY (`liste_id`) REFERENCES `courses_listes` (`liste_id`),
  CONSTRAINT `courses_achats_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits_produit` (`produit_id`),
  CONSTRAINT `courses_achats_ibfk_3` FOREIGN KEY (`unite_id`) REFERENCES `referentiel_unites` (`unite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `courses_listes`
--

DROP TABLE IF EXISTS `courses_listes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses_listes` (
  `liste_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `liste_nom` char(55) COLLATE utf8_unicode_ci NOT NULL,
  `liste_date_creation` datetime NOT NULL,
  `liste_date_suppression` datetime DEFAULT NULL,
  PRIMARY KEY (`liste_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `courses_recettes`
--

DROP TABLE IF EXISTS `courses_recettes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses_recettes` (
  `liste_id` mediumint(9) NOT NULL,
  `recette_id` mediumint(9) NOT NULL,
  `courses_recette_nombre_personnes` tinyint(4) DEFAULT NULL,
  `recette_date_creation` datetime NOT NULL,
  `recette_date_suppression` datetime DEFAULT NULL,
  KEY `liste_id` (`liste_id`),
  KEY `recette_id` (`recette_id`),
  CONSTRAINT `courses_recettes_ibfk_1` FOREIGN KEY (`liste_id`) REFERENCES `courses_listes` (`liste_id`),
  CONSTRAINT `courses_recettes_ibfk_2` FOREIGN KEY (`recette_id`) REFERENCES `recettes_recette` (`recette_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `produits_produit`
--

DROP TABLE IF EXISTS `produits_produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produits_produit` (
  `produit_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `rayon_id` mediumint(9) NOT NULL,
  `produit_nom` char(55) COLLATE utf8_unicode_ci NOT NULL,
  `produit_date_creation` datetime NOT NULL,
  `produit_date_suppression` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`produit_id`),
  KEY `rayon_id` (`rayon_id`),
  CONSTRAINT `produits_produit_ibfk_1` FOREIGN KEY (`rayon_id`) REFERENCES `rayons_rayon` (`rayon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rayons_rayon`
--

DROP TABLE IF EXISTS `rayons_rayon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rayons_rayon` (
  `rayon_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `rayon_nom` char(55) COLLATE utf8_unicode_ci NOT NULL,
  `rayon_date_creation` datetime NOT NULL,
  `rayon_date_suppression` datetime DEFAULT NULL,
  PRIMARY KEY (`rayon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recettes_ingredients`
--

DROP TABLE IF EXISTS `recettes_ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recettes_ingredients` (
  `recette_id` mediumint(9) NOT NULL,
  `produit_id` mediumint(9) NOT NULL,
  `unite_id` tinyint(4) DEFAULT NULL,
  `ingredient_quantite` decimal(10,3) DEFAULT NULL,
  `ingredient_date_creation` datetime NOT NULL,
  `ingredient_date_suppression` datetime DEFAULT NULL,
  KEY `produit_id` (`produit_id`),
  KEY `unite_id` (`unite_id`),
  KEY `recette_id` (`recette_id`),
  CONSTRAINT `recettes_ingredients_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produits_produit` (`produit_id`),
  CONSTRAINT `recettes_ingredients_ibfk_2` FOREIGN KEY (`unite_id`) REFERENCES `referentiel_unites` (`unite_id`),
  CONSTRAINT `recettes_ingredients_ibfk_3` FOREIGN KEY (`recette_id`) REFERENCES `recettes_recette` (`recette_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recettes_recette`
--

DROP TABLE IF EXISTS `recettes_recette`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recettes_recette` (
  `recette_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `recette_nom` char(55) COLLATE utf8_unicode_ci NOT NULL,
  `recette_nombre_personnes` tinyint(4) DEFAULT NULL,
  `recette_instructions` text COLLATE utf8_unicode_ci NOT NULL,
  `recette_date_creation` datetime NOT NULL,
  `recette_date_suppression` datetime DEFAULT NULL,
  PRIMARY KEY (`recette_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `referentiel_unites`
--

DROP TABLE IF EXISTS `referentiel_unites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referentiel_unites` (
  `unite_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `unite_nom` char(55) COLLATE utf8_unicode_ci NOT NULL,
  `unite_date_creation` datetime NOT NULL,
  `unite_date_suppression` datetime DEFAULT NULL,
  PRIMARY KEY (`unite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-28 14:38:35
