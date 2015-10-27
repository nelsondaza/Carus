SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS `a3m_account`;
CREATE TABLE `a3m_account` (
`id` bigint(20) unsigned NOT NULL,
  `username` varchar(24) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `createdon` datetime NOT NULL,
  `verifiedon` datetime DEFAULT NULL,
  `lastsignedinon` datetime DEFAULT NULL,
  `resetsenton` datetime DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `a3m_account_details`;
CREATE TABLE `a3m_account_details` (
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
  `picture` varchar(240) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `a3m_account_facebook`;
CREATE TABLE `a3m_account_facebook` (
  `account_id` bigint(20) NOT NULL,
  `facebook_id` bigint(20) NOT NULL,
  `linkedon` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `a3m_account_openid`;
CREATE TABLE `a3m_account_openid` (
  `openid` varchar(240) NOT NULL,
  `account_id` bigint(20) unsigned NOT NULL,
  `linkedon` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `a3m_account_twitter`;
CREATE TABLE `a3m_account_twitter` (
  `account_id` bigint(20) NOT NULL,
  `twitter_id` bigint(20) NOT NULL,
  `oauth_token` varchar(80) NOT NULL,
  `oauth_token_secret` varchar(80) NOT NULL,
  `linkedon` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `a3m_acl_permission`;
CREATE TABLE `a3m_acl_permission` (
`id` bigint(20) unsigned NOT NULL,
  `key` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `a3m_acl_role`;
CREATE TABLE `a3m_acl_role` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suspendedon` datetime DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `a3m_rel_account_permission`;
CREATE TABLE `a3m_rel_account_permission` (
  `account_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `a3m_rel_account_role`;
CREATE TABLE `a3m_rel_account_role` (
  `account_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `a3m_rel_role_permission`;
CREATE TABLE `a3m_rel_role_permission` (
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador de la cuenta|1001',
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
  `picture` varchar(250) DEFAULT NULL COMMENT 'Ruta a la imagen asignada al usuario.|’/resources/account/user1.jpg’'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Información de los usuarios registrados.';

DROP TABLE IF EXISTS `account_role`;
CREATE TABLE `account_role` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador único de la tabla.|1004',
  `id_account` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la cuenta.|1005',
  `id_role` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador del Rol.|10005'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Roles relacionados con cada cuenta.';

DROP TABLE IF EXISTS `action_log`;
CREATE TABLE `action_log` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador de la tabla de log.|1004',
  `id_account` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la cuenta que realiza la acción.|1004',
  `action` varchar(50) NOT NULL COMMENT 'Nombre de la acción.|Ingreso',
  `category` varchar(50) NOT NULL COMMENT 'Categoría de la acción.|Autenticación',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y Hora de creación del registro.|''2014-01-12 14:00:00''',
  `descripcion` varchar(250) DEFAULT NULL COMMENT 'Texto descriptivo de la acción.|Re realiza una autenticación correcta.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Registro de acciones.';

DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador único de la tabla.|1006',
  `name` varchar(50) NOT NULL COMMENT 'Nombre de la marca.|Roa',
  `logo` varchar(250) DEFAULT NULL COMMENT 'Url de la imagen para la marca.|/resources/brands/logo1.jpg',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del registro.|''2014-12-01 14:00:00'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Marca propietaria de los productos.';

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `alpha2` char(2) NOT NULL COMMENT 'Código internacional de 2 caracteres.|co',
  `alpha3` char(3) NOT NULL COMMENT 'Código de nombre de 3 caracteres.|COL',
  `numeric` varchar(3) NOT NULL COMMENT 'Número para marcación.|+57',
  `country` varchar(80) NOT NULL COMMENT 'Nombre del país.|Colombia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Países';

DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `alpha` char(3) NOT NULL COMMENT 'Identificador internacional de moneda.|COP',
  `numeric` varchar(3) DEFAULT NULL COMMENT 'Código internacional de moneda.|170',
  `currency` varchar(80) NOT NULL COMMENT 'Nombre de la moneda.|Peso Colombiano'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Monedas';

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador autonumérico de cada permiso.|1003',
  `key` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Identificador clave de cada permiso.|create_users',
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre claro del permiso representado.|Crear Usuarios',
  `suspended` timestamp NULL DEFAULT NULL COMMENT 'Fecha de desactivación del permiso.|’2014-12-01 14:00:00’',
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Bandera para saber si es un permisos de sistema (1) o de usuario (0).|1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permisos dentro del sistema.';

DROP TABLE IF EXISTS `price`;
CREATE TABLE `price` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador del producto.|1007',
  `id_account` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la cuenta.|1007',
  `id_product` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador del producto.|1008',
  `id_store` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la tienda.|1009',
  `cod_currency` char(3) NOT NULL COMMENT 'FK Identificador de la moneda.|1006',
  `value` double NOT NULL DEFAULT '0' COMMENT 'Precio del producto.|5680.00',
  `location` varchar(150) DEFAULT NULL COMMENT 'Coordenadas terrestres del punto donde se registró el precio.|4.754812,-74.044678',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del registro.|''2014-12-01 14:00:00''',
  `user_agent` varchar(250) NOT NULL COMMENT 'Cadena de identificación del agente cliente usado para hacer el registro.|Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Precio del producto en un establecimiento específico.';

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador único por registro.|1004',
  `id_brand` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la marca.|1006',
  `name` varchar(100) NOT NULL COMMENT 'Nombre del producto.|Arroz',
  `size` varchar(50) DEFAULT NULL COMMENT 'Tamaño del producto.|500g',
  `key` varchar(45) NOT NULL COMMENT 'Identificador único basado en el nombre y el tamaño para realizar búsquedas rápidas.|arroz500',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro.|2014-12-01 14:00:00.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Productos';

DROP TABLE IF EXISTS `ref_country`;
CREATE TABLE `ref_country` (
  `alpha2` char(2) NOT NULL,
  `alpha3` char(3) NOT NULL,
  `numeric` varchar(3) NOT NULL,
  `country` varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ref_currency`;
CREATE TABLE `ref_currency` (
  `alpha` char(3) NOT NULL,
  `numeric` varchar(3) DEFAULT NULL,
  `currency` varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `ref_iptocountry`;
CREATE TABLE `ref_iptocountry` (
  `ip_from` int(10) unsigned NOT NULL,
  `ip_to` int(10) unsigned NOT NULL,
  `country_code` char(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ref_language`;
CREATE TABLE `ref_language` (
  `one` char(2) NOT NULL,
  `two` char(3) NOT NULL,
  `language` varchar(120) NOT NULL,
  `native` varchar(80) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ref_zoneinfo`;
CREATE TABLE `ref_zoneinfo` (
  `zoneinfo` varchar(40) NOT NULL,
  `offset` varchar(16) DEFAULT NULL,
  `summer` varchar(16) DEFAULT NULL,
  `country` char(2) NOT NULL,
  `cicode` varchar(6) NOT NULL,
  `cicodesummer` varchar(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador único del rol.|1001',
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del rol.|Administrador',
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Descripción detallada del rol.|Encargado de Gestionar la información del sistema',
  `suspended` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de desactivación.|’2014-12-01 14:00:00’',
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Bandera que indica si es un rol de sistema o no.|1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Perfiles de usuario';

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
`id` bigint(20) NOT NULL COMMENT 'Identificador único de la tabla.|1006',
  `id_role` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador del rol.|1003',
  `id_permission` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador único del permiso.|1006'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permisos asignados a cada Rol.';

DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador único de la tabla.',
  `name` varchar(100) NOT NULL COMMENT 'Nombre del establecimiento.|Éxito Norte',
  `key` varchar(100) NOT NULL COMMENT 'Identificador único basado en el nombre para realizar búsquedas rápidas.|exitonorte',
  `location` varchar(150) NOT NULL COMMENT 'Coordenadas terrestres de ubicación de la tienda.|4.754812,-74.044678',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del registro.|''2014-12-01 14:00:00'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Establecimientos';

DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Identificador único de la tabla.|1003',
  `id_account` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador de la cuenta.|1004',
  `id_price` bigint(20) unsigned NOT NULL COMMENT 'FK Identificador del precio calificado.|1009',
  `vote` tinyint(4) NOT NULL COMMENT 'Calificación dada al producto de 1-5.|1',
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del registro.|''2014-12-01 14:00:00''',
  `user_agent` varchar(250) DEFAULT NULL COMMENT 'Cadena de identificación del agente cliente usado para hacer el registro.|Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Votos/Calificación dados al precio de un producto.';


ALTER TABLE `a3m_account`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `a3m_account_details`
 ADD PRIMARY KEY (`account_id`);

ALTER TABLE `a3m_account_facebook`
 ADD PRIMARY KEY (`account_id`), ADD UNIQUE KEY `facebook_id` (`facebook_id`);

ALTER TABLE `a3m_account_openid`
 ADD PRIMARY KEY (`openid`), ADD KEY `account_id` (`account_id`);

ALTER TABLE `a3m_account_twitter`
 ADD PRIMARY KEY (`account_id`), ADD KEY `twitter_id` (`twitter_id`);

ALTER TABLE `a3m_acl_permission`
 ADD PRIMARY KEY (`id`), ADD KEY `key` (`key`);

ALTER TABLE `a3m_acl_role`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `role_name` (`name`);

ALTER TABLE `a3m_rel_account_permission`
 ADD PRIMARY KEY (`account_id`,`permission_id`);

ALTER TABLE `a3m_rel_account_role`
 ADD PRIMARY KEY (`account_id`,`role_id`);

ALTER TABLE `a3m_rel_role_permission`
 ADD PRIMARY KEY (`role_id`,`permission_id`);

ALTER TABLE `account`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`), ADD KEY `fk_account_country1_idx` (`country`), ADD KEY `verified` (`verified`), ADD KEY `deleted` (`deleted`), ADD KEY `suspended` (`suspended`);

ALTER TABLE `account_role`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `fk_account_role_account1_idx` (`id_account`), ADD KEY `fk_account_role_role1_idx` (`id_role`);

ALTER TABLE `action_log`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`);

ALTER TABLE `brand`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD UNIQUE KEY `name_UNIQUE` (`name`);

ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`,`ip_address`,`user_agent`), ADD KEY `last_activity_idx` (`last_activity`);

ALTER TABLE `country`
 ADD PRIMARY KEY (`alpha2`), ADD UNIQUE KEY `alpha3` (`alpha3`), ADD UNIQUE KEY `alpha2_UNIQUE` (`alpha2`);

ALTER TABLE `currency`
 ADD PRIMARY KEY (`alpha`), ADD UNIQUE KEY `alpha_UNIQUE` (`alpha`), ADD UNIQUE KEY `numeric_UNIQUE` (`numeric`), ADD KEY `numeric` (`numeric`);

ALTER TABLE `permission`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `key_UNIQUE` (`key`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `key` (`key`), ADD KEY `suspended` (`suspended`), ADD KEY `is_system` (`is_system`);

ALTER TABLE `price`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `fk_price_currency1_idx` (`cod_currency`), ADD KEY `fk_price_store1_idx` (`id_store`), ADD KEY `fk_price_product1_idx` (`id_product`), ADD KEY `fk_price_account1_idx` (`id_account`), ADD KEY `creation` (`creation`);

ALTER TABLE `product`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `key_UNIQUE` (`key`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `fk_product_brand1_idx` (`id_brand`), ADD KEY `name` (`name`), ADD KEY `size` (`size`);

ALTER TABLE `ref_country`
 ADD PRIMARY KEY (`alpha2`), ADD UNIQUE KEY `alpha3` (`alpha3`);

ALTER TABLE `ref_currency`
 ADD PRIMARY KEY (`alpha`), ADD KEY `numeric` (`numeric`);

ALTER TABLE `ref_iptocountry`
 ADD KEY `country_code` (`country_code`), ADD KEY `ip_to` (`ip_to`), ADD KEY `ip_from` (`ip_from`);

ALTER TABLE `ref_language`
 ADD PRIMARY KEY (`one`), ADD KEY `two` (`two`);

ALTER TABLE `ref_zoneinfo`
 ADD PRIMARY KEY (`zoneinfo`), ADD KEY `country` (`country`);

ALTER TABLE `role`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `role_name` (`name`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `suspended` (`suspended`), ADD KEY `is_system` (`is_system`);

ALTER TABLE `role_permission`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `fk_role_permission_role1_idx` (`id_role`), ADD KEY `fk_role_permission_permission1_idx` (`id_permission`);

ALTER TABLE `store`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD UNIQUE KEY `key_UNIQUE` (`key`);

ALTER TABLE `vote`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `fk_vote_account1_idx` (`id_account`), ADD KEY `fk_vote_price1_idx` (`id_price`);


ALTER TABLE `a3m_account`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `a3m_acl_permission`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `a3m_acl_role`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `account`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la cuenta|1001';
ALTER TABLE `account_role`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.|1004';
ALTER TABLE `action_log`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla de log.|1004';
ALTER TABLE `brand`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.|1006';
ALTER TABLE `permission`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador autonumérico de cada permiso.|1003';
ALTER TABLE `price`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador del producto.|1007';
ALTER TABLE `product`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único por registro.|1004';
ALTER TABLE `role`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del rol.|1001';
ALTER TABLE `role_permission`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.|1006';
ALTER TABLE `store`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.';
ALTER TABLE `vote`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la tabla.|1003';

ALTER TABLE `account`
ADD CONSTRAINT `fk_account_country1` FOREIGN KEY (`country`) REFERENCES `country` (`alpha2`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `account_role`
ADD CONSTRAINT `fk_account_role_account1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_account_role_role1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `action_log`
ADD CONSTRAINT `fk_action_log_account1` FOREIGN KEY (`id`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `price`
ADD CONSTRAINT `fk_price_account1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_price_currency1` FOREIGN KEY (`cod_currency`) REFERENCES `currency` (`alpha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_price_product1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_price_store1` FOREIGN KEY (`id_store`) REFERENCES `store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `product`
ADD CONSTRAINT `fk_product_brand1` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `role_permission`
ADD CONSTRAINT `fk_role_permission_permission1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_role_permission_role1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `vote`
ADD CONSTRAINT `fk_vote_account1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_vote_price1` FOREIGN KEY (`id_price`) REFERENCES `price` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
