-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Sze 15. 14:20
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `hasznalt_autok`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `brands`
--

INSERT INTO `brands` (`id`, `name`, `country`, `logo`, `description`, `active`, `created_at`, `updated_at`) VALUES
(5, 'Trabant', 'Németország', 'USB2OpVAy2VGxDjT8zczZmb8G85fVrNipfyxVcsQ.jpg', 'Németországi Retró csoda', 1, '2025-09-15 06:42:17', '2025-09-15 06:42:17'),
(6, 'Audi', 'Németország', 'WGEu1Oy3t4pTtcJ7DDy34SyLpNml3t4qEz7h3ckM.jpg', 'Németországi prémium autó.', 1, '2025-09-15 06:48:51', '2025-09-15 06:48:51');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cars`
--

CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `marka` varchar(255) NOT NULL,
  `modell` varchar(255) NOT NULL,
  `evjarat` int(11) NOT NULL,
  `ar` int(11) NOT NULL,
  `km_ora` int(11) NOT NULL,
  `teljesitmeny` int(11) NOT NULL,
  `uzemanyag` varchar(255) NOT NULL,
  `valto` varchar(255) NOT NULL,
  `szin` varchar(255) NOT NULL,
  `karosszeria` varchar(255) NOT NULL,
  `leiras` text DEFAULT NULL,
  `extrak` varchar(255) DEFAULT NULL,
  `kep` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `cars`
--

INSERT INTO `cars` (`id`, `user_id`, `marka`, `modell`, `evjarat`, `ar`, `km_ora`, `teljesitmeny`, `uzemanyag`, `valto`, `szin`, `karosszeria`, `leiras`, `extrak`, `kep`, `created_at`, `updated_at`) VALUES
(11, 3, 'Trabant', '601', 1970, 2500000, 22000, 26, 'Benzin', 'manuális', 'Zöld', 'Sedan', 'Eladó egy igazi retró Trabi.', NULL, '1757925885_Trabbi_601-S_3828.jpg', '2025-09-15 06:44:45', '2025-09-15 06:44:45'),
(12, 6, 'Trabant', '601', 1990, 1500000, 720000, 26, 'Benzin', 'manuális', 'Kék', 'Sedan', 'Eladó egy Trabant', NULL, '1757925953_letöltés (1).jpg', '2025-09-15 06:45:53', '2025-09-15 06:45:53');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `car_images`
--

CREATE TABLE `car_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `car_images`
--

INSERT INTO `car_images` (`id`, `car_id`, `path`, `created_at`, `updated_at`) VALUES
(16, 11, '1757925885_Trabbi_601-S_3828.jpg', '2025-09-15 06:44:45', '2025-09-15 06:44:45'),
(17, 12, '1757925953_letöltés (1).jpg', '2025-09-15 06:45:53', '2025-09-15 06:45:53'),
(18, 12, '1757925953_letöltés (2).jpg', '2025-09-15 06:45:53', '2025-09-15 06:45:53'),
(19, 12, '1757925953_letöltés.jpg', '2025-09-15 06:45:53', '2025-09-15 06:45:53');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `car_models`
--

