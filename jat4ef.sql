-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2023 at 04:50 PM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jat4ef`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE `Account` (
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`username`, `password`) VALUES
('a', '$6$rounds=5042$64482456bcdc29.1$c185KX1wraNWehlJLuprd5m9Fp06VcN56qTxdfywNsRcgzGnTHCrbZM5BLPTEr4sU.fKectnS0SPCcKhIWvZg/'),
('aaa', '$6$rounds=5042$644bdf72655970.8$4Ce4phBqrcB.vBwTIOLbI/VhqlBTZc3IhyFUrq1XGz8a.kMTw8l6XD6KzOiApKkCk7w0Ut91KD6QTPF2jVylh/'),
('aaron_bloomfield', '2150$ucks'),
('axo_girlie', 'livelove305'),
('b', '$6$rounds=5042$644824b207d266.8$zlYXb7oR.oqzWiB.QKMHrj5LF2OQnItPu46RXU9VtFt81w3MQ9OgtSCMmhth8QrEUKeYmV26JzTZq6JW2Jr9D0'),
('bbb', '$6$rounds=5042$64497940077d35.4$4oHfbDM1zNktgpDGmEY3BxgiqGdaRmV9Bzm0Pbn1Q939wzuafEuxhc14z9emVMUPbRQWNUKijyof7oAgaC6g3/'),
('boldrockluvr10', 'mperil'),
('boylan_babe_1234', 'wah00wa'),
('c', '$6$rounds=5042$644c07d136bae8.9$Fsx3.8x29SgL47VcNRRxpXFBth5IhnPOnoxgIfJgSc1fYWZFwwTkOZiM3BxBKy2IRpvlJLwOOxMUepq6tkqEJ/'),
('commkiddo', 'deloitteHireMePls'),
('cornerjuice_luvr', 'classico4lyfe'),
('cs_babe24', 'python$elite'),
('db_queen', 'ilove$QL123'),
('dz_baddie', 'slaying150'),
('elzinga789', 'iloveecon2010'),
('fiji_groupie2002', 'liveloveclub128'),
('foodtrucks_stan', 'tacoNakosElite'),
('j', '$1$dXiYbcmf$oULDUNEvdLzJlytGZ5rzV1'),
('java_luvr', 'iloveuva456'),
('jj', '$6$rounds=5042$644979ef7524b3.5$mojtvK2UqFyBf4t4a4g0.dSKVuDNXGWgONxOSAoVnQRH44JLQMY4ngIOaG.DJt4AZqgMxiJ8qQbfGhepySC2V.'),
('joe', '$6$rounds=5042$64491bf57115c9.9$0MK8lzlSvAb3mskDr2WBNPTqIyQrGXw3a/x0SNqKx5WM7GAenubmcq9AmZflfTsXef6JEoSti76hz2K0h0qs2/'),
('jt', 'test'),
('lawnie', 'tundyI$cool'),
('lol', '$6$rounds=5042$6449426580f817.9$MsdxhcT7r6/Nwk0.7Tj37PWt79tN6qbUWrXKhbhNxqgoC3.iYn3BNBx78wCblqSNOpDn2JdqjbsjAWXVJgMlm.'),
('me', '$1$SuVpCBxS$CJV1CtA4OYEDHifa1bNyN.'),
('nate_brunelle', 'dsa2i$fun'),
('tj_stan123', 'iloveuva456'),
('trin_bouncer', 'goodbyeFke$'),
('trin_regular2020', 'balcony$tan'),
('tvh4xuk', '$6$rounds=5042$64492fe9ba22e8.3$JjXv7cf6BsbhLBarQsREu94sTv0xB2ORdPUd5eTExdr84eD4A.l6Gq7pfw8A3poVnGNAKO/JPP0OHH3VKzTia1'),
('upsorn', 'ilovedataba$es'),
('virg_queen', 'macncheeseluvr456'),
('yo', '$1$yP5QiUiB$OJurPoTdkrj5TpQdqpXqV.');

-- --------------------------------------------------------

--
-- Table structure for table `Books`
--

CREATE TABLE `Books` (
  `bookID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL DEFAULT 3,
  `name` text DEFAULT NULL,
  `course` text NOT NULL,
  `IBSN` varchar(13) NOT NULL,
  `listingID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Books`
--

