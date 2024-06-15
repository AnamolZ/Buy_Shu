CREATE DATABASE  IF NOT EXISTS `buy_shu` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `buy_shu`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: buy_shu
-- ------------------------------------------------------
-- Server version	8.0.37

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
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `CART_ID` int NOT NULL AUTO_INCREMENT,
  `CUSTOMER_ID` int DEFAULT NULL,
  `PRODUCT_ID` int DEFAULT NULL,
  `PRODUCT_QUANTITY` int DEFAULT NULL,
  PRIMARY KEY (`CART_ID`),
  KEY `CUSTOMER_ID` (`CUSTOMER_ID`),
  KEY `PRODUCT_ID` (`PRODUCT_ID`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customer` (`CUSTOMER_ID`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`PRODUCT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `CATEGORY_ID` int NOT NULL AUTO_INCREMENT,
  `TRADER_ID` int DEFAULT NULL,
  `CATEGORY_TYPE` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`CATEGORY_ID`),
  KEY `TRADER_ID` (`TRADER_ID`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`TRADER_ID`) REFERENCES `trader` (`TRADER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,1,'Meat'),(2,2,'Vegetables'),(3,3,'Seafood'),(4,4,'Baked Goods');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `CUSTOMER_ID` int NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` varchar(255) DEFAULT NULL,
  `LAST_NAME` varchar(255) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CUSTOMER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'Anamol','Dhakal','KTM','anmol1379','anmol@example.com');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_detail` (
  `ORDER_DETAIL_ID` int NOT NULL AUTO_INCREMENT,
  `SHIPPING_ADDRESS` varchar(255) DEFAULT NULL,
  `ORDER_AMOUNT` int DEFAULT NULL,
  `PAYMENT_ID` int DEFAULT NULL,
  `ORDER_STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ORDER_DETAIL_ID`),
  KEY `PAYMENT_ID` (`PAYMENT_ID`),
  CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`PAYMENT_ID`) REFERENCES `payment` (`PAYMENT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_detail`
--

LOCK TABLES `order_detail` WRITE;
/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `ORDER_ID` int NOT NULL AUTO_INCREMENT,
  `PRODUCT_ID` int DEFAULT NULL,
  `CUSTOMER_ID` int DEFAULT NULL,
  `PAYMENT_ID` int DEFAULT NULL,
  `PRODUCT_QUANTITY` int DEFAULT NULL,
  PRIMARY KEY (`ORDER_ID`),
  KEY `PRODUCT_ID` (`PRODUCT_ID`),
  KEY `CUSTOMER_ID` (`CUSTOMER_ID`),
  KEY `PAYMENT_ID` (`PAYMENT_ID`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`PRODUCT_ID`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customer` (`CUSTOMER_ID`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`PAYMENT_ID`) REFERENCES `payment` (`PAYMENT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `PAYMENT_ID` int NOT NULL AUTO_INCREMENT,
  `PAYMENT_AMOUNT` int DEFAULT NULL,
  PRIMARY KEY (`PAYMENT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4754 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1258,NULL),(4726,NULL),(4727,101),(4728,101),(4729,101),(4730,14),(4731,14),(4732,14),(4733,14),(4734,14),(4735,14),(4736,14),(4737,14),(4738,14),(4739,14),(4740,14),(4741,14),(4742,20),(4743,20),(4744,13),(4745,13),(4746,13),(4747,13),(4748,10),(4749,10),(4750,10),(4751,10),(4752,10),(4753,14);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `PRODUCT_ID` int NOT NULL AUTO_INCREMENT,
  `PRODUCT_NAME` varchar(255) DEFAULT NULL,
  `PRODUCT_PRICE` int DEFAULT NULL,
  `PRODUCT_STOCK` int DEFAULT NULL,
  `PRODUCT_DETAIL` varchar(1000) DEFAULT NULL,
  `ALLERGY_INFORMATION` varchar(500) DEFAULT NULL,
  `UPLOAD` varchar(255) DEFAULT NULL,
  `CATEGORY_ID` int DEFAULT NULL,
  PRIMARY KEY (`PRODUCT_ID`),
  KEY `CATEGORY_ID` (`CATEGORY_ID`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CATEGORY_ID`) REFERENCES `category` (`CATEGORY_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (14,'Pork Chops',10,0,'Fresh pork chops, pink with a layer of fat and a bone in each chop. Perfect for grilling, baking, or pan-frying.','Contains pork.','../uploads/Pork Chops.png',1),(15,'Sausages',7,23,'Fresh sausages, pinkish-brown with a smooth, plump texture, and linked together. Perfect for grilling, frying, or adding to stews.','Contains pork, spices.','../uploads/Sausages.png',1),(16,'Chicken Drumsticks',4,29,'Fresh chicken drumsticks, pale pink with skin on and a smooth texture. Perfect for grilling, baking, or frying.','Contains poultry.','../uploads/Chicken Drumsticks.png',1),(17,'Duck Breasts',15,30,'Fresh duck breasts, dark pink with a layer of fat and a smooth texture. Perfect for roasting, grilling, or pan-searing.','Contains poultry.','../uploads/Duck Breasts.png',1),(18,'Turkey Breasts',9,30,'Fresh turkey breasts, pale pink, boneless, and skinless with a smooth texture. Perfect for roasting, grilling, or baking.','Contains poultry.','../uploads/Turkey Breasts.png',1),(19,'Turkey Drumsticks',5,30,'Fresh turkey drumsticks, pale pink with skin on and a smooth texture. Perfect for roasting, grilling, or baking.','Contains poultry.','../uploads/Turkey Drumsticks.png',1),(20,'Chicken Wings',5,30,'Fresh chicken wings, pale pink with skin on and a smooth texture. Perfect for grilling, baking, or frying.','Contains poultry.','../uploads/Chicken Wings.png',1),(21,'Chicken Breasts',8,30,'Fresh chicken breasts, pale pink, boneless, and skinless with a smooth texture. Perfect for grilling, baking, or sautéing.','Contains poultry.','../uploads/Chicken Breasts.png',1),(22,'Lamp Chops',22,30,'Fresh lamb chops, pinkish-red with a layer of fat along the edge and a bone in each chop. Perfect for grilling, roasting, or pan-searing.	','Contains lamb.','../uploads/Lamp Chops.png',1),(23,'Pork Ribs',12,30,'Fresh pork ribs, pink with a layer of fat and bone sections. Perfect for grilling, smoking, or roasting.	','Contains pork.','../uploads/Pork Ribs.png',1),(24,'Strawberries',4,30,'Fresh strawberries, bright red with green leafy tops and a juicy texture. Perfect for snacking, baking, or adding to desserts.	','None','../uploads/Strawberries.png',2),(25,'Pineapple',3,30,'Fresh pineapple, golden yellow with a rough, textured skin and a crown of green leaves. Perfect for snacking, adding to fruit salads, or making tropical dishes.	','None','../uploads/Pineapple.png',2),(26,'Oranges',1,30,'Fresh oranges, bright orange, round, and smooth with a slightly shiny texture. Perfect for juicing, snacking, or adding to salads.	','None','../uploads/Oranges.png',2),(27,'Cucumbers',1,30,'Fresh cucumbers, dark green with a smooth, firm texture. Perfect for salads, pickling, or snacking.	','None','../uploads/Cucumbers.png',2),(28,'Lettuce',2,30,'Fresh lettuce, bright green with crisp, leafy layers. Perfect for salads, sandwiches, and wraps.	','None','../uploads/Lettuce.png',2),(29,'Bananas',2,30,'Fresh bananas, bright yellow with a few green tips and smooth skin. Perfect for snacking, baking, or adding to smoothies.	','None','../uploads/Bananas.png',2),(30,'Broccoli',2,30,'Fresh broccoli, vibrant green with tightly packed florets and a sturdy stalk. Perfect for steaming, roasting, or adding to stir-fries.	','None','../uploads/Broccoli.png',2),(31,'Tomatoes',3,30,'Fresh tomatoes, bright red, round, and firm with green stems. Perfect for salads, sauces, and sandwiches.	','None','../uploads/Tomatoes.png',2),(32,'Red Bell Peppers',3,30,'Fresh red bell peppers, vibrant red with smooth, shiny skin and green stems. Perfect for salads, grilling, or adding to stir-fries.','None','../uploads/Red Bell Peppers.png',2),(33,'Carrots',2,30,'Fresh bunch of carrots, bright orange with green leafy tops. Ideal for snacking, cooking, or adding to salads.	','None','../uploads/Carrots.png',2),(34,'Cabbage',3,30,'Our fresh green cabbage is a versatile and nutritious vegetable, perfect for a variety of culinary uses.	','Digestive Sensitivity.','../uploads/Cabbage.png',2),(35,'Fresh Calamari',14,30,'Fresh calamari rings, clean and white with a slightly glossy texture. Perfect for frying, grilling, or adding to pasta dishes.	','Contains shellfish.','../uploads/Fresh Calamari.png',3),(36,'Salmon Fillet',12,30,'A fresh salmon fillet, bright pink with a smooth, firm texture and a hint of marbling. Perfect for grilling, baking, or pan-searing.	','Contains fish.','../uploads/Salmon Fillet.png',3),(37,'Whole Sea Bass',10,30,'A whole fresh sea bass with shiny, silver skin and clear, bright eyes. Perfect for baking, grilling, or steaming.','Contains fish.','../uploads/Whole Sea Bass.png',3),(38,'Fresh Scallops',25,30,'Fresh scallops, plump and creamy white with a smooth texture. Perfect for searing, grilling, or adding to pasta dishes.	','Contains shellfish.','../uploads/Fresh Scallops.png',3),(39,'Fresh Mussels	',12,30,'Fresh mussels with dark, glossy shells, slightly open to reveal their orange, juicy meat inside. Perfect for steaming, boiling, or adding to seafood dishes.','Contains shellfish.','../uploads/Fresh Mussels.png',3),(40,'Whole Lobster',25,30,'A whole, fresh lobster with a vibrant red, glossy shell and intact claws and antennae. Perfect for boiling or steaming.','Contains shellfish.','../uploads/Whole Lobster.png',3),(41,'Tuna Steak',18,30,'A fresh tuna steak, deep red with a firm texture and marbling. Ideal for grilling, searing, or sushi.','Contains fish.','../uploads/Tuna Steak.png',3),(42,'Fresh Crab',20,30,'A fresh crab with a vibrant red, glossy shell and intact claws and legs. Perfect for boiling, steaming, or making crab cakes.','Contains shellfish.','../uploads/Fresh Crab.png',3),(43,'Fresh Oysters',20,30,'Fresh oysters, open to reveal their plump, juicy meat inside rough, textured shells. Ideal for serving raw on the half shell or for cooking.','Contains shellfish.','../uploads/Fresh Oysters.png',3),(44,'Fresh Shrimp',15,30,'Fresh, pink shrimp with a slightly translucent texture and their tails on. Ideal for grilling, sautéing, or adding to pasta dishes.	','Contains shellfish.','../uploads/Fresh Shrimp.png',3),(45,'Blueberry Muffin',3,30,'A delicious muffin packed with fresh blueberries and a hint of vanilla, topped with a sprinkle of sugar for added sweetness. Perfect for breakfast or a snack.','Contains wheat, dairy, eggs.','../uploads/Blueberry Muffin.png',4),(46,'Chocolate Chip Cookie',2,30,'A classic chocolate chip cookie with a golden brown exterior and soft, chewy center. Packed with rich chocolate chips for a delightful treat.','Contains wheat, dairy, eggs, soy.','../uploads/Chocolate Chip Cookie.png',4),(47,'Baguette',2,30,'A traditional French baguette with a crispy, golden brown crust and a soft, airy interior. Perfect for sandwiches or as a side to any meal.	','Contains wheat.','../uploads/Baguette.png',4),(48,'Cinnamon Roll',3,30,'A soft and fluffy cinnamon roll, golden brown with a rich swirl of cinnamon, topped with a glossy icing for a sweet finish. Perfect for breakfast or dessert.	','Contains wheat, dairy, eggs.','../uploads/Cinnamon Roll.png',4),(49,'Sourdough Bread',4,30,'A loaf of sourdough bread with a golden brown, crispy crust and a soft, airy interior. Made with a natural sourdough starter for a tangy flavor.	','Contains wheat.	','../uploads/Sourdough Bread.png',4),(50,'Apple Pie	',6,30,'A classic apple pie with a golden brown lattice crust and a sweet, juicy apple filling. Perfectly spiced and baked to perfection.	','Contains wheat, dairy.	','../uploads/Apple Pie.png',4),(51,'Pretzel',2,30,'A golden brown pretzel twisted into its iconic shape, with a crispy exterior and soft interior, sprinkled with coarse salt. Perfect as a snack or with mustard.	','Contains wheat	','../uploads/Pretzel.png',4),(52,'Chocolate Cake Slice',4,30,'A rich and moist slice of chocolate cake with layers of creamy chocolate frosting and topped with a smooth chocolate glaze. Perfect for dessert or a special treat.','Contains wheat, dairy, eggs, soy.	','../uploads/Chocolate Cake Slice.png',4),(53,'Danish Pastry	',3,30,'A flaky and golden brown Danish pastry topped with a swirl of raspberry jam and a drizzle of icing. Perfect for breakfast or a sweet snack.	','Contains wheat, dairy, eggs.	','../uploads/Danish Pastry.png',4),(54,'Lemon Tart	',3,30,'A delicious lemon tart with a golden brown crust and a smooth, glossy lemon filling, topped with a light dusting of powdered sugar. Perfect for a refreshing dessert.	','Contains wheat, dairy, eggs.	','../uploads/Lemon Tart.png',4);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trader`
--

DROP TABLE IF EXISTS `trader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trader` (
  `TRADER_ID` int NOT NULL AUTO_INCREMENT,
  `TRADER_NAME` varchar(200) DEFAULT NULL,
  `TRADER_PASSWORD` varchar(200) DEFAULT NULL,
  `TRADER_EMAIL` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`TRADER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trader`
--

LOCK TABLES `trader` WRITE;
/*!40000 ALTER TABLE `trader` DISABLE KEYS */;
INSERT INTO `trader` VALUES (1,'Antony Das','password123','antonydas@example.com'),(2,'Jems Nicklin','password123','jemsnicklin@example.com'),(3,'Ayushma Dhakal','password123','ayushmadhakal@example.com'),(4,'Kali Nakkali','password123','kalinakkali@example.com');
/*!40000 ALTER TABLE `trader` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-15 15:03:01
