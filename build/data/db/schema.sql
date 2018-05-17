-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

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
('restable-service-basic-annual',	'Restable Basic Package - Annual',	199.9900,	'year',	NULL,	'2018-05-14 02:43:06'),
('restable-service-basic-month',	'Restable Basic Package - Month',	19.9900,	'month',	'',	'2018-05-14 02:43:06');

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


-- 2018-05-17 18:32:44