INSERT INTO `Books` (`bookID`, `categoryID`, `name`, `course`, `IBSN`, `listingID`) VALUES
(1, 3, 'March Book One', 'AAS 1020', '9781603093002', NULL),
(2, 3, 'Kindred Graphic Novel', 'AAS 1020', '9781419728556', NULL),
(3, 3, 'Nat Turner', 'AAS 1020', '9780810972278', NULL),
(4, 3, 'Billy Budd, Bartleby and Other Stories', 'AMST 3001', '9780143107606', NULL),
(5, 3, 'Sobbing School', 'AMST 3001', '9780143111863', NULL),
(6, 3, 'Motel of Mysteries', 'AMST 3001', '9780395842546', NULL),
(7, 3, 'Chrysanthemum and The Sword', 'ANTH 1010', '9780395502020', NULL),
(8, 3, 'Probability and Statistics for Engineering and The Sciences', 'APMA 3120', '9781337432023', NULL),
(9, 3, 'Hoda Barakat\'s Sayyidi Wa Habibi', 'ARAB 3810', '9781626160026', NULL),
(10, 3, 'Janson\'s History of Art', 'ARTH 1505', '9780134182025', NULL),
(11, 3, 'Midaq Alley', 'ARTR 3290', '9780385264761', NULL),
(12, 3, 'Women and Deafness', 'ASL 2300', '9781563686177', NULL),
(13, 3, 'The Cosmic Perspective', 'ARTR 1210', '9780136996316', NULL),
(14, 3, 'Genetics: From Genes to Genomes', 'BIOL 3010', '9781260444087', NULL),
(15, 3, 'Chemical/Biochemical and Thermodynamics', 'CHE 2202', '9782202001009', NULL),
(16, 3, 'Text Level 1 Part : Integrated Chinese: Simpl Char Ed', 'CHIN 1010', '9780887276385', NULL),
(17, 3, 'Pot of Gold & Other Plays', 'CLAS 2020', '9780679729525', NULL),
(18, 3, 'Art of Love', 'CLAS 2020', '9780253200020', NULL),
(19, 3, 'Catiline\'s War, The Jugurthine War, Histories', 'CLAS 2020', '9780140449488', NULL),
(20, 3, 'Ancient Rome', 'CLAS 2020', '9781624660009', NULL),
(22, 3, 'Mastering Physics (4th Edition)', 'PHYS 1415', '0321641329', 34);

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `categoryID` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryID`, `name`) VALUES
(1, 'Furniture'),
(2, 'Clothes'),
(3, 'Books');

-- --------------------------------------------------------

--
-- Table structure for table `Clothes`
--

CREATE TABLE `Clothes` (
  `clothesID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL DEFAULT 2,
  `size` varchar(10) NOT NULL,
  `listingID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Clothes`
--

INSERT INTO `Clothes` (`clothesID`, `categoryID`, `size`, `listingID`) VALUES
(1, 2, 'S', NULL),
(2, 2, 'M', NULL),
(3, 2, 'L', NULL),
(4, 2, 'XL', NULL),
(5, 2, 'S', NULL),
(6, 2, 'M', NULL),
(7, 2, 'L', NULL),
(8, 2, 'XL', NULL),
(9, 2, 'XXL', NULL),
(10, 2, 'S', NULL),
(11, 2, 'M', NULL),
(12, 2, 'L', NULL),
(13, 2, 'XL', NULL),
(14, 2, 'S', NULL),
(15, 2, 'M', NULL),
(16, 2, 'L', NULL),
(17, 2, 'XL', NULL),
(18, 2, 'One Size', NULL),
(19, 2, 'One Size', NULL),
(20, 2, 'One Size', NULL),
(21, 2, 'L', 22),
(22, 2, 'M', 30),
(23, 2, 'M', 32);

-- --------------------------------------------------------

--
-- Table structure for table `evaluates`
--

