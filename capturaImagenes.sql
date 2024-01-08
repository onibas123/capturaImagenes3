/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.28-MariaDB : Database - capturaimagenes
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`capturaimagenes` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `capturaimagenes`;

/*Table structure for table `capturas` */

DROP TABLE IF EXISTS `capturas`;

CREATE TABLE `capturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizaciones_id` int(11) DEFAULT NULL,
  `dispositivos_id` int(11) DEFAULT NULL,
  `canal` int(11) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `consolidado` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `capturas` */

insert  into `capturas`(`id`,`organizaciones_id`,`dispositivos_id`,`canal`,`fecha_hora`,`ruta_imagen`,`observacion`,`usuario_id`,`consolidado`) values (1,1,1,1,'2024-01-04 09:49:35','img1.webp','aaaa',1,1),(2,1,1,1,'2024-01-04 17:33:53','img1.webp','',1,1),(3,1,1,2,'2024-01-04 17:34:09','img1.webp','bbb',1,1),(4,1,1,3,'2024-01-04 17:35:13','img1.webp','bbbcc',1,1);

/*Table structure for table `configuraciones` */

DROP TABLE IF EXISTS `configuraciones`;

CREATE TABLE `configuraciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parametro` varchar(255) DEFAULT NULL,
  `valor` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `configuraciones` */

insert  into `configuraciones`(`id`,`parametro`,`valor`) values (1,'nombre_empresa','<p>\r\n	SG MAS</p>\r\n'),(2,'direccion_empresa','<p>\r\n	Carrera 58-2, Curic&oacute;, Chile</p>\r\n'),(3,'email_empresa','<p>\r\n	informacion@sgmas.cl</p>\r\n'),(4,'telefono_empresa','<p>\r\n	75-2316165</p>\r\n');

/*Table structure for table `dispositivos` */

DROP TABLE IF EXISTS `dispositivos`;

CREATE TABLE `dispositivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizaciones_id` int(11) DEFAULT NULL,
  `tipo_dispositivo_id` int(11) DEFAULT NULL,
  `marcas_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `cantidad_canales` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `puerto` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `datos_extras` text DEFAULT NULL,
  `codificar_dss` varchar(255) DEFAULT NULL,
  `cantidad_capturas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `dispositivos` */

insert  into `dispositivos`(`id`,`organizaciones_id`,`tipo_dispositivo_id`,`marcas_id`,`nombre`,`cantidad_canales`,`ip`,`puerto`,`estado`,`ubicacion`,`datos_extras`,`codificar_dss`,`cantidad_capturas`) values (1,1,1,1,'Ejemplo DVR',16,'192.168.0.10',3777,1,'curico','<p>\r\n	<strong>dsadas</strong></p>\r\n','1100',10);

/*Table structure for table `esquemas` */

DROP TABLE IF EXISTS `esquemas`;

CREATE TABLE `esquemas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dispositivos_id` int(11) DEFAULT NULL,
  `Lun` tinyint(4) DEFAULT NULL,
  `Mar` tinyint(4) DEFAULT NULL,
  `Mie` tinyint(4) DEFAULT NULL,
  `Jue` tinyint(4) DEFAULT NULL,
  `Vie` tinyint(4) DEFAULT NULL,
  `Sab` tinyint(4) DEFAULT NULL,
  `Dom` tinyint(4) DEFAULT NULL,
  `hora` varchar(255) DEFAULT NULL,
  `canal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `esquemas` */

/*Table structure for table `logs` */

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) DEFAULT NULL,
  `entidad` varchar(255) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `logs` */

/*Table structure for table `marcas` */

DROP TABLE IF EXISTS `marcas`;

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `marcas` */

insert  into `marcas`(`id`,`nombre`) values (1,'DAHUA'),(2,'HIKVISION');

/*Table structure for table `opcion_rol` */

DROP TABLE IF EXISTS `opcion_rol`;

CREATE TABLE `opcion_rol` (
  `opciones_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`opciones_id`,`roles_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `opcion_rol` */

insert  into `opcion_rol`(`opciones_id`,`roles_id`) values (4,1),(5,1),(6,2);

/*Table structure for table `opciones` */

DROP TABLE IF EXISTS `opciones`;

CREATE TABLE `opciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `padre` int(11) DEFAULT NULL,
  `controlador` varchar(255) DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `opciones` */

insert  into `opciones`(`id`,`nombre`,`nivel`,`orden`,`padre`,`controlador`,`accion`,`icono`) values (1,'INTERFACE',1,1,0,NULL,NULL,NULL),(2,'REPORTES',1,2,0,NULL,NULL,NULL),(3,'Configuración',2,1,1,NULL,NULL,NULL),(4,'Paramétrica',3,1,3,NULL,NULL,NULL),(5,'Usuarios',3,2,3,NULL,NULL,NULL),(6,'Roles',3,3,3,NULL,NULL,NULL),(7,'Opciones',3,4,3,NULL,NULL,NULL),(8,'Permisos',3,5,3,NULL,NULL,NULL),(9,'Organizaciones',3,6,3,NULL,NULL,NULL),(10,'Tipo Dispositivo',3,7,3,NULL,NULL,NULL),(11,'Marcas',3,8,3,NULL,NULL,NULL),(12,'Dispositivos',3,9,3,NULL,NULL,NULL),(13,'Gestión',2,2,1,NULL,NULL,NULL),(14,'Esquema de Horarios',3,1,13,NULL,NULL,NULL),(15,'Capturas',3,2,13,NULL,NULL,NULL),(16,'Consolidar',3,3,13,NULL,NULL,NULL),(17,'Entidad',2,1,2,NULL,NULL,NULL),(18,'Registros',3,1,17,NULL,NULL,NULL),(19,'Logs',3,2,17,NULL,NULL,NULL);

/*Table structure for table `organizaciones` */

DROP TABLE IF EXISTS `organizaciones`;

CREATE TABLE `organizaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `cantidad_dispositivos` int(11) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `rut` varchar(15) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `organizaciones` */

insert  into `organizaciones`(`id`,`nombre`,`cantidad_dispositivos`,`creado`,`rut`,`razon_social`,`direccion`,`contacto`,`telefono`,`email`) values (1,'Organizacion 1',1,'2023-11-25 18:38:52',NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`nombre`) values (1,'Administrador'),(2,'Usuario');

/*Table structure for table `tipo_dispositivo` */

DROP TABLE IF EXISTS `tipo_dispositivo`;

CREATE TABLE `tipo_dispositivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tipo_dispositivo` */

insert  into `tipo_dispositivo`(`id`,`nombre`) values (1,'DVR'),(2,'NVR'),(3,'Camara IP');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `guarda` tinyint(1) DEFAULT NULL,
  `edita` tinyint(1) DEFAULT NULL,
  `elimina` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id`,`roles_id`,`email`,`password`,`nombre`,`guarda`,`edita`,`elimina`) values (1,1,'mquezada@pccurico.cl','827ccb0eea8a706c4c34a16891f84e7b','Matías Quezada Sanhueza',1,1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
