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
  CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
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
  `product_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` tinyint(6) NOT NULL,
  `product_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,4) NOT NULL,
  `unit` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `description_short` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `product` (`product_id`, `name`, `price`, `unit`, `description_short`) VALUES
('restable-service-basic-annual',	'Restable Basic Package - Annual',	199.9900,	'year',	NULL),
('restable-service-basic-month',	'Restable Basic Package - Month',	19.9900,	'month',	NULL);

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `stock_uid` varchar(64) NOT NULL,
  `product_uid` varchar(64) NOT NULL,
  `product_qty` int(6) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `stock` (`stock_uid`, `product_uid`, `product_qty`, `created`, `updated`) VALUES
('restable-service-basic-annual-stock',	'restable-service-basic-annual',	99,	'2018-05-14 02:42:33',	NULL),
('restable-service-basic-month-stock',	'restable-service-basic-month',	99,	'2018-05-14 02:43:06',	NULL);

DROP TABLE IF EXISTS `stock_barcode`;
CREATE TABLE `stock_barcode` (
  `product_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `barcode_value` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stock_barcode` (`product_uid`, `barcode_value`, `updated`, `created`) VALUES
('restable-service-basic-annual',	'041689300494',	NULL,	'2018-05-14 02:43:45'),
('restable-service-basic-month',	'5000435010778',	NULL,	'2018-05-14 02:44:38');