CREATE TABLE `car_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `car_models`
--

INSERT INTO `car_models` (`id`, `brand_id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(11, 5, 'P70', 1, '2025-09-15 06:43:02', '2025-09-15 06:43:02'),
(12, 5, 'P50', 1, '2025-09-15 06:43:07', '2025-09-15 06:43:07'),
(13, 5, '500', 1, '2025-09-15 06:43:11', '2025-09-15 06:43:11'),
(14, 5, '600', 1, '2025-09-15 06:43:15', '2025-09-15 06:43:15'),
(15, 5, '601', 1, '2025-09-15 06:43:19', '2025-09-15 06:43:19'),
(16, 5, '1.1', 1, '2025-09-15 06:43:24', '2025-09-15 06:43:24'),
(17, 5, 'Nt', 1, '2025-09-15 06:43:29', '2025-09-15 06:43:29');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `car_id`, `created_at`, `updated_at`) VALUES
(3, 3, 11, '2025-09-15 09:42:13', '2025-09-15 09:42:13');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `reply_to` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `car_id`, `message`, `read`, `reply_to`, `created_at`, `updated_at`) VALUES
(5, 3, 6, 12, 'Szia érdekelne', 1, NULL, '2025-09-15 07:48:10', '2025-09-15 07:51:10'),
(6, 6, 3, 12, 'Oké, az adatok:', 1, 5, '2025-09-15 07:48:41', '2025-09-15 07:51:39'),
(7, 6, 3, 11, 'hello meg van?', 1, NULL, '2025-09-15 09:15:37', '2025-09-15 09:16:25');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_09_06_134100_create_users_table', 1),
(2, '2025_09_06_134138_create_brands_table', 1),
(3, '2025_09_06_134145_create_car_models_table', 1),
(4, '2025_09_06_134155_create_cars_table', 1),
(5, '2025_09_06_134201_create_car_images_table', 1),
(6, '2025_09_06_134208_create_messages_table', 1),
(7, '2025_09_06_134215_create_favorites_table', 1),
(8, '2025_09_06_141905_add_kep_to_cars_table', 1),
(9, '2025_09_14_094036_add_role_to_users_table', 2),
(10, '2025_09_15_094341_add_read_at_to_messages_table', 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `role`, `password`, `bio`, `is_admin`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'larcsika', 'sipos.lauren@gmail.com', 'user', '$2y$12$mzHsVukEdFFVn45DQETcyukUQr72vFQLR0GBgdZOndDVY9.y2tHdW', 'Laura vagyok, 29 éves, gyógyszerész.', 0, 1, NULL, '2025-09-07 10:27:39', '2025-09-07 10:27:39'),
(2, 'gery576', 'gery576@gmail.com', 'user', '$2y$12$EYHAD9AU5pdVa99zZBGJyOpQG7iy9n6ojM.S4OkbUWHqhLAPaKa2O', 'Kereskedő vagyok Bp-en.', 0, 1, NULL, '2025-09-07 10:29:29', '2025-09-07 10:29:29'),
(3, 'teszt', 'teszt@teszt.com', 'user', '$2y$12$shG.jQxie3QpZJ7fABTIH.BayrZvlWpdsi4O.usA0pxxfecV07ABq', 'teszt user vagyok', 0, 1, NULL, '2025-09-14 07:05:05', '2025-09-14 07:05:05'),
(4, 'admin', 'admin@admin.com', 'admin', '$2y$12$rN/GZC7ITxvjb4jmRhyP3e8DiD8EB2V4AnguAWl6B2HlXXBG2mE9C', 'Admin user vagyok', 0, 1, NULL, '2025-09-14 07:43:12', '2025-09-14 07:43:12'),
(6, 'teszt2', 'teszt@valaki.hu', 'user', '$2y$12$kj8G4SW2ttSVu79ZIRWfH.2IvQWaXmD5iUkPnm/it/QwnPwJf6OmG', 'Ez egy másik teszt user', 0, 1, NULL, '2025-09-15 04:05:46', '2025-09-15 04:05:46');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- A tábla indexei `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cars_user_id_foreign` (`user_id`);

--
-- A tábla indexei `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_images_car_id_foreign` (`car_id`);

--
-- A tábla indexei `car_models`
--
ALTER TABLE `car_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_models_brand_id_foreign` (`brand_id`);

--
-- A tábla indexei `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_car_id_unique` (`user_id`,`car_id`),
  ADD KEY `favorites_car_id_foreign` (`car_id`);

--
-- A tábla indexei `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`),
  ADD KEY `messages_car_id_foreign` (`car_id`),
  ADD KEY `messages_reply_to_foreign` (`reply_to`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `car_images`
--
ALTER TABLE `car_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT a táblához `car_models`
--
ALTER TABLE `car_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT a táblához `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `car_images_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `car_models`
--
ALTER TABLE `car_models`
  ADD CONSTRAINT `car_models_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_reply_to_foreign` FOREIGN KEY (`reply_to`) REFERENCES `messages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
