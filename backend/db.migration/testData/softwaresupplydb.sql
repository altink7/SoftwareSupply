-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Jul 2023 um 12:40
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `softwaresupplydb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(93, 3, 1, 1, '2023-06-30 17:57:59', '2023-06-30 17:57:59');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `user_fk` int(11) DEFAULT NULL,
  `order_fk` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `invoice`
--

INSERT INTO `invoice` (`id`, `user_fk`, `order_fk`, `created_at`) VALUES
(1, 13, 47, '2023-06-30 17:35:01'),
(2, 13, 48, '2023-06-30 20:42:29'),
(3, 13, 49, '2023-06-30 20:50:35'),
(5, 13, 51, '2023-07-01 19:45:31'),
(6, 13, 52, '2023-07-01 19:49:41'),
(7, 15, 53, '2023-07-01 19:51:33'),
(8, 13, 54, '2023-07-02 09:50:03');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_fk` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL,
  `voucher` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `order`
--

INSERT INTO `order` (`id`, `user_fk`, `created`, `updated`, `total`, `voucher`) VALUES
(47, 13, '2023-06-30 17:35:01', '2023-07-01 09:14:39', '25.00', '2.50'),
(48, 13, '2023-06-30 20:42:29', '2023-06-30 20:42:29', '715.00', '0.00'),
(49, 13, '2023-06-30 20:50:35', '2023-07-01 09:27:13', '1352.00', '270.40'),
(51, 13, '2023-07-01 19:45:31', '2023-07-01 19:45:31', '83.00', '8.30'),
(52, 13, '2023-07-01 19:49:41', '2023-07-01 19:49:41', '528.00', '52.80'),
(53, 15, '2023-07-01 19:51:33', '2023-07-01 19:51:33', '518.00', '51.80'),
(54, 13, '2023-07-02 09:50:03', '2023-07-02 09:50:03', '149.00', '14.90');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order_position`
--

CREATE TABLE `order_position` (
  `position_id` int(11) NOT NULL,
  `order_fk` int(11) DEFAULT NULL,
  `product_fk` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_position_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `order_position`
--

INSERT INTO `order_position` (`position_id`, `order_fk`, `product_fk`, `price`, `quantity`, `total_position_price`) VALUES
(80, 47, 2, '25.00', 1, '25.00'),
(81, 48, 4, '15.00', 5, '75.00'),
(82, 48, 2, '25.00', 7, '175.00'),
(83, 48, 1, '39.00', 9, '351.00'),
(84, 48, 3, '19.00', 6, '114.00'),
(85, 49, 1, '39.00', 10, '390.00'),
(86, 49, 9, '40.00', 7, '280.00'),
(87, 49, 5, '15.00', 1, '15.00'),
(88, 49, 6, '20.00', 7, '140.00'),
(89, 49, 7, '60.00', 1, '60.00'),
(90, 49, 8, '30.00', 1, '30.00'),
(91, 49, 4, '15.00', 4, '60.00'),
(92, 49, 3, '19.00', 8, '152.00'),
(93, 49, 2, '25.00', 9, '225.00'),
(97, 51, 2, '25.00', 1, '25.00'),
(98, 51, 1, '39.00', 1, '39.00'),
(99, 51, 3, '19.00', 1, '19.00'),
(100, 52, 1, '39.00', 5, '195.00'),
(101, 52, 2, '25.00', 8, '200.00'),
(102, 52, 3, '19.00', 7, '133.00'),
(103, 53, 1, '39.00', 7, '273.00'),
(104, 53, 2, '25.00', 6, '150.00'),
(105, 53, 3, '19.00', 5, '95.00'),
(106, 54, 2, '25.00', 4, '100.00'),
(107, 54, 3, '19.00', 1, '19.00'),
(108, 54, 8, '30.00', 1, '30.00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  `description` varchar(5000) CHARACTER SET utf16 COLLATE utf16_general_ci DEFAULT NULL,
  `price` double NOT NULL,
  `review` int(1) DEFAULT NULL,
  `fk_customer` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` enum('tools','multimedia','business','other') DEFAULT NULL,
  `image_url` varchar(25) DEFAULT 'software'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `product`
--

