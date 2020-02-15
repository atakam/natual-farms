-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 11, 2017 at 03:43 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `naturalfarms_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `maritalstatus` enum('SINGLE','MARRIED','GIVEN PARTNER') NOT NULL,
  `numdependent` tinyint(3) UNSIGNED DEFAULT NULL,
  `streetaddress1` varchar(60) NOT NULL,
  `streetaddress2` varchar(60) NOT NULL,
  `city` varchar(30) NOT NULL,
  `province` varchar(2) NOT NULL,
  `postalcode` varchar(7) NOT NULL,
  `sector` varchar(16) DEFAULT NULL,
  `owner` tinyint(1) DEFAULT NULL,
  `howlongyear` tinyint(3) UNSIGNED DEFAULT NULL,
  `phone` varchar(14) NOT NULL,
  `workphone` varchar(14) DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `lastname2` varchar(30) DEFAULT NULL,
  `firstname2` varchar(30) DEFAULT NULL,
  `phone2` varchar(14) DEFAULT NULL,
  `fax2` varchar(14) DEFAULT NULL,
  `email2` varchar(320) DEFAULT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `lastname`, `firstname`, `maritalstatus`, `numdependent`, `streetaddress1`, `streetaddress2`, `city`, `province`, `postalcode`, `sector`, `owner`, `howlongyear`, `phone`, `workphone`, `email`, `fax`, `lastname2`, `firstname2`, `phone2`, `fax2`, `email2`, `password`) VALUES
(62, 'Komgom', 'Willy', 'MARRIED', 2, '34 RUE SAINT ANTOINE', '', 'SAINTE GENEVIEVE', 'QC', 'H9H 2P5', '', 1, 0, '(123) 445-6789', '', 'konawige@hotmail.com', '', 'KAMGANG', 'Shomron', '(514) 651-5902', '', 'sks.phenix@hotmail.com', '707d746d1f8003786e07060aa280486b'),
(66, 'Takamassss', 'Austin', '', 0, '5 Vauquelin', '', 'Saint-Hubert (Longueuil)', 'QC', 'J4L 0A4', '', 0, 0, '(514) 651-5902', '', 'austintakam@gmail.com', '', '', '', '', '', '', ''),
(67, 'sdfsdf', 'dsfsdafd', '', 0, 'sdfsdfsdf', '', 'sfsdfsdaf', 'NB', 's3f 4f4', '', 0, 2, '(123) 232-4354', '', 'fsadf@dsfdsf.com', '', 'Komgom', 'Willy', '', '', 'konawige@hotmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `form_completion`
--

CREATE TABLE `form_completion` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `total_points` int(10) UNSIGNED NOT NULL,
  `price` decimal(18,2) UNSIGNED NOT NULL,
  `rebate` decimal(18,2) NOT NULL,
  `subtotal` decimal(18,2) NOT NULL,
  `deposit` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `notice` text NOT NULL,
  `cc_flag` tinyint(1) NOT NULL,
  `cc_notes` text NOT NULL,
  `cc_number` varchar(16) NOT NULL,
  `cc_month` enum('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEPT','OCT','NOV','DEC') NOT NULL,
  `cc_year` varchar(4) NOT NULL,
  `cc_ccv` varchar(3) NOT NULL,
  `cc_name` varchar(100) NOT NULL,
  `preauthorized_flag` tinyint(1) NOT NULL,
  `preauthorized_notes` text NOT NULL,
  `cash_flag` tinyint(1) NOT NULL,
  `cash_notes` text NOT NULL,
  `conditions_nummonths` tinyint(3) UNSIGNED NOT NULL,
  `conditions_startcontractdate` date NOT NULL,
  `conditions_firstdeliverydate` date NOT NULL,
  `conditions_numwithdrawals` tinyint(3) UNSIGNED NOT NULL,
  `conditions_withdrawalamount` decimal(10,2) NOT NULL,
  `conditions_firstwithdrawaldate` date NOT NULL,
  `signature_date` date NOT NULL,
  `signature_address` varchar(255) NOT NULL,
  `signature_merchant_name` varchar(100) NOT NULL,
  `signature_merchant_url` varchar(255) NOT NULL,
  `signature_consumer_name` varchar(100) NOT NULL,
  `signature_consumer_url` varchar(255) NOT NULL,
  `signature_consumer2_name` varchar(100) NOT NULL,
  `signature_consumer2_url` varchar(255) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '0',
  `formId` varchar(30) NOT NULL,
  `edited_points` int(10) NOT NULL DEFAULT '0',
  `representative_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `form_completion`
