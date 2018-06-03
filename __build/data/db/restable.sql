-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `restable`;
CREATE DATABASE `restable` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `restable`;

DROP TABLE IF EXISTS `application`;
CREATE TABLE `application` (
  `application_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `application_client_uid` varchar(64) CHARACTER SET utf8 NOT NULL,
  `application_status` tinyint(3) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '2000-01-01 00:00:01',
  KEY `application_client_uid` (`application_client_uid`),
  CONSTRAINT `application_ibfk_1` FOREIGN KEY (`application_client_uid`) REFERENCES `client` (`client_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `application` (`application_uid`, `application_client_uid`, `application_status`, `updated`, `created`) VALUES
('15ceca13-96a7-4548-893e-198c82cc024a',	'fb1e1720-5de4-11e8-9ee3-3f5c0b608881',	0,	'2018-05-23 00:05:39',	'2000-01-01 00:00:01');

DROP TABLE IF EXISTS `application_client`;
CREATE TABLE `application_client` (
  `application_uid` varchar(64) NOT NULL,
  `client_uid` varchar(64) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `created` datetime NOT NULL DEFAULT '2001-01-01 00:00:01',
  `updated` datetime DEFAULT NULL,
  KEY `client_uid` (`client_uid`),
  CONSTRAINT `application_client_ibfk_1` FOREIGN KEY (`client_uid`) REFERENCES `client` (`client_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `application_client` (`application_uid`, `client_uid`, `status`, `created`, `updated`) VALUES
('15ceca13-96a7-4548-893e-198c82cc024a',	'fb1e1720-5de4-11e8-9ee3-3f5c0b608881',	0,	'2001-01-01 00:00:01',	NULL);

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `cart_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `currency_code` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GBP',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `cart_item`;
CREATE TABLE `cart_item` (
  `cart_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` tinyint(6) NOT NULL,
  `price_unit` decimal(6,4) NOT NULL,
  `updated` datetime NOT NULL,
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `category_uid` varchar(64) NOT NULL,
  `category_parent` varchar(64) NOT NULL DEFAULT '0',
  `label` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '2001-01-01 00:00:01',
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category` (`category_uid`, `category_parent`, `label`, `status`, `created`, `updated`) VALUES
('b91acee5-76ed-42d9-94db-14fd8bbc8be3',	'0',	'Cakes',	0,	'2001-01-01 00:00:01',	NULL),
('e371c03b-a346-4c89-ad8d-64146adc389a',	'0',	'Drinks',	0,	'2001-01-01 00:00:01',	NULL),
('03a52cb4-3808-4cf5-8cd7-71e7c96da1da',	'0',	'Wraps',	0,	'2001-01-01 00:00:01',	NULL),
('4e986c45-5b26-45e1-b4cf-9ae1ce24f31a',	'0',	'Mains',	0,	'2001-01-01 00:00:01',	NULL),
('4912cb69-0091-4d74-83e2-38013b57b5bf',	'0',	'Starters',	0,	'2001-01-01 00:00:01',	NULL),
('7c69570c-32f4-4878-a1b4-44c3b1c13af0',	'0',	'Salads',	0,	'2001-01-01 00:00:01',	NULL),
('f57b62b4-484f-43d9-94e9-cb43a4e52350',	'0',	'Sharing Platters',	0,	'2001-01-01 00:00:01',	NULL),
('1f856fc3-955e-449f-875b-0275ba9020f9',	'0',	'Mezze',	0,	'2001-01-01 00:00:01',	NULL),
('0f7befa8-ab8a-463c-88f6-8202c2f86296',	'0',	'Breakfast',	0,	'2001-01-01 00:00:01',	NULL),
('5967278e-90a9-42d2-b028-afc108b3b770',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'CANS',	0,	'2018-05-26 00:47:09',	NULL),
('e0c53fc2-cfc8-4022-a78a-93a542e6c568',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 00:48:37',	NULL),
('b410abf5-a033-4f6f-a56a-edd42ea2b769',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 00:50:15',	NULL),
('ed4b3b0d-3762-42f0-8928-08201c6a0779',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 00:50:36',	NULL),
('37e74f3b-9e3b-4d82-8747-f34f0c5840de',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 00:50:49',	NULL),
('7300bd1f-7e4a-42bf-b60a-ae1a0a2762e8',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 00:56:35',	NULL),
('22fdb120-0a5d-4cfd-a0a2-f3960d3988c8',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Hot Drinks',	0,	'2018-05-26 00:56:49',	NULL),
('0f8b0445-58b5-4329-a2b3-cded4ba648fe',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Hot Drinks',	0,	'2018-05-26 00:57:21',	NULL),
('3c3e521c-73b4-4d98-bc45-3e384234078b',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Hot Drinks',	0,	'2018-05-26 01:08:14',	NULL),
('5549674f-800e-4ee1-82e4-6babc35d3e8c',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 03:34:13',	NULL),
('317863d5-2a8d-4132-89d6-126e1a0845fc',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 04:32:12',	NULL),
('7a39a38b-1542-47c5-9a87-aaa23404a3e3',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 04:57:17',	NULL),
('8c24f2a6-2dc2-4f26-a2fd-5c27d17a65b2',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 05:00:03',	NULL),
('ccd943dc-55d7-4b9c-ab01-bf5202b57b9e',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'Cans',	0,	'2018-05-26 05:08:59',	NULL),
('a12383bc-c0d6-4f3b-aa4e-033fdee14787',	'e371c03b-a346-4c89-ad8d-64146adc389a',	'56565656Cans',	0,	'2018-05-26 05:09:07',	NULL),
('180147b9-3504-4e2d-9dea-559253f1bf64',	'0f7befa8-ab8a-463c-88f6-8202c2f86296',	'ohooo',	0,	'2018-05-26 05:11:47',	NULL);

DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `client_uid` varchar(64) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '2001-01-01 00:00:01',
  PRIMARY KEY (`client_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `client` (`client_uid`, `client_name`, `status`, `updated`, `created`) VALUES
('020c0f90-7450-482a-822a-964f5b21e53a',	'Oxford Grill',	0,	NULL,	'2018-05-26 18:01:56'),
('37e41a38-190d-46cd-b4ea-9b81290bc119',	'Biblos',	0,	NULL,	'2018-05-26 16:53:21'),
('e1695e3d-a5ae-4563-a32e-252b49dc8eb2',	'Biblos 2',	0,	NULL,	'2018-05-26 16:54:08'),
('fb1e1720-5de4-11e8-9ee3-3f5c0b608881',	'ACME Ltd',	0,	'2018-05-23 00:03:39',	'2001-01-01 00:00:01');

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `contact_uid` varchar(64) NOT NULL,
  `client_uid` varchar(64) NOT NULL,
  `contact_name` varchar(64) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(64) NOT NULL,
  `contact_notes` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '2001-01-01 00:00:01',
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `contact` (`contact_uid`, `client_uid`, `contact_name`, `contact_email`, `contact_phone`, `contact_notes`, `status`, `created`, `updated`) VALUES
('563deab9-6076-440c-81bb-47e637cf5b0e',	'37e41a38-190d-46cd-b4ea-9b81290bc119',	'Will',	'will@biblos.co.uk',	'07527073434',	'owner',	0,	'2018-05-26 16:53:21',	NULL),
('019123af-eb0c-4c9c-b0f1-dc8ee6665f85',	'e1695e3d-a5ae-4563-a32e-252b49dc8eb2',	'Will',	'will@biblos.co.uk',	'07527073434',	'fgh',	0,	'2018-05-26 16:54:08',	NULL),
('fec97a1d-df8a-4ee2-bc8c-61f9bf3143ca',	'020c0f90-7450-482a-822a-964f5b21e53a',	'Ahmed',	'ahmed@oxfordgrill-bs3.uk',	'',	'Owner',	0,	'2018-05-26 18:01:56',	NULL),
('afea3282-ab8a-43e8-8495-b664ff9a976c',	'020c0f90-7450-482a-822a-964f5b21e53a',	'Muhammed',	'',	'+447852787541',	'Manager',	0,	'2018-05-26 18:01:56',	NULL);

DROP TABLE IF EXISTS `contact_address`;
CREATE TABLE `contact_address` (
  `address_uid` varchar(64) NOT NULL,
  `client_uid` varchar(64) NOT NULL,
  `application_uid` varchar(64) DEFAULT '0',
  `contact_type` varchar(64) DEFAULT NULL,
  `address_label` varchar(64) DEFAULT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `address_1` varchar(64) NOT NULL,
  `address_2` varchar(64) DEFAULT NULL,
  `postcode` varchar(16) NOT NULL,
  `city` varchar(32) NOT NULL,
  `status` tinyint(3) DEFAULT '0',
  `address_notes` text,
  `created` datetime NOT NULL DEFAULT '2001-01-01 00:00:01',
  `updated` datetime DEFAULT NULL,
  KEY `contact_type` (`contact_type`),
  KEY `client_uid` (`client_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `contact_address` (`address_uid`, `client_uid`, `application_uid`, `contact_type`, `address_label`, `first_name`, `last_name`, `address_1`, `address_2`, `postcode`, `city`, `status`, `address_notes`, `created`, `updated`) VALUES
('9375a7bc-528e-41ec-bc79-5b6897252f4c',	'',	NULL,	NULL,	NULL,	'Jan',	'Kowalski',	'169 Wells Rd',	'bbb',	'BS4 2BU',	'Bristol',	0,	'Stokes Croft',	'2018-05-26 16:53:21',	NULL),
('d738e1ad-8b9e-4f1b-a22e-db5c73c4b6b0',	'e1695e3d-a5ae-4563-a32e-252b49dc8eb2',	NULL,	NULL,	NULL,	'Jan',	'Kowalski',	'169 Wells Rd',	'bbb',	'BS4 2BU',	'Bristol',	0,	'169 Wells Rd\r\nbbb',	'2018-05-26 16:54:08',	NULL),
('8b20ad7c-5397-4b7c-8368-4a5681ff1a0f',	'020c0f90-7450-482a-822a-964f5b21e53a',	NULL,	NULL,	NULL,	'',	'',	'',	'',	'',	'',	0,	'',	'2018-05-26 18:01:56',	NULL);

DROP TABLE IF EXISTS `contact_type`;
CREATE TABLE `contact_type` (
  `contact_type_uid` varchar(64) NOT NULL,
  `contact_type_name` varchar(64) NOT NULL,
  PRIMARY KEY (`contact_type_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `cart_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `total` decimal(6,4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `order_item`;
CREATE TABLE `order_item` (
  `order_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `product_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` tinyint(6) NOT NULL,
  `product_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,4) NOT NULL,
  `unit` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `description_short` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL DEFAULT '2000-01-01 00:00:01',
  PRIMARY KEY (`product_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `product` (`product_uid`, `name`, `price`, `unit`, `description_short`, `created`) VALUES
('0442d1c6-7da2-4998-8846-ae8d043208b6',	'Restable Basic Package - Annuall2',	67.0000,	'4567',	'',	'2018-05-17 12:38:11'),
('1c503f9f-b054-4183-94f9-f11a6a448a5b',	'Restable Basic Package - Annuall2',	67.0000,	'4567',	'',	'2018-05-17 12:38:02'),
('2478effb-db67-4408-963d-b3d6ec88ed40',	'Restable Basic Package - Annuall',	67.0000,	'4567',	'',	'2018-05-17 12:34:01'),
('29e2581f-7526-4cb0-ab1a-db0bc7d5707b',	'Zippo Premium Lighter Fluid',	4.9900,	'can',	'125ml',	'2018-05-17 12:50:10'),
('490ccfd8-98cf-440e-b92b-d4492d3c4950',	'Zippo Premium Lighter Fluid',	4.9900,	'can',	'125ml',	'2018-05-17 12:51:02'),
('65975646-d93d-400c-865d-528961a303d1',	'Restable Basic Package - Annuall21',	67.0000,	'4567',	'',	'2018-05-17 12:38:06'),
('66c126b1-b7cf-4cba-9927-5deb28484c9d',	'Zippo Premium Lighter Fluid',	4.9900,	'can',	'125ml',	'2018-05-17 13:13:20'),
('84ed7e57-eca2-430f-82af-5d4a0c0e30a2',	'Zippo Premium Lighter Fluid',	4.9900,	'can',	'125ml',	'2018-05-17 13:11:59'),
('a86ef3ef-d258-424f-a6e0-978274c0bef1',	'Zippo Premium Lighter Fluid',	4.9900,	'can',	'125ml',	'2018-05-17 13:13:07'),
('d32bdb12-1919-4f06-a596-b3dd57fd5087',	'Zippo Premium Lighter Fluid',	4.9900,	'can',	'125ml',	'2018-05-17 13:12:53'),
('df08101d-5ce4-4e5b-8ae7-add6ec61f08f',	'Zippo Premium Lighter Fluid',	4.9900,	'can',	'125ml',	'2018-05-17 13:11:18'),
('restable-service-basic-annual',	'Restable Basic Package - Annual',	299.9900,	'year',	'',	'2018-05-14 02:43:06'),
('restable-service-basic-month',	'Restable Basic Package - Month',	29.9900,	'month',	'',	'2018-05-14 02:43:06');

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `stock_uid` varchar(64) CHARACTER SET latin1 NOT NULL,
  `product_uid` varchar(64) CHARACTER SET latin1 NOT NULL,
  `product_qty` int(6) NOT NULL,
  `stock_status` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stock` (`stock_uid`, `product_uid`, `product_qty`, `stock_status`, `created`, `updated`) VALUES
('restable-service-basic-annual-stock',	'restable-service-basic-annual',	99,	0,	'2018-05-14 02:42:33',	NULL),
('restable-service-basic-month-stock',	'restable-service-basic-month',	99,	0,	'2018-05-14 02:43:06',	NULL),
('213a3578-6249-45bc-9d02-11bf0e882cdf',	'1c503f9f-b054-4183-94f9-f11a6a448a5b',	1,	0,	'2018-05-17 12:38:02',	NULL),
('41cf45e1-d838-41d1-a232-87e7105913cd',	'65975646-d93d-400c-865d-528961a303d1',	1,	0,	'2018-05-17 12:38:06',	NULL),
('e1e8e07c-6292-4bda-a5c7-3d2adcb95cbe',	'0442d1c6-7da2-4998-8846-ae8d043208b6',	1,	0,	'2018-05-17 12:38:11',	NULL),
('896f803d-ce1f-4d1f-a544-0fa33b6795d6',	'29e2581f-7526-4cb0-ab1a-db0bc7d5707b',	100,	0,	'2018-05-17 12:50:10',	NULL),
('f28d461d-b367-4317-9c23-9bb0f1e58560',	'490ccfd8-98cf-440e-b92b-d4492d3c4950',	100,	0,	'2018-05-17 12:51:02',	NULL),
('5ae93d83-c119-4fcc-8e2a-793b60e1ea7e',	'df08101d-5ce4-4e5b-8ae7-add6ec61f08f',	100,	0,	'2018-05-17 13:11:18',	NULL),
('53d33815-4f58-4500-bd66-9760738cc547',	'84ed7e57-eca2-430f-82af-5d4a0c0e30a2',	100,	0,	'2018-05-17 13:11:59',	NULL),
('f3605dc3-c962-467e-b562-0304c391bb70',	'd32bdb12-1919-4f06-a596-b3dd57fd5087',	100,	0,	'2018-05-17 13:12:53',	NULL),
('11ceea11-4dc9-4cdf-9854-51e5488fc1b5',	'a86ef3ef-d258-424f-a6e0-978274c0bef1',	100,	0,	'2018-05-17 13:13:07',	NULL),
('ad75f1ec-4e7d-47d1-89c3-46a782336e19',	'66c126b1-b7cf-4cba-9927-5deb28484c9d',	100,	0,	'2018-05-17 13:13:20',	NULL);

DROP TABLE IF EXISTS `stock_barcode`;
CREATE TABLE `stock_barcode` (
  `product_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `barcode_value` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stock_barcode` (`product_uid`, `barcode_value`, `updated`, `created`) VALUES
('restable-service-basic-month',	'5000435010778',	NULL,	'2018-05-14 02:44:38'),
('66c126b1-b7cf-4cba-9927-5deb28484c9d',	'041689300494',	NULL,	'2018-05-17 13:13:20'),
('restable-service-basic-month',	'5000435010860',	NULL,	'2018-05-17 17:50:55');

DROP TABLE IF EXISTS `stock_status`;
CREATE TABLE `stock_status` (
  `product_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `stock_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `status_code` int(2) NOT NULL DEFAULT '0',
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '2010-01-01 00:00:01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stock_status` (`product_uid`, `stock_uid`, `status_code`, `updated`, `created`) VALUES
('restable-service-basic-month',	'restable-service-basic-month-stock',	0,	NULL,	'2018-05-27 15:20:52'),
('restable-service-basic-annual',	'restable-service-basic-annual-stock',	0,	NULL,	'2018-05-27 15:23:32');

DROP TABLE IF EXISTS `venue`;
CREATE TABLE `venue` (
  `client_uid` varchar(64) NOT NULL,
  `venue_uid` varchar(64) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '2001-01-01 00:00:01',
  KEY `client_uid` (`client_uid`),
  CONSTRAINT `venue_ibfk_1` FOREIGN KEY (`client_uid`) REFERENCES `client` (`client_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `venue` (`client_uid`, `venue_uid`, `status`, `updated`, `created`) VALUES
('fb1e1720-5de4-11e8-9ee3-3f5c0b608881',	'6054698a-466d-4745-aa90-75d1c87ab7d3',	0,	'2018-05-23 00:15:01',	'2001-01-01 00:00:01');

-- 2018-05-27 19:35:38