-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: 25 дек 2016 в 03:09
-- Версия на сървъра: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `matchme`
--

-- --------------------------------------------------------

--
-- Структура на таблица `activation_codes`
--

CREATE TABLE `activation_codes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура на таблица `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `ad_1` text NOT NULL,
  `ad_2` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `ads`
--

INSERT INTO `ads` (`id`, `ad_1`, `ad_2`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Структура на таблица `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура на таблица `filters`
--

CREATE TABLE `filters` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sexual_preference` int(11) NOT NULL,
  `country` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `order_by` int(11) NOT NULL,
  `sexual_orientation` int(11) NOT NULL,
  `age_range` varchar(20) NOT NULL,
  `distance_range` varchar(20) NOT NULL,
  `location_dating` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `filters`
--

INSERT INTO `filters` (`id`, `user_id`, `sexual_preference`, `country`, `city`, `order_by`, `sexual_orientation`, `age_range`, `distance_range`, `location_dating`) VALUES
(9, 20, 3, 'All Countries', '', 2, 1, '16,100', '0,500', 0),
(10, 12, 3, 'Egypt', '', 2, 1, '', '', 0),
(11, 19, 3, 'All Countries', '', 2, 1, '16,100', '0,500', 0),
(13, 20, 3, 'All Countries', '', 2, 1, '16,100', '0,500', 0),
(14, 20, 3, 'All Countries', '', 2, 1, '16,100', '0,500', 0),
(15, 20, 3, 'All Countries', '', 2, 1, '16,100', '0,500', 0),
(25, 121, 3, 'All Countries', '', 3, 1, '18,23', '0,500 ', 0),
(26, 316, 3, 'United States', '', 3, 1, '17,25', '0,500', 0);

-- --------------------------------------------------------

--
-- Структура на таблица `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `accepted` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `user1`, `user2`, `time`, `accepted`) VALUES
(1, 121, 20, 1452539954, 1),
(2, 12, 20, 1452908537, 1),
(3, 12, 121, 1476667925, 0);

-- --------------------------------------------------------

--
-- Структура на таблица `gifts`
--

CREATE TABLE `gifts` (
  `id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Схема на данните от таблица `gifts`
--

INSERT INTO `gifts` (`id`, `user1`, `user2`, `path`, `time`) VALUES
(1, 20, 12, '26.png', 1456263594),
(4, 20, 12, '9.png', 1456263815),
(5, 20, 12, '8.png', 1456263821),
(6, 20, 12, '21.png', 1456263828),
(7, 20, 121, '10.png', 1456266041),
(8, 20, 121, '13.png', 1456266148),
(9, 20, 190, '18.png', 1456266163),
(10, 20, 186, '26.png', 1456266174),
(11, 20, 192, '5.png', 1456266182),
(12, 20, 218, '2.png', 1456322306),
(13, 20, 218, '4.png', 1456322309),
(14, 20, 220, '11.png', 1456322332),
(15, 20, 220, '14.png', 1456322334),
(16, 20, 222, '26.png', 1456322345),
(17, 20, 222, '15.png', 1456322355),
(18, 20, 223, '5.png', 1456322368),
(19, 20, 219, '16.png', 1456322375),
(20, 20, 219, '17.png', 1456322379),
(21, 20, 0, '12.png', 1473207538),
(23, 20, 0, '21.png', 1473219303),
(24, 20, 121, '21.png', 1473219417),
(25, 20, 121, '9.png', 1473219718),
(26, 20, 121, '11.png', 1473220080),
(27, 20, 121, '2.png', 1473257648),
(28, 20, 121, '5.png', 1475168559),
(29, 20, 121, '17.png', 1475181430),
(30, 121, 12, '3.png', 1475833757),
(60, 121, 20, '12.png', 1476574173),
(61, 121, 19, '12.png', 1476583011);

-- --------------------------------------------------------

--
-- Структура на таблица `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` text,
  `user1` int(11) DEFAULT NULL,
  `user2` int(11) DEFAULT NULL,
  `is_sticker` int(11) DEFAULT NULL,
  `is_photo` int(11) DEFAULT NULL,
  `sticker_id` int(11) DEFAULT NULL,
  `photo_path` varchar(100) DEFAULT NULL,
  `is_promoted` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `messages`
--

INSERT INTO `messages` (`id`, `message`, `user1`, `user2`, `is_sticker`, `is_photo`, `sticker_id`, `photo_path`, `is_promoted`, `time`) VALUES
(75, 'Hey, how are you doing?', 20, 121, 0, 0, 0, '', 0, 1476063716),
(76, 'Not much, you?', 121, 20, 0, 0, 0, '', 0, 1476063716),
(77, 'Just chillin. You free tonight?', 20, 121, 0, 0, 0, '', 0, 1476063716),
(78, 'Hey there!', 19, 121, 0, 0, 0, '', 0, 1476063716),
(79, 'How are you?', 19, 121, 0, 0, 0, '', 0, 1476063716),
(80, 'You look very pretty.', 19, 121, 0, 0, 0, '', 0, 1476063716),
(87, '', 121, 20, 1, 0, 15, '', 0, 1476063716),
(91, 'Hehe', 121, 20, 0, 0, 0, '', 0, 1476574418),
(92, 'Thank you!', 121, 19, 0, 0, 0, '', 0, 1476574434),
(93, '', 121, 19, 1, 0, 14, '', 0, 1476574444),
(103, 'Happy holidays!', 121, 12, 0, 0, 0, NULL, NULL, 1482596190),
(104, '', 121, 12, 1, 0, 14, NULL, NULL, 1482596207);

-- --------------------------------------------------------

--
-- Структура на таблица `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `content` varchar(100) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  `is_read` int(11) NOT NULL,
  `is_screen` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `notifications`
--

INSERT INTO `notifications` (`id`, `receiver_id`, `url`, `content`, `icon`, `time`, `is_read`, `is_screen`) VALUES
(1, 316, 'user/121', '<b>Nathalie</b> liked your profile', 'icon icon-heart', 1476660884, 0, 0),
(2, 334, 'user/121', '<b>Nathalie</b> liked your profile', 'icon icon-heart', 1476660885, 0, 0),
(3, 20, 'user/121', '<b>Nathalie</b> liked your profile', 'icon icon-heart', 1476660886, 0, 1),
(4, 351, 'user/121', '<b>Nathalie</b> liked your profile', 'icon icon-heart', 1476660892, 0, 0),
(5, 325, 'user/121', '<b>Nathalie</b> liked your profile', 'icon icon-heart', 1476660894, 0, 0),
(6, 336, 'user/121', '<b>Nathalie</b> liked your profile', 'icon icon-heart', 1476660895, 0, 0),
(7, 121, 'user/12', '<b>Madison</b> sent you a friend request', 'icon icon-bubble', 1476667925, 0, 1),
(9, 12, 'user/20', '<b>Dave</b> liked your profile', 'icon icon-heart', 1476775910, 0, 1),
(10, 316, 'user/20', '<b>Dave</b> liked your profile', 'icon icon-heart', 1476775911, 0, 0),
(11, 250, 'user/20', '<b>Dave</b> liked your profile', 'icon icon-heart', 1476778779, 0, 0),
(12, 317, 'user/20', '<b>Dave</b> liked your profile', 'icon icon-heart', 1476778785, 0, 0),
(13, 121, 'user/12', '<b>Madison</b> messaged you', 'icon icon-bubble', 1482064358, 0, 0),
(14, 121, 'user/12', '<b>Madison</b> messaged you', 'icon icon-bubble', 1482064380, 0, 0),
(15, 121, 'user/12', '<b>Madison</b> messaged you', 'icon icon-bubble', 1482064380, 0, 0),
(16, 121, 'user/12', '<b>Madison</b> messaged you', 'icon icon-bubble', 1482064381, 0, 0),
(17, 121, 'user/12', '<b>Madison</b> messaged you', 'icon icon-bubble', 1482064381, 0, 0),
(18, 250, 'user/12', '<b>Madison</b> messaged you', 'icon icon-bubble', 1482064412, 0, 0),
(19, 12, 'user/121', '<b>Nathalie</b> messaged you', 'icon icon-bubble', 1482596190, 0, 0),
(20, 12, 'user/121', 'Sent a sticker', 'icon icon-bubble', 1482596207, 0, 0);

-- --------------------------------------------------------

--
-- Структура на таблица `owned_sticker_packs`
--

CREATE TABLE `owned_sticker_packs` (
  `id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `owned_sticker_packs`
--

INSERT INTO `owned_sticker_packs` (`id`, `pack_id`, `user_id`) VALUES
(1, 1, 121);

-- --------------------------------------------------------

--
-- Структура на таблица `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_title` text NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `pages`
--

INSERT INTO `pages` (`id`, `page_title`, `content`) VALUES
(1, 'Terms of Service', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. \r\n\r\nLorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. \r\n\r\nIt has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. \r\n\r\nIt was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(2, 'About Us', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. \r\n\r\nLorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. \r\n\r\nIt has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. \r\n\r\nIt was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');

-- --------------------------------------------------------

--
-- Структура на таблица `plugins`
--

CREATE TABLE `plugins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `version` varchar(10) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `path` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `plugins`
--

INSERT INTO `plugins` (`id`, `name`, `author`, `version`, `icon`, `path`, `is_active`) VALUES
(2, 'Mass Email', 'Condor5', '2.7', 'fa-envelope', 'mass_email', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `profile_dislikes`
--

CREATE TABLE `profile_dislikes` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `viewer_id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура на таблица `profile_likes`
--

CREATE TABLE `profile_likes` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `viewer_id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `profile_likes`
--

INSERT INTO `profile_likes` (`id`, `profile_id`, `viewer_id`, `time`) VALUES
(2, 12, 20, 1476775910),
(3, 316, 20, 1476775911),
(4, 250, 20, 1476778779),
(5, 317, 20, 1476778785);

-- --------------------------------------------------------

--
-- Структура на таблица `profile_views`
--

CREATE TABLE `profile_views` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `viewer_id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `profile_views`
--

INSERT INTO `profile_views` (`id`, `profile_id`, `viewer_id`, `time`) VALUES
(1, 12, 121, 1476368557),
(2, 317, 121, 1476369722),
(3, 20, 121, 1476370084),
(4, 316, 121, 1476371058),
(5, 0, 121, 1476390965),
(6, 19, 121, 1476409063),
(7, 121, 121, 1476409502),
(8, 250, 121, 1476415507),
(9, 316, 12, 1476638350),
(10, 121, 12, 1476638354),
(11, 12, 12, 1476638356),
(12, 19, 12, 1476638357),
(13, 250, 12, 1476638358),
(14, 317, 350, 1476639259),
(15, 350, 121, 1476639723),
(16, 316, 353, 1476645542),
(17, 250, 353, 1476645576),
(18, 351, 121, 1476646580),
(19, 332, 121, 1476655969),
(20, 334, 121, 1481416616);

-- --------------------------------------------------------

--
-- Структура на таблица `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `fortumo_service_id` varchar(50) NOT NULL,
  `paypal_email` varchar(20) NOT NULL,
  `stripe_secret_key` varchar(50) NOT NULL,
  `stripe_publishable_key` varchar(50) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `credits_price_100` int(11) NOT NULL,
  `credits_price_500` int(11) NOT NULL,
  `credits_price_1000` int(11) NOT NULL,
  `credits_price_1500` int(11) NOT NULL,
  `gift_price` int(11) NOT NULL,
  `feature_price` int(11) NOT NULL,
  `sticker_pack_price` int(11) NOT NULL,
  `vip_1_month` int(11) NOT NULL,
  `vip_3_months` int(11) NOT NULL,
  `vip_6_months` int(11) NOT NULL,
  `facebook_link` varchar(100) NOT NULL,
  `twitter_link` varchar(100) NOT NULL,
  `google_plus_link` varchar(100) NOT NULL,
  `email_sender` varchar(100) NOT NULL,
  `smtp_host` varchar(100) NOT NULL,
  `smtp_username` varchar(100) NOT NULL,
  `smtp_password` varchar(100) NOT NULL,
  `smtp_encryption` varchar(100) NOT NULL,
  `smtp_port` varchar(10) NOT NULL,
  `winter_theme` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `settings`
--

INSERT INTO `settings` (`id`, `fortumo_service_id`, `paypal_email`, `stripe_secret_key`, `stripe_publishable_key`, `currency`, `credits_price_100`, `credits_price_500`, `credits_price_1000`, `credits_price_1500`, `gift_price`, `feature_price`, `sticker_pack_price`, `vip_1_month`, `vip_3_months`, `vip_6_months`, `facebook_link`, `twitter_link`, `google_plus_link`, `email_sender`, `smtp_host`, `smtp_username`, `smtp_password`, `smtp_encryption`, `smtp_port`, `winter_theme`) VALUES
(1, '0435e6030027989146c1bae84916db0c', 'jana_kol@abv.bg', 'sk_test_4QDeOqoIwa4hgT82S9k9X0Yh', 'pk_test_GgYzMGsz0evDsovUuvS4ZNZj', 'USD', 1, 5, 10, 15, 100, 300, 250, 5, 15, 30, 'https://www.facebook.com/envato', 'https://twitter.com/envato', 'https://plus.google.com/+envato', 'martinkolarov9@gmail.com', 'in-v3.mailjet.com', '3c36d8fa42306c3e03ffbaf7aae90263', '0461c39d64cba808dae9b7c94c2fbf6d', 'tls', '587', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `stickers`
--

CREATE TABLE `stickers` (
  `id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `path` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `stickers`
--

INSERT INTO `stickers` (`id`, `pack_id`, `path`) VALUES
(1, 1, '1.png'),
(2, 1, '2.png'),
(3, 1, '3.png'),
(4, 1, '4.png'),
(5, 1, '5.png'),
(6, 1, '6.png'),
(7, 1, '7.png'),
(8, 1, '8.png'),
(9, 1, '9.png'),
(10, 1, '10.png'),
(11, 1, '11.png'),
(12, 1, '12.png'),
(13, 1, '13.png'),
(14, 1, '14.png'),
(15, 1, '15.png'),
(16, 1, '16.png'),
(17, 2, '1.png'),
(18, 2, '2.png'),
(19, 2, '3.png'),
(20, 2, '4.png'),
(21, 2, '5.png'),
(22, 2, '6.png'),
(23, 2, '7.png'),
(24, 2, '8.png'),
(25, 2, '9.png'),
(26, 2, '10.png'),
(27, 2, '11.png'),
(28, 2, '12.png'),
(29, 2, '13.png'),
(30, 2, '14.png'),
(31, 2, '15.png'),
(32, 2, '16.png'),
(33, 2, '17.png'),
(34, 2, '18.png'),
(35, 2, '19.png'),
(36, 2, '20.png'),
(37, 3, '1.png'),
(38, 3, '2.png'),
(39, 3, '3.png'),
(40, 3, '4.png'),
(41, 3, '5.png'),
(42, 3, '6.png'),
(43, 3, '7.png'),
(44, 3, '8.png'),
(45, 3, '9.png'),
(46, 3, '10.png'),
(47, 3, '11.png'),
(48, 3, '12.png'),
(49, 3, '13.png'),
(50, 3, '14.png');

-- --------------------------------------------------------

--
-- Структура на таблица `sticker_packs`
--

CREATE TABLE `sticker_packs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cover` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_premium` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Схема на данните от таблица `sticker_packs`
--

INSERT INTO `sticker_packs` (`id`, `name`, `cover`, `is_premium`) VALUES
(1, 'Savvy Abbey', '6.png', 1),
(2, 'Sandy', '2.png', 1),
(3, 'Bao Bao', '1.png', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_amount` int(11) NOT NULL,
  `transaction_name` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(123) NOT NULL,
  `credits_to_add` int(11) NOT NULL,
  `method` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_amount`, `transaction_name`, `status`, `user_id`, `token`, `credits_to_add`, `method`) VALUES
(1, 2, '100 Credits', 0, 20, '2f7ddab2f9f0cb1f6beff7d7ea84e4fc', 100, 1),
(2, 10, '500 Credits', 0, 20, '2ea0b64eba74756b3de70c097a68ed9c', 500, 1),
(3, 10, '500 Credits', 0, 20, 'd596700c2f5648921b599016e81ae9ff', 500, 3),
(4, 2, '100 Credits', 0, 20, 'f75cdd55ef6becdbe0133aa41d6d1ff4', 100, 3),
(5, 2, '100 Credits', 0, 20, '66c292993148d6b592df9847085746f7', 100, 3),
(6, 8, '400 Credits', 0, 20, '6d2e9a79593c3f87ded6ba89916d62f0', 400, 1),
(7, 18, '900 Credits', 0, 20, '7a525b647ac3950cac8c3f8397088154', 900, 3),
(8, 2, '100 Credits', 0, 20, '94e215cd8ca763334343987f8b13cf6a', 100, 3);

-- --------------------------------------------------------

--
-- Структура на таблица `uploaded_photos`
--

CREATE TABLE `uploaded_photos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `is_instagram` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=321 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Схема на данните от таблица `uploaded_photos`
--

INSERT INTO `uploaded_photos` (`id`, `user_id`, `path`, `is_instagram`, `time`) VALUES
(14, 121, 'a9f1fed0f1d56a9a46fbc049cd3db69413774686_280773935628049_1659801828_n.jpg', 0, 1471137924),
(16, 121, 'd64909cad3b0922fa338fbc4fa31124713768185_629422937213893_1042281455_n.jpg', 0, 1471137947),
(17, 121, '20f72a0142c043590e89c5a367faca4b13737097_1080897195309259_969103843_n.jpg', 0, 1471137959),
(18, 121, '192c2c8f9f136d178b988f7c94a3743113649383_938289572965684_795231051_n.jpg', 0, 1471137988),
(19, 121, '99ba1450564891c7fac91249d172495013597740_899836836811666_1327390116_n.jpg', 0, 1471138018),
(20, 121, 'cdf5a8f53e80903df6363fe3c3fb424913423498_459279414282457_757812880_n.jpg', 0, 1471138028),
(21, 121, '5ea7728b9b10ab80118748e571c2927813549383_540490202828488_1559680432_n.jpg', 0, 1471138052),
(24, 121, '0e5efcc534f56d5cc0c6824d81da22f113259521_1767805206790053_1740625501_n.jpg', 0, 1471138118),
(25, 121, 'fbeef70b6827c00c07f64b367b19824e13258968_1010942828993524_2043956845_n.jpg', 0, 1471138136),
(50, 12, '5c7d043ea9d4c81eca727a51d7e1c47413423618_1085957468131302_639342158_n.jpg', 0, 1473289039),
(52, 12, '65335fc4ee906924c0d4bd5fefb94cd612950295_1721923328097087_1394584198_n.jpg', 0, 1473289257),
(53, 12, '58e1e1f61e8307b62972667e457be64e12907130_632945260195690_1295856776_n (1).jpg', 0, 1473289305),
(301, 250, '5046b9662b62f4840d2cb51367a98bce1935598_170577573309744_2444956376011796608_n.jpg', 0, 1473366807),
(302, 250, '309f83b97839c709872b271f9d45223212717901_140517613000627_544625955038330000_n.jpg', 0, 1473366815),
(303, 250, 'c8ff3e15bfeb236b8140d828d834eca712654629_122570218128700_7101414265121819022_n.jpg', 0, 1473366820),
(304, 250, 'f06338e4ee06788dd6a11de87e49852d12341063_130152937352208_8746270854138607820_n.jpg', 0, 1473366825),
(305, 250, '515b5624200a22859a1921aba55837c512321643_156826298036425_3235552786128752336_n.jpg', 0, 1473366834),
(306, 250, 'a749c83e6bcfcb858acf4db517214f1810407066_121557594896629_4444391297539507437_n.jpg', 0, 1473366840),
(308, 316, 'e65aaf07101e20b6c036d1ec73165bf913712502_967127906742268_1102873957_n.jpg', 0, 1476168255),
(311, 316, '255b6405dbb1b4011b26c00ad6600d0f13181529_1576284296002205_1960514059_n.jpg', 0, 1476168591),
(312, 316, '83064ebfad6399674db964c1c36e938913126616_1745963722354507_909746710_n.jpg', 0, 1476168614),
(313, 316, 'd9f89e3f3d69dab1d1a3d70da97ebe9412964995_255363421475395_1295701062_n.jpg', 0, 1476168636),
(315, 316, '5abc3612b284e1537d7fc3b0a3ea2d4012519166_456355174564632_1501564170_n.jpg', 0, 1476168707),
(320, 317, '0712a9d04b4525226af5c82955b57db513643658_1066922773345658_82770667_n.jpg', 0, 1476170581);

-- --------------------------------------------------------

--
-- Структура на таблица `uploaded_photo_comments`
--

CREATE TABLE `uploaded_photo_comments` (
  `id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `commenter_id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `uploaded_photo_comments`
--

INSERT INTO `uploaded_photo_comments` (`id`, `photo_id`, `commenter_id`, `comment`) VALUES
(32, 13, 20, 'Beautiful photo!'),
(33, 17, 20, 'Stunning eyes!');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(123) DEFAULT NULL,
  `country` varchar(199) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `credits` int(11) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `bio` text,
  `gender` varchar(20) DEFAULT NULL,
  `sexual_interest` int(11) DEFAULT NULL,
  `instagram_username` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(200) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `registered` int(11) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `last_active` int(11) DEFAULT NULL,
  `updated_preferences` int(11) DEFAULT NULL,
  `updated_name` int(11) DEFAULT NULL,
  `is_admin` int(11) DEFAULT NULL,
  `is_incognito` int(11) DEFAULT NULL,
  `is_verified` int(11) DEFAULT NULL,
  `has_disabled_ads` int(11) DEFAULT NULL,
  `is_increased_exposure` int(11) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `interests` text,
  `uploaded_photos` int(11) DEFAULT NULL,
  `is_vip` int(20) DEFAULT NULL,
  `vip_expiration` int(20) DEFAULT NULL,
  `ghost_mode_start` int(20) DEFAULT NULL,
  `verified_badge_start` int(20) DEFAULT NULL,
  `spotlight_start` int(20) DEFAULT NULL,
  `disable_ads_start` int(20) DEFAULT NULL,
  `ghost_mode_expiration` int(20) DEFAULT NULL,
  `verified_badge_expiration` int(20) DEFAULT NULL,
  `spotlight_expiration` int(20) DEFAULT NULL,
  `disable_ads_expiration` int(20) DEFAULT NULL,
  `height` text,
  `weight` int(11) DEFAULT NULL,
  `last_encounter` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=318 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `country`, `city`, `credits`, `latitude`, `longitude`, `age`, `bio`, `gender`, `sexual_interest`, `instagram_username`, `profile_picture`, `ip`, `registered`, `last_login`, `last_active`, `updated_preferences`, `updated_name`, `is_admin`, `is_incognito`, `is_verified`, `has_disabled_ads`, `is_increased_exposure`, `language`, `interests`, `uploaded_photos`, `is_vip`, `vip_expiration`, `ghost_mode_start`, `verified_badge_start`, `spotlight_start`, `disable_ads_start`, `ghost_mode_expiration`, `verified_badge_expiration`, `spotlight_expiration`, `disable_ads_expiration`, `height`, `weight`, `last_encounter`) VALUES
(12, 'Madison Beer', 'madisonbeer@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'United States', 'New York', 10, '', '', 22, 'Loving ya ', 'Female', 1, 'davefrancosig', 'be6d8b018882738ad1d52bcfe8e5ed2e14156127_315611852125286_1674664816_n.jpg', '::1', 1439286270, 1482064344, 1482627565, 1, 0, 0, 0, 1, 0, 1, 'english', 'Singing,Hiking,Exploring,Music', 4, 1, 1491298220, 0, 0, 0, 0, 0, 0, 0, 0, '169', 50, 250),
(19, 'Justin Bieber', 'justinbieber@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'United States', 'New York', 10, '42.7147615', '23.1714689', 21, 'Hey guys ;)', 'Male', 1, 'justinbieber', 'ebdb09aaff7611c3940efa04d69f35b613736909_1094099234002741_858562481_n.jpg', '::1', 1439317970, 1473368413, 1482627565, 0, 1, 0, 0, 1, 0, 1, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', 0, 12),
(20, 'Dave Franco', 'davefranco@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'United States', 'New York', 9850, '', '', 26, 'Welcome to my profile ;) :P', 'Male', 1, 'dave_franco_fan', 'ee0c2b4e90ccc978a672547acc7036cd11357700_903808249668053_300388208_n.jpg', '::1', 1439418997, 1476778674, 1482627565, 0, 1, 1, 1, 1, 1, 0, 'english', 'Video Games,Computers,Football,Drinking', 0, 0, 0, 1470872006, 1470872006, 0, 1470872006, 1474106699, 1474106699, 0, 1474104689, '175', 75, 19),
(121, 'Nathalie Paris', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '', 'Sofia', 3000, '', '', 18, 'A typical teen', '', 1, '', 'c8ff3cd6cc8322b6eca0b4eb7e05222512534177_878313762282969_1626513728_n.jpg', '::1', 1452539673, 1482625568, 1482631340, 1, 0, 1, 0, 0, 0, 1, 'english', 'Cosmetics,Skydiving,Swimming', 9, 1, 1491298220, 1475519762, 1475519762, 1475519762, 1475519762, 1491298220, 1491298220, 1491298220, 1491298220, '165', 50, 316),
(250, 'Nicole Williams', 'nicolewilliams@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'United States', 'New York', 100, '42.7147601', '23.1714689', 23, '', 'Female', 1, '', '1eac0eaa8bf7c53a64c547062260f86113924994_261904607528593_349332101909269609_n.jpg', '::1', 1473365950, 1473368473, 1482627565, 1, 0, 0, 0, 0, 0, 1, 'english', '', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', 0, 20),
(316, 'Gabby DeMartino', 'gabidemartino@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'United States', 'New York', 2950, '42.7147615', '23.1714689', 19, '', 'Female', 1, '', '2c3d5085d4972c5caa8a073ad821da8913556779_868922016574007_511438478_n.jpg', '::1', 1452539673, 1476167625, 1482627565, 1, 0, 1, 0, 0, 0, 1, 'english', 'Vlogging,Cosmetics,Food', 5, 1, 1491298220, 1475519762, 1475519762, 1475519762, 1475519762, 1491298220, 1491298220, 1491298220, 1491298220, '165', 48, 12),
(317, 'Aidette Cancino', 'aidettecancino@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'United States', 'New York', 2950, '42.7147615', '23.1714689', 19, 'Couldn''t think of anything to put here xoxo', 'Female', 1, '', '9df68c8ec1d5232300d3e4d48c4261c812328477_1034122216609060_1386835886_n.jpg', '::1', 1452539673, 1476169751, 1482627565, 1, 0, 1, 0, 0, 0, 1, 'english', 'Vlogging,Cosmetics,Food', 1, 1, 1491298220, 1475519762, 1475519762, 1475519762, 1475519762, 1491298220, 1491298220, 1491298220, 1491298220, '165', 48, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activation_codes`
--
ALTER TABLE `activation_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gifts`
--
ALTER TABLE `gifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owned_sticker_packs`
--
ALTER TABLE `owned_sticker_packs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_dislikes`
--
ALTER TABLE `profile_dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_likes`
--
ALTER TABLE `profile_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_views`
--
ALTER TABLE `profile_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stickers`
--
ALTER TABLE `stickers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sticker_packs`
--
ALTER TABLE `sticker_packs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploaded_photos`
--
ALTER TABLE `uploaded_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploaded_photo_comments`
--
ALTER TABLE `uploaded_photo_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activation_codes`
--
ALTER TABLE `activation_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `filters`
--
ALTER TABLE `filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gifts`
--
ALTER TABLE `gifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `owned_sticker_packs`
--
ALTER TABLE `owned_sticker_packs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `profile_dislikes`
--
ALTER TABLE `profile_dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profile_likes`
--
ALTER TABLE `profile_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `profile_views`
--
ALTER TABLE `profile_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stickers`
--
ALTER TABLE `stickers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `sticker_packs`
--
ALTER TABLE `sticker_packs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `uploaded_photos`
--
ALTER TABLE `uploaded_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=321;
--
-- AUTO_INCREMENT for table `uploaded_photo_comments`
--
ALTER TABLE `uploaded_photo_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=318;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