--

INSERT INTO `form_completion` (`id`, `customer_id`, `total_points`, `price`, `rebate`, `subtotal`, `deposit`, `total`, `notice`, `cc_flag`, `cc_notes`, `cc_number`, `cc_month`, `cc_year`, `cc_ccv`, `cc_name`, `preauthorized_flag`, `preauthorized_notes`, `cash_flag`, `cash_notes`, `conditions_nummonths`, `conditions_startcontractdate`, `conditions_firstdeliverydate`, `conditions_numwithdrawals`, `conditions_withdrawalamount`, `conditions_firstwithdrawaldate`, `signature_date`, `signature_address`, `signature_merchant_name`, `signature_merchant_url`, `signature_consumer_name`, `signature_consumer_url`, `signature_consumer2_name`, `signature_consumer2_url`, `status`, `formId`, `edited_points`, `representative_id`) VALUES
(37, 62, 2508, '1234.00', '0.00', '1234.00', '0.00', '1234.00', '', 0, '', '', '', '', '', '', 0, '', 0, '', 0, '2017-04-12', '2017-04-15', 0, '0.00', '2017-04-19', '2017-04-12', '', 'cedro', '1491158123498.png', 'Willy Komgom', '1491158123502.png', '', '', 1, '234567', 0, 2),
(39, 66, 4884, '2345.00', '0.00', '0.00', '0.00', '0.00', '', 0, '', '', '', '', '', '', 0, '', 0, '', 0, '2017-04-05', '2017-04-23', 0, '0.00', '2017-04-08', '2017-04-05', '', 'cedro', '1491159403497.png', 'Austin Takam', '1491159403500.png', '', '1491159403503.png', 1, '12342', 0, 2),
(40, 67, 306, '344.00', '0.00', '344.00', '0.00', '344.00', '', 0, '', '', '', '', '', '', 0, '', 0, '', 0, '2017-04-06', '2017-04-15', 0, '0.00', '2017-04-12', '2017-04-06', 'sfsdfsdaf, NB', 'Administrator', '1491161434901.png', 'dsfsdafd sdfsdf', '1491161434904.png', 'Willy Komgom', '1491161434909.png', 0, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `userid` mediumint(6) NOT NULL,
  `iscustomer` smallint(1) NOT NULL,
  `date` date NOT NULL,
  `message` text NOT NULL,
  `isread` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `userid`, `iscustomer`, `date`, `message`, `isread`) VALUES
(1, 1, 0, '2017-05-08', 'This is a notification message!', 1),
(2, 1, 0, '2017-05-08', 'This is a notification message!', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `form_id` int(10) UNSIGNED NOT NULL,
  `product_details_id` smallint(5) UNSIGNED NOT NULL,
  `quantity1` smallint(5) UNSIGNED NOT NULL,
  `quantity2` smallint(5) UNSIGNED NOT NULL,
  `quantity3` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`form_id`, `product_details_id`, `quantity1`, `quantity2`, `quantity3`) VALUES