CREATE TABLE `evaluates` (
  `offerID` int(11) NOT NULL,
  `sellerID` varchar(7) NOT NULL,
  `offer_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluates`
--

INSERT INTO `evaluates` (`offerID`, `sellerID`, `offer_status`) VALUES
(1, 'asl7xdp', 'Pending'),
(2, 'lh4amx', 'Completed'),
(3, 'vd9aps', 'Rejected'),
(4, 'lh4amx', 'Pending'),
(5, 'jat4ef', 'Completed'),
(6, 'tvh4xuk', 'Rejected'),
(7, 'nbs9gt', 'Pending'),
(8, 'jr2nx', 'Completed'),
(9, 'nbs9gt', 'Rejected'),
(10, 'asl7xdp', 'Pending'),
(11, 'dms7aoy', 'Completed'),
(12, 'nbs9gt', 'Rejected'),
(13, 'ctj4uq', 'Pending'),
(14, 'vd9aps', 'Completed'),
(15, 'ms67az', 'Rejected'),
(16, 'jat4ef', 'Pending'),
(17, 'nbs9gt', 'Completed'),
(18, 'tv2pxj', 'Rejected'),
(19, 'ctj4uq', 'Pending'),
(20, 'tvh4xuk', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `buyerID` varchar(7) NOT NULL,
  `listingID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`buyerID`, `listingID`) VALUES
('agpd5sp', 5),
('agpd5sp', 20),
('asl7xdp', 4),
('by4nb', 13),
('ctj4uq', 3),
('ctj4uq', 6),
('ctj4uq', 10),
('dms7aoy', 16),
('jat4ef', 7),
('jat4ef', 14),
('jr2nx', 15),
('jta2pm', 12),
('jta2pm', 17),
('lh4amx', 9),
('nbs9gt', 8),
('nbs9gt', 18),
('tj46h', 1),
('tj46h', 11),
('tvh4xuk', 2),
('tvh4xuk', 19);

-- --------------------------------------------------------

--
-- Table structure for table `Furniture`
--

CREATE TABLE `Furniture` (
  `furnitureID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL DEFAULT 1,
  `material` text NOT NULL,
  `dimensions` text NOT NULL,
  `listingID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Furniture`
--

INSERT INTO `Furniture` (`furnitureID`, `categoryID`, `material`, `dimensions`, `listingID`) VALUES
(1, 1, 'Wooden', '30x60', NULL),
(2, 1, 'Metal', '30x60', NULL),
(3, 1, 'Wooden', '22x27', NULL),
(4, 1, 'Wooden/Glass', '43x13', NULL),
(5, 1, 'Wooden', '26x60', NULL),
(6, 1, 'Plastic', '26x40', NULL),
(7, 1, 'Metal', '40x70', NULL),
(8, 1, 'Wooden', '40x70', NULL),
(9, 1, 'Metal', ' 62x85', NULL),
(10, 1, 'Wooden', '62x85', NULL),
(11, 1, 'Metal', '76x85', NULL),
(12, 1, 'Wooden', '76x85', NULL),
(13, 1, 'Wooden', '43x50', NULL),
(14, 1, 'Metal', '43x50', NULL),
(15, 1, 'Metal', '36x60', NULL),
(16, 1, 'Metal', '72x50', NULL),
(17, 1, 'Metal', '20x45', NULL),
(18, 1, ' Metal', '21x20', NULL),
(19, 1, 'Metal', '43x50', NULL),
(20, 1, 'Metal', '20x45', NULL),
(21, 1, 'Leather', '5x10x15', 23),
(22, 1, 'Suede', '1x1x1', 26),
(23, 1, 'Cloth', '20x40x30', 29),
(24, 1, 'Wood', '48x24x36', 33);

-- --------------------------------------------------------

--
-- Table structure for table `Listing`
--

CREATE TABLE `Listing` (
  `listingID` int(11) NOT NULL,
  `title` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(256) NOT NULL,
  `description` text DEFAULT NULL,
  `itemPic` text NOT NULL,
  `condition` varchar(10) NOT NULL,
  `listed_price` float NOT NULL,
  `sellerID` varchar(7) NOT NULL,
  `categoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Listing`
--

INSERT INTO `Listing` (`listingID`, `title`, `post_date`, `location`, `description`, `itemPic`, `condition`, `listed_price`, `sellerID`, `categoryID`) VALUES
(1, 'UVA Sweatshirt', '2023-03-23 04:00:00', 'Kellogg', 'Super cutie, Worn once', 'Desktopuvass', 'New', 5, 'tvh4xuk', 2),
(2, 'Night Stand', '2023-03-23 04:00:00', 'Tuttle', 'White Base with Brown Top', 'Desktop\nightstand', 'Fair', 100, 'asl7xdp', 1),
(3, 'UVA Rain Jacket', '2023-03-23 04:00:00', 'Wetland St.', 'Blue and Orange, Kinda beat', 'Desktop\rainj', 'Poor', 52.01, 'ctj4uq', 2),
(4, 'Motel of Mysteries', '2023-03-23 04:00:00', '14th St.', 'Textbook', 'Desktop	b', 'New', 5.2, 'lh4amx', 3),
(5, 'Dresser', '2023-03-23 04:00:00', 'JPA', 'Good for storing clothes', 'Desktopdresser', 'Good', 500, 'tv2pxj', 1),
(6, 'UVA Beanie', '2023-03-23 04:00:00', 'Rice Hall', 'Keeps my head warm and could keep yours too!', 'Desktopeanie', 'New', 20.13, 'vd9aps', 2),
(7, 'UVA Scarf', '2023-03-23 04:00:00', 'Gilmer Hall', 'Good for winter', 'Desktopscarf', 'Fair', 45.9, 'nbs9gt', 2),
(8, 'The Cosmic Perspective', '2023-03-23 04:00:00', 'Kellogg', 'So helpful with exams', 'Desktop	b', 'Poor', 0.01, 'lh4amx', 3),
(9, 'Couch', '2023-03-23 04:00:00', 'Minor Hall', 'Good for naps', 'Desktopcouch', 'Good', 30, 'jat4ef', 1),
(10, 'Kitchen Table', '2023-03-23 04:00:00', 'Virginia Ave.', 'Good place to eat all meals', 'Desktopkt', 'Fair', 67.09, 'jat4ef', 1),
(11, 'Ancient Rome', '2023-03-23 04:00:00', 'Main St.', 'Super Interesting', 'Desktop	b', 'New', 60, 'ms67az', 3),
(12, 'Genetics: From Genes to Genomes', '2023-03-23 04:00:00', 'Kellogg', 'Used all the time for Genetics', 'Desktop	b', 'Good', 25, 'tvh4xuk', 3),
(13, 'Bookshelf', '2023-03-23 04:00:00', 'Gooch', 'Will hold all your books!', 'Desktops', 'Poor', 90.99, 'vd9aps', 1),
(14, 'Desk Chair', '2023-03-23 04:00:00', 'Dillard', 'So comfy you will want to do work', 'Desktopds', 'Good', 32.22, 'nbs9gt', 1),
(15, 'UVA T Shirt', '2023-03-23 04:00:00', 'NGRC', 'Support the Hoos', 'Desktop	s', 'Fair', 5.55, 'ctj4uq', 2),
(16, 'Nat Turner', '2023-03-23 04:00:00', 'AFC', 'Required for class', 'Desktop	b', 'New', 40, 'jr2nx', 3),
(17, 'Twin Mattress Frame', '2023-03-23 04:00:00', 'Memorial Gym', 'If you want to continue your dorm experience!', 'Desktoped', 'Fair', 29.99, 'nbs9gt', 1),
(18, 'Mirror', '2023-03-23 04:00:00', 'Makes u looks so good', 'JPA', 'Desktopmirror', 'Poor', 1.01, 'nbs9gt', 1),
(19, 'Art of Love', '2023-03-23 04:00:00', 'OHill', 'Required for class', 'Desktop	b', 'New', 78, 'dms7aoy', 3),
(20, 'Queen Mattress Frame', '2023-03-23 04:00:00', 'Runk', 'Leave the twin xl behind pls', 'Desktoped', 'Good', 86.66, 'asl7xdp', 1),
(22, 'b', '2023-04-28 00:23:24', 'b', ' b', 'defaultItem.jpeg', 'New', 15, 'asdfga', 2),
(26, 'New couch', '2023-04-27 20:47:59', 'Wert', ' asdf', 'defaultItem.jpeg', 'Fair', 5, 'asdfga', 1),
(29, 'Old couch for sale', '2023-04-27 21:15:42', 'Rice Hall', ' Come get it', '29.jpeg', 'Good', 100, 'asdfga', 1),
(30, 'Selling shirt', '2023-04-27 21:47:03', 'Wertland', ' Selling old shirt', '30.jpg', 'Good', 5, 'asdfga', 2),
(32, 'Selling shorts', '2023-04-28 16:36:48', 'The lawn', ' Getting rid of shorts', '32.jpg', 'New', 5, 'asdfga', 2),
(33, 'Selling desk', '2023-04-28 16:48:40', 'Camden', ' graduating and selling desk!', '33.jpg', 'Good', 25, 'asdfga', 1),
(34, 'Selling old MP Textbook', '2023-04-28 16:58:55', 'Physics Bldg', ' Selling Mastering Physics textbook', '34.jpg', 'Good', 50, 'asdfga', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Offer`
--

CREATE TABLE `Offer` (
  `offerID` int(11) NOT NULL,
  `offer_price` float NOT NULL,
  `buyerID` varchar(7) NOT NULL,
  `listingID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Offer`
--

INSERT INTO `Offer` (`offerID`, `offer_price`, `buyerID`, `listingID`) VALUES
(1, 15, 'tvh4xuk', 2),
(2, 25, 'asl7xdp', 4),
(3, 31, 'ctj4uq', 6),
(4, 59, 'nbs9gt', 8),
(5, 78, 'tj46h', 10),
(6, 94, 'jta2pm', 12),
(7, 115.12, 'jat4ef', 14),
(8, 134.01, 'dms7aoy', 16),
(9, 158, 'tv2pxj', 18),
(10, 175, 'nbs9gt', 20),
(11, 169, 'vd9aps', 19),
(12, 144.02, 'tj46h', 17),
(13, 126, 'jr2nx', 15),
(14, 109.5, 'by4nb', 13),
(15, 88, 'jr2nx', 11),
(16, 62, 'lh4amx', 9),
(17, 47, 'jat4ef', 7),
(18, 30, 'agpd5sp', 5),
(19, 20, 'vd9aps', 3),
(20, 10, 'tj46h', 1);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `computingID` varchar(7) NOT NULL,
  `name` varchar(30) NOT NULL,
  `year` int(11) NOT NULL,
  `profilePic` text NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`computingID`, `name`, `year`, `profilePic`, `username`) VALUES
('abp7c', 'Aaron Bloomfield', 2, 'Pictures/cs4750/ab', 'aaron_bloomfield'),
('agpd5sp', 'Alexi Gladstone', 3, 'Pictures/cs4750/sql', 'db_queen'),
('asddddd', 'asd', 1, 'default.jpeg', 'aaa'),
('asdfga', 'Andrew Johnson', 4, 'a.png', 'a'),
('asdfght', 'b', 3, '.jpeg', 'bbb'),
('asl7xdp', 'Addison Lowman', 3, 'Pictures/cs4750/al', 'virg_queen'),
('bbbbbb', 'Bill Jones', 2, 'default.jpeg', 'b'),
('by4nb', 'Evan Yan', 4, 'Pictures/cs4750/ey', 'boldrockluvr10'),
('cghcbg', 'Chris', 2, 'default.jpeg', 'c'),
('ctj4uq', 'Caroline Jenkins', 3, 'Pictures/cs4750/cj', 'cornerjuice_luvr'),
('dey4ks', 'Thumay Huynh', 3, 'tvh4xuk.jpeg', 'tvh4xuk'),
('dms7aoy', 'Dylan Stanford', 1, 'Pictures/cs4750/gb', 'foodtrucks_stan'),
('gw1qy8', 'George Washington', 3, 'Pictures/cs4750/gw', 'elzinga789'),
('jat4ef', 'Jalon Thomas', 1, 'Pictures/cs4750/jt', 'trin_regular2020'),
('jg7sk4', 'Jonathan Genda', 2, 'Pictures/cs4750/tib', 'trin_bouncer'),
('jjjjjj', 'jj', 2, 'jt.png', 'jt'),
('joemom', 'joe', 2, 'default.jpeg', 'joe'),
('jr2nx', 'Jim Ryan', 2, 'Pictures/cs4750/tr', 'boylan_babe_1234'),
('jta2pm', 'Jackson Arnberg', 2, 'Pictures/cs4750/128', 'fiji_groupie2002'),
('lh4amx', 'Lili Ho', 1, 'Pictures/cs4750/axo', 'axo_girlie'),
('llllll', 'j', 3, 'jj.png', 'jj'),
('lwr7sc', 'Lauren Rosco', 3, 'Pictures/cs4750/lawn', 'lawnie'),
('ms67az', 'Mark Sherrif', 1, 'Pictures/cs4750/ms', 'cs_babe24'),
('nbs9gt', 'Nathan Brunelle', 4, 'Pictures/cs4750/nb', 'nate_brunelle'),
('tj46h', 'Thomas Jefferson', 4, 'Pictures/cs4750/tj', 'tj_stan123'),
('tv2pxj', 'Tyler Vo', 2, 'Pictures/cs4750/java', 'java_luvr'),
('tvh4xuk', 'Thumay Huynh', 4, 'Pictures/cs4750/th', 'commkiddo'),
('up6sk', 'Upsorn Prap', 1, 'Pictures/cs4750/up', 'upsorn'),
('vd9aps', 'Tori Dailo', 4, 'Pictures/cs4750/dz', 'dz_baddie');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `Books`
--
ALTER TABLE `Books`
  ADD PRIMARY KEY (`bookID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `Clothes`
--
ALTER TABLE `Clothes`
  ADD PRIMARY KEY (`clothesID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `evaluates`
--
ALTER TABLE `evaluates`
  ADD PRIMARY KEY (`offerID`),
  ADD KEY `sellerID` (`sellerID`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`buyerID`,`listingID`),
  ADD KEY `listingID` (`listingID`);

--
-- Indexes for table `Furniture`
--
ALTER TABLE `Furniture`
  ADD PRIMARY KEY (`furnitureID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `Listing`
--
ALTER TABLE `Listing`
  ADD PRIMARY KEY (`listingID`),
  ADD KEY `sellerID` (`sellerID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `Offer`
--
ALTER TABLE `Offer`
  ADD PRIMARY KEY (`offerID`),
  ADD KEY `buyerID` (`buyerID`),
  ADD KEY `listingID` (`listingID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`computingID`),
  ADD KEY `username` (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Books`
--
ALTER TABLE `Books`
  ADD CONSTRAINT `Books_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryID`);

--
-- Constraints for table `Clothes`
--
ALTER TABLE `Clothes`
  ADD CONSTRAINT `Clothes_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryID`);

--
-- Constraints for table `evaluates`
--
ALTER TABLE `evaluates`
  ADD CONSTRAINT `evaluates_ibfk_1` FOREIGN KEY (`offerID`) REFERENCES `Offer` (`offerID`),
  ADD CONSTRAINT `evaluates_ibfk_2` FOREIGN KEY (`sellerID`) REFERENCES `User` (`computingID`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `User` (`computingID`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`listingID`) REFERENCES `Listing` (`listingID`);

--
-- Constraints for table `Furniture`
--
ALTER TABLE `Furniture`
  ADD CONSTRAINT `Furniture_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryID`);

--
-- Constraints for table `Listing`
--
ALTER TABLE `Listing`
  ADD CONSTRAINT `Listing_ibfk_1` FOREIGN KEY (`sellerID`) REFERENCES `User` (`computingID`),
  ADD CONSTRAINT `Listing_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryID`);

--
-- Constraints for table `Offer`
--
ALTER TABLE `Offer`
  ADD CONSTRAINT `Offer_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `User` (`computingID`),
  ADD CONSTRAINT `Offer_ibfk_2` FOREIGN KEY (`listingID`) REFERENCES `Listing` (`listingID`);

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`username`) REFERENCES `Account` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE `Listing_audit` (
  `audit_ID` int(11) NOT NULL AUTO_INCREMENT,
  `listingID` int(11) NOT NULL,
  `title` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(256) NOT NULL,
  `description` text DEFAULT NULL,
  `itemPic` text NOT NULL,
  `condition` varchar(10) NOT NULL,
  `listed_price` float NOT NULL,
  `sellerID` varchar(7) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `audit_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`audit_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER $$
CREATE TRIGGER `Listing_audit_trigger` 
AFTER UPDATE ON `Listing`
FOR EACH ROW 
BEGIN
  INSERT INTO `Listing_audit` (
    `listingID`,
    `title`,
    `post_date`,
    `location`,
    `description`,
    `itemPic`,
    `condition`,
    `listed_price`,
    `sellerID`,
    `categoryID`
  ) 
  VALUES (
    OLD.`listingID`,
    OLD.`title`,
    OLD.`post_date`,
    OLD.`location`,
    OLD.`description`,
    OLD.`itemPic`,
    OLD.`condition`,
    OLD.`listed_price`,
    OLD.`sellerID`,
    OLD.`categoryID`
  );
END$$
DELIMITER ;


CREATE TABLE `User_audit` (
  `audit_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `computingID` varchar(7) NOT NULL,
  `name` varchar(30) NOT NULL,
  `year` int(11) NOT NULL,
  `profilePic` text NOT NULL,
  `username` varchar(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`audit_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER $$
CREATE TRIGGER `User_audit_trigger` 
AFTER UPDATE ON `User` 
FOR EACH ROW
BEGIN
  INSERT INTO `User_audit` (computingID, name, year, profilePic, username, updated_at)
  VALUES (OLD.computingID, OLD.name, OLD.year, OLD.profilePic, OLD.username, NOW());
END$$
DELIMITER ;
