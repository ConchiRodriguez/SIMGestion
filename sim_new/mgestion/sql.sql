CREATE TABLE `sim_articulos` ( `id` int(11) NOT NULL auto_increment,  PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id` ;
ALTER TABLE `sim_articulos` ADD `codigo` varchar(6) NOT NULL default '0' AFTER `visible` ;
ALTER TABLE `sim_articulos` ADD `nombre` varchar(70) NOT NULL default '' AFTER `codigo` ;
ALTER TABLE `sim_articulos` ADD `id_subgrupo` int(11) NOT NULL default '0' AFTER `nombre` ;
ALTER TABLE `sim_articulos` ADD `notas` longtext AFTER `id_subgrupo` ;
ALTER TABLE `sim_articulos` ADD `descatalogat` tinyint(1) NOT NULL default '0' AFTER `notas` ;
ALTER TABLE `sim_articulos` ADD `img1` varchar(100) NOT NULL default '' AFTER `descatalogat` ;
ALTER TABLE `sim_articulos` ADD `img2` varchar(100) NOT NULL default '' AFTER `img1` ;
ALTER TABLE `sim_articulos` ADD `img3` varchar(100) NOT NULL default '' AFTER `img2` ;
ALTER TABLE `sim_articulos` ADD `escandall` tinyint(1) NOT NULL default '0' AFTER `img3` ;
ALTER TABLE `sim_articulos` ADD `recalc_escandall` tinyint(1) NOT NULL default '0' AFTER `escandall` ;
ALTER TABLE `sim_articulos` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `recalc_escandall` ;

CREATE TABLE `sim_articulos_escandall` ( `id` int(11) NOT NULL auto_increment,  PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_escandall` ADD `id_escandall` int(11) NOT NULL default '0' AFTER `id` ;
ALTER TABLE `sim_articulos_escandall` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `id_escandall` ;
ALTER TABLE `sim_articulos_escandall` ADD `unidades` decimal(11,3) NOT NULL default '0' AFTER `id_articulo` ;
ALTER TABLE `sim_articulos_escandall` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `unidades` ;
ALTER TABLE `sim_articulos_escandall` ADD `pvd_forzado` decimal(11,3) NOT NULL default '0' AFTER `visible` ;
ALTER TABLE `sim_articulos_escandall` ADD `pvp_forzado` decimal(11,3) NOT NULL default '0' AFTER `pvd_forzado` ;

CREATE TABLE `sim_articulos_caracteristicas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) ) ;
ALTER TABLE `sim_articulos_caracteristicas` ADD `id_caracteristica` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_caracteristicas` ADD `nombre` varchar(25) NOT NULL default '' AFTER `id_caracteristica`;
ALTER TABLE `sim_articulos_caracteristicas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `nombre`;
ALTER TABLE `sim_articulos_caracteristicas` ADD `unidad` varchar(25) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sim_articulos_caracteristicas` ADD `unidad_abr` varchar(10) NOT NULL default '' AFTER `unidad`;
ALTER TABLE `sim_articulos_caracteristicas` ADD `valor` varchar(25) NOT NULL default '' AFTER `unidad_abr`;

CREATE TABLE `sim_articulos_caracteristicas_tablas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) ) ;
ALTER TABLE `sim_articulos_caracteristicas_tablas` ADD `id_caracteristica` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_caracteristicas_tablas` ADD `valor` varchar(25) NOT NULL default '' AFTER `id_caracteristica`;
ALTER TABLE `sim_articulos_caracteristicas_tablas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `valor`;

CREATE TABLE `sim_articulos_grupos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_grupos` ADD `codigo` varchar(5) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_articulos_grupos` ADD `grupo` varchar(30) NOT NULL default '' AFTER `codigo`;

CREATE TABLE `sim_articulos_grupos_idiomas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_grupos_idiomas` ADD `id_grupo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_grupos_idiomas` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_grupo` ;
ALTER TABLE `sim_articulos_grupos_idiomas` ADD `grupo` varchar(30) NOT NULL default '' AFTER `id_idioma`;

CREATE TABLE `sim_articulos_precios` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_precios` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_precios` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `id_articulo`;
ALTER TABLE `sim_articulos_precios` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `fecha`;
ALTER TABLE `sim_articulos_precios` ADD `pvp` decimal(10,3) NOT NULL default '0.000' AFTER `id_usuario`;
ALTER TABLE `sim_articulos_precios` ADD `pvd` decimal(10,3) NOT NULL default '0.000' AFTER `pvp`;
ALTER TABLE `sim_articulos_precios` ADD `vigente` tinyint(1) NOT NULL default '0' AFTER `pvd`;
ALTER TABLE `sim_articulos_precios` ADD `id_divisa_pvp` int(11) NOT NULL default '0' AFTER `vigente` ;
ALTER TABLE `sim_articulos_precios` ADD `id_divisa_pvd` int(11) NOT NULL default '0' AFTER `id_divisa_pvp` ;

CREATE TABLE `sim_articulos_rel_caracteristicas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_rel_caracteristicas` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_rel_caracteristicas` ADD `id_valor` int(11) NOT NULL default '0' AFTER `id_articulo`;
ALTER TABLE `sim_articulos_rel_caracteristicas` ADD `valor` varchar(50) NOT NULL default '' AFTER `id_valor`;

CREATE TABLE `sim_articulos_rel_proveedores` ( `id` int(11) NOT NULL auto_increment,  PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_rel_proveedores` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_rel_proveedores` ADD `id_proveedor` int(11) NOT NULL default '0' AFTER `id_articulo`;
ALTER TABLE `sim_articulos_rel_proveedores` ADD `codigo_proveedor` varchar(30) NOT NULL default '' AFTER `id_proveedor`;
ALTER TABLE `sim_articulos_rel_proveedores` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `codigo_proveedor`;

CREATE TABLE `sim_articulos_subgrupos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_subgrupos` ADD `id_grupo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_subgrupos` ADD `codigo` varchar(5) NOT NULL default '' AFTER `id_grupo`;
ALTER TABLE `sim_articulos_subgrupos` ADD `subgrupo` varchar(30) NOT NULL default '' AFTER `codigo`;
ALTER TABLE `sim_articulos_subgrupos` ADD `contador` int(11) NOT NULL default '0' AFTER `subgrupo`;

CREATE TABLE `sim_articulos_subgrupos_idiomas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_subgrupos_idiomas` ADD `id_subgrupo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_subgrupos_idiomas` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_subgrupo` ;
ALTER TABLE `sim_articulos_subgrupos_idiomas` ADD `subgrupo` varchar(30) NOT NULL default '' AFTER `id_idioma`;

CREATE TABLE `sim_articulos_subgrupos_caracteristicas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_articulos_subgrupos_caracteristicas` ADD `id_subgrupo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_articulos_subgrupos_caracteristicas` ADD `id_caracteristica` int(11) NOT NULL default '0' AFTER `id_subgrupo` ;

CREATE TABLE `sim_calendario` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_calendario` ADD `dia` int(11) NOT NULL default '0' AFTER `id` ;
ALTER TABLE `sim_calendario` ADD `mes` int(11) NOT NULL default '0' AFTER `dia` ;
ALTER TABLE `sim_calendario` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `mes`;

CREATE TABLE `sim_calendario_horario` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_calendario_horario` ADD `dia` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_calendario_horario` ADD `hora_inicio` int(11) NOT NULL default '0' AFTER `dia` ;
ALTER TABLE `sim_calendario_horario` ADD `hora_fin` int(11) NOT NULL default '0' AFTER `hora_inicio` ;
ALTER TABLE `sim_calendario_horario` ADD `total_horas` int(11) NOT NULL default '0' AFTER `hora_fin` ;

CREATE TABLE `sim_clientes` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes` ADD `id_origen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_clientes` ADD `id_agrupacion` int(11) NOT NULL default '0' AFTER `id_origen`;
ALTER TABLE `sim_clientes` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_agrupacion`;
ALTER TABLE `sim_clientes` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sim_clientes` ADD `apellido1` varchar(55) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sim_clientes` ADD `apellido2` varchar(55) NOT NULL default '' AFTER `apellido1`;
ALTER TABLE `sim_clientes` ADD `tipo_identificador` tinyint(1) NOT NULL default '1' AFTER `apellido2`;
/*tipo_identificador: 1 nif; 2 VAT; 3 extrangero; 4 sin numero*/
ALTER TABLE `sim_clientes` ADD `nif` varchar(15) NOT NULL default '' AFTER `tipo_identificador`;
ALTER TABLE `sim_clientes` ADD `direccion` varchar(255) NOT NULL default '' AFTER `nif`;
ALTER TABLE `sim_clientes` ADD `poblacion` varchar(50) NOT NULL default '' AFTER `direccion`;
ALTER TABLE `sim_clientes` ADD `cp` varchar(5) NOT NULL default '' AFTER `poblacion`;
ALTER TABLE `sim_clientes` ADD `provincia` varchar(15) NOT NULL default '' AFTER `cp`;
ALTER TABLE `sim_clientes` ADD `id_pais` int(11) NOT NULL default '0' AFTER `provincia`;
ALTER TABLE `sim_clientes` ADD `tipo_persona` tinyint(1) NOT NULL default '0' AFTER `id_pais`;
/*tipo_persona: 0 juridica; 1 física*/
ALTER TABLE `sim_clientes` ADD `tipo_residencia` int(11) NOT NULL default '0' AFTER `tipo_persona`;
/*tipo_residencia: 0 residente; 1 residente UE; 2 extrangero*/
/*DIR3 per factura electronica*/
ALTER TABLE `sim_clientes` ADD `dir3_oficina_contable` varchar(15) NOT NULL default '' AFTER `tipo_residencia`;
ALTER TABLE `sim_clientes` ADD `dir3_organo_gestor` varchar(15) NOT NULL default '' AFTER `dir3_oficina_contable`;
ALTER TABLE `sim_clientes` ADD `dir3_unidad_tramitadora` varchar(15) NOT NULL default '' AFTER `dir3_organo_gestor`;
ALTER TABLE `sim_clientes` ADD `mail` varchar(50) NOT NULL default '' AFTER `dir3_unidad_tramitadora`;
ALTER TABLE `sim_clientes` ADD `telefono` varchar(15) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sim_clientes` ADD `telefono2` varchar(15) NOT NULL default '' AFTER `telefono`;
ALTER TABLE `sim_clientes` ADD `fax` varchar(15) NOT NULL default '' AFTER `telefono2`;
ALTER TABLE `sim_clientes` ADD `web` varchar(150) default NULL AFTER `fax`;
ALTER TABLE `sim_clientes` ADD `alias` varchar(11) NOT NULL default '' AFTER `web`;
ALTER TABLE `sim_clientes` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `alias`;
ALTER TABLE `sim_clientes` ADD `cliente_fid` tinyint(1) NOT NULL default '0' AFTER `id_idioma`;
ALTER TABLE `sim_clientes` ADD `cliente_vip` tinyint(1) NOT NULL default '0' AFTER `cliente_fid`;
ALTER TABLE `sim_clientes` ADD `cuenta_bancaria` varchar(30) default NULL AFTER `cliente_vip`;
ALTER TABLE `sim_clientes` ADD `dia_facturacion` int(11) NOT NULL default '0' AFTER `cuenta_bancaria`;
ALTER TABLE `sim_clientes` ADD `dia_recibo` int(11) NOT NULL default '0' AFTER `dia_facturacion`;
ALTER TABLE `sim_clientes` ADD `unidad_vencimiento` int(11) NOT NULL default '0' AFTER `dia_recibo`;
ALTER TABLE `sim_clientes` ADD `vencimiento` tinyint(1) NOT NULL default '1' AFTER `unidad_vencimiento`;
/*vencimiento: 0 dias; 1 meses*/

CREATE TABLE `sim_clientes_busquedas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_busquedas` ADD `nombre` varchar(20) default NULL AFTER `id`;
ALTER TABLE `sim_clientes_busquedas` ADD `letras` varchar(30) default NULL AFTER `nombre`;
ALTER TABLE `sim_clientes_busquedas` ADD `tipos` varchar(50) NOT NULL default '' AFTER `letras`;
ALTER TABLE `sim_clientes_busquedas` ADD `sectores` varchar(50) NOT NULL default '' AFTER `tipos`;
ALTER TABLE `sim_clientes_busquedas` ADD `origenes` varchar(50) NOT NULL default '' AFTER `sectores`;
ALTER TABLE `sim_clientes_busquedas` ADD `paises` varchar(50) NOT NULL default '' AFTER `origenes`;
ALTER TABLE `sim_clientes_busquedas` ADD `comunidades` varchar(50) NOT NULL default '' AFTER `paises`;
ALTER TABLE `sim_clientes_busquedas` ADD `provincias` varchar(50) NOT NULL default '' AFTER `comunidades`;
ALTER TABLE `sim_clientes_busquedas` ADD `regiones` varchar(50) NOT NULL default '' AFTER `provincias` ;
ALTER TABLE `sim_clientes_busquedas` ADD `likenombre` varchar(20) default NULL AFTER `regiones`;

CREATE TABLE `sim_clientes_contactos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_contactos` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_clientes_contactos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_cliente`;
ALTER TABLE `sim_clientes_contactos` ADD `notas` longtext AFTER `visible`;
ALTER TABLE `sim_clientes_contactos` ADD `nombre` varchar(255) NOT NULL default '' AFTER `notas`;
ALTER TABLE `sim_clientes_contactos` ADD `cargo` varchar(255) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sim_clientes_contactos` ADD `departamento` varchar(255) NOT NULL default '' AFTER `cargo`;
ALTER TABLE `sim_clientes_contactos` ADD `telefono` varchar(15) NOT NULL default '' AFTER `departamento`;
ALTER TABLE `sim_clientes_contactos` ADD `fax` varchar(15) NOT NULL default '' AFTER `telefono`;
ALTER TABLE `sim_clientes_contactos` ADD `mail` varchar(50) NOT NULL default '' AFTER `fax`;
ALTER TABLE `sim_clientes_contactos` ADD `mobil` varchar(15) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sim_clientes_contactos` ADD `id_trato` int(11) NOT NULL default '0' AFTER `mobil`;
ALTER TABLE `sim_clientes_contactos` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_trato`;
ALTER TABLE `sim_clientes_contactos` ADD `pred` tinyint(1) NOT NULL default '0' AFTER `id_idioma`;
ALTER TABLE `sim_clientes_contactos` ADD `apellido1` varchar(255) NOT NULL default '' AFTER `pred`;
ALTER TABLE `sim_clientes_contactos` ADD `apellido2` varchar(255) NOT NULL default '' AFTER `apellido1`;

CREATE TABLE `sim_clients_dias_vencimiento` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clients_dias_vencimiento` ADD `dia` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_clients_dias_vencimiento` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `dia`;

CREATE TABLE `sim_clientes_origen` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_origen` ADD `origen` varchar(30) NOT NULL default '' AFTER `id`;

CREATE TABLE `sim_clientes_rel_origen` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_rel_origen` ADD `id_cliente` int(11) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_clientes_rel_origen` ADD `id_origen` int(11) NOT NULL AFTER `id_cliente`;
ALTER TABLE `sim_clientes_rel_origen` ADD `tipo_origen` int(11) NOT NULL AFTER `id_origen`;
ALTER TABLE `sim_clientes_rel_origen` ADD `otro_origen` varchar(30) NOT NULL default '' AFTER `tipo_origen`;
/*tipo_origen: 1 origen; 2 cliente; 3 contacto; 4 empleado; 5 otros*/

CREATE TABLE `sim_clientes_rel_sectores` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_rel_sectores` ADD `id_sector` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sim_clientes_rel_sectores` ADD `id_cliente` varchar(30) NOT NULL default '' AFTER `id_sector`;

CREATE TABLE `sim_clientes_rel_tipos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_rel_tipos` ADD `id_tipo` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sim_clientes_rel_tipos` ADD `id_cliente` varchar(30) NOT NULL default '' AFTER `id_tipo`;

CREATE TABLE `sim_clientes_rel_ubicacion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_rel_ubicacion` ADD `id_cliente` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_clientes_rel_ubicacion` ADD `id_ubicacion` int(11) NOT NULL AFTER `id_cliente`;
ALTER TABLE `sim_clientes_rel_ubicacion` ADD `tipo_ubicacion` int(11) NOT NULL AFTER `id_ubicacion`;
/*tipo_ubicacion: 1 pais; 2 com. autonoma; 3 provincia; 4 región*/

CREATE TABLE `sim_clientes_sectores` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_sectores` ADD `id_sector` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sim_clientes_sectores` ADD `sector` varchar(30) NOT NULL default '' AFTER `id_sector`;

CREATE TABLE `sim_clientes_tipos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_tipos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sim_clientes_tipos` ADD `id_origen` int(11) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_clientes_tipos` ADD `nombre` varchar(255) NOT NULL default '' AFTER `id_origen`;
ALTER TABLE `sim_clientes_tipos` ADD `color` varchar(12) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sim_clientes_tipos` ADD `color_letra` varchar(12) NOT NULL default '' AFTER `color`;
ALTER TABLE `sim_clientes_tipos` ADD `factura` tinyint(1) NOT NULL default '0' AFTER `color_letra`;
ALTER TABLE `sim_clientes_tipos` ADD `id_tipo_factura` int(11) NOT NULL default '0' AFTER `factura`;
ALTER TABLE `sim_clientes_tipos` ADD `contrato` tinyint(1) NOT NULL default '0' AFTER `id_tipo_factura`;
ALTER TABLE `sim_clientes_tipos` ADD `contrato_activo` tinyint(1) NOT NULL default '0' AFTER `id_tipo_factura`;
ALTER TABLE `sim_clientes_tipos` ADD `incidencia` tinyint(1) NOT NULL default '0' AFTER `contrato_activo`;
ALTER TABLE `sim_clientes_tipos` ADD `datos_fiscales` tinyint(1) NOT NULL default '0' AFTER `incidencia`;

CREATE TABLE `sim_clientes_tarifas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_tarifas` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_clientes_tarifas` ADD `id_tarifa` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_clientes_tarifas` ADD `predeterminado` tinyint(1) NOT NULL default '1' AFTER `id_tarifa`;

CREATE TABLE `sim_clientes_tratos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_clientes_tratos` ADD `trato` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_clientes_tratos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `trato`;
ALTER TABLE `sim_clientes_tratos` ADD `predeterminado` tinyint(1) NOT NULL default '0' AFTER `visible`;
INSERT INTO `sim_clientes_tratos` VALUES (1, 'Sr.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (2, 'Sra.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (3, 'Mr.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (4, 'Ms.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (5, 'M.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (6, 'Mme.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (7, 'Mlle',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (8, 'Hr.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (9, 'Fr.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (10, 'Illo.',1,0);
INSERT INTO `sim_clientes_tratos` VALUES (11, 'Illa.',1,0);

CREATE TABLE `sim_comunidades_autonomas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_comunidades_autonomas` ADD `comunidad_autonoma` varchar(50) default NULL AFTER `id`;
ALTER TABLE `sim_comunidades_autonomas` ADD `siglas` char(3) default NULL AFTER `comunidad_autonoma`;
ALTER TABLE `sim_comunidades_autonomas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `siglas`;
ALTER TABLE `sim_comunidades_autonomas` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `visible`;
INSERT INTO `sim_comunidades_autonomas` (`id`,`comunidad_autonoma`,`siglas`,`visible`,`predefinido`) VALUES (1,'Andalucía','AN',1,0),(2,'Aragón','AR',1,0),(3,'Asturias, Principado de','AS',1,0),(4,'Balears, Illes','IB',1,0),(5,'Canarias','CN',1,0),(6,'Cantabria','CB',1,0),(7,'Castilla y León','CL',1,0),(8,'Castilla - La Mancha','CM',1,0),(9,'Catalunya','CT',1,1),(10,'Comunitat Valenciana','VC',1,0),(11,'Extremadura','EX',1,0),(12,'Galicia','GA',1,0),(13,'Madrid, Comunidad de','MD',1,0),(14,'Murcia, Región de','MC',1,0),(15,'Navarra, Comunidad Foral de','NC',1,0),(16,'País Vasco','PV',1,0),(17,'Rioja, La','RI',1,0),(18,'Ceuta','CE',1,0),(19,'Melilla','ML',1,0);

CREATE TABLE `sim_contenidos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos` ADD `id_autor` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_autor`;
ALTER TABLE `sim_contenidos` ADD `fecha_creacion` int(15) NOT NULL default '0' AFTER `id_idioma`;
ALTER TABLE `sim_contenidos` ADD `fecha_publicacion` int(15) NOT NULL default '0' AFTER `fecha_creacion`;
ALTER TABLE `sim_contenidos` ADD `titulo` varchar(55) NOT NULL default '' AFTER `fecha_publicacion`;
ALTER TABLE `sim_contenidos` ADD `contenido` longtext AFTER `titulo`;
ALTER TABLE `sim_contenidos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `contenido`;

CREATE TABLE `sim_contenidos_revisiones` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_revisiones` ADD `id_autor_revision` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_revisiones` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_autor_revision`;
ALTER TABLE `sim_contenidos_revisiones` ADD `fecha_revision` int(15) NOT NULL default '0' AFTER `id_contenido`;

CREATE TABLE `sim_contenidos_categorias` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_categorias` ADD `categoria` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contenidos_categorias` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `categoria`;

CREATE TABLE `sim_contenidos_rel_categorias` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_rel_categorias` ADD `id_categoria` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_rel_categorias` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_categoria`;

CREATE TABLE `sim_contenidos_etiquetas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_etiquetas` ADD `etiqueta` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contenidos_etiquetas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `etiqueta`;

CREATE TABLE `sim_contenidos_rel_etiquetas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_rel_etiquetas` ADD `id_etiqueta` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_rel_etiquetas` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_etiqueta`;

CREATE TABLE `sim_contenidos_medios_publicacion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_medios_publicacion` ADD `medio_publicacion` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contenidos_medios_publicacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `medio_publicacion`;

CREATE TABLE `sim_contenidos_rel_medios_publicacion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_rel_medios_publicacion` ADD `id_medios_publicacion` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_rel_medios_publicacion` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_medios_publicacion`;

CREATE TABLE `sim_contenidos_redes_sociales` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_redes_sociales` ADD `red_social` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contenidos_redes_sociales` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `red_social`;

CREATE TABLE `sim_contenidos_rel_redes_sociales` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contenidos_rel_redes_sociales` ADD `id_redes_sociales` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_rel_redes_sociales` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_redes_sociales`;

CREATE TABLE `sim_contratos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contratos` ADD `id_contrato_tipo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contratos` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id_contrato_tipo`;
ALTER TABLE `sim_contratos` ADD `id_cliente_final` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_contratos` ADD `num_contrato` int(11) NOT NULL default '0' AFTER `id_cliente_final`;
ALTER TABLE `sim_contratos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `num_contrato`;
ALTER TABLE `sim_contratos` ADD `fecha_ini` date NOT NULL default '0000-00-00' AFTER `visible`;
ALTER TABLE `sim_contratos` ADD `fecha_fin` date NOT NULL default '0000-00-00' AFTER `fecha_ini`;
ALTER TABLE `sim_contratos` ADD `activo` tinyint(1) NOT NULL default '1' AFTER `fecha_fin`;
ALTER TABLE `sim_contratos` ADD `descripcion` longtext AFTER `activo`;
ALTER TABLE `sim_contratos` ADD `id_responsable` int(11) NOT NULL default '0' AFTER `descripcion`;
ALTER TABLE `sim_contratos` ADD `id_tecnico` int(11) NOT NULL default '0' AFTER `id_responsable`;
ALTER TABLE `sim_contratos` ADD `renovado` tinyint(1) NOT NULL default '0' AFTER `id_tecnico`;
ALTER TABLE `sim_contratos` ADD `id_plantilla` int(11) NOT NULL default '0' AFTER `renovado`;
ALTER TABLE `sim_contratos` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `id_plantilla`;

CREATE TABLE `sim_contratos_sla_cobertura` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contratos_sla_cobertura` ADD `nombre` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contratos_sla_cobertura` ADD `descripcion` longtext AFTER `nombre`;
ALTER TABLE `sim_contratos_sla_cobertura` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;

CREATE TABLE `sim_contratos_tipos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contratos_tipos` ADD `nombre` varchar(255) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contratos_tipos` ADD `descripcion` longtext AFTER `nombre`;
ALTER TABLE `sim_contratos_tipos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;

CREATE TABLE `sim_contratos_servicio` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contratos_servicio` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contratos_servicio` ADD `servicio` varchar(55) NOT NULL default '' AFTER `id_contrato`;
ALTER TABLE `sim_contratos_servicio` ADD `id_cobertura` int(11) NOT NULL default '0' AFTER `servicio`;
ALTER TABLE `sim_contratos_servicio` ADD `tiempo_respuesta` int(11) NOT NULL default '0' AFTER `id_cobertura`;
ALTER TABLE `sim_contratos_servicio` ADD `nbd` tinyint(1) NOT NULL default '1' AFTER `tiempo_respuesta`;
ALTER TABLE `sim_contratos_servicio` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `nbd`;
ALTER TABLE `sim_contratos_servicio` ADD `extranet` tinyint(1) NOT NULL default '1' AFTER `visible`;
ALTER TABLE `sim_contratos_servicio` ADD `obligatorio` tinyint(1) NOT NULL default '1' AFTER `extranet`;
ALTER TABLE `sim_contratos_servicio` ADD `incidencias` tinyint(1) NOT NULL default '1' AFTER `obligatorio`;
ALTER TABLE `sim_contratos_servicio` ADD `sla` int(11) NOT NULL default '0' AFTER `incidencias`;
ALTER TABLE `sim_contratos_servicio` ADD `duracion` int(11) NOT NULL default '0' AFTER `sla`;
ALTER TABLE `sim_contratos_servicio` ADD `precio_hora` decimal(11,3) NOT NULL default '0.000' AFTER `duracion`;
ALTER TABLE `sim_contratos_servicio` ADD `codigo_catalogo` varchar(55) NOT NULL default '' AFTER `precio_hora`;
ALTER TABLE `sim_contratos_servicio` ADD `auto_email` tinyint(1) NOT NULL default '0' AFTER `codigo_catalogo`;
ALTER TABLE `sim_contratos_servicio` ADD `funcion` varchar(55) NOT NULL default '' AFTER `auto_email`;
ALTER TABLE `sim_contratos_servicio` ADD `id_servicio_origen` int(11) NOT NULL default '0' AFTER `funcion`;

CREATE TABLE `sim_contrasenas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contrasenas` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contrasenas` ADD `id_aplicacion` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_contrasenas` ADD `acceso` varchar(100) NOT NULL default '' AFTER `id_aplicacion`;
ALTER TABLE `sim_contrasenas` ADD `usuario` varchar(50) NOT NULL default '' AFTER `acceso`;
ALTER TABLE `sim_contrasenas` ADD `contrasena` varchar(50) NOT NULL default '' AFTER `usuario`;
ALTER TABLE `sim_contrasenas` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `contrasena`;
ALTER TABLE `sim_contrasenas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;
ALTER TABLE `sim_contrasenas` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sim_contrasenas_apliciones` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contrasenas_apliciones` ADD `aplicacion` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contrasenas_apliciones` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `aplicacion`;
ALTER TABLE `sim_contrasenas_apliciones` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;

CREATE TABLE `sim_contrasenas_lopd` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_contrasenas_lopd` ADD `id_contrasena` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contrasenas_lopd` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_contrasena`;
ALTER TABLE `sim_contrasenas_lopd` ADD `fecha` int(11) NOT NULL default '0' AFTER `id_usuario`;
ALTER TABLE `sim_contrasenas_lopd` ADD `accion` int(11) NOT NULL default '0' AFTER `fecha`;

CREATE TABLE `sim_divisas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_divisas` ADD `divisa` varchar(255) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_divisas` ADD `abrev` varchar(3) NOT NULL default '' AFTER `divisa`;
ALTER TABLE `sim_divisas` ADD `cambio` decimal(11,3) NOT NULL default '0.000' AFTER `abrev`;
ALTER TABLE `sim_divisas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `cambio`;
ALTER TABLE `sim_divisas` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_divisas` ADD `simbolo` varchar(1) AFTER `predefinido`;

CREATE TABLE `sim_divisas_cambios` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_divisas_cambios` ADD `id_divisa_origen` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sim_divisas_cambios` ADD `id_divisa_destino` int(11) NOT NULL AFTER `id_divisa_origen`;
ALTER TABLE `sim_divisas_cambios` ADD `cambio` decimal(11,4) NOT NULL default '0.0000' AFTER `id_divisa_destino`;
ALTER TABLE `sim_divisas_cambios` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `cambio`;

CREATE TABLE `sim_divisas_mod_cambio` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_divisas_mod_cambio` ADD `id_divisa_origen` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sim_divisas_mod_cambio` ADD `id_divisa_destino` int(11) NOT NULL AFTER `id_divisa_origen`;
ALTER TABLE `sim_divisas_mod_cambio` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_divisa_destino`;
ALTER TABLE `sim_divisas_mod_cambio` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `id_usuario`;
ALTER TABLE `sim_divisas_mod_cambio` ADD `cambio` decimal(11,4) NOT NULL default '0.0000' AFTER `fecha`;

CREATE TABLE `sim_factura_files` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_files` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sim_factura_files` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_factura_files` ADD `name` varchar(100) NOT NULL default '' AFTER `id_tipo`;
ALTER TABLE `sim_factura_files` ADD `type` varchar(20) NOT NULL default '' AFTER `name`;
ALTER TABLE `sim_factura_files` ADD `size` int(11) NOT NULL default '0' AFTER `type`;
ALTER TABLE `sim_factura_files` ADD `tipo_id_elemento` int(11) NOT NULL default '0' AFTER `size`;
ALTER TABLE `sim_factura_files` ADD `id_elemento` int(11) NOT NULL default '0' AFTER `tipo_id_elemento`;
/*tipo_id_elemento - 0=factura, 1=articulo, 2=cliente, 3=contrato, 4=incidencia, 5=dispositivo, 6=empleado;*/

CREATE TABLE `sim_factura_files_tipos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_files_tipos` ADD `nombre` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_factura_files_tipos` ADD `limite_kb` int(11) NOT NULL default '0' AFTER `nombre`;
INSERT INTO `sim_factura_files_tipos` VALUES (1, 'Imagen', 250);
INSERT INTO `sim_factura_files_tipos` VALUES (2, 'Video', 5000);
INSERT INTO `sim_factura_files_tipos` VALUES (3, 'PDF', 1500);
INSERT INTO `sim_factura_files_tipos` VALUES (4, 'DOC', 250);
INSERT INTO `sim_factura_files_tipos` VALUES (5, 'DWG-Cad', 1500);
INSERT INTO `sim_factura_files_tipos` VALUES (6, 'Programa', 3500);

CREATE TABLE `sim_factura` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura` ADD `id_origen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura` ADD `numero` int(11) NOT NULL default '0' AFTER `id_origen`;
ALTER TABLE `sim_factura` ADD `version` int(11) NOT NULL default '0' AFTER `numero`;
ALTER TABLE `sim_factura` ADD `numero_cliente` varchar(20) default NULL AFTER `version`;
ALTER TABLE `sim_factura` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `numero_cliente`;
ALTER TABLE `sim_factura` ADD `fecha_prevision` date NOT NULL default '0000-00-00' AFTER `fecha`;
ALTER TABLE `sim_factura` ADD `fecha_entrega` date NOT NULL default '0000-00-00' AFTER `fecha_prevision`;
ALTER TABLE `sim_factura` ADD `fecha_vencimiento` date NOT NULL default '0000-00-00' AFTER `fecha_entrega`;
ALTER TABLE `sim_factura` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `fecha_vencimiento`;
ALTER TABLE `sim_factura` ADD `id_tipo` int(11) NOT NULL default '1' AFTER `visible`;
ALTER TABLE `sim_factura` ADD `id_subtipo` int(11) NOT NULL default '0' AFTER `id_tipo`;
ALTER TABLE `sim_factura` ADD `nombre` varchar(255) default NULL AFTER `id_subtipo`;
ALTER TABLE `sim_factura` ADD `nif` varchar(15) default NULL AFTER `nombre`;
ALTER TABLE `sim_factura` ADD `direccion` varchar(150) default NULL AFTER `nif`;
ALTER TABLE `sim_factura` ADD `poblacion` varchar(50) default NULL AFTER `direccion`;
ALTER TABLE `sim_factura` ADD `cp` varchar(5) default NULL AFTER `poblacion`;
ALTER TABLE `sim_factura` ADD `provincia` varchar(50) default NULL AFTER `cp`;
ALTER TABLE `sim_factura` ADD `id_pais` int(11) NOT NULL default '0' AFTER `provincia`;
ALTER TABLE `sim_factura` ADD `mail` varchar(50) default NULL AFTER `id_pais`;
ALTER TABLE `sim_factura` ADD `telefono` varchar(15) default NULL AFTER `mail`;
ALTER TABLE `sim_factura` ADD `notas` longtext AFTER `telefono`;
ALTER TABLE `sim_factura` ADD `subtotal` decimal(11,3) NOT NULL default '0.000' AFTER `notas`;
ALTER TABLE `sim_factura` ADD `descuento` decimal(11,3) NOT NULL default '0.000' AFTER `subtotal`;
ALTER TABLE `sim_factura` ADD `descuento_absoluto` decimal(11,3) NOT NULL default '0.000' AFTER `descuento`;
ALTER TABLE `sim_factura` ADD `subtotaldescuento` decimal(11,3) NOT NULL default '0.000' AFTER `descuento_absoluto`;
ALTER TABLE `sim_factura` ADD `iva` decimal(11,3) NOT NULL default '21.000' AFTER `subtotaldescuento`;
ALTER TABLE `sim_factura` ADD `total` decimal(11,3) NOT NULL default '0.000' AFTER `iva`;
ALTER TABLE `sim_factura` ADD `total_forzado` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `total` ;
ALTER TABLE `sim_factura` ADD `id_cliente` int(5) NOT NULL default '0' AFTER `total_forzado`;
ALTER TABLE `sim_factura` ADD `id_usuario` int(5) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_factura` ADD `recibos` tinyint(1) NOT NULL default '0' AFTER `id_usuario`;
ALTER TABLE `sim_factura` ADD `cobrada` tinyint(1) NOT NULL default '0' AFTER `recibos`;
ALTER TABLE `sim_factura` ADD `id_tipo_pago` int(11) NOT NULL default '0' AFTER `cobrada`;
ALTER TABLE `sim_factura` ADD `cerrada` tinyint(1) NOT NULL default '0' AFTER `id_tipo_pago`;
ALTER TABLE `sim_factura` ADD `confirmada` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `cerrada` ;
ALTER TABLE `sim_factura` ADD `confirmada_cliente` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `confirmada` ;
ALTER TABLE `sim_factura` ADD `id_divisa` int(11) NOT NULL default '0' AFTER `confirmada_cliente`;
ALTER TABLE `sim_factura` ADD `div_cambio` int(11) NOT NULL default '0' AFTER `id_divisa`;
ALTER TABLE `sim_factura` ADD `cnombre` varchar(55) NOT NULL default '' AFTER `div_cambio`;
ALTER TABLE `sim_factura` ADD `ctelefono` varchar(55) NOT NULL default '' AFTER `cnombre`;
ALTER TABLE `sim_factura` ADD `cmail` varchar(55) NOT NULL default '' AFTER `ctelefono`;
ALTER TABLE `sim_factura` ADD `numero_rfq` varchar(55) NOT NULL default '' AFTER `cmail`;
ALTER TABLE `sim_factura` ADD `aprovado` tinyint(1) NOT NULL default '0' AFTER `numero_rfq`;
ALTER TABLE `sim_factura` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `aprovado`;
ALTER TABLE `sim_factura` ADD `id_licencia` int(11) NOT NULL default '0' AFTER `id_contrato`;
ALTER TABLE `sim_factura` ADD `id_pagador` int(11) NOT NULL default '0' AFTER `id_licencia`;
ALTER TABLE `sim_factura` ADD `id_factura_dades_origen_iban` int(11) NOT NULL default '0' AFTER `id_pagador`;
ALTER TABLE `sim_factura` ADD `retenciones` decimal(11,3) NOT NULL default '0.000' AFTER `id_factura_dades_origen_iban`;

CREATE TABLE `sim_factura_calendario` ( `id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_calendario` ADD `fecha` int(15) NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `sim_factura_calendario` ADD `gastos` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `fecha`;
ALTER TABLE `sim_factura_calendario` ADD `pre_gastos` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `gastos`;
ALTER TABLE `sim_factura_calendario` ADD `ingresos` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `pre_gastos`;
ALTER TABLE `sim_factura_calendario` ADD `externos` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `ingresos`;
ALTER TABLE `sim_factura_calendario` ADD `liquido` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `externos`;

CREATE TABLE `sim_factura_cambio_fecha_entrega` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_cambio_fecha_entrega` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_cambio_fecha_entrega` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sim_factura_cambio_fecha_entrega` ADD `fecha_ant` date NOT NULL default '0000-00-00' AFTER `id_usuario`;
ALTER TABLE `sim_factura_cambio_fecha_entrega` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `fecha_ant`;

CREATE TABLE `sim_factura_cambio_fecha_prevision` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_cambio_fecha_prevision` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_cambio_fecha_prevision` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sim_factura_cambio_fecha_prevision` ADD `fecha_ant` date NOT NULL default '0000-00-00' AFTER `id_usuario`;
ALTER TABLE `sim_factura_cambio_fecha_prevision` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `fecha_ant`;

CREATE TABLE `sim_factura_cambio_fecha_prevision_cuerpo` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_cambio_fecha_prevision_cuerpo` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_cambio_fecha_prevision_cuerpo` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sim_factura_cambio_fecha_prevision_cuerpo` ADD `fecha_ant` date NOT NULL default '0000-00-00' AFTER `id_usuario`;
ALTER TABLE `sim_factura_cambio_fecha_prevision_cuerpo` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `fecha_ant`;
ALTER TABLE `sim_factura_cambio_fecha_prevision_cuerpo` ADD `id_cuerpo` int(11) NOT NULL default '0' AFTER `fecha`;

CREATE TABLE `sim_factura_cuerpo` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_cuerpo` ADD `id_origen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_cuerpo` ADD `linea` int(11) NOT NULL default '0' AFTER `id_origen`;
ALTER TABLE `sim_factura_cuerpo` ADD `id_cuerpo` int(11) NOT NULL default '0' AFTER `linea`;
ALTER TABLE `sim_factura_cuerpo` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id_cuerpo`;
ALTER TABLE `sim_factura_cuerpo` ADD `fecha_prevision` date NOT NULL default '0000-00-00' AFTER `id_factura`;
ALTER TABLE `sim_factura_cuerpo` ADD `fecha_entrega` date NOT NULL default '0000-00-00' AFTER `fecha_prevision`;
ALTER TABLE `sim_factura_cuerpo` ADD `codigo` varchar(20) NOT NULL default '' AFTER `fecha_entrega`;
ALTER TABLE `sim_factura_cuerpo` ADD `nombre` varchar(70) NOT NULL default '' AFTER `codigo`;
ALTER TABLE `sim_factura_cuerpo` ADD `pvd` decimal(11,3) NOT NULL default '0.000' AFTER `nombre`;
ALTER TABLE `sim_factura_cuerpo` ADD `pvp` decimal(11,3) NOT NULL default '0.000' AFTER `pvd`;
ALTER TABLE `sim_factura_cuerpo` ADD `unidades` decimal(11,3) NOT NULL default '0.000' AFTER `pvp`;
ALTER TABLE `sim_factura_cuerpo` ADD `descuento` decimal(11,3) NOT NULL default '0.000' AFTER `unidades`;
ALTER TABLE `sim_factura_cuerpo` ADD `descuento_absoluto` decimal(11,3) NOT NULL default '0.000' AFTER `descuento`;
ALTER TABLE `sim_factura_cuerpo` ADD `subtotaldescuento` decimal(11,3) NOT NULL default '0.000' AFTER `descuento_absoluto`;
ALTER TABLE `sim_factura_cuerpo` ADD `total` decimal(11,3) NOT NULL default '0.000' AFTER `subtotaldescuento`;
ALTER TABLE `sim_factura_cuerpo` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `total`;
ALTER TABLE `sim_factura_cuerpo` ADD `suma` tinyint(1) NOT NULL default '0' AFTER `id_articulo`;
ALTER TABLE `sim_factura_cuerpo` ADD `aprobado` tinyint(1) NOT NULL default '0' AFTER `suma`;
ALTER TABLE `sim_factura_cuerpo` ADD `fecha_prevision_propia` date NOT NULL default '0000-00-00' AFTER `aprobado`;

CREATE TABLE `sim_factura_dades_origen` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_dades_origen` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sim_factura_dades_origen` ADD `nombre` varchar(255) default NULL AFTER `visible`;
ALTER TABLE `sim_factura_dades_origen` ADD `nif` varchar(15) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sim_factura_dades_origen` ADD `direccion` varchar(150) NOT NULL default '' AFTER `nif`;
ALTER TABLE `sim_factura_dades_origen` ADD `poblacion` varchar(15) NOT NULL default '' AFTER `direccion`;
ALTER TABLE `sim_factura_dades_origen` ADD `cp` varchar(5) NOT NULL default '' AFTER `poblacion`;
ALTER TABLE `sim_factura_dades_origen` ADD `provincia` varchar(15) NOT NULL default '' AFTER `cp`;
ALTER TABLE `sim_factura_dades_origen` ADD `mail` varchar(50) NOT NULL default '' AFTER `provincia`;
ALTER TABLE `sim_factura_dades_origen` ADD `telefono` varchar(15) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sim_factura_dades_origen` ADD `notas` longtext AFTER `telefono`;
ALTER TABLE `sim_factura_dades_origen` ADD `logo1` varchar(50) NOT NULL default '' AFTER `notas`;
ALTER TABLE `sim_factura_dades_origen` ADD `logo2` varchar(50) NOT NULL default '' AFTER `logo1`;
ALTER TABLE `sim_factura_dades_origen` ADD `logo_ticket` varchar(50) NOT NULL default '' AFTER `logo2`;
ALTER TABLE `sim_factura_dades_origen` ADD `logo_papel` varchar(50) NOT NULL default '' AFTER `logo_ticket`;
ALTER TABLE `sim_factura_dades_origen` ADD `iva` decimal(11,3) NOT NULL default '0.000' AFTER `logo_papel`;

CREATE TABLE `sim_factura_dades_origen_iban` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_dades_origen_iban` ADD `id_factura_dades_origen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_dades_origen_iban` ADD `entidad_bancaria` varchar(50) NOT NULL default '' AFTER `id_factura_dades_origen`;
ALTER TABLE `sim_factura_dades_origen_iban` ADD `iban` varchar(50) NOT NULL default '' AFTER `entidad_bancaria`;
ALTER TABLE `sim_factura_dades_origen_iban` ADD `descripcion` varchar(150) NOT NULL default '' AFTER `iban`;
ALTER TABLE `sim_factura_dades_origen_iban` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `descripcion`;

CREATE TABLE `sim_factura_modificacion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_modificacion` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_modificacion` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sim_factura_modificacion` ADD `fecha` int(25) NOT NULL default '0' AFTER `id_usuario`;

CREATE TABLE `sim_factura_recibos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_recibos` ADD `numero` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_recibos` ADD `id_factura` int(11) NOT NULL default '0' AFTER `numero`;
ALTER TABLE `sim_factura_recibos` ADD `numero_serie` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sim_factura_recibos` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `numero_serie`;
ALTER TABLE `sim_factura_recibos` ADD `fecha_vencimiento` date NOT NULL default '0000-00-00' AFTER `fecha`;
ALTER TABLE `sim_factura_recibos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `fecha_vencimiento`;
ALTER TABLE `sim_factura_recibos` ADD `nombre` varchar(255) default NULL AFTER `visible`;
ALTER TABLE `sim_factura_recibos` ADD `nif` varchar(15) default NULL AFTER `nombre`;
ALTER TABLE `sim_factura_recibos` ADD `direccion` varchar(150) default NULL AFTER `nif`;
ALTER TABLE `sim_factura_recibos` ADD `poblacion` varchar(50) default NULL AFTER `direccion`;
ALTER TABLE `sim_factura_recibos` ADD `cp` varchar(5) default NULL AFTER `poblacion`;
ALTER TABLE `sim_factura_recibos` ADD `provincia` varchar(15) default NULL AFTER `cp`;
ALTER TABLE `sim_factura_recibos` ADD `onombre` varchar(255) default NULL AFTER `provincia`;
ALTER TABLE `sim_factura_recibos` ADD `onif` varchar(15) default NULL AFTER `onombre`;
ALTER TABLE `sim_factura_recibos` ADD `odireccion` varchar(150) default NULL AFTER `onif`;
ALTER TABLE `sim_factura_recibos` ADD `opoblacion` varchar(50) default NULL AFTER `odireccion`;
ALTER TABLE `sim_factura_recibos` ADD `ocp` varchar(5) default NULL AFTER `opoblacion`;
ALTER TABLE `sim_factura_recibos` ADD `oprovincia` varchar(15) default NULL AFTER `ocp`;
ALTER TABLE `sim_factura_recibos` ADD `entidad_bancaria` varchar(50) default NULL AFTER `oprovincia`;
ALTER TABLE `sim_factura_recibos` ADD `numero_cuenta` varchar(20) default NULL AFTER `entidad_bancaria`;
ALTER TABLE `sim_factura_recibos` ADD `total` decimal(11,3) NOT NULL default '0.000' AFTER `numero_cuenta`;
ALTER TABLE `sim_factura_recibos` ADD `id_cliente` int(5) NOT NULL default '0' AFTER `total`;
ALTER TABLE `sim_factura_recibos` ADD `id_usuario` int(5) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_factura_recibos` ADD `id_tipo_pago` int(11) NOT NULL default '0' AFTER `id_usuario`;
ALTER TABLE `sim_factura_recibos` ADD `cobrada` tinyint(1) NOT NULL default '0' AFTER `id_tipo_pago`;

CREATE TABLE `sim_factura_subtipos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_subtipos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sim_factura_subtipos` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_factura_subtipos` ADD `subtipo` varchar(50) default NULL AFTER `id_tipo`;
  
CREATE TABLE `sim_factura_tipos_pago` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_tipos_pago` ADD `tipo` varchar(150) NOT NULL default '' AFTER `id`;
INSERT INTO `sim_factura_tipos_pago` VALUES (1, 'Efectivo');
INSERT INTO `sim_factura_tipos_pago` VALUES (2, 'Tarjeta');
INSERT INTO `sim_factura_tipos_pago` VALUES (3, 'Cheque');
INSERT INTO `sim_factura_tipos_pago` VALUES (4, 'Domiciliaci&oacute;n');
INSERT INTO `sim_factura_tipos_pago` VALUES (5, 'Transferencia');
  
CREATE TABLE `sim_factura_tipos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_tipos` ADD `orden` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_tipos` ADD `tipo` varchar(150) NOT NULL default '' AFTER `orden`;
ALTER TABLE `sim_factura_tipos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `tipo`;
ALTER TABLE `sim_factura_tipos` ADD `descripcion` varchar(250) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sim_factura_tipos` ADD `dias` int(11) NOT NULL default '0' AFTER `descripcion`;
ALTER TABLE `sim_factura_tipos` ADD `facturable` tinyint(1) NOT NULL default '0' AFTER `dias`;
ALTER TABLE `sim_factura_tipos` ADD `tpv` tinyint(1) NOT NULL DEFAULT '0' AFTER `facturable` ;
-- en el momento de seleccion destino, muestra un grupo o otro
ALTER TABLE `sim_factura_tipos` ADD `filtro` tinyint(1) NOT NULL default '1' AFTER `tpv`;
ALTER TABLE `sim_factura_tipos` ADD `cliente` tinyint(1) NOT NULL default '0' AFTER `filtro`;
ALTER TABLE `sim_factura_tipos` ADD `proveedor` tinyint(1) NOT NULL default '0' AFTER `cliente`;
ALTER TABLE `sim_factura_tipos` ADD `impacto` tinyint(1) NOT NULL default '0' AFTER `proveedor`;
-- ver la fecha de prevision
ALTER TABLE `sim_factura_tipos` ADD `v_fecha_prevision` tinyint(1) NOT NULL default '0' AFTER `impacto`;
-- ver la fecha de vencimeinto
ALTER TABLE `sim_factura_tipos` ADD `v_fecha_vencimiento` tinyint(1) NOT NULL default '0' AFTER `v_fecha_prevision`;
-- ver la referencia de pedido del cliente
ALTER TABLE `sim_factura_tipos` ADD `v_numero_cliente` tinyint(1) NOT NULL default '0' AFTER `v_fecha_vencimiento`;
-- agrupacion de subtipos
ALTER TABLE `sim_factura_tipos` ADD `v_subtipos` tinyint(1) NOT NULL default '0' AFTER `v_numero_cliente`;
-- ver el peso y los bultos 
ALTER TABLE `sim_factura_tipos` ADD `v_pesobultos` tinyint(1) NOT NULL default '0' AFTER `v_subtipos`;
ALTER TABLE `sim_factura_tipos` ADD `v_fecha_prevision_dias` int(11) NOT NULL default '0' AFTER `v_fecha_prevision` ;
ALTER TABLE `sim_factura_tipos` ADD `v_recibos` tinyint(1) NOT NULL default '0' AFTER `v_pesobultos` ;
ALTER TABLE `sim_factura_tipos` ADD `tipo_ot` tinyint(1) NOT NULL default '0' AFTER `v_recibos` ;
-- calculo de costes (presupuesto)
ALTER TABLE `sim_factura_tipos` ADD `presu` tinyint(1) NOT NULL default '0' AFTER `tipo_ot`;
ALTER TABLE `sim_factura_tipos` ADD `presu_dias` int(11) NOT NULL default '0' AFTER `presu` ;
ALTER TABLE `sim_factura_tipos` ADD `stock` int(11) NOT NULL default '0' AFTER `presu_dias` ;
ALTER TABLE `sim_factura_tipos` ADD `calidad` tinyint(1) NOT NULL default '0' AFTER `stock`;
ALTER TABLE `sim_factura_tipos` ADD `caja` tinyint(1) NOT NULL default '0' AFTER `calidad`;
ALTER TABLE `sim_factura_tipos` ADD `aprovado` tinyint(1) NOT NULL default '0' AFTER `caja`;
ALTER TABLE `sim_factura_tipos` ADD `v_rfq` tinyint(1) NOT NULL default '0' AFTER `aprovado`;
ALTER TABLE `sim_factura_tipos` ADD `contabilidad` int(11) NOT NULL default '0' AFTER `v_rfq`;

CREATE TABLE `sim_factura_tipos_idiomas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_tipos_idiomas` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_tipos_idiomas` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_tipo`;
ALTER TABLE `sim_factura_tipos_idiomas` ADD `tipo`  varchar(100) NOT NULL default '' AFTER `id_idioma`;

CREATE TABLE `sim_factura_tipos_permisos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_tipos_permisos` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_tipos_permisos` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `id_usuario`;
ALTER TABLE `sim_factura_tipos_permisos` ADD `admin`  tinyint(1) NOT NULL default '0' AFTER `id_tipo`;

CREATE TABLE `sim_factura_tipos_relaciones` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_factura_tipos_relaciones` ADD `id_tipo_o` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_factura_tipos_relaciones` ADD `id_tipo_d` int(11) NOT NULL default '0' AFTER `id_tipo_o`;
ALTER TABLE `sim_factura_tipos_relaciones` ADD `cerrar` int(11) NOT NULL default '0' AFTER `id_tipo_d`;

CREATE TABLE `sim_formato_documento` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_formato_documento` ADD `formato_documento` varchar(50) default NULL AFTER `id`;
ALTER TABLE `sim_formato_documento` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `formato_documento`;

CREATE TABLE `sim_idiomas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_idiomas` ADD `idioma` varchar(2) NOT NULL default 'ES' AFTER `id`;
ALTER TABLE `sim_idiomas` ADD `descripcion` varchar(15) NOT NULL default '' AFTER `idioma`;
ALTER TABLE `sim_idiomas` ADD `imagen` varchar(15) NOT NULL default '' AFTER `descripcion`;
ALTER TABLE `sim_idiomas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `imagen`;
ALTER TABLE `sim_idiomas` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sim_incidencias` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_incidencias` ADD `id_incidencia` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_incidencias` ADD `id_usuario_origen` int(11) NOT NULL default '0' AFTER `id_incidencia`;
ALTER TABLE `sim_incidencias` ADD `id_usuario_registro` int(11) NOT NULL default '0' AFTER `id_usuario_origen`;
ALTER TABLE `sim_incidencias` ADD `id_usuario_destino` int(11) NOT NULL default '0' AFTER `id_usuario_registro`;
ALTER TABLE `sim_incidencias` ADD `id_usuario_finalizacion` int(11) NOT NULL default '0' AFTER `id_usuario_destino`;
ALTER TABLE `sim_incidencias` ADD `fecha_prevision` int(15) NOT NULL default '0' AFTER `id_usuario_finalizacion`;
ALTER TABLE `sim_incidencias` ADD `fecha_registro_inicio` int(15) NOT NULL default '0' AFTER `fecha_prevision`;
ALTER TABLE `sim_incidencias` ADD `fecha_inicio` int(15) NOT NULL default '0' AFTER `fecha_registro_inicio`;
ALTER TABLE `sim_incidencias` ADD `fecha_registro_cierre` int(15) NOT NULL default '0' AFTER `fecha_inicio`;
ALTER TABLE `sim_incidencias` ADD `fecha_cierre` int(15) NOT NULL default '0' AFTER `fecha_registro_cierre`;
ALTER TABLE `sim_incidencias` ADD `asunto` varchar(150) default NULL AFTER `fecha_cierre`;
ALTER TABLE `sim_incidencias` ADD `notas_registro` longtext AFTER `asunto`;
ALTER TABLE `sim_incidencias` ADD `notas_desarrollo` longtext AFTER `notas_registro`;
ALTER TABLE `sim_incidencias` ADD `notas_conclusion` longtext AFTER `notas_desarrollo`;
ALTER TABLE `sim_incidencias` ADD `id_estado` int(11) NOT NULL default '0' AFTER `notas_conclusion`;
ALTER TABLE `sim_incidencias` ADD `id_entrada` int(11) NOT NULL default '0' AFTER `id_estado`;
ALTER TABLE `sim_incidencias` ADD `id_servicio` int(11) NOT NULL default '0' AFTER `id_entrada`;
ALTER TABLE `sim_incidencias` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id_servicio`;
ALTER TABLE `sim_incidencias` ADD `duracion` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_incidencias` ADD `sla` tinyint(1) NOT NULL default '0' AFTER `duracion` ;
ALTER TABLE `sim_incidencias` ADD `visible_cliente` tinyint(1) NOT NULL default '1' AFTER `sla` ;
ALTER TABLE `sim_incidencias` ADD `pausada` tinyint(1) NOT NULL default '0' AFTER `visible_cliente` ;
ALTER TABLE `sim_incidencias` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `pausada` ;
ALTER TABLE `sim_incidencias` ADD `tiempo_transcurrido` int(15) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_incidencias` ADD `tiempo_pendiente` int(15) NOT NULL default '0' AFTER `tiempo_transcurrido`;
ALTER TABLE `sim_incidencias` ADD `correo` int(15) NOT NULL default '0' AFTER `tiempo_pendiente`;
ALTER TABLE `sim_incidencias` ADD `pausada_forzada` tinyint(1) NOT NULL default '0' AFTER `correo` ;
ALTER TABLE `sim_incidencias` ADD `codigo_externo` varchar(50) default NULL AFTER `pausada_forzada`;

CREATE TABLE `sim_incidencias_correos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_incidencias_correos` ADD `uid` int(11) NOT NULL default '0' AFTER `id`;

CREATE TABLE `sim_incidencias_correos_enviados` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_incidencias_correos_enviados` ADD `id_incidencia` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_incidencias_correos_enviados` ADD `destinatario` varchar(100) NOT NULL default '' AFTER `id_incidencia`;
ALTER TABLE `sim_incidencias_correos_enviados` ADD `asunto` varchar(150) NOT NULL default '' AFTER `destinatario`;
ALTER TABLE `sim_incidencias_correos_enviados` ADD `fecha` int(15) NOT NULL default '0' AFTER `asunto`;

CREATE TABLE `sim_incidencias_estados` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_incidencias_estados` ADD `estado` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_incidencias_estados` ADD `editable` tinyint(1) NOT NULL default '1' AFTER `estado`;
ALTER TABLE `sim_incidencias_estados` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `editable`;

CREATE TABLE `sim_incidencias_entrada` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_incidencias_entrada` ADD `entrada` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_incidencias_entrada` ADD `predeterminada` tinyint(1) NOT NULL default '0' AFTER `entrada`;
INSERT INTO `sim_incidencias_entrada` VALUES (1, 'Teléfono');
INSERT INTO `sim_incidencias_entrada` VALUES (2, 'Fax');
INSERT INTO `sim_incidencias_entrada` VALUES (3, 'Mail');
INSERT INTO `sim_incidencias_entrada` VALUES (4, 'Web');
INSERT INTO `sim_incidencias_entrada` VALUES (5, 'Otra');

CREATE TABLE `sgm_inventario` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sgm_inventario` ADD `nombre` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `nombre` ;
ALTER TABLE `sgm_inventario` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id_tipo` ;
ALTER TABLE `sgm_inventario` ADD `codigo` varchar(50) NOT NULL default '' AFTER `id_cliente`;
ALTER TABLE `sgm_inventario` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `codigo` ;
ALTER TABLE `sgm_inventario` ADD `num_serie` varchar(50) NOT NULL default '' AFTER `id_empleado` ;
ALTER TABLE `sgm_inventario` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `num_serie` ;

CREATE TABLE `sgm_inventario_relacion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sgm_inventario_relacion` ADD `id_disp1` int(11) NOT NULL default '0' AFTER `id` ;
ALTER TABLE `sgm_inventario_relacion` ADD `id_disp2` int(11) NOT NULL default '0' AFTER `id_disp1` ;
ALTER TABLE `sgm_inventario_relacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_disp2` ;

CREATE TABLE `sgm_inventario_actuacion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sgm_inventario_actuacion` ADD `nombre` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario_actuacion` ADD `parada` tinyint(1) NOT NULL default '0' AFTER `nombre`;
ALTER TABLE `sgm_inventario_actuacion` ADD `duracion` int(11) NOT NULL default '0' AFTER `parada`;
ALTER TABLE `sgm_inventario_actuacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `duracion` ;

CREATE TABLE `sgm_inventario_actuacion_disp` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `id_actuacion` int(11) NOT NULL default '0' AFTER `id` ;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `id_dispositivo` int(11) NOT NULL default '0' AFTER `id_actuacion` ;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_dispositivo` ;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `fecha_prevision` datetime default NULL AFTER `id_usuario`;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `fecha_finalizacion` datetime default NULL AFTER `fecha_prevision`;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `finalizada` tinyint(1) NOT NULL default '0' AFTER `fecha_finalizacion` ;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `finalizada` ;

CREATE TABLE `sgm_inventario_tipo` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sgm_inventario_tipo` ADD `tipo` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario_tipo` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `tipo` ;
ALTER TABLE `sgm_inventario_tipo` ADD `orden` int(11) NOT NULL default '0' AFTER `visible` ;
ALTER TABLE `sgm_inventario_tipo` ADD `codigo` int(4) NOT NULL default '0000' AFTER `orden` ;

CREATE TABLE `sgm_inventario_tipo_atributo` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sgm_inventario_tipo_atributo` ADD `atributo` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario_tipo_atributo` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `atributo` ;
ALTER TABLE `sgm_inventario_tipo_atributo` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_tipo` ;

CREATE TABLE `sgm_inventario_tipo_atributo_dato` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sgm_inventario_tipo_atributo_dato` ADD `dato` longtext NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario_tipo_atributo_dato` ADD `id_atributo` int(11) NOT NULL default '0' AFTER `dato` ;
ALTER TABLE `sgm_inventario_tipo_atributo_dato` ADD `id_inventario` int(11) NOT NULL default '0' AFTER `id_atributo` ;
ALTER TABLE `sgm_inventario_tipo_atributo_dato` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_inventario` ;

CREATE TABLE `sim_medio_comunicacion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_medio_comunicacion` ADD `medio_comunicacion` varchar(50) default NULL AFTER `id`;
ALTER TABLE `sim_medio_comunicacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `medio_comunicacion`;

CREATE TABLE `sim_paises` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_paises` ADD `pais` varchar(50) default NULL AFTER `id`;
ALTER TABLE `sim_paises` ADD `siglas` char(3) default NULL AFTER `pais`;
ALTER TABLE `sim_paises` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `siglas`;
ALTER TABLE `sim_paises` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sim_provincias` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_provincias` ADD `provincia` varchar(30) DEFAULT NULL AFTER `id`;
ALTER TABLE `sim_provincias` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `provincia`;
INSERT INTO `sim_provincias` (`id`,`provincia`,`visible`) VALUES (2,'Albacete',1),(3,'Alicante/Alacant',1),(4,'Almería',1),(1,'Araba/Álava',1),(33,'Asturias',1),(5,'Ávila',1),(6,'Badajoz',1),(7,'Balears, Illes',1),(8,'Barcelona',1),(48,'Bizkaia',1),(9,'Burgos',1),(10,'Cáceres',1),(11,'Cádiz',1),(39,'Cantabria',1),(12,'Castellón/Castelló',1),(51,'Ceuta',1),(13,'Ciudad Real',1),(14,'Córdoba',1),(15,'Coruña, A',1),(16,'Cuenca',1),(20,'Gipuzkoa',1),(17,'Girona',1),(18,'Granada',1),(19,'Guadalajara',1),(21,'Huelva',1),(22,'Huesca',1),(23,'Jaén',1),(24,'León',1),(27,'Lugo',1),(25,'Lleida',1),(28,'Madrid',1),(29,'Málaga',1),(52,'Melilla',1),(30,'Murcia',1),(31,'Navarra',1),(32,'Ourense',1),(34,'Palencia',1),(35,'Palmas, Las',1),(36,'Pontevedra',1),(26,'Rioja, La',1),(37,'Salamanca',1),(38,'Santa Cruz de Tenerife',1),(40,'Segovia',1),(41,'Sevilla',1),(42,'Soria',1),(43,'Tarragona',1),(44,'Teruel',1),(45,'Toledo',1),(46,'Valencia/València',1),(47,'Valladolid',1),(49,'Zamora',1),(50,'Zaragoza',1);

CREATE TABLE `sim_regiones` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_regiones` ADD `region` varchar(30) DEFAULT NULL AFTER `id`;
ALTER TABLE `sim_regiones` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `region`;

CREATE TABLE `sim_rrhh_departamento` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_departamento` ADD `id_departamento` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_rrhh_departamento` ADD `departamento` varchar(255) default NULL AFTER `id_departamento`;
ALTER TABLE `sim_rrhh_departamento` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `departamento`;

CREATE TABLE `sim_rrhh_empleado` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_empleado` ADD `nombre` varchar(255) default NULL AFTER `id`;
ALTER TABLE `sim_rrhh_empleado` ADD `fecha_incor` date NOT NULL default '0000-00-00' AFTER `nombre`;
ALTER TABLE `sim_rrhh_empleado` ADD `fecha_baja` date NOT NULL default '0000-00-00' AFTER `fecha_incor`;
ALTER TABLE `sim_rrhh_empleado` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `fecha_baja`;
ALTER TABLE `sim_rrhh_empleado` ADD `codigo` int(15) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_rrhh_empleado` ADD `nif` varchar(15) NOT NULL default '' AFTER `codigo`;
ALTER TABLE `sim_rrhh_empleado` ADD `direccion` varchar(255) NOT NULL default '' AFTER `nif`;
ALTER TABLE `sim_rrhh_empleado` ADD `poblacion` varchar(50) NOT NULL default '' AFTER `direccion`;
ALTER TABLE `sim_rrhh_empleado` ADD `cp` varchar(5) NOT NULL default '' AFTER `poblacion`;
ALTER TABLE `sim_rrhh_empleado` ADD `provincia` varchar(15) NOT NULL default '' AFTER `cp`;
ALTER TABLE `sim_rrhh_empleado` ADD `id_pais` int(11) NOT NULL default '0' AFTER `provincia`;
ALTER TABLE `sim_rrhh_empleado` ADD `telefono` varchar(15) NOT NULL default '' AFTER `id_pais`;
ALTER TABLE `sim_rrhh_empleado` ADD `telefono2` varchar(15) NOT NULL default '' AFTER `telefono`;
ALTER TABLE `sim_rrhh_empleado` ADD `mail` varchar(50) NOT NULL default '' AFTER `telefono2`;
ALTER TABLE `sim_rrhh_empleado` ADD `notas` longtext AFTER `mail`;
ALTER TABLE `sim_rrhh_empleado` ADD `cuentabancaria` varchar(30) default NULL AFTER `notas`;
ALTER TABLE `sim_rrhh_empleado` ADD `entidadbancaria` varchar(100) NOT NULL default '' AFTER `cuentabancaria`;
ALTER TABLE `sim_rrhh_empleado` ADD `domiciliobancario` varchar(255) NOT NULL default '' AFTER `entidadbancaria`;
ALTER TABLE `sim_rrhh_empleado` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `domiciliobancario`;
ALTER TABLE `sim_rrhh_empleado` ADD `num_ins_segsoc` varchar(25) NOT NULL default '' AFTER `id_usuario`;
ALTER TABLE `sim_rrhh_empleado` ADD `num_afil_segsoc` varchar(25) NOT NULL default '' AFTER `num_ins_segsoc`;

CREATE TABLE `sim_rrhh_empleado_calendario` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_empleado_calendario` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_rrhh_empleado_calendario` ADD `fecha_inicio` int(20) NOT NULL default '0' AFTER `id_empleado`;
ALTER TABLE `sim_rrhh_empleado_calendario` ADD `fecha_fin` int(20) NOT NULL default '0' AFTER `fecha_inicio`;
ALTER TABLE `sim_rrhh_empleado_calendario` ADD `total_dias` int(20) NOT NULL default '0' AFTER `fecha_fin`;
ALTER TABLE `sim_rrhh_empleado_calendario` ADD `motivo` varchar(255) NOT NULL default '' AFTER `total_dias`;
ALTER TABLE `sim_rrhh_empleado_calendario` ADD `vacaciones` tinyint(1) NOT NULL default '0' AFTER `motivo`;
ALTER TABLE `sim_rrhh_empleado_calendario` ADD `remunerado` tinyint(1) NOT NULL default '0' AFTER `vacaciones`;

CREATE TABLE `sim_rrhh_empleado_horario` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_empleado_horario` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_rrhh_empleado_horario` ADD `fecha_inicio` date NOT NULL default '0000-00-00' AFTER `id_empleado`;
ALTER TABLE `sim_rrhh_empleado_horario` ADD `fecha_fin` date NOT NULL default '0000-00-00' AFTER `fecha_inicio`;
ALTER TABLE `sim_rrhh_empleado_horario` ADD `hora_ini` varchar(11) NOT NULL default '00:00' AFTER `fecha_fin` ;
ALTER TABLE `sim_rrhh_empleado_horario` ADD `hora_fi` varchar(11) NOT NULL default '00:00' AFTER `hora_ini` ;
ALTER TABLE `sim_rrhh_empleado_horario` ADD `hora_ini2` varchar(11) NOT NULL default '00:00' AFTER `hora_fi` ;
ALTER TABLE `sim_rrhh_empleado_horario` ADD `hora_fi2` varchar(11) NOT NULL default '00:00' AFTER `hora_ini2` ;
ALTER TABLE `sim_rrhh_empleado_horario` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `hora_fi2`;
ALTER TABLE `sim_rrhh_empleado_horario` ADD `dia_setmana` int(11) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sim_rrhh_empleado_nominas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_empleado_nominas` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_rrhh_empleado_nominas` ADD `total` decimal(11,2) NOT NULL default '0.00' AFTER `id_empleado`;
ALTER TABLE `sim_rrhh_empleado_nominas` ADD `fecha_inicio` int(20) NOT NULL default '0' AFTER `total`;
ALTER TABLE `sim_rrhh_empleado_nominas` ADD `fecha_fin` int(20) NOT NULL default '0' AFTER `fecha_inicio`;

CREATE TABLE `sim_rrhh_empleado_puesto` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_empleado_puesto` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_rrhh_empleado_puesto` ADD `id_puesto` int(11) NOT NULL default '0' AFTER `id_empleado`;
ALTER TABLE `sim_rrhh_empleado_puesto` ADD `fecha_alta` date NOT NULL default '0000-00-00' AFTER `id_puesto`;
ALTER TABLE `sim_rrhh_empleado_puesto` ADD `fecha_baja` date NOT NULL default '0000-00-00' AFTER `fecha_alta`;
ALTER TABLE `sim_rrhh_empleado_puesto` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `fecha_baja`;

CREATE TABLE `sim_rrhh_formacion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_formacion` ADD `numero` varchar(15) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sim_rrhh_formacion` ADD `nombre` varchar(255) default NULL AFTER `numero`;
ALTER TABLE `sim_rrhh_formacion` ADD `tipo` tinyint(1) NOT NULL default '1' AFTER `nombre`;
ALTER TABLE `sim_rrhh_formacion` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `tipo`;
ALTER TABLE `sim_rrhh_formacion` ADD `fecha_inicio` date NOT NULL default '0000-00-00' AFTER `fecha`;
ALTER TABLE `sim_rrhh_formacion` ADD `fecha_fin` date NOT NULL default '0000-00-00' AFTER `fecha_inicio`;
ALTER TABLE `sim_rrhh_formacion` ADD `impartidor` varchar(255) default NULL AFTER `fecha_fin`;
ALTER TABLE `sim_rrhh_formacion` ADD `duracion` tinyint(11) NOT NULL default '1' AFTER `impartidor`;
ALTER TABLE `sim_rrhh_formacion` ADD `observaciones` longtext NOT NULL AFTER `duracion`;
ALTER TABLE `sim_rrhh_formacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `observaciones`;
ALTER TABLE `sim_rrhh_formacion` ADD `temario` longtext NOT NULL AFTER `visible`;
ALTER TABLE `sim_rrhh_formacion` ADD `id_plan` int(11) NOT NULL default '0' AFTER `temario`;
ALTER TABLE `sim_rrhh_formacion` ADD `planificado` tinyint(1) NOT NULL default '0' AFTER `id_plan`;
ALTER TABLE `sim_rrhh_formacion` ADD `realizado` tinyint(1) NOT NULL default '0' AFTER `planificado`;
ALTER TABLE `sim_rrhh_formacion` ADD `coste` varchar(15) NOT NULL default '0' AFTER `realizado`;

CREATE TABLE `sim_rrhh_formacion_empleado` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_formacion_empleado` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_rrhh_formacion_empleado` ADD `id_curso` int(11) NOT NULL default '0' AFTER `id_empleado`;
ALTER TABLE `sim_rrhh_formacion_empleado` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_curso`;

CREATE TABLE `sim_rrhh_jornada_anual` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_jornada_anual` ADD `num_horas_any` int(11) NOT NULL default '0' AFTER `id`;

CREATE TABLE `sim_rrhh_puesto_trabajo` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `puesto` varchar(255) default NULL AFTER `id`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `id_departamento` int(11) NOT NULL default '0' AFTER `puesto`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `tareas` longtext NOT NULL AFTER `id_departamento`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `f_general` longtext NOT NULL AFTER `tareas`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `f_especifica` longtext NOT NULL AFTER `f_general`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `experiencia` longtext NOT NULL AFTER `f_especifica`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `habilidades` longtext NOT NULL AFTER `experiencia`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `habilidades`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `activo` tinyint(1) NOT NULL default '1' AFTER `visible`;
ALTER TABLE `sim_rrhh_puesto_trabajo` ADD `numero` int(15) NOT NULL default '0' AFTER `activo`;

CREATE TABLE `sim_rrhh_num_dias_vacaciones` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_num_dias_vacaciones` ADD `num_dias_vac` int(11) NOT NULL default '0' AFTER `id`;

CREATE TABLE `sim_rrhh_num_dias_libres` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_rrhh_num_dias_libres` ADD `num_dias_lib` int(11) NOT NULL default '0' AFTER `id`;

CREATE TABLE `sim_stock_almacenes` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_stock_almacenes` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sim_stock_almacenes` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sim_stock_almacenes` ADD `direccion` varchar(50) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sim_stock_almacenes` ADD `poblacion` varchar(30) NOT NULL default '' AFTER `direccion`;
ALTER TABLE `sim_stock_almacenes` ADD `cp` varchar(5) NOT NULL default '' AFTER `poblacion`;
ALTER TABLE `sim_stock_almacenes` ADD `provincia` varchar(15) NOT NULL default '' AFTER `cp`;
ALTER TABLE `sim_stock_almacenes` ADD `mail` varchar(50) NOT NULL default '' AFTER `provincia`;
ALTER TABLE `sim_stock_almacenes` ADD `telefono` varchar(15) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sim_stock_almacenes` ADD `notas` longtext AFTER `telefono`;

CREATE TABLE `sim_stock_almacenes_pasillo` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_stock_almacenes_pasillo` ADD `id_almacen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_stock_almacenes_pasillo` ADD `orden` int(11) NOT NULL default '0' AFTER `id_almacen`;
ALTER TABLE `sim_stock_almacenes_pasillo` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `orden`;
ALTER TABLE `sim_stock_almacenes_pasillo` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;

CREATE TABLE `sim_stock_almacenes_pasillo_estanteria` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria` ADD `id_pasillo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria` ADD `orden` int(11) NOT NULL default '0' AFTER `id_pasillo`;
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `orden`;
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;

CREATE TABLE `sim_stock_almacenes_pasillo_estanteria_seccion` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria_seccion` ADD `id_estanteria` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria_seccion` ADD `orden` int(11) NOT NULL default '0' AFTER `id_estanteria`;
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria_seccion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `orden`;
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria_seccion` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sim_stock_almacenes_pasillo_estanteria_seccion` ADD `porcentage` int(11) NOT NULL default '0' AFTER `nombre`;

CREATE TABLE `sim_tarifas` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_tarifas` ADD `nombre` varchar(255) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_tarifas` ADD `porcentage` decimal(10,2) NOT NULL default '0.00' AFTER `nombre`;
ALTER TABLE `sim_tarifas` ADD `descuento` tinyint(1) NOT NULL default '1' AFTER `porcentage`;
ALTER TABLE `sim_tarifas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descuento`;

CREATE TABLE `sim_usuarios` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_usuarios` ADD `validado` tinyint(1) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_usuarios` ADD `activo` tinyint(1) NOT NULL default '1' AFTER `validado`;
ALTER TABLE `sim_usuarios` ADD `usuario` varchar(30) NOT NULL default '' AFTER `activo`;
ALTER TABLE `sim_usuarios` ADD `contrasena` varchar(10) NOT NULL default '' AFTER `usuario`;
ALTER TABLE `sim_usuarios` ADD `mail` varchar(50) NOT NULL default '' AFTER `contrasena`;
ALTER TABLE `sim_usuarios` ADD `sim` tinyint(1) NOT NULL default '0' AFTER `mail`;
ALTER TABLE `sim_usuarios` ADD `id_origen` int(11) NOT NULL default '0' AFTER `sim`;
ALTER TABLE `sim_usuarios` ADD `id_tipus` int(11) NOT NULL default '0' AFTER `id_origen`;
INSERT INTO `sim_usuarios` (`id`, `validado`, `activo`, `usuario`, `contrasena`, `mail`, `sim`, `id_origen`, `id_tipus`) VALUES (1, '1', '1', 'admin', 'admin', 'administracion@solucions-im.com', '1', '0','0');

CREATE TABLE `sim_usuarios_clientes` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_usuarios_clientes` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_usuarios_clientes` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id_usuario`;
ALTER TABLE `sim_usuarios_clientes` ADD `id_modulo` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_usuarios_clientes` ADD `admin` tinyint(1) NOT NULL default '0' AFTER `id_modulo`;

CREATE TABLE `sim_usuarios_modulos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_usuarios_modulos` ADD `id_modulo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_usuarios_modulos` ADD `nombre` varchar(30) NOT NULL default '' AFTER `id_modulo`;
ALTER TABLE `sim_usuarios_modulos` ADD `descripcion` varchar(130) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sim_usuarios_modulos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;
ALTER TABLE `sim_usuarios_modulos` ADD `id_grupo` int(11) NOT NULL default '0' AFTER `visible` ;
INSERT INTO `sim_usuarios_modulos` VALUES (1, 1001, 'Contenidos', 'Permite crear noticias, articulos i sus grupos.', 0, 5);
INSERT INTO `sim_usuarios_modulos` VALUES (2, 1002, 'Usuarios', 'Permite conceder permisos y modificar usuarios.', 1, 5);
INSERT INTO `sim_usuarios_modulos` VALUES (3, 1003, 'Facturaci&oacute;n', 'M&oacute;dulo para la gesti&oacute;n de facturaci&oacute;n y contabilidad', 0, 3);
INSERT INTO `sim_usuarios_modulos` VALUES (4, 1004, 'Art&iacute;culos', 'Gesti&oacute;n de articulos y marcas de fabricantes.', 0, 6);
INSERT INTO `sim_usuarios_modulos` VALUES (5, 1005, 'Inventario', 'Gesti&oacute;n del inventario que dispone cada cliente.', 0, 3);
INSERT INTO `sim_usuarios_modulos` VALUES (6, 1006, 'Tareas', 'Gesti&oacute;n de las agenas y tareas', 0, 4);
INSERT INTO `sim_usuarios_modulos` VALUES (7, 1007, 'Pedidos', 'Formulario de solucitud de material.', 0, 3);
INSERT INTO `sim_usuarios_modulos` VALUES (8, 1008, 'Contactos', 'Gesti&oacute;n de clientes y todos sus datos.', 0, 1);
INSERT INTO `sim_usuarios_modulos` VALUES (9, 1009, 'Comercial', 'Para la gesti&oacute;n de posibles clientes y su seguimiento', 0, 1);
INSERT INTO `sim_usuarios_modulos` VALUES (10, 1010, 'Compras', 'Gesti&oacute;n de proveedores y pedidos', 0, 3);
INSERT INTO `sim_usuarios_modulos` VALUES (11, 1011, 'Contratos', 'Gesti&oacute;n de contratos de servicios', 0, 3);
INSERT INTO `sim_usuarios_modulos` VALUES (12, 1012, 'Mailing', 'Gesti&oacute; de e-mails masivos.', 0, 3);
INSERT INTO `sim_usuarios_modulos` VALUES (13, 1013, 'Inventario Incid.', 'Gesti&oacute;n de incidencias técnicas en los registros de inventario.', 0, 1);
INSERT INTO `sim_usuarios_modulos` VALUES (14, 1014, 'Producci&oacute;n', 'Control del proceso de producci&oacute;n y control de calidad.', 0, 6);
INSERT INTO `sim_usuarios_modulos` VALUES (15, 1015, 'Calidad', 'Gesti&oacute;n del control de calidad para normativa ISO', 0, 6);
INSERT INTO `sim_usuarios_modulos` VALUES (16, 1016, 'Producci&oacute;n', 'Gesti&oacute;n de OT, FT, etc', 0, 6);
INSERT INTO `sim_usuarios_modulos` VALUES (17, 1017, 'Tareas', 'Gesti&oacute;n de las agendas y tareas', 0, 4);
INSERT INTO `sim_usuarios_modulos` VALUES (18, 1018, 'Incidencias', 'Gesti&oacute; de incidencias', 0, 6);
INSERT INTO `sim_usuarios_modulos` VALUES (19, 1019, 'Contabilidad', 'Contabilidad', 0, 0);
INSERT INTO `sim_usuarios_modulos` VALUES (20, 1020, 'RRHH', 'Curriculums y ofertas de empleo', 0, 2);
INSERT INTO `sim_usuarios_modulos` VALUES (21, 1021, 'TPV', 'Terminal Punto de Venta', 0, 3);
INSERT INTO `sim_usuarios_modulos` VALUES (22, 1022, 'Sistema', 'Acceso a la configuraci&oacute;n del programa MGestion', 1, 5);
INSERT INTO `sim_usuarios_modulos` VALUES (23, 1023, 'Auxiliares', 'Gesti&oacute;n de la Tablas Auxiliares de los M&oacute;dulos', 0, 5);
INSERT INTO `sim_usuarios_modulos` VALUES (24, 1024, 'Contrase&ntilde;as', 'Gesti&oacute;n de contrase&ntilde;as de apliciones', 0, 6);
INSERT INTO `sim_usuarios_modulos` VALUES (25, 1025, 'Monitorizaci&oacute;n', 'Gesti&oacute;n Monitorizaci&oacute;n', 0, 6);
INSERT INTO `sim_usuarios_modulos` VALUES (26, 1026, 'Licencias', 'Gesti&oacute;n de licencias de productos', 0, 3);
INSERT INTO `sim_usuarios_modulos` VALUES (1001, 2001, 'Estado Servidor', 'Permite conocer el estador del servidor o servidores del cliente', 0, 7);
INSERT INTO `sim_usuarios_modulos` VALUES (1002, 2002, 'Reports', 'Permite descargar los reports del cliente', 0, 7);
INSERT INTO `sim_usuarios_modulos` VALUES (1003, 2003, 'Documentos', 'Permite descargar los documentos asociados al cliente', 0, 7);

CREATE TABLE `sim_usuarios_modulos_grupos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_usuarios_modulos_grupos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sim_usuarios_modulos_grupos` ADD `nombre` varchar(30) NOT NULL default '' AFTER `visible`;
INSERT INTO `sim_usuarios_modulos_grupos` VALUES (1,1,'Gesti&oacute;n Comercial');
INSERT INTO `sim_usuarios_modulos_grupos` VALUES (2,1,'Gesti&oacute;n Direcci&oacute;n');
INSERT INTO `sim_usuarios_modulos_grupos` VALUES (3,1,'Gesti&oacute;n Administrativa');
INSERT INTO `sim_usuarios_modulos_grupos` VALUES (4,1,'Agenda');
INSERT INTO `sim_usuarios_modulos_grupos` VALUES (5,1,'Administraci&oacute;n');
INSERT INTO `sim_usuarios_modulos_grupos` VALUES (6,1,'Producci&oacute;n');

CREATE TABLE `sim_usuarios_rel_modulos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_usuarios_rel_modulos` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_usuarios_rel_modulos` ADD `id_tipus` int(11) NOT NULL default '0' AFTER `id_usuario`;
ALTER TABLE `sim_usuarios_rel_modulos` ADD `id_modulo` int(11) NOT NULL default '0' AFTER `id_tipus`;
ALTER TABLE `sim_usuarios_rel_modulos` ADD `admin` tinyint(1) NOT NULL default '0' AFTER `id_modulo`;
INSERT INTO `sim_usuarios_rel_modulos` VALUES (1, '1', '0', '1002', '1');
INSERT INTO `sim_usuarios_rel_modulos` VALUES (2, '1', '0', '1022', '1');

CREATE TABLE `sim_usuarios_tipus` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`) );
ALTER TABLE `sim_usuarios_tipus` ADD `tipus` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_usuarios_tipus` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `tipus`;