(37, 28, 12, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `category_id` tinyint(4) UNSIGNED NOT NULL,
  `name_fr` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `image_name` varchar(256) NOT NULL DEFAULT 'beef.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name_fr`, `name_en`, `image_name`) VALUES
(5, 1, 'BIFTECK DE CONTRE FILET DE BOEUF C/C', 'hhjs99778', 'beef.jpg'),
(7, 1, 'BIFTECK FAUX-FILET DE BŒUF (SPENCER)', 'Try', 'beef.jpg'),
(9, 1, 'BIFTECK DE SURLONGE DE BŒUF', 'BEEF SURFACE BIFTECK', 'beef.jpg'),
(11, 1, 'BIFTECK AU POIVRE DE BŒUF', '', 'beef.jpg'),
(12, 1, 'BIFTECK DU ROI (INTÉRIEUR RONDE) BŒUF', '', 'beef.jpg'),
(13, 1, 'BIFTECK SANDWICH/ SOUS-MARIN DE BŒUF', '', 'beef.jpg'),
(14, 1, 'BIFTECK D’ALOYAU (T-BONE) BŒUF   C/C', '', 'beef.jpg'),
(15, 1, 'BIFTECK MINUTE ( STEAKS)  DE BOEUF', '', 'beef.jpg'),
(16, 1, 'BIFTECK DE, CÔTE ( RIB STEAKS) DE BŒUF', '', 'beef.jpg'),
(18, 1, 'BIFTECK DE FILET MIGNON BOEUF   C/C', '', 'beef.jpg'),
(19, 1, 'BŒUF HACHÉ EXTRA MAIGRE À 90%', '', 'beef.jpg'),
(21, 1, 'CUBE À BROCHETTE', '', 'beef.jpg'),
(22, 1, 'CUBES BOURGUIGNON DE BŒUF', '', 'beef.jpg'),
(23, 1, 'CUBES À RAGOÛT (À MIJOTER) BŒUF', '', 'beef.jpg'),
(24, 1, 'FOIE DE BŒUF', '', 'beef.jpg'),
(25, 1, 'LANIÈRE DE BŒUF', '', 'beef.jpg'),
(26, 1, 'PATTY\'S BERGER 100% BŒUF', '', 'beef.jpg'),
(27, 1, 'RÔTI SURLONGE DÉSOSSÉ BŒUF', '', 'beef.jpg'),
(31, 1, 'RÔTI DE PALETTE DÉSOSSÉ BŒUF', '', 'beef.jpg'),
(34, 1, 'RÔTI DE PALETTE AVEC OS', '', 'beef.jpg'),
(35, 1, 'RÔTI DU ROI (INTÉRIEUR DE RONDE) BŒUF', '', 'beef.jpg'),
(38, 1, 'TOURNEDOS DE BŒUF INTÉRIEUR DE RONDE', '', 'beef.jpg'),
(39, 2, 'DINDE ENTIERE GRADE A', '', 'beef.jpg'),
(40, 2, 'DINDE HACHÉE', '', 'beef.jpg'),
(41, 2, 'POITRINE DE DINDE', '', 'beef.jpg'),
(42, 6, 'FONDUE CHINOISE DE BŒUF', '', 'beef.jpg'),
(43, 6, 'FONDUE CHINOISE DE PORC', '', 'beef.jpg'),
(44, 6, 'FONDUE CHINOISE DE POULET GRAIN', '', 'beef.jpg'),
(45, 5, 'SAUCISSES FINES HERBES & AIL', '', 'beef.jpg'),
(46, 5, 'SAUCISSES FROMAGE BACON', '', 'beef.jpg'),
(47, 5, 'SAUCISSES ITALIENNE DOUCE', '', 'beef.jpg'),
(48, 5, 'SAUCISSES ITALIENNE MI-FORTE', '', 'beef.jpg'),
(49, 5, 'SAUCISSES ITALIENNE FORTE', '', 'beef.jpg'),
(50, 5, 'SAUCISSES MIEL & AIL', '', 'beef.jpg'),
(51, 5, 'SAUSSICE CIBOULETTE', '', 'beef.jpg'),
(52, 5, 'SAUCISSES POLONAISE', '', 'beef.jpg'),
(53, 5, 'SAUCISSES TOMATE BASILIC', '', 'beef.jpg'),
(54, 5, 'SAUCISSES TOULOUSE', '', 'beef.jpg'),
(55, 5, 'SAUCISSES OCTOBERFEST', '', 'beef.jpg'),
(56, 5, 'SAUCISSE BISON CIBOULETTE', '', 'beef.jpg'),
(57, 4, 'COTELETTES DE VEAU (RIBS STEAKS)', '', 'beef.jpg'),
(58, 4, 'CUBES DE VEAU (RAGOÛT)', '', 'beef.jpg'),
(59, 4, 'ESCALOPPES DE VEAU', '', 'beef.jpg'),
(60, 4, 'FOIE DE VEAU', '', 'beef.jpg'),
(61, 4, 'VEAU HACHÉ MAIGRE', '', 'beef.jpg'),
(62, 4, 'RÔTI DE VEAU', '', 'beef.jpg'),
(65, 4, 'OSSO BUCO DE VEAU', '', 'beef.jpg'),
(66, 4, 'MINUTES STEAK DE VEAU', '', 'beef.jpg'),
(67, 3, 'BACON (SUPÉRIEUR) DE PORC ', '', 'beef.jpg'),
(68, 3, 'CÔTELETTE DE PORC AVEC OS C/C', '', 'beef.jpg'),
(69, 3, 'CÔTELETTE PORC PAPILLON C/C', '', 'beef.jpg'),
(70, 3, 'CÔTELETTE PORC DÉSOSSÉE TRANCHE SIMPLE', '', 'beef.jpg'),
(71, 3, 'COTELETTES LEVÉES CHINOISE 2,5\'\' (COURTE)', '', 'beef.jpg'),
(72, 3, 'COTELETTE DOS (BABY BACK) - 4 POUCES', '', 'beef.jpg'),
(73, 3, 'CUBES DE PORC NATUREL (CUBE 1 POUCE)', '', 'beef.jpg'),
(74, 3, 'CUBES À BROCHETTE DE PORC', '', 'beef.jpg'),
(75, 3, 'FILET DE PORC', '', 'beef.jpg'),
(76, 3, 'JAMBON DÉSOSSÉ TOUPIE - 2.7 LBS', '', 'beef.jpg'),
(77, 3, 'JAMBON FESSE AVEC OS 8 LBS', '', 'beef.jpg'),
(78, 3, 'JARRETS PORC (PATTE DE COCHON)', '', 'beef.jpg'),
(79, 3, 'PORC HACHÉ  EXTRA MAIGRE', '', 'beef.jpg'),
(80, 3, 'PORC HACHÉ TRIO (BOEUF-PORC-VEAU) TOURTIÈRE', '', 'beef.jpg'),
(81, 3, 'RÔTI DE LONGE PORC DÉSOSSÉ C/C', '', 'beef.jpg'),
(84, 3, 'SAUCISSE À DÉJEUNER', '', 'beef.jpg'),
(85, 3, 'SAUCISSE HOT DOG TOUTE BŒUF', '', 'beef.jpg'),
(86, 3, 'RÔTI PORC D\'ÉPAULE AVEC OS (EFFILOCHÉ)', '', 'beef.jpg'),
(87, 7, 'AILES DE POULET DE GRAIN COUPE BUFFALO', '', 'beef.jpg'),
(88, 7, 'CUBES DE POULET DE GRAIN', '', 'beef.jpg'),
(89, 7, 'CUISSES DE POULET DE GRAIN', '', 'beef.jpg'),
(90, 7, 'HAUT DE CUISSE AVEC OS', '', 'beef.jpg'),
(91, 7, 'HAUT DE CUISSE DÉSOSSÉE', '', 'beef.jpg'),
(92, 7, 'LANIÈRE DE POITRINE DE POULET DE GRAIN', '', 'beef.jpg'),
(93, 7, 'PILON DE POULET DE GRAIN', '', 'beef.jpg'),
(94, 7, 'POITRINE DE POULET DÉSOSSÉ DE GRAIN', '', 'beef.jpg'),
(95, 7, 'POITRINE DE POULET AVEC OS', '', 'beef.jpg'),
(96, 7, 'POULET DE GRAIN HACHÉ', '', 'beef.jpg'),
(97, 7, 'TOURNEDOS POULET DE GRAIN POITRINE BACON', '', 'beef.jpg'),
(98, 7, 'POULET ENTIER DE GRAIN', '', 'beef.jpg'),
(99, 7, 'CHAPON ENTIER DE GRAIN', '', 'beef.jpg'),
(100, 4, 'B', 'A', 'beef.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products_category`
--

CREATE TABLE `products_category` (
  `id` tinyint(10) UNSIGNED NOT NULL,
  `name_en` varchar(30) NOT NULL,
  `name_fr` varchar(30) NOT NULL,
  `slug` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_category`
--

INSERT INTO `products_category` (`id`, `name_en`, `name_fr`, `slug`) VALUES
(1, 'Beef', 'Boeuf', 'beef'),
(2, 'Turkey', 'Dinde', 'turkey'),
(3, 'Pork', 'Porc', 'porc'),
(4, ' Veal', 'Veau', 'veal'),
(5, 'Homemade Sausage', 'Saucisse maison', 'homemadeSausage'),
(6, 'Chinese Fondue', 'Fondue chinoise', 'chineseFondue'),
(7, 'Chicken', 'Poulet', 'chicken');

-- --------------------------------------------------------

--
-- Table structure for table `products_details`
--

CREATE TABLE `products_details` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `product_id` smallint(5) UNSIGNED NOT NULL,
  `packaging_id` smallint(5) UNSIGNED NOT NULL,
  `code` smallint(5) UNSIGNED NOT NULL,
  `point` smallint(5) UNSIGNED NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_details`
--

INSERT INTO `products_details` (`id`, `product_id`, `packaging_id`, `code`, `point`, `purchase_price`) VALUES
(26, 5, 2, 233, 129, '0.00'),
(27, 5, 1, 200, 108, '0.00'),
(28, 7, 2, 234, 132, '0.00'),
(29, 7, 1, 201, 108, '0.00'),
(30, 9, 2, 236, 80, '150.00'),
(31, 9, 1, 202, 59, '500.00'),
(32, 16, 2, 232, 119, '0.00'),
(33, 16, 1, 208, 89, '0.00'),
(34, 19, 7, 212, 230, '0.00'),
(35, 19, 4, 210, 47, '0.00'),
(36, 27, 9, 222, 217, '0.00'),
(38, 27, 8, 221, 156, '0.00'),
(39, 27, 10, 223, 312, '0.00'),
(42, 31, 9, 225, 173, '0.00'),
(43, 31, 10, 226, 231, '0.00'),
(46, 31, 8, 224, 129, '0.00'),
(51, 35, 10, 229, 257, '0.00'),
(52, 35, 8, 227, 138, '0.00'),
(53, 35, 9, 228, 197, '0.00'),
(54, 62, 9, 706, 230, '0.00'),
(55, 62, 10, 707, 297, '0.00'),
(58, 62, 8, 705, 153, '0.00'),
(63, 81, 10, 520, 118, '0.00'),
(64, 81, 8, 518, 61, '0.00'),
(65, 81, 9, 519, 88, '0.00'),
(92, 11, 3, 203, 27, '0.00'),
(93, 12, 3, 204, 34, '0.00'),
(94, 13, 4, 205, 73, '0.00'),
(95, 14, 2, 231, 119, '0.00'),
(96, 15, 4, 207, 69, '0.00'),
(98, 18, 5, 209, 225, '0.00'),
(100, 21, 4, 214, 87, '0.00'),
(101, 22, 4, 215, 69, '0.00'),
(102, 23, 4, 216, 60, '0.00'),
(103, 24, 4, 217, 44, '0.00'),
(104, 25, 4, 218, 69, '0.00'),
(105, 26, 4, 219, 51, '0.00'),
(108, 34, 10, 238, 257, '0.00'),
(110, 38, 4, 230, 73, '0.00'),
(111, 39, 11, 300, 441, '0.00'),
(112, 40, 4, 301, 51, '0.00'),
(113, 41, 8, 302, 149, '0.00'),
(114, 42, 26, 867, 46, '0.00'),
(115, 43, 26, 868, 40, '0.00'),
(116, 44, 26, 869, 46, '0.00'),
(117, 45, 25, 852, 41, '0.00'),
(118, 46, 25, 853, 41, '0.00'),
(119, 47, 25, 854, 41, '0.00'),
(120, 48, 4, 855, 855, '855.00'),
(121, 49, 25, 856, 41, '0.00'),
(122, 50, 25, 857, 41, '0.00'),
(123, 51, 25, 858, 41, '0.00'),
(124, 52, 25, 859, 41, '0.00'),
(125, 53, 25, 860, 41, '0.00'),
(126, 54, 25, 861, 41, '0.00'),
(127, 55, 25, 862, 41, '0.00'),
(128, 56, 25, 865, 87, '0.00'),
(129, 57, 27, 700, 156, '0.00'),
(130, 58, 4, 701, 115, '0.00'),
(131, 59, 4, 702, 115, '0.00'),
(132, 60, 4, 703, 46, '0.00'),
(133, 61, 4, 704, 60, '0.00'),
(135, 65, 8, 708, 153, '0.00'),
(136, 66, 4, 709, 115, '0.00'),
(137, 67, 4, 500, 58, '0.00'),
(138, 68, 4, 501, 28, '0.00'),
(139, 69, 4, 503, 32, '0.00'),
(140, 70, 4, 505, 32, '0.00'),
(141, 71, 12, 507, 56, '0.00'),
(142, 72, 13, 509, 101, '0.00'),
(143, 73, 4, 510, 32, '0.00'),
(144, 74, 4, 511, 32, '0.00'),
(145, 75, 14, 512, 51, '0.00'),
(146, 76, 15, 513, 80, '0.00'),
(147, 77, 16, 514, 321, '0.00'),
(148, 78, 17, 515, 69, '0.00'),
(149, 79, 4, 516, 26, '0.00'),
(150, 80, 7, 517, 243, '0.00'),
(152, 84, 4, 521, 44, '0.00'),
(153, 85, 4, 522, 37, '0.00'),
(154, 86, 16, 524, 220, '0.00'),
(155, 87, 18, 600, 165, '0.00'),
(156, 88, 4, 601, 64, '0.00'),
(157, 89, 19, 602, 44, '0.00'),
(158, 90, 27, 604, 37, '0.00'),
(159, 91, 4, 616, 38, '0.00'),
(160, 92, 4, 606, 61, '0.00'),
(161, 93, 4, 607, 29, '0.00'),
(162, 94, 4, 609, 58, '0.00'),
(163, 95, 20, 611, 53, '0.00'),
(164, 96, 4, 612, 61, '0.00'),
(165, 97, 22, 613, 72, '0.00'),
(166, 98, 23, 614, 107, '0.00'),
(167, 99, 24, 615, 160, '0.00'),
(184, 100, 26, 5, 5, '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `product_packaging`
--

CREATE TABLE `product_packaging` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `type` enum('NONE','BIFTECK','SOUS-VIDE','ENTIER','SAC','PAQUET') NOT NULL,
  `quantity` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='How a product is packaged (name, weight, size...)' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `product_packaging`
--

INSERT INTO `product_packaging` (`id`, `type`, `quantity`) VALUES
(28, 'NONE', '-'),
(6, 'BIFTECK', '1 LBS - 454 GR'),
(4, 'SOUS-VIDE', '1 LBS - 454 GR'),
(20, 'SOUS-VIDE', '1 x 1¼ LBS - 567 GR'),
(26, 'PAQUET', '10 OZ - 300 GR'),
(11, 'ENTIER', '12 A 15 LBS'),
(1, 'BIFTECK', '12 OZ - 340 GR'),
(27, 'SOUS-VIDE', '12 OZ - 340 GR'),
(14, 'SOUS-VIDE', '14 OZ - 400 GR'),
(2, 'BIFTECK', '16 OZ - 454 GR'),
(8, 'SOUS-VIDE', '2 LBS - 906 GR'),
(13, 'SOUS-VIDE', '2 x 1 LBS - 454GR'),
(19, 'SOUS-VIDE', '2 x 12 OZ - 340 GR '),
(5, 'BIFTECK', '2 x 8 OZ - 227 GR'),
(22, 'SOUS-VIDE', '2 x 8 OZ - 227 GR'),
(12, 'SOUS-VIDE', '2,2 LBS - 1 KG'),
(18, 'SAC', '2.2 LBS - 1 KG'),
(17, 'SOUS-VIDE', '2.5 LBS - 1.13 KG'),
(15, 'SOUS-VIDE', '2.7 LBS - 1.22 KG'),
(25, 'SOUS-VIDE', '3 - 4 SAUCISSES'),
(9, 'SOUS-VIDE', '3 LBS - 1,36 KG'),
(10, 'SOUS-VIDE', '4 LBS - 1,81  KG'),
(23, 'ENTIER', '4 LBS - 2 KG'),
(7, 'SOUS-VIDE', '5 LBS - 2,27 KG'),
(24, 'ENTIER', '6 LBS - 2.72 KG'),
(16, 'SOUS-VIDE', '8 LBS - 3,63 KG'),
(3, 'BIFTECK', '8 OZ - 227 GR');

-- --------------------------------------------------------

--
-- Table structure for table `representative`
--

CREATE TABLE `representative` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adminflag` tinyint(1) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `representative`
--

INSERT INTO `representative` (`id`, `username`, `password`, `name`, `email`, `adminflag`) VALUES
(1, 'admin', 'cbb58ff7f146eddbb11c37236fa27ac8', 'Administrator Admin', 'cedrick.fonkwa@soonatech.com', 1),
(2, 'cedro', '5e0be2f030b3fda297d25fd0d8ccb5c6', 'cedro', 'austintakam@gmail.com', 0),
(4, 'bordel', '81dc9bdb52d04dc20036dbd8313ed055', 'patate', 'patate@hotmail.com', 0),
(17, 'atakam', 'd41d8cd98f00b204e9800998ecf8427e', 'Austin', 'austintakam@gmail.com', 0),
(25, 'austin', '229979fce5174c17d4645bf8752dae1e', 'Austin', 'austin.takam@soonatech.com', 0),
(26, 'admin2', 'cbb58ff7f146eddbb11c37236fa27ac8', 'SSsss', 'ssss', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `admin_email` varchar(60) NOT NULL,
  `admin_email2` varchar(60) NOT NULL,
  `provider_email` varchar(60) NOT NULL,
  `provider_email2` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`admin_email`, `admin_email2`, `provider_email`, `provider_email2`, `password`) VALUES
('austintakam@gmail.com', 'austintakam@gmail.com', 'austintakam@gmail.com', 'austintakam@gmail.com', 'naturalfarms');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `form_completion`
--
ALTER TABLE `form_completion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id_2` (`customer_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `representative_id` (`representative_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD UNIQUE KEY `my_unique_key` (`form_id`,`product_details_id`),
  ADD KEY `product_id` (`product_details_id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category_id` (`category_id`);

--
-- Indexes for table `products_category`
--
ALTER TABLE `products_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_details`
--
ALTER TABLE `products_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_packaging`
--
ALTER TABLE `product_packaging`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emballage_id` (`quantity`,`type`);

--
-- Indexes for table `representative`
--
ALTER TABLE `representative`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `form_completion`
--
ALTER TABLE `form_completion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `products_category`
--
ALTER TABLE `products_category`
  MODIFY `id` tinyint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `products_details`
--
ALTER TABLE `products_details`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;
--
-- AUTO_INCREMENT for table `product_packaging`
--
ALTER TABLE `product_packaging`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `representative`
--
ALTER TABLE `representative`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `form_completion`
--
ALTER TABLE `form_completion`
  ADD CONSTRAINT `form_completion_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `form_completion_ibfk_2` FOREIGN KEY (`representative_id`) REFERENCES `representative` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `form_completion` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`product_details_id`) REFERENCES `products_details` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `products_category` (`id`);

--
-- Constraints for table `products_details`
--
ALTER TABLE `products_details`
  ADD CONSTRAINT `products_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
