
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(6,4) NOT NULL,
  `unit` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `description_short` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `product` (`product_id`, `name`, `price`, `unit`, `description_short`) VALUES
('3cd50767-0504-4ce6-af89-b4845efc31e6',	'Peas',	0.9500,	'bag',	'Melius fastidii repudiare pro id, pri modus quando vocent ad. Per ea consul persequeris, et mucius accusam est. Et nisl honestatis eos, no omnes nostro mel, duis sale ignota cu mea'),
('953445a9-fd1b-4a8f-ad25-b3cff5ef8741',	'Beans',	0.7300,	'can',	'Ei ullum deleniti tractatos mea. An per erant vocent appetere, unum cibo dissentiunt mel te, no est stet iisque suavitate. Vel an veri justo explicari, mel ad salutatus assueverit. '),
('bc03ca4f-8bd6-485d-8301-0dc249b2c9b5',	'Eggs',	2.1000,	'dozen',	'Altera discere te sed. Iisque iudicabit cu pri. Justo pericula mel eu, ignota expetendis an mea. Alia ponderum indoctum eam ne, putent copiosae prodesset at eam, qui wisi primis reprehendunt no. '),
('fac2f882-1801-4b14-b407-4495d2115480',	'Milk',	1.3000,	'bottle',	'Sit quaeque dolorem inimicus no, dico posse theophrastus no usu. Elit reprimique quo ad, errem officiis vix ad, novum consequat eu mei. ');

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
