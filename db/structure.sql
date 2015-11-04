-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.25 - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.3.0.4999
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla carus_db.a3m_account
CREATE TABLE IF NOT EXISTS `a3m_account` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(24) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `createdon` datetime NOT NULL,
  `verifiedon` datetime DEFAULT NULL,
  `lastsignedinon` datetime DEFAULT NULL,
  `resetsenton` datetime DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_account_details
CREATE TABLE IF NOT EXISTS `a3m_account_details` (
  `account_id` bigint(20) unsigned NOT NULL,
  `fullname` varchar(160) DEFAULT NULL,
  `firstname` varchar(80) DEFAULT NULL,
  `lastname` varchar(80) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `postalcode` varchar(40) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `language` char(2) DEFAULT NULL,
  `timezone` varchar(40) DEFAULT NULL,
  `citimezone` varchar(6) DEFAULT NULL,
  `picture` varchar(240) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_account_facebook
CREATE TABLE IF NOT EXISTS `a3m_account_facebook` (
  `account_id` bigint(20) NOT NULL,
  `facebook_id` bigint(20) NOT NULL,
  `linkedon` datetime NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `facebook_id` (`facebook_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_account_openid
CREATE TABLE IF NOT EXISTS `a3m_account_openid` (
  `openid` varchar(240) NOT NULL,
  `account_id` bigint(20) unsigned NOT NULL,
  `linkedon` datetime NOT NULL,
  PRIMARY KEY (`openid`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_account_twitter
CREATE TABLE IF NOT EXISTS `a3m_account_twitter` (
  `account_id` bigint(20) NOT NULL,
  `twitter_id` bigint(20) NOT NULL,
  `oauth_token` varchar(80) NOT NULL,
  `oauth_token_secret` varchar(80) NOT NULL,
  `linkedon` datetime NOT NULL,
  PRIMARY KEY (`account_id`),
  KEY `twitter_id` (`twitter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_acl_permission
CREATE TABLE IF NOT EXISTS `a3m_acl_permission` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_acl_role
CREATE TABLE IF NOT EXISTS `a3m_acl_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_rel_account_permission
CREATE TABLE IF NOT EXISTS `a3m_rel_account_permission` (
  `account_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`account_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_rel_account_role
CREATE TABLE IF NOT EXISTS `a3m_rel_account_role` (
  `account_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`account_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.a3m_rel_role_permission
CREATE TABLE IF NOT EXISTS `a3m_rel_role_permission` (
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la cuenta|1001',
  `username` varchar(160) NOT NULL COMMENT 'Nombre de usuario para el ingreso.|nelson.daza',
  `email` varchar(160) NOT NULL COMMENT 'Correo electrónico de contacto.|nelson.daza@gmail.com',
  `password` varchar(60) NOT NULL COMMENT 'Contraseña de ingreso al sistema.|SFD%/R3453',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación de la cuenta.|’2014-12-01 14:00:00’',
  `verified` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de verificación vía e-mail.|’2014-12-01 14:00:00’',
  `last_signed_in` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora del último ingreso.|’2014-12-01 14:00:00’',
  `reset_sent` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de reinicio de la contraseña como sistema de seguridad.|’2014-12-01 14:00:00’',
  `deleted` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de eliminación (Realmente no se eliminan datos solo se marcan como eliminados).|’2014-12-01 14:00:00’',
  `suspended` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de suspención|’2014-12-01 14:00:00’',
  `first_name` varchar(45) DEFAULT NULL COMMENT 'Nombres del usuario.|Nelson',
  `last_name` varchar(45) DEFAULT NULL COMMENT 'Apellidos del usuario.|Daza',
  `country` char(2) DEFAULT NULL COMMENT 'FK Código del país.|co',
  `timezone` varchar(40) DEFAULT NULL COMMENT 'Zona horaria.|’America/Bogota’',
  `picture` varchar(250) DEFAULT NULL COMMENT 'Ruta a la imagen asignada al usuario.|’/resources/account/user1.jpg’',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_account_country1_idx` (`country`),
  KEY `verified` (`verified`),
  KEY `deleted` (`deleted`),
  KEY `suspended` (`suspended`),
  CONSTRAINT `fk_account_country1` FOREIGN KEY (`country`) REFERENCES `country` (`alpha2`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Información de los usuarios registrados.';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.account_role
CREATE TABLE IF NOT EXISTS `account_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.|1004',
  `id_account` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la cuenta.|1005',
  `id_role` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador del Rol.|10005',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_account_role_account1_idx` (`id_account`),
  KEY `fk_account_role_role1_idx` (`id_role`),
  CONSTRAINT `fk_account_role_account1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_account_role_role1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Roles relacionados con cada cuenta.';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.action_log
CREATE TABLE IF NOT EXISTS `action_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla de log.|1004',
  `id_account` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la cuenta que realiza la acción.|1004',
  `action` varchar(50) NOT NULL COMMENT 'Nombre de la acción.|Ingreso',
  `category` varchar(50) NOT NULL COMMENT 'Categoría de la acción.|Autenticación',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y Hora de creación del registro.|''2014-01-12 14:00:00''',
  `descripcion` varchar(250) DEFAULT NULL COMMENT 'Texto descriptivo de la acción.|Re realiza una autenticación correcta.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  CONSTRAINT `fk_action_log_account1` FOREIGN KEY (`id`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Registro de acciones.';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.brand
CREATE TABLE IF NOT EXISTS `brand` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.|1006',
  `name` varchar(50) NOT NULL COMMENT 'Nombre de la marca.|Roa',
  `key` varchar(100) NOT NULL,
  `logo` varchar(250) DEFAULT NULL COMMENT 'Url de la imagen para la marca.|/resources/brands/logo1.jpg',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del registro.|''2014-12-01 14:00:00''',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Marca propietaria de los productos.';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`,`ip_address`,`user_agent`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.country
CREATE TABLE IF NOT EXISTS `country` (
  `alpha2` char(2) NOT NULL COMMENT 'Código internacional de 2 caracteres.|co',
  `alpha3` char(3) NOT NULL COMMENT 'Código de nombre de 3 caracteres.|COL',
  `numeric` varchar(3) NOT NULL COMMENT 'Número para marcación.|+57',
  `country` varchar(80) NOT NULL COMMENT 'Nombre del país.|Colombia',
  PRIMARY KEY (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`),
  UNIQUE KEY `alpha2_UNIQUE` (`alpha2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Países';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.currency
CREATE TABLE IF NOT EXISTS `currency` (
  `alpha` char(3) NOT NULL COMMENT 'Identificador internacional de moneda.|COP',
  `numeric` varchar(3) DEFAULT NULL COMMENT 'Código internacional de moneda.|170',
  `currency` varchar(80) NOT NULL COMMENT 'Nombre de la moneda.|Peso Colombiano',
  PRIMARY KEY (`alpha`),
  UNIQUE KEY `alpha_UNIQUE` (`alpha`),
  UNIQUE KEY `numeric_UNIQUE` (`numeric`),
  KEY `numeric` (`numeric`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Monedas';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.permission
CREATE TABLE IF NOT EXISTS `permission` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador autonumérico de cada permiso.|1003',
  `key` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Identificador clave de cada permiso.|create_users',
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre claro del permiso representado.|Crear Usuarios',
  `suspended` timestamp NULL DEFAULT NULL COMMENT 'Fecha de desactivación del permiso.|’2014-12-01 14:00:00’',
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Bandera para saber si es un permisos de sistema (1) o de usuario (0).|1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_UNIQUE` (`key`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `key` (`key`),
  KEY `suspended` (`suspended`),
  KEY `is_system` (`is_system`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permisos dentro del sistema.';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.price
CREATE TABLE IF NOT EXISTS `price` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador del producto.|1007',
  `id_account` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la cuenta.|1007',
  `id_product` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador del producto.|1008',
  `id_store` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la tienda.|1009',
  `cod_currency` char(3) DEFAULT NULL COMMENT 'FK Identificador de la moneda.|1006',
  `value` double NOT NULL DEFAULT '0' COMMENT 'Precio del producto.|5680.00',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del registro.|''2014-12-01 14:00:00''',
  `user_agent` varchar(250) NOT NULL COMMENT 'Cadena de identificación del agente cliente usado para hacer el registro.|Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_price_currency1_idx` (`cod_currency`),
  KEY `fk_price_store1_idx` (`id_store`),
  KEY `fk_price_product1_idx` (`id_product`),
  KEY `fk_price_account1_idx` (`id_account`),
  KEY `creation` (`creation`),
  CONSTRAINT `fk_price_product1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_price_store1` FOREIGN KEY (`id_store`) REFERENCES `store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Precio del producto en un establecimiento específico.';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único por registro.|1004',
  `id_account` bigint(20) unsigned NOT NULL,
  `id_brand` bigint(20) unsigned DEFAULT NULL COMMENT 'FK Identificador de la marca.|1006',
  `name` varchar(100) NOT NULL COMMENT 'Nombre del producto.|Arroz',
  `size` varchar(50) DEFAULT NULL COMMENT 'Tamaño del producto.|500g',
  `key` varchar(100) NOT NULL COMMENT 'Identificador único basado en el nombre y el tamaño para realizar búsquedas rápidas.|arroz500',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro.|2014-12-01 14:00:00.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_product_brand1_idx` (`id_brand`),
  KEY `name` (`name`),
  KEY `size` (`size`),
  KEY `key` (`key`),
  CONSTRAINT `fk_product_brand1` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Productos';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.ref_country
CREATE TABLE IF NOT EXISTS `ref_country` (
  `alpha2` char(2) NOT NULL,
  `alpha3` char(3) NOT NULL,
  `numeric` varchar(3) NOT NULL,
  `country` varchar(80) NOT NULL,
  PRIMARY KEY (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.ref_currency
CREATE TABLE IF NOT EXISTS `ref_currency` (
  `alpha` char(3) NOT NULL,
  `numeric` varchar(3) DEFAULT NULL,
  `currency` varchar(80) NOT NULL,
  PRIMARY KEY (`alpha`),
  KEY `numeric` (`numeric`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.ref_iptocountry
CREATE TABLE IF NOT EXISTS `ref_iptocountry` (
  `ip_from` int(10) unsigned NOT NULL,
  `ip_to` int(10) unsigned NOT NULL,
  `country_code` char(2) NOT NULL,
  KEY `country_code` (`country_code`),
  KEY `ip_to` (`ip_to`),
  KEY `ip_from` (`ip_from`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.ref_language
CREATE TABLE IF NOT EXISTS `ref_language` (
  `one` char(2) NOT NULL,
  `two` char(3) NOT NULL,
  `language` varchar(120) NOT NULL,
  `native` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`one`),
  KEY `two` (`two`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.ref_zoneinfo
CREATE TABLE IF NOT EXISTS `ref_zoneinfo` (
  `zoneinfo` varchar(40) NOT NULL,
  `offset` varchar(16) DEFAULT NULL,
  `summer` varchar(16) DEFAULT NULL,
  `country` char(2) NOT NULL,
  `cicode` varchar(6) NOT NULL,
  `cicodesummer` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`zoneinfo`),
  KEY `country` (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del rol.|1001',
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del rol.|Administrador',
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Descripción detallada del rol.|Encargado de Gestionar la información del sistema',
  `suspended` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de desactivación.|’2014-12-01 14:00:00’',
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Bandera que indica si es un rol de sistema o no.|1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`name`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `suspended` (`suspended`),
  KEY `is_system` (`is_system`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Perfiles de usuario';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.role_permission
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.|1006',
  `id_role` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador del rol.|1003',
  `id_permission` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador único del permiso.|1006',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_role_permission_role1_idx` (`id_role`),
  KEY `fk_role_permission_permission1_idx` (`id_permission`),
  CONSTRAINT `fk_role_permission_permission1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_permission_role1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permisos asignados a cada Rol.';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.store
CREATE TABLE IF NOT EXISTS `store` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.',
  `id_account` varchar(100) NOT NULL COMMENT 'Identificador del Creador',
  `name` varchar(100) NOT NULL COMMENT 'Nombre del establecimiento.|Éxito Norte',
  `key` varchar(100) NOT NULL COMMENT 'Identificador único basado en el nombre para realizar búsquedas rápidas.|exitonorte',
  `latitude` double NOT NULL COMMENT 'Coordenadas terrestres de ubicación de la tienda.|4.754812,-74.044678',
  `longitude` double NOT NULL COMMENT 'Coordenadas terrestres de ubicación de la tienda.|4.754812,-74.044678',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del registro.|''2014-12-01 14:00:00''',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `key_UNIQUE` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Establecimientos';

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla carus_db.vote
CREATE TABLE IF NOT EXISTS `vote` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.|1003',
  `id_account` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la cuenta.|1004',
  `id_price` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador del precio calificado.|1009',
  `vote` tinyint(4) NOT NULL COMMENT 'Calificación dada al producto de 1-5.|1',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del registro.|''2014-12-01 14:00:00''',
  `user_agent` varchar(250) DEFAULT NULL COMMENT 'Cadena de identificación del agente cliente usado para hacer el registro.|Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_vote_account1_idx` (`id_account`),
  KEY `fk_vote_price1_idx` (`id_price`),
  CONSTRAINT `fk_vote_account1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vote_price1` FOREIGN KEY (`id_price`) REFERENCES `price` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Votos/Calificación dados al precio de un producto.';

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
