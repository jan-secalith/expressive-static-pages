SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_uid` varchar(64) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `pwd_reset_token` varchar(255) DEFAULT NULL,
  `pwd_reset_token_creation_date` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '2001-01-01 00:00:01',
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`user_uid`, `user_email`, `full_name`, `password`, `status`, `pwd_reset_token`, `pwd_reset_token_creation_date`, `created`, `updated`) VALUES
('0bddcf6e-f47e-4b1e-a0bd-322e023deab8',	'jan@secalith.co.uk',	'Jan Kowalski',	'$2y$10$rteIPWcS.HvpcQqu7JYNPegiIkLpK/lL6LQ61BrmgYlJ6YoYnWjRa',	0,	NULL,	NULL,	'2001-01-01 00:00:01',	NULL);