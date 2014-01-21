-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2014 at 10:51 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kwizz`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id_poruka` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_primatelj` int(11) NOT NULL,
  `id_posiljatelj` int(11) NOT NULL,
  `tekst_poruka` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_poruka`,`id_primatelj`,`id_posiljatelj`),
  UNIQUE KEY `id_poruka_UNIQUE` (`id_poruka`),
  KEY `primatelj_idx` (`id_primatelj`),
  KEY `posiljatelj_idx` (`id_posiljatelj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dostignuce`
--

CREATE TABLE IF NOT EXISTS `dostignuce` (
  `id_dostignuce` int(11) NOT NULL AUTO_INCREMENT,
  `naziv_dostignuce` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ikona_dostignuce` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_dostignuce`),
  UNIQUE KEY `id_dostignuce_UNIQUE` (`id_dostignuce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE IF NOT EXISTS `kategorija` (
  `id_kategorija` int(11) NOT NULL AUTO_INCREMENT,
  `naziv_kategorija` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nadkategorija` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kategorija`),
  UNIQUE KEY `id_kategorija_UNIQUE` (`id_kategorija`),
  KEY `nadkategorija_idx` (`nadkategorija`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`id_kategorija`, `naziv_kategorija`, `nadkategorija`) VALUES
(1, 'Kultura', NULL),
(2, 'Znanost', NULL),
(3, 'Zabava', NULL),
(4, 'Trivia', NULL),
(5, 'Povijest', 2),
(6, 'Zemljopis', 2),
(7, 'Fizika', 2),
(8, 'Tehnologija', 2),
(9, 'Glazba', 1),
(10, 'Film i TV', 1),
(11, 'Igre', 1),
(12, 'Književnost', 1),
(13, 'Sport', NULL),
(14, 'Biologija', 2);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE IF NOT EXISTS `korisnik` (
  `id_korisnik` int(11) NOT NULL AUTO_INCREMENT,
  `nadimak_korisnik` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ime` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password_korisnik` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `drzava_korisnik` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `uloga_korisnik` int(11) NOT NULL DEFAULT '0',
  `about` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_korisnik`),
  UNIQUE KEY `id_korisnik_UNIQUE` (`id_korisnik`),
  UNIQUE KEY `nadimak_korisnik_UNIQUE` (`nadimak_korisnik`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id_korisnik`, `nadimak_korisnik`, `ime`, `password_korisnik`, `drzava_korisnik`, `uloga_korisnik`, `about`) VALUES
(1, 'David', '', '172522ec1028ab781d9dfd17eaca4427', 'hr', 0, ''),
(2, 'Paolo', '', '21232f297a57a5a743894a0e4a801fc3', 'hr', 0, ''),
(3, 'Iva', 'Iva Petrovic', '21232f297a57a5a743894a0e4a801fc3', 'hr', 0, 'blablablablabla'),
(5, 'admin', '', '21232f297a57a5a743894a0e4a801fc3', 'hr', 0, ''),
(7, 'test', 'Ana', '098f6bcd4621d373cade4e832627b4f6', '1', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik_dostignuce`
--

CREATE TABLE IF NOT EXISTS `korisnik_dostignuce` (
  `id_korisnik` int(11) NOT NULL,
  `id_dostignuce` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_korisnik`,`id_dostignuce`),
  UNIQUE KEY `id_korisnik_UNIQUE` (`id_korisnik`),
  UNIQUE KEY `id_dostignuce_UNIQUE` (`id_dostignuce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lista_prijatelja`
--

CREATE TABLE IF NOT EXISTS `lista_prijatelja` (
  `id_vlasnik` int(11) NOT NULL,
  `id_prijatelj` int(11) NOT NULL,
  PRIMARY KEY (`id_vlasnik`,`id_prijatelj`),
  UNIQUE KEY `id_vlasnik_UNIQUE` (`id_vlasnik`,`id_prijatelj`),
  UNIQUE KEY `id_prijatelj_UNIQUE` (`id_prijatelj`,`id_vlasnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lista_prijatelja`
--

INSERT INTO `lista_prijatelja` (`id_vlasnik`, `id_prijatelj`) VALUES
(3, 5),
(3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `mode`
--

CREATE TABLE IF NOT EXISTS `mode` (
  `id_mode` int(11) NOT NULL,
  `naziv_mode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_mode`),
  UNIQUE KEY `id_mode_UNIQUE` (`id_mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mode`
--

INSERT INTO `mode` (`id_mode`, `naziv_mode`) VALUES
(0, 'FFA'),
(1, 'CHA');

-- --------------------------------------------------------

--
-- Table structure for table `odgovor`
--

CREATE TABLE IF NOT EXISTS `odgovor` (
  `id_odgovor` int(11) NOT NULL AUTO_INCREMENT,
  `tekst_odgovor` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tocan_odgovor` tinyint(1) NOT NULL DEFAULT '1',
  `id_pitanje` int(11) NOT NULL,
  PRIMARY KEY (`id_odgovor`),
  UNIQUE KEY `id_odgovor_UNIQUE` (`id_odgovor`),
  KEY `odgovor_na_idx` (`id_pitanje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=210 ;

--
-- Dumping data for table `odgovor`
--

INSERT INTO `odgovor` (`id_odgovor`, `tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES
(1, '4', 0, 1),
(2, '6', 0, 1),
(3, '8', 1, 1),
(4, '10', 0, 1),
(5, '1939', 1, 2),
(6, 'Monitor', 0, 3),
(7, 'Miš', 0, 3),
(8, 'Mačka', 1, 3),
(9, 'Tastatura', 0, 3),
(10, 'Hard disk', 0, 3),
(11, 'Procesor', 0, 3),
(12, 'Točno', 0, 4),
(13, 'Netočno', 1, 4),
(21, 'Točno', 1, 8),
(22, 'Netočno', 0, 8),
(23, 'Slon', 0, 9),
(24, 'Zebra', 0, 9),
(25, 'Žirafa', 1, 9),
(26, 'Deep Purple', 0, 10),
(27, 'High Blue', 0, 10),
(28, 'Deep Blue', 1, 10),
(29, 'High Purple', 0, 10),
(30, 'Ribom', 0, 11),
(31, 'Planktonom', 1, 11),
(32, 'Ljudima', 0, 11),
(33, 'Koraljima', 0, 11),
(34, 'Netočno', 1, 12),
(35, 'Točno', 0, 12),
(36, 'Pretoria', 1, 13),
(37, 'Kaapstad', 1, 13),
(38, 'Bloemfontein', 1, 13),
(39, 'Harry Potter i kamen mudraca', 0, 14),
(40, 'Sanjaju li androidi električne ovce', 1, 14),
(41, 'Vodič kroz galaksiju za autostopere', 0, 14),
(42, 'Atlas Shrugged', 0, 14),
(43, '7', 1, 15),
(44, 'sedam', 1, 15),
(45, 'Porsche', 0, 16),
(46, 'Ferrari', 0, 16),
(47, 'Opel', 1, 16),
(48, 'Seat', 0, 16),
(49, 'Peugeot', 0, 16),
(50, 'Francuska', 1, 17),
(51, 'Cosby Show', 0, 18),
(52, 'Seinfeld', 1, 18),
(53, 'Tom & Jerry', 0, 18),
(54, 'Wario', 0, 19),
(55, 'Luigi', 1, 19),
(56, 'Bowser', 0, 19),
(57, 'Michael Schumacher', 0, 20),
(58, 'Sebastian Vettel', 1, 20),
(59, 'Juha Kittoinen', 0, 20),
(60, 'Lewis Hamilton', 0, 20),
(61, 'Rammstein', 0, 21),
(62, 'Cardigans', 0, 21),
(63, 'Cranberries', 1, 21),
(64, 'Counting Crows', 0, 21),
(65, 'Nightwish', 0, 22),
(66, 'Within Temptation', 1, 22),
(67, 'Kosheen', 0, 22),
(68, 'George Michael', 0, 23),
(69, 'Boy George', 0, 23),
(70, 'Bob Dylan', 0, 23),
(71, 'Elton John', 1, 23),
(72, 'Little Richard', 0, 23),
(73, 'Sputnik', 1, 24),
(74, 'Oreo', 0, 24),
(75, 'Apollo', 0, 24),
(76, 'Mercury', 0, 24),
(77, 'Skoku s mosta', 0, 25),
(78, 'Skoku iz svemira', 1, 25),
(79, 'Skoku s motkom', 0, 25),
(80, 'Skoku iz jurećeg vlaka', 0, 25),
(81, 'Bono', 1, 26),
(82, 'Gitaristica', 0, 27),
(83, 'Violinistica', 1, 27),
(84, 'Pianistica', 0, 27),
(85, 'Bubnjarka', 0, 27),
(86, 'Vettel', 1, 20),
(87, 'Mee', 0, 28),
(88, 'Wii', 1, 28),
(89, 'Xbox', 0, 28),
(90, 'Dreamcast', 0, 28),
(91, 'Minsk', 1, 29),
(92, '1492', 1, 30),
(97, 'Zatvor', 0, 31),
(98, 'Parkiralište', 0, 31),
(99, 'Start', 0, 31),
(100, 'Banka', 1, 31),
(101, 'Michael Schumacher', 1, 32),
(102, 'Brawn', 1, 33),
(111, 'August Šenoa', 1, 36),
(112, 'Miroslav Krleza', 0, 37),
(113, 'Ranko Marinkovic', 1, 37),
(114, 'Kafka', 0, 37),
(115, 'Matos', 0, 37),
(116, 'Ralje', 0, 38),
(117, 'Star Trek', 0, 38),
(118, 'Policijska akademija', 1, 38),
(119, 'Pirati s Kariba', 0, 38),
(120, 'beneath', 1, 39),
(121, 'in the house', 0, 39),
(122, 'on the shore', 0, 39),
(123, 'in the sheets', 0, 39),
(124, 'Dortmund', 0, 40),
(125, 'Rome ', 0, 40),
(126, 'Moscow', 0, 40),
(127, 'Kiev', 1, 40),
(128, 'Vanessa Williams', 0, 41),
(129, 'Cher', 0, 41),
(130, 'Madonna', 0, 41),
(131, 'Whitney Houston', 1, 41),
(132, 'Kinu', 0, 42),
(133, 'Veliku Britaniju', 0, 42),
(134, 'Austriju', 1, 42),
(135, 'Italiju', 0, 42),
(136, 'Lima', 1, 43),
(137, 'Bogota', 0, 43),
(138, 'Barcelona', 0, 43),
(139, 'Buenos Aires', 0, 43),
(140, 'Theodore Roosevelt', 0, 44),
(141, 'Richard Nixon', 1, 44),
(142, 'Bill Clinton', 0, 44),
(143, 'Barack Obama', 0, 44),
(144, 'Kairo', 0, 45),
(145, 'Aleksandrija', 0, 45),
(146, 'Memphis', 1, 45),
(147, 'Teba', 0, 45),
(148, 'Gondor', 0, 46),
(149, 'Shire', 1, 46),
(150, 'Mordor', 0, 46),
(151, 'Eriador', 0, 46),
(152, '1', 0, 47),
(153, '2', 0, 47),
(154, '3', 1, 47),
(155, '5', 0, 47),
(156, 'Sean Conery', 1, 48),
(157, 'Roger Moore', 0, 48),
(158, 'George Lazenby', 0, 48),
(159, 'Timothy Dalton', 0, 48),
(160, 'Star Wars', 1, 49),
(161, 'Robocop', 0, 49),
(162, 'Back To The Future', 0, 49),
(163, 'Star Trek', 0, 49),
(164, 'Yerevan', 1, 50),
(165, 'Canberra', 0, 50),
(166, 'Tashkent', 0, 50),
(167, 'Tbilisi', 0, 50),
(168, 'Bayern', 1, 51),
(169, 'Stuttgart', 0, 51),
(170, 'Nurnberg', 0, 51),
(171, 'Real Madrid', 0, 51),
(172, 'Munchen', 0, 52),
(173, 'Leitpzig', 0, 52),
(174, 'Bonn', 1, 52),
(175, 'Hamburg', 0, 52),
(176, '1930', 0, 53),
(177, '1945', 0, 53),
(178, '1949', 1, 53),
(179, '1980', 0, 53),
(180, 'Grčkoj', 1, 54),
(181, 'Mezopotamiji', 0, 54),
(182, 'Kini', 0, 54),
(183, 'Egiptu', 0, 54),
(184, 'Honore de Balzac', 1, 55),
(185, 'Otac Goriot', 0, 56),
(186, 'Ana Karenjina', 0, 56),
(187, 'Zločin i kazna', 0, 56),
(188, 'Božanstvena komedija', 1, 56),
(189, 'Točno', 1, 57),
(190, 'Netočno', 0, 57),
(191, 'Točno', 0, 58),
(192, 'Netočno', 1, 58),
(193, 'Povratak Filipa Latinovicza', 0, 59),
(194, 'Gospoda Glembajevi', 0, 59),
(195, 'Leda', 0, 59),
(196, 'Tena', 1, 59),
(197, 'renesansa', 1, 60),
(198, 'realizam', 0, 60),
(199, 'barok', 0, 60),
(200, 'moderna', 0, 60),
(201, 'Paul', 0, 61),
(202, 'Jimmy', 0, 61),
(203, 'Holden', 1, 61),
(204, 'Mark', 0, 61),
(205, 'Točno', 1, 62),
(206, 'Netočno', 0, 62),
(207, 'Sanja Jovanović', 1, 63),
(208, 'Kina', 1, 64),
(209, '1492', 1, 65);

-- --------------------------------------------------------

--
-- Table structure for table `odgovorena_pitanja`
--

CREATE TABLE IF NOT EXISTS `odgovorena_pitanja` (
  `id_korisnik` int(11) NOT NULL,
  `id_pitanje` int(11) NOT NULL,
  `vrijeme` datetime NOT NULL,
  `tocno` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_korisnik`,`id_pitanje`,`vrijeme`),
  UNIQUE KEY `id_pitanja_UNIQUE` (`id_pitanje`,`id_korisnik`,`vrijeme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `odgovorena_pitanja`
--

INSERT INTO `odgovorena_pitanja` (`id_korisnik`, `id_pitanje`, `vrijeme`, `tocno`) VALUES
(3, 3, '2014-01-21 19:49:31', 1),
(3, 8, '2014-01-21 19:49:43', 0),
(3, 56, '2014-01-21 21:06:12', 1),
(3, 58, '2014-01-21 19:49:22', 1),
(3, 60, '2014-01-21 19:49:19', 1),
(3, 60, '2014-01-21 19:49:26', 1),
(3, 63, '2014-01-21 19:48:58', 1),
(3, 64, '2014-01-21 19:49:14', 1),
(3, 65, '2014-01-21 19:49:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pitanje`
--

CREATE TABLE IF NOT EXISTS `pitanje` (
  `id_pitanje` int(11) NOT NULL AUTO_INCREMENT,
  `tekst_pitanja` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vrsta_pitanja` int(11) NOT NULL,
  `bodovi_pitanja` int(11) NOT NULL,
  `ocjena_pitanja` int(11) NOT NULL DEFAULT '0',
  `jezik_pitanja` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `id_autor` int(11) NOT NULL,
  `odobreno_pitanje` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pitanje`),
  UNIQUE KEY `id_pitanje_UNIQUE` (`id_pitanje`),
  KEY `autor_idx` (`id_autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=66 ;

--
-- Dumping data for table `pitanje`
--

INSERT INTO `pitanje` (`id_pitanje`, `tekst_pitanja`, `vrsta_pitanja`, `bodovi_pitanja`, `ocjena_pitanja`, `jezik_pitanja`, `id_autor`, `odobreno_pitanje`) VALUES
(1, 'Koliko nogu imaju pauci?', 0, 30, 0, 'hr', 1, 1),
(2, 'Koje godine je započeo drugi svjetski rat?', 1, 4, 0, 'hr', 1, 1),
(3, 'Što nije standardna računalna oprema?', 0, 2, 0, 'hr', 1, 1),
(4, 'Panamski kanal pušten je u promet 1921. godine?', 0, 80, 0, 'hr', 1, 1),
(8, 'Izreka kaže da nikad nismo više od 5m udaljeni od pauka', 0, 10, 0, 'hr', 1, 1),
(9, 'Najviša životinja na kopnu je', 0, 20, 0, 'hr', 1, 1),
(10, 'Računalo koje je  11. svibnja 1997. pobijedilo Garija Kasparova u šahu zvalo se', 0, 45, 0, 'hr', 1, 1),
(11, 'Plavetni kit hrani se pretežno', 0, 34, 0, 'hr', 1, 1),
(12, 'Pluton je 1997. godine proglašen patuljastim planetom', 0, 10, 0, 'hr', 1, 1),
(13, 'Glavni grad Južnoafričke Republike je', 1, 60, 0, 'hr', 1, 1),
(14, 'Rick Deckard je glavni lik koje knjige?', 0, 55, 0, 'hr', 1, 1),
(15, 'Serijal "Policijska Akademija" broji koliko nastavaka?', 1, 40, 0, 'hr', 1, 1),
(16, 'Koji od ovih proizvođača vozila nije baziran u Europi?', 0, 35, 0, 'hr', 1, 1),
(17, 'Svjetsko nogometno prvenstvo 1998. godine osvojila je koja država?', 1, 30, 0, 'hr', 1, 1),
(18, 'Jerry, Cosmo i Elaine su susjedi u kojoj seriji?', 0, 20, 0, 'hr', 1, 1),
(19, 'Mariov brat zove se?', 0, 40, 0, 'hr', 1, 1),
(20, 'Vozač Formule 1 koji je osvojio naslov 2012. godine', 1, 55, 0, 'hr', 1, 1),
(21, 'Dolores O''Riordan je pjevačica grupe', 0, 45, 0, 'hr', 1, 1),
(22, 'Nizozemska rock grupa koja izvodi ''Mother Earth'' i ''Caged''', 0, 55, 0, 'hr', 1, 1),
(23, 'Reginald Kenneth Dwight poznatiji je kao?', 0, 65, 0, 'hr', 1, 1),
(24, 'Prvi umjetni satelit lansiran je 1957. godine a zvao se', 0, 60, 0, 'hr', 1, 1),
(25, 'Felix Baumgartner poznat je po', 0, 45, 0, 'hr', 1, 1),
(26, 'Frontman grupe U2', 1, 50, 0, 'hr', 1, 1),
(27, 'Emilie Autumn je?', 0, 65, 0, 'hr', 1, 1),
(28, 'Kako se zove Nintendova igrača konzola?', 0, 20, 0, 'hr', 2, 1),
(29, 'Glavni grad Bjelorusije je', 1, 40, 0, 'hr', 2, 1),
(30, 'Koje godine je otkrivena Amerika?', 1, 65, 0, 'hr', 2, 1),
(31, 'Koje od ovoga nije polje iz Monopoly-a?', 0, 40, 0, 'hr', 2, 1),
(32, 'Sedmerostruki svjetski prvak F1 je', 1, 25, 0, 'hr', 2, 1),
(33, 'Koja je momčad osvojila konstruktorski naslov F1 u 2009. godini?', 1, 50, 0, 'hr', 2, 1),
(36, 'Autor romana Zlatarovo zlato', 1, 40, 0, 'hr', 3, 1),
(37, 'Tko je napisao Kiklopa?', 0, 10, 0, '1', 1, 1),
(38, 'George Gaynes igra ulogu komadanta Lassarda, u kojem serijalu filmova?', 0, 50, 0, 'hr', 3, 1),
(39, 'Nastavite originalan naziv filma Harrison Forda: What lies...', 0, 50, 0, 'hr', 3, 1),
(40, 'Najveći kapacitet u Europi ima Camp Nou. U kojem gradu je, sa 90.000 mjesta, drugi po redu u Europi?', 0, 65, 0, 'hr', 3, 1),
(41, 'Koja pop zvijezda ima značajnu ulogu u filmu Bodyguard?', 0, 60, 0, 'hr', 3, 1),
(42, 'U koju zemlju je Rusija poslala 200.000 vojnika da spriječi nezavisnost više država?', 0, 80, 0, 'hr', 3, 1),
(43, 'Glavni grad Perua je...', 0, 20, 0, 'hr', 3, 1),
(44, 'Tko je napravio prvi telefonski poziv na Mjesec?', 0, 80, 0, 'hr', 3, 1),
(45, 'Prvi glavni grad drevnog Egipta bio je...', 0, 40, 0, 'hr', 3, 1),
(46, 'Gdje žive hobiti?', 0, 40, 0, 'hr', 3, 1),
(47, 'Koliko puta je Manchester United osvojio Ligu prvaka??', 0, 30, 0, 'hr', 3, 1),
(48, 'Tko je glumio James Bonda u "Diamonds are forever"?', 0, 40, 0, 'hr', 3, 1),
(49, 'U kojem filmu se pojavljuje Luke Skywalker?', 0, 30, 0, 'hr', 3, 1),
(50, 'Koji je glavni grad Armenije?', 0, 50, 0, 'hr', 3, 1),
(51, 'Čiji stadion je Allianz Arena?', 0, 20, 0, 'hr', 3, 1),
(52, 'Trenutno je glavni grad Berlin. Koji je grad bio glavni pri ujedinjenju Njemačke?', 0, 50, 0, 'hr', 3, 1),
(53, 'Koje godine je formiran NATO savez?', 0, 60, 0, 'hr', 3, 1),
(54, 'U kojoj zemlji su rođene Olimpijske igre?', 0, 20, 0, 'hr', 3, 1),
(55, 'Francuski romanopisac, autor romana Otac Goriot', 1, 10, 0, 'hr', 3, 1),
(56, 'Koje od slijedećih djela ne spada u razdoblje realizma?', 0, 8, 0, 'hr', 3, 1),
(57, 'Carlo Goldoni autor je komedije Gostioničarka Mirandolina.', 0, 6, 0, 'hr', 3, 1),
(58, 'Henrik Ibsen danski je dramatičar i autor tragične farse Stolice.', 0, 10, 0, 'hr', 3, 1),
(59, 'Koje od slijedećih djela nije napisao Miroslav Krleža?', 0, 15, 0, 'hr', 3, 1),
(60, 'Kojem razdoblju pripada pjesnik i dramatičar Hanibal Lucić?', 0, 10, 0, 'hr', 3, 1),
(61, 'Kako se zove glavni lik romana Lovac u žitu autora J.D.Salingera?', 0, 10, 0, 'hr', 3, 1),
(62, 'Dora Krupićeva lik je romana Zlatarovo zlato.', 0, 8, 0, 'hr', 3, 1),
(63, 'Najuspješnija hrvatska plivačica zove se', 1, 10, 0, 'hr', 3, 1),
(64, 'Koja je najmnogoljudnija zemlja na svijetu?', 1, 2, 0, 'hr', 3, 1),
(65, 'Koje je godine otkrivena Amerika?', 1, 5, 0, 'hr', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pitanje_kategorija`
--

CREATE TABLE IF NOT EXISTS `pitanje_kategorija` (
  `id_pitanje` int(11) NOT NULL,
  `id_kategorija` int(11) NOT NULL,
  PRIMARY KEY (`id_pitanje`,`id_kategorija`),
  UNIQUE KEY `id_pitanje` (`id_pitanje`,`id_kategorija`),
  UNIQUE KEY `id_kategorija_UNIQUE` (`id_kategorija`,`id_pitanje`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pitanje_kategorija`
--

INSERT INTO `pitanje_kategorija` (`id_pitanje`, `id_kategorija`) VALUES
(1, 14),
(2, 5),
(3, 8),
(4, 5),
(4, 6),
(8, 4),
(9, 14),
(10, 8),
(11, 14),
(12, 7),
(13, 6),
(14, 12),
(15, 10),
(16, 4),
(17, 13),
(18, 10),
(19, 11),
(20, 13),
(21, 9),
(22, 9),
(23, 9),
(24, 7),
(25, 3),
(26, 9),
(27, 9),
(28, 8),
(29, 6),
(30, 5),
(31, 11),
(32, 13),
(33, 13),
(36, 12),
(38, 10),
(39, 10),
(40, 13),
(41, 10),
(42, 5),
(43, 6),
(44, 2),
(45, 6),
(46, 4),
(47, 13),
(48, 10),
(49, 10),
(50, 6),
(51, 13),
(52, 5),
(53, 5),
(54, 5),
(55, 12),
(56, 12),
(57, 12),
(58, 12),
(59, 12),
(60, 12),
(61, 12),
(62, 12),
(63, 13),
(64, 6),
(65, 5);

-- --------------------------------------------------------

--
-- Table structure for table `rezultat`
--

CREATE TABLE IF NOT EXISTS `rezultat` (
  `id_korisnik` int(11) NOT NULL,
  `id_mode` int(11) NOT NULL,
  `rezultat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_korisnik`,`id_mode`),
  UNIQUE KEY `id_mode_UNIQUE` (`id_mode`,`id_korisnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rezultat`
--

INSERT INTO `rezultat` (`id_korisnik`, `id_mode`, `rezultat`) VALUES
(2, 0, 2896),
(3, 0, 57),
(5, 0, 350),
(7, 0, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `posiljatelj` FOREIGN KEY (`id_posiljatelj`) REFERENCES `korisnik` (`id_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `primatelj` FOREIGN KEY (`id_primatelj`) REFERENCES `korisnik` (`id_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD CONSTRAINT `nadkategorija` FOREIGN KEY (`nadkategorija`) REFERENCES `kategorija` (`id_kategorija`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `korisnik_dostignuce`
--
ALTER TABLE `korisnik_dostignuce`
  ADD CONSTRAINT `dostignuce` FOREIGN KEY (`id_dostignuce`) REFERENCES `dostignuce` (`id_dostignuce`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `korisnik_dost` FOREIGN KEY (`id_korisnik`) REFERENCES `korisnik` (`id_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lista_prijatelja`
--
ALTER TABLE `lista_prijatelja`
  ADD CONSTRAINT `prijatelj` FOREIGN KEY (`id_prijatelj`) REFERENCES `korisnik` (`id_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vlasnik` FOREIGN KEY (`id_vlasnik`) REFERENCES `korisnik` (`id_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odgovor`
--
ALTER TABLE `odgovor`
  ADD CONSTRAINT `odgovor_na` FOREIGN KEY (`id_pitanje`) REFERENCES `pitanje` (`id_pitanje`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odgovorena_pitanja`
--
ALTER TABLE `odgovorena_pitanja`
  ADD CONSTRAINT `odg_korisnik` FOREIGN KEY (`id_korisnik`) REFERENCES `korisnik` (`id_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `odg_pitanje` FOREIGN KEY (`id_pitanje`) REFERENCES `pitanje` (`id_pitanje`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pitanje`
--
ALTER TABLE `pitanje`
  ADD CONSTRAINT `autor` FOREIGN KEY (`id_autor`) REFERENCES `korisnik` (`id_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pitanje_kategorija`
--
ALTER TABLE `pitanje_kategorija`
  ADD CONSTRAINT `kategorija` FOREIGN KEY (`id_kategorija`) REFERENCES `kategorija` (`id_kategorija`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pitanje` FOREIGN KEY (`id_pitanje`) REFERENCES `pitanje` (`id_pitanje`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rezultat`
--
ALTER TABLE `rezultat`
  ADD CONSTRAINT `korisnik` FOREIGN KEY (`id_korisnik`) REFERENCES `korisnik` (`id_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mode` FOREIGN KEY (`id_mode`) REFERENCES `mode` (`id_mode`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
