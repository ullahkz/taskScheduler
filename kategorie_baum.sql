-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2018 at 01:28 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kategorie_baum`
--

-- --------------------------------------------------------

--
-- Table structure for table `kat_index`
--

CREATE TABLE `kat_index` (
  `ID` int(11) NOT NULL,
  `VS4_KAT_ID` varchar(12) DEFAULT NULL,
  `VS4_KAT_PARENT_ID` varchar(12) DEFAULT NULL,
  `KAT_NAME` varchar(50) DEFAULT NULL,
  `SHOPWARE_ID` varchar(12) DEFAULT NULL,
  `AKTIV` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kat_index`
--

INSERT INTO `kat_index` (`ID`, `VS4_KAT_ID`, `VS4_KAT_PARENT_ID`, `KAT_NAME`, `SHOPWARE_ID`, `AKTIV`) VALUES
(1, '000001', '', 'Briefmarken', '5', 1),
(2, '000004', '000001', 'Altdeutschland', '96', 1),
(3, '000254', '000004', 'Baden', '117', 1),
(4, '000255', '000004', 'Bayern', '118', 1),
(5, '000256', '000004', 'Bergedorf', '119', 1),
(6, '000257', '000004', 'Braunschweig', '120', 1),
(7, '000259', '000004', 'Hamburg', '121', 1),
(8, '000260', '000004', 'Hannover', '122', 1),
(9, '000261', '000004', 'Helgoland', '123', 1),
(10, '000262', '000004', 'Lübeck', '124', 1),
(11, '000263', '000004', 'Mecklenburg-Schwerin', '125', 1),
(12, '000264', '000004', 'Mecklenburg-Strelitz', '126', 1),
(13, '000265', '000004', 'Oldenburg', '127', 1),
(14, '000267', '000004', 'Sachsen', '128', 1),
(15, '000269', '000004', 'Thurn und Taxis', '129', 1),
(16, '000270', '000004', 'Württemberg', '130', 1),
(17, '000005', '000001', 'Deutsches Reich', '97', 1),
(18, '000019', '000005', 'Kaiserreich 1872-1918', '131', 1),
(19, '000021', '000005', 'Weimarer Republik 1919-1932', '132', 1),
(20, '000022', '000005', 'Drittes Reich 1933-1945', '133', 1),
(21, '000243', '000005', 'Dienstmarken 1903-1944', '134', 1),
(22, '000241', '000005', 'Posten & Lots', '135', 1),
(23, '000020', '000005', 'Inflation', '136', 1),
(24, '000023', '000005', 'Sonderausgaben', NULL, 0),
(25, '000024', '000005', 'Saar', NULL, 0),
(26, '000242', '000005', 'Blockausgaben', '137', 1),
(27, '000288', '000001', 'Deutsche Auslandspostämter', '98', 1),
(28, '000290', '000288', 'Deutsche Post in Marokko', NULL, 0),
(29, '000292', '000288', 'Sammlungen & Lots', '138', 1),
(30, '000293', '000001', 'Deutsche Kolonien', '99', 1),
(31, '000305', '000001', 'Deutsche Besetzungsausgaben 1914-1918', '100', 1),
(32, '000306', '000001', 'Deutsche Abstimmungsgebiete', '101', 1),
(33, '000307', '000001', 'Deutsche Besetzungsausgaben 1939-1945', '102', 1),
(34, '000364', '000307', 'Albanien', NULL, 0),
(35, '000365', '000307', 'Elsass', '141', 1),
(36, '000366', '000307', 'Estland', '142', 1),
(37, '000368', '000307', 'Kanalinseln', NULL, 0),
(38, '000369', '000307', 'Kotor', '143', 1),
(39, '000370', '000307', 'Kurland', '144', 1),
(40, '000372', '000307', 'Lettland', '145', 1),
(41, '000373', '000307', 'Litauen', '146', 1),
(42, '000374', '000307', 'Lothringen', '147', 1),
(43, '000375', '000307', 'Luxemburg', NULL, 0),
(44, '000380', '000307', 'Serbien', '148', 1),
(45, '000382', '000307', 'Zante', NULL, 0),
(46, '000384', '000307', 'Sammlungen & Lots', NULL, 0),
(47, '000308', '000001', 'Sonstige Gebiete', '103', 1),
(48, '000387', '000308', 'Freie Stadt Danzig', NULL, 0),
(49, '000389', '000308', 'Böhmen und Mähren', '149', 1),
(50, '000390', '000308', 'Generalgouvernement', '150', 1),
(51, '000391', '000308', 'Sudetenland', '151', 1),
(52, '000392', '000308', 'Feldpostmarken', '152', 1),
(53, '000006', '000001', 'Alliierte Besatzung', '104', 1),
(54, '000025', '000006', 'Kontrollrat', NULL, 0),
(55, '000027', '000006', 'Bizone', '153', 1),
(56, '000245', '000006', 'Posten & Lots', '154', 1),
(57, '000346', '000006', 'Gemeinschaftsausgaben', '155', 1),
(58, '000349', '000006', 'Berlin und Brandenburg', '156', 1),
(59, '000028', '000006', 'Sowjetische Zone', '157', 1),
(60, '000338', '000028', 'Mecklenburg-Vorpommern', '161', 1),
(61, '000340', '000028', 'Ost-Sachsen', '162', 1),
(62, '000341', '000028', 'Provinz Sachsen', '163', 1),
(63, '000026', '000006', 'Französische Zone', '158', 1),
(64, '000244', '000006', 'Amerikanische und Britische Zone', '159', 1),
(65, '000051', '000001', 'BRD', '105', 1),
(66, '000052', '000051', 'Frühausgaben', '165', 1),
(67, '000053', '000051', 'Jahrgänge', '166', 1),
(68, '000158', '000051', 'Posten & Lots', '167', 1),
(69, '000248', '000051', 'Kiloware', '168', 1),
(70, '000007', '000001', 'DDR', '106', 1),
(71, '000030', '000007', 'Frühausgaben', '169', 1),
(72, '000031', '000007', 'Jahrgänge', '170', 1),
(73, '000032', '000007', 'Sonderausgaben', '171', 1),
(74, '000247', '000007', 'Posten & Lots', '172', 1),
(75, '000008', '000001', 'Berlin', '107', 1),
(76, '000033', '000008', 'Frühausgaben', '173', 1),
(77, '000034', '000008', 'Jahrgänge', '174', 1),
(78, '000035', '000008', 'Sonderausgaben', '175', 1),
(79, '000246', '000001', 'Saarland', '108', 1),
(80, '000013', '000001', 'Posten, Kollektionen', '109', 1),
(81, '000010', '000001', 'Österreich', '110', 1),
(82, '000014', '000010', 'Frühausgaben', '177', 1),
(83, '000015', '000010', 'Jahrgänge', '178', 1),
(84, '000252', '000010', 'Posten & Lots', '179', 1),
(85, '000323', '000010', 'Kaisertum 1850-1866', '180', 1),
(86, '000249', '000010', 'Kaiserreich 1867-1918', '181', 1),
(87, '000324', '000010', 'Republik Deutsch-Österreich 1918-1921', '182', 1),
(88, '000250', '000010', '1. Republik 1922-1937', '183', 1),
(89, '000251', '000010', '2. Republik 1945-heute', '184', 1),
(90, '000055', '000001', 'Schweiz', NULL, 1),
(91, '000011', '000001', 'Liechtenstein', '111', 1),
(92, '000039', '000011', 'Frühjahrsaugaben', '186', 1),
(93, '000040', '000011', 'Jahrgänge', '187', 1),
(94, '000012', '000001', 'Alle Welt', '112', 1),
(95, '000042', '000012', 'Afrika', '188', 1),
(96, '000043', '000012', 'Asien', '189', 1),
(97, '000044', '000012', 'Amerika', '190', 1),
(98, '000207', '000012', 'Australien / Ozeanien', '191', 1),
(99, '000045', '000012', 'Europa', '192', 1),
(100, '000152', '000001', 'Reste & Schnäppchen', '113', 1),
(101, '000157', '000001', 'Raritäten', '114', 1),
(102, '000156', '000001', 'Kiloware', '115', 1),
(103, '000253', '000001', 'Kollektionen und Sammlungen', '116', 1),
(104, '000002', '', 'Münzen', '4', 1),
(105, '000062', '000002', 'Euromünzen', '9', 1),
(106, '000203', '000062', 'Euro Kursmünzen-Sätze', NULL, 1),
(107, '000228', '000062', 'Euro Kursmünzensätze', '17', 1),
(108, '000204', '000062', 'Andorra', '18', 1),
(109, '000068', '000062', 'Belgien', '19', 1),
(110, '000069', '000062', 'Deutschland', '20', 1),
(111, '000273', '000069', '5 Euro mit Polymer', '41', 1),
(112, '000091', '000069', '10 Euro Gedenkmünzen', '42', 1),
(113, '000274', '000069', '20 Euro Silber-Gedenkmünzen', '43', 1),
(114, '000092', '000069', 'Goldmünzen', NULL, 1),
(115, '000176', '000069', 'BRD Gold', '44', 1),
(116, '000210', '000176', 'BRD 20 Euro Gold', '46', 1),
(117, '000211', '000176', 'BRD 100 Euro Gold', '47', 1),
(118, '000229', '000069', '20 Euro Gedenkmünzen', '45', 1),
(119, '000070', '000062', 'Estland', '21', 1),
(120, '000074', '000062', 'Finnland', '22', 1),
(121, '000075', '000062', 'Frankreich', '23', 1),
(122, '000076', '000062', 'Griechenland', '24', 1),
(123, '000078', '000062', 'Italien', '25', 1),
(124, '000077', '000062', 'Irland', '26', 1),
(125, '000167', '000062', 'Lettland', '27', 1),
(126, '000216', '000062', 'Litauen', '28', 1),
(127, '000079', '000062', 'Luxemburg', '29', 1),
(128, '000080', '000062', 'Malta', '30', 1),
(129, '000081', '000062', 'Monaco', '31', 1),
(130, '000082', '000062', 'Niederlande', '32', 1),
(131, '000083', '000062', 'Österreich', '33', 1),
(132, '000084', '000062', 'Portugal', '34', 1),
(133, '000085', '000062', 'San Marino', '35', 1),
(134, '000086', '000062', 'Slowakei', '36', 1),
(135, '000087', '000062', 'Slowenien', '37', 1),
(136, '000088', '000062', 'Spanien', '38', 1),
(137, '000089', '000062', 'Vatikan', '39', 1),
(138, '000090', '000062', 'Zypern', '40', 1),
(139, '000063', '000002', '2 Euro Münzen', '10', 1),
(140, '000064', '000063', '2 Euro Kursmünzen', '48', 1),
(141, '000065', '000063', '2 Euro Gedenkmünzen', '49', 1),
(142, '000225', '000065', 'Jahrgang 2018', '52', 1),
(143, '000226', '000065', 'Jahrgang 2017', '53', 1),
(144, '000227', '000065', 'Jahrgang 2016', '54', 1),
(145, '000224', '000065', 'Jahrgang 2015', '55', 1),
(146, '000208', '000065', 'Jahrgang 2014', '56', 1),
(147, '000155', '000065', 'Jahrgang 2013', '57', 1),
(148, '000066', '000065', 'Jahrgang 2012', '58', 1),
(149, '000067', '000065', 'Jahrgang 2011', '59', 1),
(150, '000073', '000065', 'Jahrgang 2010', '60', 1),
(151, '000119', '000065', 'Jahrgang 2009', NULL, 1),
(152, '000120', '000065', 'Jahrgang 2008', '61', 1),
(153, '000131', '000065', 'Jahrgang 2007', '62', 1),
(154, '000133', '000065', 'Jahrgang 2005', '64', 1),
(155, '000134', '000065', 'Jahrgang 2004', '65', 1),
(156, '000145', '000063', '2 Euro Kleinstaaten', '50', 1),
(157, '000148', '000063', '2 Euro Münzen veredelt', '51', 1),
(158, '000093', '000002', 'Deutschland vor 2001', '11', 1),
(159, '000101', '000093', 'BRD', '66', 1),
(160, '000102', '000093', 'DDR', '67', 1),
(161, '000103', '000093', 'Drittes Reich', '68', 1),
(162, '000104', '000093', 'Weimarer Republik', '69', 1),
(163, '000105', '000093', 'Kaiserreich', '70', 1),
(164, '000106', '000093', 'Altdeutschland', '71', 1),
(165, '000278', '000093', 'Antike Münzen', NULL, 0),
(166, '000094', '000002', 'Goldmünzen und Barren', NULL, 0),
(167, '000095', '000002', 'Silbermünzen und Barren', NULL, 0),
(168, '000100', '000002', 'Historische Münzen', '12', 1),
(169, '000169', '000002', 'Gold und Silber', '13', 1),
(170, '000170', '000169', 'Goldmünzen', '73', 1),
(171, '000171', '000169', 'Goldbarren', '74', 1),
(172, '000201', '000169', 'Historische Goldmünzen', '75', 1),
(173, '000172', '000169', 'Gold-Preishits', '76', 1),
(174, '000173', '000169', 'Silbermünzen', '77', 1),
(175, '000174', '000169', 'Silberbarren', '78', 1),
(176, '000202', '000169', 'Historische Silbermünzen', '79', 1),
(177, '000175', '000169', 'Silber-Preishits', '80', 1),
(178, '000214', '000169', 'Barren aus Edelmetall', '81', 1),
(179, '000217', '000169', 'Weitere Anlagemünzen', '82', 1),
(180, '000230', '000169', 'Goldmünzen Deutschland', '83', 1),
(181, '000231', '000230', 'BRD 100 Euro Goldmünze', '85', 1),
(182, '000233', '000230', 'BRD 20 Euro Goldmünze', '86', 1),
(183, '000234', '000230', 'Historische Goldmünzen', NULL, 1),
(184, '000235', '000169', 'Kupferbarren', NULL, 1),
(185, '000283', '000169', 'Kupfer', '84', 1),
(186, '000096', '000002', 'Münzen aus aller Welt', '14', 1),
(187, '000097', '000096', 'Schweiz', '87', 1),
(188, '000098', '000096', 'Vor-Euro', '88', 1),
(189, '000137', '000096', 'Weltmünzensätze', '89', 1),
(190, '000099', '000002', 'Banknoten - Aktien - Orden', '15', 1),
(191, '000165', '000099', 'Goldfolien', '90', 1),
(192, '000284', '000099', 'Banknoten', NULL, 1),
(193, '000286', '000099', 'Orden und Abzeichen', NULL, 1),
(194, '000136', '000002', 'Besondere Münzen & Kollektionen', '16', 1),
(195, '000205', '000136', 'Besondere Münzen', '91', 1),
(196, '000206', '000136', 'Kollektionen', '92', 1),
(197, '000147', '000136', 'Goldfolien 10 Jahre Euro-Bargeld', '93', 1),
(198, '000153', '000136', 'Württemberg', NULL, 1),
(199, '000287', '000136', 'Gold-Gedenkausgaben', '95', 1),
(200, '000168', '', 'Geschenkideen', '7', 1),
(201, '000221', '000168', 'Schmuck', '208', 1),
(202, '000236', '000168', 'Literatur', '209', 1),
(203, '000109', '', 'Zubehör und Pflege', '6', 1),
(204, '000237', '000109', 'Briefmarken Zubehör', '193', 1),
(205, '000238', '000237', 'Briefmarken Alben', '204', 1),
(206, '000239', '000237', 'Briefmarken Vordruckalben', '205', 1),
(207, '000240', '000237', 'Briefmarken sonstiges Zubehör', '206', 1),
(208, '000110', '000109', 'Alben für Briefmarken & Münzen', '194', 1),
(209, '000111', '000109', 'Münzkapseln', '195', 1),
(210, '000112', '000109', 'Kassetten', '196', 1),
(211, '000113', '000109', 'Münzboxen und Koffer', '197', 1),
(212, '000114', '000109', 'Tableaus für Kassetten, Boxen & Koffer', '198', 1),
(213, '000115', '000109', 'Waagen & Prüfgeräte', '199', 1),
(214, '000116', '000109', 'Lupen und Pinzetten', '200', 1),
(215, '000117', '000109', 'Münzreinigung', '201', 1),
(216, '000212', '000109', 'Hüllen für Alben', '202', 1),
(217, '000213', '000109', 'Steckkarten für Briefmarken & Postkarten', '203', 1),
(218, '000149', '000102', 'Gedenkmünzen der DDR', '72', 1),
(219, '000138', NULL, 'SALE', '8', NULL),
(220, '000139', '000138', 'Euro Münzensätze', '210', 1),
(221, '140', '000138', '2 Euromünzen', '211', 1),
(222, '000141', '000138', 'Euro Gedenkmünzen', '212', NULL),
(223, '000142', '000138', 'Weltmünzensätze', '213', 1),
(224, '000151', '000138', 'Besonderheiten', '214', NULL),
(225, '000160', '000139', 'Alles unter 5 Euro', '215', 1),
(226, '000161', '000138', 'Alles unter 20 Euro', '216', 1),
(227, '000162', '000138', 'Gemeinschaftsausgaben', '217', 1),
(228, '000135', NULL, 'Alles unter 10', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kat_index`
--
ALTER TABLE `kat_index`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kat_index`
--
ALTER TABLE `kat_index`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