INSERT INTO `product` (`id`, `title`, `description`, `price`, `review`, `fk_customer`, `date`, `category`, `image_url`) VALUES
(1, 'Microsoft Office', 'Für die ausgiebige Texterstellung, für beeindruckende Präsentationen oder umfassende Tabellenkalkulation stellt Microsoft Office Home and Student 2021 seit vielen Jahren die optimale Wahl dar.', 39, 5, 3, '2023-06-14 18:29:10', 'business', 'microsoftoffice'),
(2, 'IntelliJ Idea Ultimate', 'IntelliJ IDEA ist die führende IDE für die Java- und Kotlin-Entwicklung. IntelliJ IDEA unterstützt Ihre Produktivität mit einer Reihe von effizienzsteigernden Funktionen, integrierte Entwicklungstools, Unterstützung für die Web- und Enterprise-Entwicklung und noch einiges mehr umfassen.', 25, 4, 3, '2023-06-14 18:32:00', 'tools', 'intellijultimate'),
(3, 'Visual Studio Code Premium', 'Es bietet integrierte Unterstützung für JavaScript, TypeScript und Node.js und verfügt über ein umfangreiches Ökosystem von Erweiterungen für andere Sprachen und Laufzeiten (z. B. C++, C#, Java, Python, PHP, Go, .NET).', 19, 3, 3, '2023-06-14 18:33:55', 'tools', 'vscode'),
(4, 'Xcode Ultimate Version', 'Xcode ist eine integrierte Entwicklungsumgebung von Apple für macOS. Mit ihr lassen sich Programme für macOS, iPadOS, iOS, watchOS und tvOS entwickeln. Xcode ist für die Programmiersprachen Swift und Objective-C unter Verwendung der Cocoa-Frameworks gedacht.', 15, 4, 3, '2023-06-14 18:38:34', 'tools', 'xcodeultimate'),
(5, 'Ventura Mac OS', 'Das neue macOS erkennt das iPhone automatisch und verbindet sich drahtlos damit. Nutze so clevere Features wie den Folgemodus und profitiere mit Studiolicht von einer optimalen Ausleuchtung des Gesichts. Das ermöglicht nun auch „Desk View“.', 15, 3, 3, '2023-06-14 18:44:00', 'multimedia', 'venturamacosx'),
(6, 'Adobe ', 'Adobe Reader ist die kostenlose, bewährte Standardlösung für die Anzeige, Druckausgabe, Unterzeichnung und Kommentierung von PDF-Dokumenten', 20, 4, 3, '2023-06-14 18:46:48', 'multimedia', 'adobe'),
(7, 'Avira Antivirenschutz', 'Die Browser-Erweiterung Avira Browserschutz für Chrome, Firefox und Opera blockiert gefährliche und Phishing-Webseiten, Werbeanzeigen und Online-Tracking. Mit unserem kostenlosen Antivirus für Windows können Sie sich und Ihre Geräte vor Viren, Ransomware, Banking-Trojanern und allen anderen Malware-Arten schützen', 60, 0, 3, '2023-06-14 18:49:12', 'other', 'avira'),
(8, 'XAMPP ', 'XAMPP ist die Kombination des Apache Webservers, der Datenbank MySQL und der Skriptsprachen Perl und PHP. Mit XAMPP ist es möglich, in wenigen Schritten einen eigenen Webserver mit all seinen Komponenten auf Ihrem lokalen Rechner zu installieren.', 30, 0, 3, '2023-06-14 18:50:02', 'other', 'xampp'),
(9, 'Windows', 'Windows steht übersetzt für \"Fenster\" und genau das soll das Betriebssystem auch sei: ein Fenster zu Ihrem Rechner. Mithilfe eines Betriebssystems kommunizieren Sie mit Ihrem PC. Dabei fungiert das Betriebssystem als Schnittstelle zwischen Ihren und Ihrer Hardware.', 40, 0, 3, '2023-06-14 18:51:15', 'business', 'windowsos');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `salutation` enum('Herr','Frau','Divers') NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postal_code` varchar(4) NOT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `isAdmin` tinyint(1) DEFAULT NULL,
  `payment` enum('Credit card','PayPal','Klarna','none') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `salutation`, `first_name`, `last_name`, `address`, `postal_code`, `city`, `email`, `username`, `password`, `created_at`, `isAdmin`, `payment`) VALUES
(3, '', 'admin', 'admin', 'softwarestrasse 12', '1100', 'wien', 'admin@software.at', 'altin', '$2y$10$/uqX3CyNFpsTgqN81h/cpOvSNdCRU.N2L3ovnX0kDFeo4GFeBWuqK', '2023-06-06 17:20:02', 1, 'Credit card'),
(13, 'Herr', 'User', 'Mustermann', 'musterstrasse 12', '1234', 'wien', 'max@muster.at', 'julian', '$2y$10$/uqX3CyNFpsTgqN81h/cpOvSNdCRU.N2L3ovnX0kDFeo4GFeBWuqK', '2023-06-20 16:33:21', NULL, 'PayPal'),
(15, 'Herr', 'altin', 'kelmendi', 'Software Strasse 12', '1100', 'Wien', 'altin@altin.at', 'altin07', '$2y$10$XVrUY7vAdLP53FNNsFuR/OUyqIjOkKQW75CYgvNdXDSYVU2LLo456', '2023-07-01 19:50:26', NULL, 'PayPal');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_fk` (`user_fk`),
  ADD KEY `fk_order_fk` (`order_fk`);

--
-- Indizes für die Tabelle `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_fk` (`user_fk`);

--
-- Indizes für die Tabelle `order_position`
--
ALTER TABLE `order_position`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `order_id` (`order_fk`),
  ADD KEY `product_id` (`product_fk`);

--
-- Indizes für die Tabelle `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_customer` (`fk_customer`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT für Tabelle `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT für Tabelle `order_position`
--
ALTER TABLE `order_position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT für Tabelle `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_order_fk` FOREIGN KEY (`order_fk`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `fk_user_fk` FOREIGN KEY (`user_fk`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_fk`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `order_position`
--
ALTER TABLE `order_position`
  ADD CONSTRAINT `order_position_ibfk_1` FOREIGN KEY (`order_fk`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_position_ibfk_2` FOREIGN KEY (`product_fk`) REFERENCES `product` (`id`);

--
-- Constraints der Tabelle `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_customer` FOREIGN KEY (`fk_customer`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
