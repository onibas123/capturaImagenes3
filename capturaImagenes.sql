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

/*Table structure for table `canales` */

DROP TABLE IF EXISTS `canales`;

CREATE TABLE `canales` (
  `devices_id` int(11) NOT NULL,
  `canal` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`devices_id`,`canal`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `canales` */

insert  into `canales`(`devices_id`,`canal`,`nombre`) values (1,32,'fdsfds'),(1,31,'Canal 31'),(1,30,'Canal 30'),(1,29,'Canal 29'),(1,28,'Canal 28'),(1,27,'Canal 27'),(1,26,'Canal 26'),(1,25,'Canal 25'),(1,24,'Canal 24'),(1,23,'Canal 23'),(1,22,'Canal 22'),(1,21,'Canal 21'),(1,20,'Canal 20'),(1,19,'Canal 19'),(1,18,'Canal 18'),(1,17,'Canal 17'),(1,16,'Canal 16'),(1,15,'Canal 15'),(1,14,'Canal 14'),(1,13,'Canal 13'),(1,12,'Canal 12'),(1,11,'Canal 11'),(1,10,'Canal 10'),(1,9,'Canal 9'),(1,8,'Canal 8'),(1,7,'Canal 7'),(1,6,'Canal 6'),(1,5,'Canal 5'),(1,4,'5fsdfd'),(1,3,'Canal 33'),(1,2,'Canal 22'),(1,1,'Canal 11');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `capturas` */

insert  into `capturas`(`id`,`organizaciones_id`,`dispositivos_id`,`canal`,`fecha_hora`,`ruta_imagen`,`observacion`,`usuario_id`,`consolidado`) values (1,1,1,1,'2024-01-04 09:49:35','img1.jpg','aaaa',1,1),(2,1,1,1,'2024-01-04 17:33:53','img1.jpg','',1,1),(3,1,1,2,'2024-01-04 17:34:09','img1.jpg','bbb',1,1),(4,1,1,3,'2024-01-04 17:35:13','img1.jpg','bbbcc',1,1),(5,1,1,1,'2024-01-12 12:42:13','','bggg',1,1),(6,1,1,1,'2024-01-12 12:43:38','','tttyyyy',1,1),(7,1,1,1,'2024-02-02 15:33:11','captura_1_1_1_20240202153307.jpg','',1,0);

/*Table structure for table `configuraciones` */

DROP TABLE IF EXISTS `configuraciones`;

CREATE TABLE `configuraciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parametro` varchar(255) DEFAULT NULL,
  `valor` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `configuraciones` */

insert  into `configuraciones`(`id`,`parametro`,`valor`) values (1,'nombre_empresa','SG MAS'),(2,'direccion_empresa','Carrera 58-2, Curic&oacute;, Chile'),(3,'email_empresa','informacion@sgmas.cl'),(4,'telefono_empresa','75-2316165\r\n');

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
  `usuario` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `dispositivos` */

insert  into `dispositivos`(`id`,`organizaciones_id`,`tipo_dispositivo_id`,`marcas_id`,`nombre`,`cantidad_canales`,`ip`,`puerto`,`estado`,`ubicacion`,`datos_extras`,`codificar_dss`,`cantidad_capturas`,`usuario`,`password`) values (1,1,1,1,'DVR Colegio',32,'201.236.179.91',81,1,'curico','<p>\r\n	<strong>dsadas</strong></p>\r\n','1100',10,'sgmas','sgmas123');

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `logs` */

insert  into `logs`(`id`,`usuarios_id`,`entidad`,`fecha_hora`,`accion`,`data`) values (1,0,'Usuarios','2024-01-12 12:06:34','Login','{\"usuario_id\":\"1\",\"usuario_usuario\":\"mquezada@pccurico.cl\",\"usuario_password_raw\":\"12345\",\"usuario_password\":\"827ccb0eea8a706c4c34a16891f84e7b\",\"usuario_nombre\":\"Mat\\u00edas Quezada Sanhueza\",\"usuario_email\":\"mquezada@pccurico.cl\",\"usuario_guarda\":\"1\",\"usuario_edita\":\"1\",\"usuario_elimina\":\"1\",\"roles_id\":\"1\",\"roles_nombre\":\"Administrador\",\"opciones\":[{\"id\":\"4\",\"nombre\":\"Param\\u00e9trica\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"3\",\"controlador\":\"ConfiguracionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"5\",\"nombre\":\"Usuarios\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"3\",\"controlador\":\"UsuariosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"6\",\"nombre\":\"Roles\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"7\",\"nombre\":\"Opciones\",\"nivel\":\"3\",\"orden\":\"4\",\"padre\":\"3\",\"controlador\":\"OpcionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"8\",\"nombre\":\"Permisos\",\"nivel\":\"3\",\"orden\":\"5\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"permisos\",\"icono\":null},{\"id\":\"9\",\"nombre\":\"Organizaciones\",\"nivel\":\"3\",\"orden\":\"6\",\"padre\":\"3\",\"controlador\":\"OrganizacionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"10\",\"nombre\":\"Tipo Dispositivo\",\"nivel\":\"3\",\"orden\":\"7\",\"padre\":\"3\",\"controlador\":\"TipoDispositivoController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"11\",\"nombre\":\"Marcas\",\"nivel\":\"3\",\"orden\":\"8\",\"padre\":\"3\",\"controlador\":\"MarcasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"12\",\"nombre\":\"Dispositivos\",\"nivel\":\"3\",\"orden\":\"9\",\"padre\":\"3\",\"controlador\":\"DispositivosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"14\",\"nombre\":\"Esquema de Horarios\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"schema\",\"icono\":null},{\"id\":\"15\",\"nombre\":\"Capturas\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"16\",\"nombre\":\"Consolidar\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"consolidate\",\"icono\":null},{\"id\":\"18\",\"nombre\":\"Registros\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"17\",\"controlador\":\"CapturasController\",\"accion\":\"report\",\"icono\":null},{\"id\":\"19\",\"nombre\":\"Logs\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"17\",\"controlador\":\"LogsController\",\"accion\":\"index\",\"icono\":null}]}'),(2,1,'Usuarios','2024-01-12 12:07:00','Login','{\"usuario_id\":\"1\",\"usuario_usuario\":\"mquezada@pccurico.cl\",\"usuario_password_raw\":\"12345\",\"usuario_password\":\"827ccb0eea8a706c4c34a16891f84e7b\",\"usuario_nombre\":\"Mat\\u00edas Quezada Sanhueza\",\"usuario_email\":\"mquezada@pccurico.cl\",\"usuario_guarda\":\"1\",\"usuario_edita\":\"1\",\"usuario_elimina\":\"1\",\"roles_id\":\"1\",\"roles_nombre\":\"Administrador\",\"opciones\":[{\"id\":\"4\",\"nombre\":\"Param\\u00e9trica\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"3\",\"controlador\":\"ConfiguracionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"5\",\"nombre\":\"Usuarios\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"3\",\"controlador\":\"UsuariosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"6\",\"nombre\":\"Roles\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"7\",\"nombre\":\"Opciones\",\"nivel\":\"3\",\"orden\":\"4\",\"padre\":\"3\",\"controlador\":\"OpcionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"8\",\"nombre\":\"Permisos\",\"nivel\":\"3\",\"orden\":\"5\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"permisos\",\"icono\":null},{\"id\":\"9\",\"nombre\":\"Organizaciones\",\"nivel\":\"3\",\"orden\":\"6\",\"padre\":\"3\",\"controlador\":\"OrganizacionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"10\",\"nombre\":\"Tipo Dispositivo\",\"nivel\":\"3\",\"orden\":\"7\",\"padre\":\"3\",\"controlador\":\"TipoDispositivoController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"11\",\"nombre\":\"Marcas\",\"nivel\":\"3\",\"orden\":\"8\",\"padre\":\"3\",\"controlador\":\"MarcasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"12\",\"nombre\":\"Dispositivos\",\"nivel\":\"3\",\"orden\":\"9\",\"padre\":\"3\",\"controlador\":\"DispositivosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"14\",\"nombre\":\"Esquema de Horarios\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"schema\",\"icono\":null},{\"id\":\"15\",\"nombre\":\"Capturas\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"16\",\"nombre\":\"Consolidar\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"consolidate\",\"icono\":null},{\"id\":\"18\",\"nombre\":\"Registros\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"17\",\"controlador\":\"CapturasController\",\"accion\":\"report\",\"icono\":null},{\"id\":\"19\",\"nombre\":\"Logs\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"17\",\"controlador\":\"LogsController\",\"accion\":\"index\",\"icono\":null}]}'),(3,1,'Usuarios','2024-01-12 12:08:05','Login','{\"usuario_id\":\"1\",\"usuario_usuario\":\"mquezada@pccurico.cl\",\"usuario_password_raw\":\"12345\",\"usuario_password\":\"827ccb0eea8a706c4c34a16891f84e7b\",\"usuario_nombre\":\"Mat\\u00edas Quezada Sanhueza\",\"usuario_email\":\"mquezada@pccurico.cl\",\"usuario_guarda\":\"1\",\"usuario_edita\":\"1\",\"usuario_elimina\":\"1\",\"roles_id\":\"2\",\"roles_nombre\":\"Usuario\",\"opciones\":[{\"id\":\"6\",\"nombre\":\"Roles\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"index\",\"icono\":null}]}'),(4,1,'Usuarios','2024-01-12 12:11:10','Login','{\"usuario_id\":\"1\",\"usuario_usuario\":\"mquezada@pccurico.cl\",\"usuario_password_raw\":\"12345\",\"usuario_password\":\"827ccb0eea8a706c4c34a16891f84e7b\",\"usuario_nombre\":\"Mat\\u00edas Quezada Sanhueza\",\"usuario_email\":\"mquezada@pccurico.cl\",\"usuario_guarda\":\"1\",\"usuario_edita\":\"1\",\"usuario_elimina\":\"1\",\"roles_id\":\"1\",\"roles_nombre\":\"Administrador\",\"opciones\":[{\"id\":\"4\",\"nombre\":\"Param\\u00e9trica\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"3\",\"controlador\":\"ConfiguracionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"5\",\"nombre\":\"Usuarios\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"3\",\"controlador\":\"UsuariosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"6\",\"nombre\":\"Roles\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"7\",\"nombre\":\"Opciones\",\"nivel\":\"3\",\"orden\":\"4\",\"padre\":\"3\",\"controlador\":\"OpcionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"8\",\"nombre\":\"Permisos\",\"nivel\":\"3\",\"orden\":\"5\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"permisos\",\"icono\":null},{\"id\":\"9\",\"nombre\":\"Organizaciones\",\"nivel\":\"3\",\"orden\":\"6\",\"padre\":\"3\",\"controlador\":\"OrganizacionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"10\",\"nombre\":\"Tipo Dispositivo\",\"nivel\":\"3\",\"orden\":\"7\",\"padre\":\"3\",\"controlador\":\"TipoDispositivoController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"11\",\"nombre\":\"Marcas\",\"nivel\":\"3\",\"orden\":\"8\",\"padre\":\"3\",\"controlador\":\"MarcasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"12\",\"nombre\":\"Dispositivos\",\"nivel\":\"3\",\"orden\":\"9\",\"padre\":\"3\",\"controlador\":\"DispositivosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"14\",\"nombre\":\"Esquema de Horarios\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"schema\",\"icono\":null},{\"id\":\"15\",\"nombre\":\"Capturas\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"16\",\"nombre\":\"Consolidar\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"consolidate\",\"icono\":null},{\"id\":\"18\",\"nombre\":\"Registros\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"17\",\"controlador\":\"CapturasController\",\"accion\":\"report\",\"icono\":null},{\"id\":\"19\",\"nombre\":\"Logs\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"17\",\"controlador\":\"LogsController\",\"accion\":\"index\",\"icono\":null}]}'),(5,0,'Usuarios','2024-01-12 12:19:09','Intento Login (Usuario Deshabilitado)','{\"usuario\":\"mquezada@pccurico.cl\",\"password\":\"123453\"}'),(6,1,'Usuarios','2024-01-12 12:21:04','Login','{\"usuario_id\":\"1\",\"usuario_usuario\":\"mquezada@pccurico.cl\",\"usuario_password_raw\":\"12345\",\"usuario_password\":\"827ccb0eea8a706c4c34a16891f84e7b\",\"usuario_nombre\":\"Mat\\u00edas Quezada Sanhueza\",\"usuario_email\":\"mquezada@pccurico.cl\",\"usuario_guarda\":\"1\",\"usuario_edita\":\"1\",\"usuario_elimina\":\"1\",\"roles_id\":\"1\",\"roles_nombre\":\"Administrador\",\"opciones\":[{\"id\":\"4\",\"nombre\":\"Param\\u00e9trica\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"3\",\"controlador\":\"ConfiguracionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"5\",\"nombre\":\"Usuarios\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"3\",\"controlador\":\"UsuariosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"6\",\"nombre\":\"Roles\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"7\",\"nombre\":\"Opciones\",\"nivel\":\"3\",\"orden\":\"4\",\"padre\":\"3\",\"controlador\":\"OpcionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"8\",\"nombre\":\"Permisos\",\"nivel\":\"3\",\"orden\":\"5\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"permisos\",\"icono\":null},{\"id\":\"9\",\"nombre\":\"Organizaciones\",\"nivel\":\"3\",\"orden\":\"6\",\"padre\":\"3\",\"controlador\":\"OrganizacionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"10\",\"nombre\":\"Tipo Dispositivo\",\"nivel\":\"3\",\"orden\":\"7\",\"padre\":\"3\",\"controlador\":\"TipoDispositivoController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"11\",\"nombre\":\"Marcas\",\"nivel\":\"3\",\"orden\":\"8\",\"padre\":\"3\",\"controlador\":\"MarcasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"12\",\"nombre\":\"Dispositivos\",\"nivel\":\"3\",\"orden\":\"9\",\"padre\":\"3\",\"controlador\":\"DispositivosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"14\",\"nombre\":\"Esquema de Horarios\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"schema\",\"icono\":null},{\"id\":\"15\",\"nombre\":\"Capturas\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"16\",\"nombre\":\"Consolidar\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"consolidate\",\"icono\":null},{\"id\":\"18\",\"nombre\":\"Registros\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"17\",\"controlador\":\"CapturasController\",\"accion\":\"report\",\"icono\":null},{\"id\":\"19\",\"nombre\":\"Logs\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"17\",\"controlador\":\"LogsController\",\"accion\":\"index\",\"icono\":null}]}'),(7,1,'Usuarios','2024-01-12 12:21:25','Crear','{\"roles_id\":\"2\",\"email\":\"el_mts@hotmail.com\",\"password\":\"12345\",\"nombre\":\"usuario prueba\",\"estado\":\"1\",\"guarda\":\"1\",\"edita\":\"1\",\"elimina\":\"1\"}'),(8,1,'Usuarios','2024-01-12 12:25:08','Editar','{\"roles_id\":\"2\",\"email\":\"el_mts2@hotmail.com\",\"password\":\"827ccb0eea8a706c4c34a16891f84e7b\",\"nombre\":\"usuario prueba\",\"estado\":\"1\",\"guarda\":\"1\",\"edita\":\"1\",\"elimina\":\"1\"}'),(9,1,'Usuarios','2024-01-12 12:25:27','Eliminar','{\"id\":\"2\",\"roles_id\":\"2\",\"email\":\"el_mts2@hotmail.com\",\"password\":\"1f32aa4c9a1d2ea010adcf2348166a04\",\"nombre\":\"usuario prueba\",\"estado\":\"1\",\"guarda\":\"1\",\"edita\":\"1\",\"elimina\":\"1\"}'),(10,1,'Roles','2024-01-12 16:29:32','Crear','{\"nombre\":\"Prueba\"}'),(11,1,'Roles','2024-01-12 16:29:36','Editar','{\"nombre\":\"Prueba2\"}'),(12,1,'Roles','2024-01-12 16:29:40','Eliminar','{\"id\":\"3\",\"nombre\":\"Prueba2\"}'),(13,1,'Capturas','2024-01-12 12:42:13','Crear','{\"organizaciones_id\":\"1\",\"dispositivos_id\":\"1\",\"canal\":\"1\",\"fecha_hora\":\"2024-01-12 12:42:13\",\"ruta_imagen\":\"\",\"observacion\":\"bggg\",\"usuario_id\":1,\"consolidado\":\"1\"}'),(14,1,'Capturas','2024-01-12 12:43:12','Crear Esquema Horarios','{\"dispositivo\":\"1\",\"esquema\":[{\"canal\":\"1\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"2\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"3\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"4\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"5\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"6\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"7\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"8\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"9\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"10\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"11\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"12\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"13\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"14\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"15\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]},{\"canal\":\"16\",\"lun\":\"false\",\"mar\":\"false\",\"mie\":\"false\",\"jue\":\"false\",\"vie\":\"false\",\"sab\":\"false\",\"dom\":\"false\",\"horas\":[\"06:00\"]}]}'),(15,1,'Capturas','2024-01-12 12:43:38','Crear','{\"organizaciones_id\":\"1\",\"dispositivos_id\":\"1\",\"canal\":\"1\",\"fecha_hora\":\"2024-01-12 12:43:38\",\"ruta_imagen\":\"\",\"observacion\":\"ttt\",\"usuario_id\":1,\"consolidado\":\"0\"}'),(16,1,'Capturas','2024-01-12 12:43:56','Crear Consolidado','{\"capturas_id\":\"6\",\"data\":{\"observacion\":\"tttyyyy\",\"consolidado\":1}}'),(17,1,'Usuarios','2024-02-02 10:59:09','Login','{\"usuario_id\":\"1\",\"usuario_usuario\":\"mquezada@pccurico.cl\",\"usuario_password_raw\":\"12345\",\"usuario_password\":\"827ccb0eea8a706c4c34a16891f84e7b\",\"usuario_nombre\":\"Mat\\u00edas Quezada Sanhueza\",\"usuario_email\":\"mquezada@pccurico.cl\",\"usuario_guarda\":\"1\",\"usuario_edita\":\"1\",\"usuario_elimina\":\"1\",\"roles_id\":\"1\",\"roles_nombre\":\"Administrador\",\"opciones\":[{\"id\":\"4\",\"nombre\":\"Param\\u00e9trica\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"3\",\"controlador\":\"ConfiguracionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"5\",\"nombre\":\"Usuarios\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"3\",\"controlador\":\"UsuariosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"6\",\"nombre\":\"Roles\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"7\",\"nombre\":\"Opciones\",\"nivel\":\"3\",\"orden\":\"4\",\"padre\":\"3\",\"controlador\":\"OpcionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"8\",\"nombre\":\"Permisos\",\"nivel\":\"3\",\"orden\":\"5\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"permisos\",\"icono\":null},{\"id\":\"9\",\"nombre\":\"Organizaciones\",\"nivel\":\"3\",\"orden\":\"6\",\"padre\":\"3\",\"controlador\":\"OrganizacionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"10\",\"nombre\":\"Tipo Dispositivo\",\"nivel\":\"3\",\"orden\":\"7\",\"padre\":\"3\",\"controlador\":\"TipoDispositivoController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"11\",\"nombre\":\"Marcas\",\"nivel\":\"3\",\"orden\":\"8\",\"padre\":\"3\",\"controlador\":\"MarcasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"12\",\"nombre\":\"Dispositivos\",\"nivel\":\"3\",\"orden\":\"9\",\"padre\":\"3\",\"controlador\":\"DispositivosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"14\",\"nombre\":\"Esquema de Horarios\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"schema\",\"icono\":null},{\"id\":\"15\",\"nombre\":\"Capturas\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"16\",\"nombre\":\"Consolidar\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"consolidate\",\"icono\":null},{\"id\":\"18\",\"nombre\":\"Registros\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"17\",\"controlador\":\"CapturasController\",\"accion\":\"report\",\"icono\":null},{\"id\":\"19\",\"nombre\":\"Logs\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"17\",\"controlador\":\"LogsController\",\"accion\":\"index\",\"icono\":null}]}'),(18,1,'Dispositivos','2024-02-02 15:00:36','Editar','{\"organizaciones_id\":\"1\",\"tipo_dispositivo_id\":\"1\",\"marcas_id\":\"1\",\"nombre\":\"DVR Colegio\",\"cantidad_canales\":\"32\",\"ip\":\"201.236.179.91\",\"puerto\":\"81\",\"estado\":\"1\",\"ubicacion\":\"curico\",\"datos_extras\":\"<p>\\r\\n\\t<strong>dsadas<\\/strong><\\/p>\\r\\n\",\"codificar_dss\":\"1100\",\"cantidad_capturas\":\"10\",\"usuario\":\"sgmas\",\"password\":\"sgmas123\"}'),(19,1,'Capturas','2024-02-02 11:03:41','Success','{\"mensaje\":\"Se ha captura de manera correcta. (Dahua)\",\"data\":{\"organizacion_id\":\"1\",\"ip\":\"201.236.179.91:81\",\"puerto\":\"81\",\"usuario\":\"sgmas\",\"clave\":\"sgmas123\",\"canal\":\"4\"}}'),(20,1,'Usuarios','2024-02-02 11:56:29','Login','{\"usuario_id\":\"1\",\"usuario_usuario\":\"mquezada@pccurico.cl\",\"usuario_password_raw\":\"12345\",\"usuario_password\":\"827ccb0eea8a706c4c34a16891f84e7b\",\"usuario_nombre\":\"Mat\\u00edas Quezada Sanhueza\",\"usuario_email\":\"mquezada@pccurico.cl\",\"usuario_guarda\":\"1\",\"usuario_edita\":\"1\",\"usuario_elimina\":\"1\",\"roles_id\":\"1\",\"roles_nombre\":\"Administrador\",\"opciones\":[{\"id\":\"4\",\"nombre\":\"Param\\u00e9trica\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"3\",\"controlador\":\"ConfiguracionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"5\",\"nombre\":\"Usuarios\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"3\",\"controlador\":\"UsuariosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"6\",\"nombre\":\"Roles\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"7\",\"nombre\":\"Opciones\",\"nivel\":\"3\",\"orden\":\"4\",\"padre\":\"3\",\"controlador\":\"OpcionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"8\",\"nombre\":\"Permisos\",\"nivel\":\"3\",\"orden\":\"5\",\"padre\":\"3\",\"controlador\":\"RolesController\",\"accion\":\"permisos\",\"icono\":null},{\"id\":\"9\",\"nombre\":\"Organizaciones\",\"nivel\":\"3\",\"orden\":\"6\",\"padre\":\"3\",\"controlador\":\"OrganizacionesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"10\",\"nombre\":\"Tipo Dispositivo\",\"nivel\":\"3\",\"orden\":\"7\",\"padre\":\"3\",\"controlador\":\"TipoDispositivoController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"11\",\"nombre\":\"Marcas\",\"nivel\":\"3\",\"orden\":\"8\",\"padre\":\"3\",\"controlador\":\"MarcasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"12\",\"nombre\":\"Dispositivos\",\"nivel\":\"3\",\"orden\":\"9\",\"padre\":\"3\",\"controlador\":\"DispositivosController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"20\",\"nombre\":\"Canales\",\"nivel\":\"3\",\"orden\":\"10\",\"padre\":\"3\",\"controlador\":\"CanalesController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"14\",\"nombre\":\"Esquema de Horarios\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"schema\",\"icono\":null},{\"id\":\"15\",\"nombre\":\"Capturas\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"index\",\"icono\":null},{\"id\":\"16\",\"nombre\":\"Consolidar\",\"nivel\":\"3\",\"orden\":\"3\",\"padre\":\"13\",\"controlador\":\"CapturasController\",\"accion\":\"consolidate\",\"icono\":null},{\"id\":\"18\",\"nombre\":\"Registros\",\"nivel\":\"3\",\"orden\":\"1\",\"padre\":\"17\",\"controlador\":\"CapturasController\",\"accion\":\"report\",\"icono\":null},{\"id\":\"19\",\"nombre\":\"Logs\",\"nivel\":\"3\",\"orden\":\"2\",\"padre\":\"17\",\"controlador\":\"LogsController\",\"accion\":\"index\",\"icono\":null}]}'),(21,1,'Capturas','2024-02-02 15:32:57','Success','{\"mensaje\":\"Se ha captura de manera correcta. (Dahua)\",\"data\":{\"organizacion_id\":\"1\",\"ip\":\"201.236.179.91:81\",\"puerto\":\"81\",\"usuario\":\"sgmas\",\"clave\":\"sgmas123\",\"canal\":\"1\"}}'),(22,1,'Capturas','2024-02-02 15:33:07','Success','{\"mensaje\":\"Se ha captura de manera correcta. (Dahua)\",\"data\":{\"organizacion_id\":\"1\",\"ip\":\"201.236.179.91:81\",\"puerto\":\"81\",\"usuario\":\"sgmas\",\"clave\":\"sgmas123\",\"canal\":\"1\"}}'),(23,1,'Capturas','2024-02-02 15:33:11','Crear','{\"organizaciones_id\":\"1\",\"dispositivos_id\":\"1\",\"canal\":\"1\",\"fecha_hora\":\"2024-02-02 15:33:11\",\"ruta_imagen\":\"captura_1_1_1_20240202153307.jpg\",\"observacion\":\"\",\"usuario_id\":\"1\",\"consolidado\":\"0\"}'),(24,1,'Capturas','2024-02-02 15:47:40','Success','{\"mensaje\":\"Se ha captura de manera correcta. (Dahua)\",\"data\":{\"organizacion_id\":\"1\",\"ip\":\"201.236.179.91:81\",\"puerto\":\"81\",\"usuario\":\"sgmas\",\"clave\":\"sgmas123\",\"canal\":\"14\"}}');

/*Table structure for table `marcas` */

DROP TABLE IF EXISTS `marcas`;

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `marcas` */

insert  into `marcas`(`id`,`nombre`) values (1,'DAHUA'),(2,'HIKVISION');

/*Table structure for table `observaciones_sugeridas` */

DROP TABLE IF EXISTS `observaciones_sugeridas`;

CREATE TABLE `observaciones_sugeridas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `observacion` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `observaciones_sugeridas` */

insert  into `observaciones_sugeridas`(`id`,`observacion`) values (1,'hallazgo 1'),(2,'hallazgo 2');

/*Table structure for table `opcion_rol` */

DROP TABLE IF EXISTS `opcion_rol`;

CREATE TABLE `opcion_rol` (
  `opciones_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`opciones_id`,`roles_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `opcion_rol` */

insert  into `opcion_rol`(`opciones_id`,`roles_id`) values (4,1),(5,1),(6,1),(6,2),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(14,1),(15,1),(16,1),(18,1),(19,1),(20,1);

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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `opciones` */

insert  into `opciones`(`id`,`nombre`,`nivel`,`orden`,`padre`,`controlador`,`accion`,`icono`) values (1,'INTERFACE',1,1,0,NULL,NULL,NULL),(2,'REPORTES',1,2,0,NULL,NULL,NULL),(3,'Configuración',2,1,1,NULL,NULL,NULL),(4,'Paramétrica',3,1,3,'ConfiguracionesController','index',NULL),(5,'Usuarios',3,2,3,'UsuariosController','index',NULL),(6,'Roles',3,3,3,'RolesController','index',NULL),(7,'Opciones',3,4,3,'OpcionesController','index',NULL),(8,'Permisos',3,5,3,'RolesController','permisos',NULL),(9,'Organizaciones',3,6,3,'OrganizacionesController','index',NULL),(10,'Tipo Dispositivo',3,7,3,'TipoDispositivoController','index',NULL),(11,'Marcas',3,8,3,'MarcasController','index',NULL),(12,'Dispositivos',3,9,3,'DispositivosController','index',NULL),(13,'Gestión',2,2,1,NULL,NULL,NULL),(14,'Esquema de Horarios',3,1,13,'CapturasController','schema',NULL),(15,'Capturas',3,2,13,'CapturasController','index',NULL),(16,'Consolidar',3,3,13,'CapturasController','consolidate',NULL),(17,'Entidad',2,1,2,NULL,NULL,NULL),(18,'Registros',3,1,17,'CapturasController','report',NULL),(19,'Logs',3,2,17,'LogsController','index',NULL),(20,'Canales',3,10,3,'CanalesController','index',NULL);

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

insert  into `organizaciones`(`id`,`nombre`,`cantidad_dispositivos`,`creado`,`rut`,`razon_social`,`direccion`,`contacto`,`telefono`,`email`) values (1,'Organizacion 1',1,'2023-11-25 18:38:52','11.111.111-1','AAAA','DIR DIR','CONTACTO','123456','HOLA@GMAIL.COM');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`nombre`) values (1,'Administrador'),(2,'Usuario');

/*Table structure for table `tipo_dispositivo` */

DROP TABLE IF EXISTS `tipo_dispositivo`;

CREATE TABLE `tipo_dispositivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
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
  `estado` tinyint(1) DEFAULT NULL,
  `guarda` tinyint(1) DEFAULT NULL,
  `edita` tinyint(1) DEFAULT NULL,
  `elimina` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id`,`roles_id`,`email`,`password`,`nombre`,`estado`,`guarda`,`edita`,`elimina`) values (1,1,'mquezada@pccurico.cl','827ccb0eea8a706c4c34a16891f84e7b','Matías Quezada Sanhueza',1,1,1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
