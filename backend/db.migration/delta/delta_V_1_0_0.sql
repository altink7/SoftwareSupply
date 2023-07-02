
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
-- Tabellenstruktur für Tabelle `invoice`
--

CREATE TABLE `invoice` (
                           `id` int(11) NOT NULL,
                           `user_fk` int(11) DEFAULT NULL,
                           `order_fk` int(11) DEFAULT NULL,
                           `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order`
--

CREATE TABLE `order` (
                         `id` int(11) NOT NULL,
                         `user_fk` int(11) DEFAULT NULL,
                         `created` timestamp NOT NULL DEFAULT current_timestamp(),
                         `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                         `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- AUTO_INCREMENT für Tabelle `cart`
--
ALTER TABLE `cart`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT für Tabelle `invoice`
--
ALTER TABLE `invoice`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `order`
--
ALTER TABLE `order`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT für Tabelle `order_position`
--
ALTER TABLE `order_position`
    MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT für Tabelle `product`
--
ALTER TABLE `product`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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