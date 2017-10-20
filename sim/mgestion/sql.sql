CREATE TABLE `sgm_articles` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id` ;
ALTER TABLE `sgm_articles` ADD `codigo` varchar(6) NOT NULL default '0' AFTER `visible` ;
ALTER TABLE `sgm_articles` ADD `nombre` varchar(70) NOT NULL default '' AFTER `codigo` ;
ALTER TABLE `sgm_articles` ADD `id_subgrupo` int(11) NOT NULL default '0' AFTER `nombre` ;
ALTER TABLE `sgm_articles` ADD `notas` longtext AFTER `id_subgrupo` ;
ALTER TABLE `sgm_articles` ADD `descatalogat` tinyint(1) NOT NULL default '0' AFTER `notas` ;
ALTER TABLE `sgm_articles` ADD `precio` decimal(11,3) NOT NULL default '0' AFTER `descatalogat` ;
ALTER TABLE `sgm_articles` ADD `id_divisa` int(11) NOT NULL default '0' AFTER `precio` ;
ALTER TABLE `sgm_articles` ADD `img1` varchar(100) NOT NULL default '' AFTER `id_divisa` ;
ALTER TABLE `sgm_articles` ADD `img2` varchar(100) NOT NULL default '' AFTER `img1` ;
ALTER TABLE `sgm_articles` ADD `img3` varchar(100) NOT NULL default '' AFTER `img2` ;
ALTER TABLE `sgm_articles` ADD `escandall` tinyint(1) NOT NULL default '0' AFTER `img3` ;
ALTER TABLE `sgm_articles` ADD `recalc_escandall` tinyint(1) NOT NULL default '0' AFTER `escandall` ;
ALTER TABLE `sgm_articles` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `recalc_escandall` ;
ALTER TABLE `sgm_articles` ADD `stock_min` int(11) NOT NULL default '0' AFTER `fecha` ;
ALTER TABLE `sgm_articles` ADD `stock_max` int(11) NOT NULL default '0' AFTER `stock_min` ;

CREATE TABLE `sgm_articles_caracteristicas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM ;
ALTER TABLE `sgm_articles_caracteristicas` ADD `id_caracteristica` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_caracteristicas` ADD `nombre` varchar(25) NOT NULL default '' AFTER `id_caracteristica`;
ALTER TABLE `sgm_articles_caracteristicas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `nombre`;
ALTER TABLE `sgm_articles_caracteristicas` ADD `unidad` varchar(25) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sgm_articles_caracteristicas` ADD `unidad_abr` varchar(10) NOT NULL default '' AFTER `unidad`;
ALTER TABLE `sgm_articles_caracteristicas` ADD `valor` varchar(25) NOT NULL default '' AFTER `unidad_abr`;

CREATE TABLE `sgm_articles_caracteristicas_tablas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM ;
ALTER TABLE `sgm_articles_caracteristicas_tablas` ADD `id_caracteristica` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_caracteristicas_tablas` ADD `valor` varchar(25) NOT NULL default '' AFTER `id_caracteristica`;
ALTER TABLE `sgm_articles_caracteristicas_tablas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `valor`;

CREATE TABLE `sgm_articles_grupos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles_grupos` ADD `codigo` varchar(5) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_articles_grupos` ADD `grupo` varchar(30) NOT NULL default '' AFTER `codigo`;

CREATE TABLE `sgm_articles_grupos_idiomas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles_grupos_idiomas` ADD `id_grupo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_grupos_idiomas` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_grupo` ;
ALTER TABLE `sgm_articles_grupos_idiomas` ADD `grupo` varchar(30) NOT NULL default '' AFTER `id_idioma`;

CREATE TABLE `sgm_articles_rel_caracteristicas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles_rel_caracteristicas` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_rel_caracteristicas` ADD `id_valor` int(11) NOT NULL default '0' AFTER `id_articulo`;
ALTER TABLE `sgm_articles_rel_caracteristicas` ADD `valor` varchar(50) NOT NULL default '' AFTER `id_valor`;

CREATE TABLE `sgm_articles_rel_proveedores` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles_rel_proveedores` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_rel_proveedores` ADD `id_proveedor` int(11) NOT NULL default '0' AFTER `id_articulo`;
ALTER TABLE `sgm_articles_rel_proveedores` ADD `codigo_proveedor` varchar(30) NOT NULL default '' AFTER `id_proveedor`;
ALTER TABLE `sgm_articles_rel_proveedores` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `codigo_proveedor`;

CREATE TABLE `sgm_articles_subgrupos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles_subgrupos` ADD `id_grupo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_subgrupos` ADD `codigo` varchar(5) NOT NULL default '' AFTER `id_grupo`;
ALTER TABLE `sgm_articles_subgrupos` ADD `subgrupo` varchar(30) NOT NULL default '' AFTER `codigo`;
ALTER TABLE `sgm_articles_subgrupos` ADD `contador` int(11) NOT NULL default '0' AFTER `subgrupo`;

CREATE TABLE `sgm_articles_subgrupos_caracteristicas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles_subgrupos_caracteristicas` ADD `id_subgrupo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_subgrupos_caracteristicas` ADD `id_caracteristica` int(11) NOT NULL default '0' AFTER `id_subgrupo` ;

CREATE TABLE `sgm_articles_subgrupos_idiomas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles_subgrupos_idiomas` ADD `id_subgrupo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_subgrupos_idiomas` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_subgrupo` ;
ALTER TABLE `sgm_articles_subgrupos_idiomas` ADD `subgrupo` varchar(30) NOT NULL default '' AFTER `id_idioma`;

CREATE TABLE `sgm_articles_seccions` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_articles_seccions` ADD `id_article` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_articles_seccions` ADD `id_seccion` int(11) NOT NULL default '0' AFTER `id_article` ;
ALTER TABLE `sgm_articles_seccions` ADD `id_estanteria` int(11) NOT NULL default '0' AFTER `id_seccion`;
ALTER TABLE `sgm_articles_seccions` ADD `id_pasillo` int(11) NOT NULL default '0' AFTER `id_estanteria` ;
ALTER TABLE `sgm_articles_seccions` ADD `id_almacen` int(11) NOT NULL default '0' AFTER `id_pasillo`;
ALTER TABLE `sgm_articles_seccions` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_almacen`;

CREATE TABLE `sgm_cabezera` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_cabezera` ADD `id_origen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_cabezera` ADD `numero` int(11) NOT NULL default '0' AFTER `id_origen`;
ALTER TABLE `sgm_cabezera` ADD `version` int(11) NOT NULL default '0' AFTER `numero`;
ALTER TABLE `sgm_cabezera` ADD `numero_cliente` varchar(20) default NULL AFTER `version`;
ALTER TABLE `sgm_cabezera` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `numero_cliente`;
ALTER TABLE `sgm_cabezera` ADD `fecha_prevision` date NOT NULL default '0000-00-00' AFTER `fecha`;
ALTER TABLE `sgm_cabezera` ADD `fecha_entrega` date NOT NULL default '0000-00-00' AFTER `fecha_prevision`;
ALTER TABLE `sgm_cabezera` ADD `fecha_vencimiento` date NOT NULL default '0000-00-00' AFTER `fecha_entrega`;
ALTER TABLE `sgm_cabezera` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `fecha_vencimiento`;
ALTER TABLE `sgm_cabezera` ADD `tipo` int(11) NOT NULL default '1' AFTER `visible`;
ALTER TABLE `sgm_cabezera` ADD `subtipo` int(11) NOT NULL default '0' AFTER `tipo`;
ALTER TABLE `sgm_cabezera` ADD `nombre` varchar(255) default NULL AFTER `subtipo`;
ALTER TABLE `sgm_cabezera` ADD `nif` varchar(15) default NULL AFTER `nombre`;
ALTER TABLE `sgm_cabezera` ADD `direccion` varchar(150) default NULL AFTER `nif`;
ALTER TABLE `sgm_cabezera` ADD `poblacion` varchar(50) default NULL AFTER `direccion`;
ALTER TABLE `sgm_cabezera` ADD `cp` varchar(5) default NULL AFTER `poblacion`;
ALTER TABLE `sgm_cabezera` ADD `provincia` varchar(50) default NULL AFTER `cp`;
ALTER TABLE `sgm_cabezera` ADD `id_pais` int(11) NOT NULL default '0' AFTER `provincia`;
ALTER TABLE `sgm_cabezera` ADD `mail` varchar(50) default NULL AFTER `id_pais`;
ALTER TABLE `sgm_cabezera` ADD `telefono` varchar(15) default NULL AFTER `mail`;
ALTER TABLE `sgm_cabezera` ADD `onombre` varchar(255) default NULL AFTER `telefono`;
ALTER TABLE `sgm_cabezera` ADD `onif` varchar(15) default NULL AFTER `onombre`;
ALTER TABLE `sgm_cabezera` ADD `odireccion` varchar(150) default NULL AFTER `onif`;
ALTER TABLE `sgm_cabezera` ADD `opoblacion` varchar(50) default NULL AFTER `odireccion`;
ALTER TABLE `sgm_cabezera` ADD `ocp` varchar(5) default NULL AFTER `opoblacion`;
ALTER TABLE `sgm_cabezera` ADD `oprovincia` varchar(50) default NULL AFTER `ocp`;
ALTER TABLE `sgm_cabezera` ADD `omail` varchar(50) default NULL AFTER `oprovincia`;
ALTER TABLE `sgm_cabezera` ADD `otelefono` varchar(15) default NULL AFTER `omail`;
ALTER TABLE `sgm_cabezera` ADD `enombre` varchar(255) NOT NULL default '' AFTER `otelefono`;
ALTER TABLE `sgm_cabezera` ADD `edireccion` varchar(150) NOT NULL default '' AFTER `enombre`;
ALTER TABLE `sgm_cabezera` ADD `epoblacion` varchar(150) NOT NULL default '' AFTER `edireccion`;
ALTER TABLE `sgm_cabezera` ADD `ecp` varchar(5) NOT NULL default '' AFTER `epoblacion`;
ALTER TABLE `sgm_cabezera` ADD `eprovincia` varchar(50) NOT NULL default '' AFTER `ecp`;
ALTER TABLE `sgm_cabezera` ADD `eid_pais` int(11) NOT NULL default '0' AFTER `eprovincia`;
ALTER TABLE `sgm_cabezera` ADD `notas` longtext AFTER `eid_pais`;
ALTER TABLE `sgm_cabezera` ADD `subtotal` decimal(11,3) NOT NULL default '0.000' AFTER `notas`;
ALTER TABLE `sgm_cabezera` ADD `descuento` decimal(11,3) NOT NULL default '0.000' AFTER `subtotal`;
ALTER TABLE `sgm_cabezera` ADD `descuento_absoluto` decimal(11,3) NOT NULL default '0.000' AFTER `descuento`;
ALTER TABLE `sgm_cabezera` ADD `subtotaldescuento` decimal(11,3) NOT NULL default '0.000' AFTER `descuento_absoluto`;
ALTER TABLE `sgm_cabezera` ADD `iva` decimal(11,3) NOT NULL default '21.000' AFTER `subtotaldescuento`;
ALTER TABLE `sgm_cabezera` ADD `total` decimal(11,3) NOT NULL default '0.000' AFTER `iva`;
ALTER TABLE `sgm_cabezera` ADD `total_forzado` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `total` ;
ALTER TABLE `sgm_cabezera` ADD `id_cliente` int(5) NOT NULL default '0' AFTER `total_forzado`;
ALTER TABLE `sgm_cabezera` ADD `id_user` int(5) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sgm_cabezera` ADD `recibos` tinyint(1) NOT NULL default '0' AFTER `id_user`;
ALTER TABLE `sgm_cabezera` ADD `cobrada` tinyint(1) NOT NULL default '0' AFTER `recibos`;
ALTER TABLE `sgm_cabezera` ADD `id_tipo_pago` int(11) NOT NULL default '0' AFTER `cobrada`;
ALTER TABLE `sgm_cabezera` ADD `file` varchar(50) NOT NULL default '' AFTER `id_tipo_pago`;
ALTER TABLE `sgm_cabezera` ADD `cerrada` tinyint(1) NOT NULL default '0' AFTER `file`;
ALTER TABLE `sgm_cabezera` ADD `controlcalidad` int(11) NOT NULL default '0' AFTER `cerrada`;
ALTER TABLE `sgm_cabezera` ADD `print` int(11) NOT NULL default '0' AFTER `controlcalidad`;
ALTER TABLE `sgm_cabezera` ADD `bultos` int(11) NOT NULL default '0' AFTER `print`;
ALTER TABLE `sgm_cabezera` ADD `peso` int(11) NOT NULL default '0' AFTER `bultos`;
ALTER TABLE `sgm_cabezera` ADD `nombre_contacto` varchar(20) default NULL AFTER `peso`;
ALTER TABLE `sgm_cabezera` ADD `confirmada` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `nombre_contacto` ;
ALTER TABLE `sgm_cabezera` ADD `confirmada_cliente` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `confirmada` ;
ALTER TABLE `sgm_cabezera` ADD `id_divisa` int(11) NOT NULL default '0' AFTER `confirmada_cliente`;
ALTER TABLE `sgm_cabezera` ADD `div_canvi` int(11) NOT NULL default '0' AFTER `id_divisa`;
ALTER TABLE `sgm_cabezera` ADD `imp_exp` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `div_canvi` ;
ALTER TABLE `sgm_cabezera` ADD `trz` int(11) NOT NULL default '0' AFTER `imp_exp`;
ALTER TABLE `sgm_cabezera` ADD `cnombre` varchar(55) NOT NULL default '' AFTER `trz`;
ALTER TABLE `sgm_cabezera` ADD `ctelefono` varchar(55) NOT NULL default '' AFTER `cnombre`;
ALTER TABLE `sgm_cabezera` ADD `cmail` varchar(55) NOT NULL default '' AFTER `ctelefono`;
ALTER TABLE `sgm_cabezera` ADD `numero_rfq` varchar(55) NOT NULL default '' AFTER `cmail`;
ALTER TABLE `sgm_cabezera` ADD `cuenta` int(30) NOT NULL default '0' AFTER `numero_rfq`;
ALTER TABLE `sgm_cabezera` ADD `aprovado` tinyint(1) NOT NULL default '0' AFTER `cuenta`;
ALTER TABLE `sgm_cabezera` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `aprovado`;
ALTER TABLE `sgm_cabezera` ADD `id_licencia` int(11) NOT NULL default '0' AFTER `id_contrato`;
ALTER TABLE `sgm_cabezera` ADD `id_pagador` int(11) NOT NULL default '0' AFTER `id_licencia`;
ALTER TABLE `sgm_cabezera` ADD `id_dades_origen_factura_iban` int(11) NOT NULL default '0' AFTER `id_pagador`;
ALTER TABLE `sgm_cabezera` ADD `retenciones` decimal(11,3) NOT NULL default '0.000' AFTER `id_dades_origen_factura_iban`;

CREATE TABLE `sgm_calendario` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_calendario` ADD `dia` int(11) NOT NULL default '0' AFTER `id` ;
ALTER TABLE `sgm_calendario` ADD `mes` int(11) NOT NULL default '0' AFTER `dia` ;
ALTER TABLE `sgm_calendario` ADD `ano` int(11) NOT NULL default '0' AFTER `mes` ;
ALTER TABLE `sgm_calendario` ADD `descripcio` varchar(255) NOT NULL default '' AFTER `ano`;

CREATE TABLE `sgm_calendario_horario` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_calendario_horario` ADD `dia` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_calendario_horario` ADD `hora_inicio` int(11) NOT NULL default '0' AFTER `dia` ;
ALTER TABLE `sgm_calendario_horario` ADD `hora_fin` int(11) NOT NULL default '0' AFTER `hora_inicio` ;
ALTER TABLE `sgm_calendario_horario` ADD `total_horas` int(11) NOT NULL default '0' AFTER `hora_fin` ;

CREATE TABLE `sgm_clients` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients` ADD `id_origen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_clients` ADD `id_agrupacio` int(11) NOT NULL default '0' AFTER `id_origen`;
ALTER TABLE `sgm_clients` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_agrupacio`;
ALTER TABLE `sgm_clients` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sgm_clients` ADD `cognom1` varchar(55) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sgm_clients` ADD `cognom2` varchar(55) NOT NULL default '' AFTER `cognom1`;
ALTER TABLE `sgm_clients` ADD `tipo_identificador` tinyint(1) NOT NULL default '1' AFTER `cognom2`;
/*tipo_identificador: 1 nif; 2 VAT; 3 extrangero; 4 sin numero*/
ALTER TABLE `sgm_clients` ADD `nif` varchar(15) NOT NULL default '' AFTER `tipo_identificador`;
ALTER TABLE `sgm_clients` ADD `direccion` varchar(255) NOT NULL default '' AFTER `nif`;
ALTER TABLE `sgm_clients` ADD `poblacion` varchar(50) NOT NULL default '' AFTER `direccion`;
ALTER TABLE `sgm_clients` ADD `cp` varchar(5) NOT NULL default '' AFTER `poblacion`;
ALTER TABLE `sgm_clients` ADD `provincia` varchar(15) NOT NULL default '' AFTER `cp`;
ALTER TABLE `sgm_clients` ADD `id_pais` int(11) NOT NULL default '0' AFTER `provincia`;
ALTER TABLE `sgm_clients` ADD `tipo_persona` tinyint(1) NOT NULL default '0' AFTER `id_pais`;
/*tipo_persona: 0 juridica; 1 física*/
ALTER TABLE `sgm_clients` ADD `tipo_residencia` int(11) NOT NULL default '0' AFTER `tipo_persona`;
/*tipo_residencia: 0 residente; 1 residente UE; 2 extrangero*/
/*DIR3 per factura electronica*/
ALTER TABLE `sgm_clients` ADD `dir3_oficina_contable` varchar(15) NOT NULL default '' AFTER `tipo_residencia`;
ALTER TABLE `sgm_clients` ADD `dir3_organo_gestor` varchar(15) NOT NULL default '' AFTER `dir3_oficina_contable`;
ALTER TABLE `sgm_clients` ADD `dir3_unidad_tramitadora` varchar(15) NOT NULL default '' AFTER `dir3_organo_gestor`;
ALTER TABLE `sgm_clients` ADD `mail` varchar(50) NOT NULL default '' AFTER `dir3_unidad_tramitadora`;
ALTER TABLE `sgm_clients` ADD `telefono` varchar(15) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sgm_clients` ADD `telefono2` varchar(15) NOT NULL default '' AFTER `telefono`;
ALTER TABLE `sgm_clients` ADD `fax` varchar(15) NOT NULL default '' AFTER `telefono2`;
ALTER TABLE `sgm_clients` ADD `fax2` varchar(15) NOT NULL default '' AFTER `fax`;
ALTER TABLE `sgm_clients` ADD `web` varchar(150) default NULL AFTER `fax2`;
ALTER TABLE `sgm_clients` ADD `alias` varchar(11) NOT NULL default '' AFTER `web`;
ALTER TABLE `sgm_clients` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `alias`;
ALTER TABLE `sgm_clients` ADD `num_treballadors` int(11) NOT NULL default '0' AFTER `id_idioma`;
ALTER TABLE `sgm_clients` ADD `notas` longtext AFTER `num_treballadors`;
ALTER TABLE `sgm_clients` ADD `client` tinyint(1) NOT NULL default '0' AFTER `notas`;
ALTER TABLE `sgm_clients` ADD `clientvip` tinyint(1) NOT NULL default '0' AFTER `client`;
ALTER TABLE `sgm_clients` ADD `cuentabancaria` varchar(30) default NULL AFTER `clientvip`;
ALTER TABLE `sgm_clients` ADD `dias_vencimiento` int(11) NOT NULL default '0' AFTER `cuentabancaria`;
ALTER TABLE `sgm_clients` ADD `dia_mes_vencimiento` int(11) NOT NULL default '0' AFTER `dias_vencimiento`;
ALTER TABLE `sgm_clients` ADD `dias` tinyint(1) NOT NULL default '1' AFTER `dia_mes_vencimiento`;
ALTER TABLE `sgm_clients` ADD `dia_facturacion` int(11) NOT NULL default '0' AFTER `dias`;
ALTER TABLE `sgm_clients` ADD `dia_recibo` int(11) NOT NULL default '0' AFTER `dia_facturacion`;
ALTER TABLE `sgm_clients` ADD `id_medio_facturacion` int(11) NOT NULL default '0' AFTER `dia_recibo`;
ALTER TABLE `sgm_clients` ADD `destino_facturacion` varchar(255) NOT NULL default '' AFTER `id_medio_facturacion`;
ALTER TABLE `sgm_clients` ADD `id_formato_facturacion` int(11) NOT NULL default '0' AFTER `destino_facturacion`;
ALTER TABLE `sgm_clients` ADD `id_contacto_facturacion` int(11) NOT NULL default '0' AFTER `id_formato_facturacion`;
ALTER TABLE `sgm_clients` ADD `notas_facturacion` longtext AFTER `id_contacto_facturacion`;
ALTER TABLE `sgm_clients` ADD `cae` tinyint(1) NOT NULL default '0' AFTER `notas_facturacion`;
ALTER TABLE `sgm_clients` ADD `cae_url` varchar(150) NOT NULL default '' AFTER `cae`;

/*
ALTER TABLE `sgm_clients` ADD `clienttipus` tinyint(1) NOT NULL default '0' AFTER `client`;
ALTER TABLE `sgm_clients` ADD `entidadbancaria` varchar(100) NOT NULL default '' AFTER `cuentabancaria`;
ALTER TABLE `sgm_clients` ADD `domiciliobancario` varchar(255) NOT NULL default '' AFTER `entidadbancaria`;
ALTER TABLE `sgm_clients` ADD `cuentacontable` varchar(20) NOT NULL default '' AFTER `dias`;
ALTER TABLE `sgm_clients` ADD `formas_pago` varchar(15) NOT NULL default '' AFTER `cuentacontable`;
ALTER TABLE `sgm_clients` ADD `sector` int(11) NOT NULL default '0' AFTER `formas_pago`;
ALTER TABLE `sgm_clients` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `notas_comerciales`;
ALTER TABLE `sgm_clients` ADD `id_direccion_envio` int(11) NOT NULL default '0' AFTER `id_tipo`;
ALTER TABLE `sgm_clients` ADD `onweb` tinyint(1) NOT NULL default '0' AFTER `id_direccion_envio`;
ALTER TABLE `sgm_clients` ADD `logo` varchar(255) NOT NULL default '' AFTER `onweb`;
ALTER TABLE `sgm_clients` ADD `id_ubicacion` int(11) NOT NULL default '0' AFTER `logo`;
ALTER TABLE `sgm_clients` ADD `id_grupo` int(11) NOT NULL default '0' AFTER `id_ubicacion`;
ALTER TABLE `sgm_clients` ADD `general` tinyint(1) NOT NULL default '0' AFTER `id_grupo`;
ALTER TABLE `sgm_clients` ADD `servicio` tinyint(1) NOT NULL default '0' AFTER `general`;
ALTER TABLE `sgm_clients` ADD `coste_ekl` decimal(11,3) NOT NULL default '0.000' AFTER `servicio`;
ALTER TABLE `sgm_clients` ADD `coste_em3` decimal(11,3) NOT NULL default '0.000' AFTER `coste_ekl`;
ALTER TABLE `sgm_clients` ADD `coste_miledia` decimal(11,3) NOT NULL default '0.000' AFTER `coste_em3`;
ALTER TABLE `sgm_clients` ADD `dades_adicionals` longtext AFTER `fax2`;
ALTER TABLE `sgm_clients` ADD `text_lliure` longtext AFTER `dades_adicionals`;
ALTER TABLE `sgm_clients` ADD `codcliente` varchar(11) NOT NULL default '' AFTER `cognom2`;
ALTER TABLE `sgm_clients` ADD `fecha_contrac` date NOT NULL default '0000-00-00' AFTER `codcliente`;
ALTER TABLE `sgm_clients` ADD `id_tipo_carrer` int(11) NOT NULL default '0' AFTER `fecha_contrac`;
ALTER TABLE `sgm_clients` ADD `id_carrer` int(11) NOT NULL default '0' AFTER `id_tipo_carrer`;
ALTER TABLE `sgm_clients` ADD `numero` varchar(11) NOT NULL default '0' AFTER `id_carrer`;
ALTER TABLE `sgm_clients` ADD `id_sector_zf` int(11) NOT NULL default '0' AFTER `numero`;
*/

CREATE TABLE `sgm_clients_bases_dades` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_bases_dades` ADD `id_client` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_clients_bases_dades` ADD `base` varchar(50) NOT NULL default '' AFTER `id_client`;
ALTER TABLE `sgm_clients_bases_dades` ADD `ip` varchar(50) NOT NULL default '' AFTER `base`;
ALTER TABLE `sgm_clients_bases_dades` ADD `usuario` varchar(50) NOT NULL default '' AFTER `ip`;
ALTER TABLE `sgm_clients_bases_dades` ADD `pass` varchar(50) NOT NULL default '' AFTER `usuario`;
ALTER TABLE `sgm_clients_bases_dades` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `pass`;
ALTER TABLE `sgm_clients_bases_dades` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;

CREATE TABLE `sgm_clients_busquedas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_busquedas` ADD `nombre` varchar(20) default NULL AFTER `id`;
ALTER TABLE `sgm_clients_busquedas` ADD `letras` varchar(30) default NULL AFTER `nombre`;
ALTER TABLE `sgm_clients_busquedas` ADD `tipos` varchar(50) NOT NULL default '' AFTER `letras` ;
ALTER TABLE `sgm_clients_busquedas` ADD `sectores` varchar(50) NOT NULL default '' AFTER `tipos`;
ALTER TABLE `sgm_clients_busquedas` ADD `origenes` varchar(50) NOT NULL default '' AFTER `sectores` ;
ALTER TABLE `sgm_clients_busquedas` ADD `paises` varchar(50) NOT NULL default '' AFTER `origenes`;
ALTER TABLE `sgm_clients_busquedas` ADD `comunidades` varchar(50) NOT NULL default '' AFTER `paises`;
ALTER TABLE `sgm_clients_busquedas` ADD `provincias` varchar(50) NOT NULL default '' AFTER `comunidades`;
ALTER TABLE `sgm_clients_busquedas` ADD `regiones` varchar(50) NOT NULL default '' AFTER `provincias` ;
ALTER TABLE `sgm_clients_busquedas` ADD `likenombre` varchar(20) default NULL AFTER `regiones`;

CREATE TABLE `sgm_clients_contactos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_contactos` ADD `id_client` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_clients_contactos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_client`;
ALTER TABLE `sgm_clients_contactos` ADD `notas` longtext AFTER `visible`;
ALTER TABLE `sgm_clients_contactos` ADD `nombre` varchar(255) NOT NULL default '' AFTER `notas`;
ALTER TABLE `sgm_clients_contactos` ADD `carrec` varchar(255) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sgm_clients_contactos` ADD `departament` varchar(255) NOT NULL default '' AFTER `carrec`;
ALTER TABLE `sgm_clients_contactos` ADD `telefono` varchar(15) NOT NULL default '' AFTER `departament`;
ALTER TABLE `sgm_clients_contactos` ADD `fax` varchar(15) NOT NULL default '' AFTER `telefono`;
ALTER TABLE `sgm_clients_contactos` ADD `mail` varchar(50) NOT NULL default '' AFTER `fax`;
ALTER TABLE `sgm_clients_contactos` ADD `movil` varchar(15) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sgm_clients_contactos` ADD `id_trato` int(11) NOT NULL default '0' AFTER `movil`;
ALTER TABLE `sgm_clients_contactos` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_trato`;
ALTER TABLE `sgm_clients_contactos` ADD `pred` tinyint(1) NOT NULL default '0' AFTER `id_idioma`;
ALTER TABLE `sgm_clients_contactos` ADD `apellido1` varchar(255) NOT NULL default '' AFTER `pred`;
ALTER TABLE `sgm_clients_contactos` ADD `apellido2` varchar(255) NOT NULL default '' AFTER `apellido1`;

CREATE TABLE `sgm_clients_dias_recibos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_dias_recibos` ADD `dia` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_clients_dias_recibos` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `dia`;

CREATE TABLE `sgm_clients_dias_vencimiento` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_dias_vencimiento` ADD `dia` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_clients_dias_vencimiento` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `dia`;

CREATE TABLE `sim_clientes_docs_cae` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_clientes_docs_cae` ADD `nombre` varchar(100) default NULL AFTER `id`;
ALTER TABLE `sim_clientes_docs_cae` ADD `caducidad` date NOT NULL default '0000-00-00' AFTER `nombre`;
ALTER TABLE `sim_clientes_docs_cae` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `caducidad`;

CREATE TABLE `sgm_clients_origen` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_origen` ADD `origen` varchar(30) NOT NULL default '' AFTER `id`;

CREATE TABLE `sgm_clients_rel_origen` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_rel_origen` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_clients_rel_origen` ADD `id_origen` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sgm_clients_rel_origen` ADD `tipo_origen` int(11) NOT NULL default '0' AFTER `id_origen`;
ALTER TABLE `sgm_clients_rel_origen` ADD `otro_origen` varchar(30) NOT NULL default '' AFTER `tipo_origen`;
/*tipo_origen: 1 origen; 2 cliente; 3 contacto; 4 empleado; 5 otros*/

CREATE TABLE `sgm_clients_rel_sectores` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_rel_sectores` ADD `id_sector` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sgm_clients_rel_sectores` ADD `id_cliente` varchar(30) NOT NULL default '' AFTER `id_sector`;

CREATE TABLE `sgm_clients_rel_tipos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_rel_tipos` ADD `id_tipo` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sgm_clients_rel_tipos` ADD `id_cliente` varchar(30) NOT NULL default '' AFTER `id_tipo`;

CREATE TABLE `sgm_clients_rel_ubicacion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_rel_ubicacion` ADD `id_cliente` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_clients_rel_ubicacion` ADD `id_ubicacion` int(11) NOT NULL AFTER `id_cliente`;
ALTER TABLE `sgm_clients_rel_ubicacion` ADD `tipo_ubicacion` int(11) NOT NULL AFTER `id_ubicacion`;
/*tipo_ubicacion: 1 pais; 2 com. autonoma; 3 provincia; 4 región*/

CREATE TABLE `sgm_clients_sectores` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_sectores` ADD `id_sector` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sgm_clients_sectores` ADD `sector` varchar(30) NOT NULL default '' AFTER `id_sector`;

CREATE TABLE `sgm_clients_servidors` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_servidors` ADD `id_client` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sgm_clients_servidors` ADD `servidor` varchar(255) NOT NULL default '' AFTER `id_client`;
ALTER TABLE `sgm_clients_servidors` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `servidor`;
ALTER TABLE `sgm_clients_servidors` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;
ALTER TABLE `sgm_clients_servidors` ADD `indice` int(11) NOT NULL AFTER `visible`;

CREATE TABLE `sgm_clients_servidors_alertes` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_servidors_alertes` ADD `id_servidor` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sgm_clients_servidors_alertes` ADD `fecha_caida` int(11) NOT NULL AFTER `id_servidor`;
ALTER TABLE `sgm_clients_servidors_alertes` ADD `fecha_subida` int(11) AFTER `fecha_caida`;
ALTER TABLE `sgm_clients_servidors_alertes` ADD `tiempo` int(11) NOT NULL default '0' AFTER `fecha_subida`;
ALTER TABLE `sgm_clients_servidors_alertes` ADD `id_error` int(11) NOT NULL AFTER `tiempo`;

CREATE TABLE `sgm_clients_servidors_param` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_servidors_param` ADD `cpu` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sgm_clients_servidors_param` ADD `mem` int(11) NOT NULL AFTER `cpu`;
ALTER TABLE `sgm_clients_servidors_param` ADD `memswap` int(11) NOT NULL AFTER `mem`;
ALTER TABLE `sgm_clients_servidors_param` ADD `hd` int(11) NOT NULL AFTER `memswap`;

CREATE TABLE `sgm_clients_tipos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_tipos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sgm_clients_tipos` ADD `id_origen` int(11) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sgm_clients_tipos` ADD `nombre` varchar(255) NOT NULL default '' AFTER `id_origen`;
ALTER TABLE `sgm_clients_tipos` ADD `color` varchar(12) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sgm_clients_tipos` ADD `color_letra` varchar(12) NOT NULL default '' AFTER `color`;
ALTER TABLE `sgm_clients_tipos` ADD `factura` tinyint(1) NOT NULL default '0' AFTER `color_letra`;
ALTER TABLE `sgm_clients_tipos` ADD `id_tipo_factura` int(11) NOT NULL default '0' AFTER `factura`;
ALTER TABLE `sgm_clients_tipos` ADD `contrato` tinyint(1) NOT NULL default '0' AFTER `id_tipo_factura`;
ALTER TABLE `sgm_clients_tipos` ADD `contrato_activo` tinyint(1) NOT NULL default '0' AFTER `id_tipo_factura`;
ALTER TABLE `sgm_clients_tipos` ADD `incidencia` tinyint(1) NOT NULL default '0' AFTER `contrato_activo`;
ALTER TABLE `sgm_clients_tipos` ADD `datos_fiscales` tinyint(1) NOT NULL default '0' AFTER `incidencia`;

CREATE TABLE `sgm_clients_tratos` ( `id` int(11) NOT NULL auto_increment, PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_clients_tratos` ADD `trato` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_clients_tratos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `trato`;
ALTER TABLE `sgm_clients_tratos` ADD `predeterminado` tinyint(1) NOT NULL default '0' AFTER `visible`;
INSERT INTO `sgm_clients_tratos` VALUES (0,'',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (1,'Sr.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (2,'Sra.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (3,'Mr.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (4,'Ms.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (5,'M.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (6,'Mme.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (7,'Mlle',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (8,'Hr.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (9,'Fr.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (10,'Illo.',1,0);
INSERT INTO `sgm_clients_tratos` VALUES (11,'Illa.',1,0);

CREATE TABLE `sim_comercial_articulos_grupos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_articulos_grupos` ADD `id_articulo_grupo` int(11) NOT NULL default '0' AFTER `id`;

CREATE TABLE `sim_comercial_contenido` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_contenido` ADD `id_comercial_contenido` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_contenido` ADD `titulo` varchar(100) NOT NULL default '' AFTER `id_comercial_contenido`;
ALTER TABLE `sim_comercial_contenido` ADD `contenido` longtext AFTER `titulo`;
ALTER TABLE `sim_comercial_contenido` ADD `contenido_extenso` longtext AFTER `contenido`;
ALTER TABLE `sim_comercial_contenido` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `contenido_extenso`;
ALTER TABLE `sim_comercial_contenido` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_comercial_contenido` ADD `version` int(11) NOT NULL default '0' AFTER `id_idioma`;
ALTER TABLE `sim_comercial_contenido` ADD `versionado` tinyint(1) NOT NULL default '0' AFTER `version`;
ALTER TABLE `sim_comercial_contenido` ADD `editable` tinyint(1) NOT NULL default '0' AFTER `versionado`;
ALTER TABLE `sim_comercial_contenido` ADD `id_comercial_oferta` int(11) NOT NULL default '0' AFTER `editable`;

CREATE TABLE `sim_comercial_oferta` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta` ADD `id_cliente_final` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_comercial_oferta` ADD `numero` int(11) NOT NULL default '0' AFTER `id_cliente_final`;
ALTER TABLE `sim_comercial_oferta` ADD `version` int(11) NOT NULL default '0' AFTER `numero`;
ALTER TABLE `sim_comercial_oferta` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `version`;
ALTER TABLE `sim_comercial_oferta` ADD `id_plantilla` int(11) NOT NULL default '0' AFTER `fecha`;
ALTER TABLE `sim_comercial_oferta` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_plantilla`;
ALTER TABLE `sim_comercial_oferta` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `id_idioma`;
ALTER TABLE `sim_comercial_oferta` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;
ALTER TABLE `sim_comercial_oferta` ADD `versionado` tinyint(1) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_comercial_oferta` ADD `aceptada` tinyint(1) NOT NULL default '0' AFTER `versionado`;
ALTER TABLE `sim_comercial_oferta` ADD `cerrada` tinyint(1) NOT NULL default '0' AFTER `aceptada`;
ALTER TABLE `sim_comercial_oferta` ADD `id_autor` int(11) NOT NULL default '0' AFTER `cerrada`;
ALTER TABLE `sim_comercial_oferta` ADD `num_dispositivos` int(11) NOT NULL default '0' AFTER `id_autor`;
ALTER TABLE `sim_comercial_oferta` ADD `num_servicios` int(11) NOT NULL default '0' AFTER `num_dispositivos`;
ALTER TABLE `sim_comercial_oferta` ADD `id_tipo_servidor` int(11) NOT NULL default '0' AFTER `num_servicios`;
ALTER TABLE `sim_comercial_oferta` ADD `id_software` int(11) NOT NULL default '0' AFTER `id_tipo_servidor`;
ALTER TABLE `sim_comercial_oferta` ADD `socio_tecnologico` tinyint(1) NOT NULL default '0' AFTER `id_software`;
ALTER TABLE `sim_comercial_oferta` ADD `id_contacto` int(11) NOT NULL default '0' AFTER `socio_tecnologico`;

CREATE TABLE `sim_comercial_oferta_comentarios` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta_comentarios` ADD `id_comercial_oferta` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta_comentarios` ADD `comentario` varchar(255) NOT NULL default '' AFTER `id_comercial_oferta`;
ALTER TABLE `sim_comercial_oferta_comentarios` ADD `fecha` datetime NOT NULL default '0000-00-00 00:00:00' AFTER `comentario`;
ALTER TABLE `sim_comercial_oferta_comentarios` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `fecha`;
ALTER TABLE `sim_comercial_oferta_comentarios` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_usuario`;

CREATE TABLE `sim_comercial_oferta_condiciones_pago` ( `id` int(11) NOT NULL auto_increment,   PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta_condiciones_pago` ADD `id_comercial_oferta` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago` ADD `id_comercial_oferta_valoracion` int(11) NOT NULL default '0' AFTER `id_comercial_oferta`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `id_comercial_oferta_valoracion`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago` ADD `aceptada` tinyint(1) NOT NULL default '0' AFTER `descripcion`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago` ADD `orden` int(11) NOT NULL default '0' AFTER `aceptada`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago` ADD `comentarios` longtext AFTER `orden`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago` ADD CONSTRAINT `fkcomercialoferta` FOREIGN KEY(`id_comercial_oferta`) REFERENCES `sim_comercial_oferta_comentarios`(`id`);
ALTER TABLE `sim_comercial_oferta_condiciones_pago` ADD CONSTRAINT `fkcomercialvaloracion` FOREIGN KEY(`id_comercial_oferta_valoracion`) REFERENCES `sim_comercial_oferta_valoracion`(`id`);

CREATE TABLE `sim_comercial_oferta_condiciones_pago_facturas` ( `id` int(11) NOT NULL auto_increment,   PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD `id_comercial_oferta_condiciones_pago` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD `orden` int(11) NOT NULL default '0' AFTER `id_comercial_oferta_condiciones_pago`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `orden`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD `fecha_texto` varchar(255) NOT NULL default '' AFTER `fecha`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD `concepto` longtext AFTER `fecha_texto`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD `importe` decimal(11,2) NOT NULL default '0' AFTER `concepto` ;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD `descuento` decimal(11,2) NOT NULL default '0' AFTER `importe` ;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD `dias_vencimiento` int(11) NOT NULL default '0' AFTER `descuento`;
ALTER TABLE `sim_comercial_oferta_condiciones_pago_facturas` ADD CONSTRAINT `fkcomercialcondiciones` FOREIGN KEY(`id_comercial_oferta_condiciones_pago`) REFERENCES `sim_comercial_oferta_condiciones_pago`(`id`);

CREATE TABLE `sim_comercial_oferta_rel_contenido` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta_rel_contenido` ADD `id_comercial_oferta` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta_rel_contenido` ADD `id_comercial_contenido` int(11) NOT NULL default '0' AFTER `id_comercial_oferta`;
ALTER TABLE `sim_comercial_oferta_rel_contenido` ADD `orden` varchar(10) NOT NULL default '' AFTER `id_comercial_contenido`;

CREATE TABLE `sim_comercial_oferta_valoracion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta_valoracion` ADD `id_comercial_oferta` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta_valoracion` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `id_comercial_oferta`;
ALTER TABLE `sim_comercial_oferta_valoracion` ADD `total` decimal(11,2) NOT NULL default '0' AFTER `descripcion` ;
ALTER TABLE `sim_comercial_oferta_valoracion` ADD `descuento` decimal(11,2) NOT NULL default '0' AFTER `total` ;
ALTER TABLE `sim_comercial_oferta_valoracion` ADD `aceptada` tinyint(1) NOT NULL default '0' AFTER `descuento`;
ALTER TABLE `sim_comercial_oferta_valoracion` ADD `comentarios` longtext AFTER `aceptada`;
ALTER TABLE `sim_comercial_oferta_valoracion` ADD `desglosar` tinyint(1) NOT NULL default '0' AFTER `comentarios`;
ALTER TABLE `sim_comercial_oferta_valoracion` ADD `orden` int(11) NOT NULL default '0' AFTER `desglosar`;

CREATE TABLE `sim_comercial_oferta_valoracion_rel_articulos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta_valoracion_rel_articulos` ADD `id_comercial_oferta_valoracion` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta_valoracion_rel_articulos` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `id_comercial_oferta_valoracion`;
ALTER TABLE `sim_comercial_oferta_valoracion_rel_articulos` ADD `unidades` int(11) NOT NULL default '0' AFTER `id_articulo`;
ALTER TABLE `sim_comercial_oferta_valoracion_rel_articulos` ADD `pvp` decimal(11,2) NOT NULL default '0.00' AFTER `unidades`;
ALTER TABLE `sim_comercial_oferta_valoracion_rel_articulos` ADD `orden` int(11) NOT NULL default '0' AFTER `pvp`;

CREATE TABLE `sim_comercial_oferta_rel_servicios` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta_rel_servicios` ADD `id_comercial_oferta` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta_rel_servicios` ADD `id_servicio` int(11) NOT NULL default '0' AFTER `id_comercial_oferta`;

CREATE TABLE `sim_comercial_oferta_servidores` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_oferta_servidores` ADD `id_comercial_oferta` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_comercial_oferta_servidores` ADD `servidores` varchar(255) NOT NULL default '' AFTER `id_comercial_oferta`;

CREATE TABLE `sim_comercial_socio_tecnologico` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_socio_tecnologico` ADD `texto` longtext AFTER `id`;
ALTER TABLE `sim_comercial_socio_tecnologico` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `texto`;

CREATE TABLE `sim_comercial_software` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_software` ADD `software` varchar(255) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_comercial_software` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `software`;

CREATE TABLE `sim_comercial_tipos_servidores` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comercial_tipos_servidores` ADD `tipo_servidor` varchar(255) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_comercial_tipos_servidores` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `tipo_servidor`;

CREATE TABLE `sim_comunidades_autonomas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_comunidades_autonomas` ADD `comunidad_autonoma` varchar(50) default NULL AFTER `id`;
ALTER TABLE `sim_comunidades_autonomas` ADD `siglas` char(3) default NULL AFTER `comunidad_autonoma`;
ALTER TABLE `sim_comunidades_autonomas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `siglas`;
ALTER TABLE `sim_comunidades_autonomas` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `visible`;
INSERT INTO `sim_comunidades_autonomas` (`id`,`comunidad_autonoma`,`siglas`,`visible`,`predefinido`) VALUES (1,'Andalucía','AN',1,0),(2,'Aragón','AR',1,0),(3,'Asturias, Principado de','AS',1,0),(4,'Balears, Illes','IB',1,0),(5,'Canarias','CN',1,0),(6,'Cantabria','CB',1,0),(7,'Castilla y León','CL',1,0),(8,'Castilla - La Mancha','CM',1,0),(9,'Catalunya','CT',1,1),(10,'Comunitat Valenciana','VC',1,0),(11,'Extremadura','EX',1,0),(12,'Galicia','GA',1,0),(13,'Madrid, Comunidad de','MD',1,0),(14,'Murcia, Región de','MC',1,0),(15,'Navarra, Comunidad Foral de','NC',1,0),(16,'País Vasco','PV',1,0),(17,'Rioja, La','RI',1,0),(18,'Ceuta','CE',1,0),(19,'Melilla','ML',1,0);

CREATE TABLE `sim_contenidos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos` ADD `id_autor` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_autor`;
ALTER TABLE `sim_contenidos` ADD `fecha_creacion` int(15) NOT NULL default '0' AFTER `id_idioma`;
ALTER TABLE `sim_contenidos` ADD `fecha_publicacion` int(15) NOT NULL default '0' AFTER `fecha_creacion`;
ALTER TABLE `sim_contenidos` ADD `titulo` varchar(55) NOT NULL default '' AFTER `fecha_publicacion`;
ALTER TABLE `sim_contenidos` ADD `contenido` longtext AFTER `titulo`;
ALTER TABLE `sim_contenidos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `contenido`;

CREATE TABLE `sim_contenidos_categorias` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_categorias` ADD `categoria` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contenidos_categorias` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `categoria`;

CREATE TABLE `sim_contenidos_etiquetas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_etiquetas` ADD `etiqueta` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contenidos_etiquetas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `etiqueta`;

CREATE TABLE `sim_contenidos_medios_publicacion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_medios_publicacion` ADD `medio_publicacion` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contenidos_medios_publicacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `medio_publicacion`;

CREATE TABLE `sim_contenidos_redes_sociales` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_redes_sociales` ADD `red_social` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sim_contenidos_redes_sociales` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `red_social`;

CREATE TABLE `sim_contenidos_rel_categorias` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_rel_categorias` ADD `id_categoria` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_rel_categorias` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_categoria`;

CREATE TABLE `sim_contenidos_rel_etiquetas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_rel_etiquetas` ADD `id_etiqueta` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_rel_etiquetas` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_etiqueta`;

CREATE TABLE `sim_contenidos_rel_medios_publicacion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_rel_medios_publicacion` ADD `id_medios_publicacion` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_rel_medios_publicacion` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_medios_publicacion`;

CREATE TABLE `sim_contenidos_rel_redes_sociales` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_rel_redes_sociales` ADD `id_redes_sociales` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_rel_redes_sociales` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_redes_sociales`;

CREATE TABLE `sim_contenidos_revisiones` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_contenidos_revisiones` ADD `id_autor_revision` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_contenidos_revisiones` ADD `id_contenido` int(11) NOT NULL default '0' AFTER `id_autor_revision`;
ALTER TABLE `sim_contenidos_revisiones` ADD `fecha_revision` int(15) NOT NULL default '0' AFTER `id_contenido`;

CREATE TABLE `sgm_contrasenyes` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contrasenyes` ADD `id_client` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_contrasenyes` ADD `id_aplicacion` int(11) NOT NULL default '0' AFTER `id_client`;
ALTER TABLE `sgm_contrasenyes` ADD `acceso` varchar(100) NOT NULL default '' AFTER `id_aplicacion`;
ALTER TABLE `sgm_contrasenyes` ADD `usuario` varchar(50) NOT NULL default '' AFTER `acceso`;
ALTER TABLE `sgm_contrasenyes` ADD `pass` varchar(50) NOT NULL default '' AFTER `usuario`;
ALTER TABLE `sgm_contrasenyes` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `pass`;
ALTER TABLE `sgm_contrasenyes` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;
ALTER TABLE `sgm_contrasenyes` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sgm_contrasenyes_apliciones` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contrasenyes_apliciones` ADD `aplicacion` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_contrasenyes_apliciones` ADD `descripcion` varchar(255) NOT NULL default '' AFTER `aplicacion`;
ALTER TABLE `sgm_contrasenyes_apliciones` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;

CREATE TABLE `sgm_contrasenyes_lopd` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contrasenyes_lopd` ADD `id_contrasenya` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_contrasenyes_lopd` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_contrasenya`;
ALTER TABLE `sgm_contrasenyes_lopd` ADD `fecha` int(11) NOT NULL default '0' AFTER `id_usuario`;
ALTER TABLE `sgm_contrasenyes_lopd` ADD `accion` int(11) NOT NULL default '0' AFTER `fecha`;

CREATE TABLE `sgm_contratos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contratos` ADD `id_contrato_tipo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_contratos` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id_contrato_tipo`;
ALTER TABLE `sgm_contratos` ADD `id_cliente_final` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sgm_contratos` ADD `num_contrato` int(11) NOT NULL default '0' AFTER `id_cliente_final`;
ALTER TABLE `sgm_contratos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `num_contrato`;
ALTER TABLE `sgm_contratos` ADD `fecha_ini` date NOT NULL default '0000-00-00' AFTER `visible`;
ALTER TABLE `sgm_contratos` ADD `fecha_fin` date NOT NULL default '0000-00-00' AFTER `fecha_ini`;
ALTER TABLE `sgm_contratos` ADD `activo` tinyint(1) NOT NULL default '1' AFTER `fecha_fin`;
ALTER TABLE `sgm_contratos` ADD `descripcion` longtext AFTER `activo`;
ALTER TABLE `sgm_contratos` ADD `id_responsable` int(11) NOT NULL default '0' AFTER `descripcion`;
ALTER TABLE `sgm_contratos` ADD `id_tecnico` int(11) NOT NULL default '0' AFTER `id_responsable`;
ALTER TABLE `sgm_contratos` ADD `renovado` tinyint(1) NOT NULL default '0' AFTER `id_tecnico`;
ALTER TABLE `sgm_contratos` ADD `id_plantilla` int(11) NOT NULL default '0' AFTER `renovado`;
ALTER TABLE `sgm_contratos` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `id_plantilla`;
ALTER TABLE `sgm_contratos` ADD `id_tarifa` int(11) NOT NULL default '0' AFTER `id_contrato`;
ALTER TABLE `sgm_contratos` ADD `pack_horas` tinyint(1) NOT NULL default '0' AFTER `id_tarifa`;
ALTER TABLE `sgm_contratos` ADD `num_horas` int(11) NOT NULL default '0' AFTER `pack_horas`;
ALTER TABLE `sgm_contratos` ADD `horas_mensual` tinyint(1) NOT NULL default '0' AFTER `num_horas`;
ALTER TABLE `sgm_contratos` ADD `id_articulo_desplazamiento` tinyint(1) NOT NULL default '0' AFTER `horas_mensual`;

CREATE TABLE `sgm_contratos_servicio` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contratos_servicio` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_contratos_servicio` ADD `id_servicio` int(11) NOT NULL default '0' AFTER `id_contrato`;
ALTER TABLE `sgm_contratos_servicio` ADD `servicio` varchar(55) NOT NULL default '' AFTER `id_servicio`;
ALTER TABLE `sgm_contratos_servicio` ADD `id_cobertura` int(11) NOT NULL default '0' AFTER `servicio`;
ALTER TABLE `sgm_contratos_servicio` ADD `temps_resposta` int(11) NOT NULL default '0' AFTER `id_cobertura`;
ALTER TABLE `sgm_contratos_servicio` ADD `nbd` tinyint(1) NOT NULL default '1' AFTER `temps_resposta`;
ALTER TABLE `sgm_contratos_servicio` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `nbd`;
ALTER TABLE `sgm_contratos_servicio` ADD `extranet` tinyint(1) NOT NULL default '1' AFTER `visible`;
ALTER TABLE `sgm_contratos_servicio` ADD `obligatorio` tinyint(1) NOT NULL default '1' AFTER `extranet`;
ALTER TABLE `sgm_contratos_servicio` ADD `incidencias` tinyint(1) NOT NULL default '1' AFTER `obligatorio`;
ALTER TABLE `sgm_contratos_servicio` ADD `sla` int(11) NOT NULL default '0' AFTER `incidencias`;
ALTER TABLE `sgm_contratos_servicio` ADD `duracion` int(11) NOT NULL default '0' AFTER `sla`;
ALTER TABLE `sgm_contratos_servicio` ADD `precio_hora` decimal(11,3) NOT NULL default '0.000' AFTER `duracion`;
ALTER TABLE `sgm_contratos_servicio` ADD `codigo_catalogo` varchar(55) NOT NULL default '' AFTER `precio_hora`;
ALTER TABLE `sgm_contratos_servicio` ADD `auto_email` tinyint(1) NOT NULL default '0' AFTER `codigo_catalogo`;
ALTER TABLE `sgm_contratos_servicio` ADD `funcion` varchar(55) NOT NULL default '' AFTER `auto_email`;
ALTER TABLE `sgm_contratos_servicio` ADD `id_servicio_origen` int(11) NOT NULL default '0' AFTER `funcion`;
ALTER TABLE `sgm_contratos_servicio` ADD `prefijo_notificacion` varchar(55) NOT NULL default '' AFTER `id_servicio_origen`;
ALTER TABLE `sgm_contratos_servicio` ADD `horas` tinyint(1) NOT NULL default '0' AFTER `prefijo_notificacion`;
/*
INSERT INTO `sgm_contratos_servicio` VALUES (-1,0,'Instal&middot;laci&oacute; de Plataforma',0,0,0,1,0,0,0,0,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-2,0,'Manteniment Plataforma',0,0,0,1,0,0,0,0,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-3,0,'Monitoritzaci&oacute; Plataforma',1,0,0,1,1,0,0,0,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-4,0,'Gesti&oacute; d&#39;Incid&egrave;ncies',1,4,0,1,1,0,1,95,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-5,0,'Gesti&oacute; de Canvis',2,8,1,1,1,0,1,95,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-6,0,'Gesti&oacute; d&#39;Alertes',1,4,0,1,1,0,0,95,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-7,0,'Auditoria de servei i plataforma',2,8,1,1,1,0,1,95,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-8,0,'Servei de Consultoria',2,0,0,1,1,0,1,0,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-9,0,'Servei de Formaci&oacute;',2,8,1,1,1,0,1,95,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-10,0,'Servei de Backups',2,8,1,1,1,0,1,95,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-11,0,'Gesti&oacute; Comercial',2,8,1,1,1,1,1,95,0,0,'',0);
INSERT INTO `sgm_contratos_servicio` VALUES (-12,0,'Gesti&oacute; Administrativa',2,8,1,1,1,1,1,95,0,0,'',0);
*/

CREATE TABLE `sgm_contratos_servicio_notificacion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contratos_servicio_notificacion` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_contratos_servicio_notificacion` ADD `id_servicio` int(11) NOT NULL default '0' AFTER `id_contrato`;
ALTER TABLE `sgm_contratos_servicio_notificacion` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_servicio`;
ALTER TABLE `sgm_contratos_servicio_notificacion` ADD `id_usuario_origen` int(11) NOT NULL default '0' AFTER `id_usuario`;
ALTER TABLE `sgm_contratos_servicio_notificacion` ADD `tipo_edicion_todas` int(11) NOT NULL default '0' AFTER `id_usuario_origen`;
ALTER TABLE `sgm_contratos_servicio_notificacion` ADD `tipo_edicion_anadir` int(11) NOT NULL default '0' AFTER `tipo_edicion_todas`;
ALTER TABLE `sgm_contratos_servicio_notificacion` ADD `tipo_edicion_modificar` int(11) NOT NULL default '0' AFTER `tipo_edicion_anadir`;
ALTER TABLE `sgm_contratos_servicio_notificacion` ADD `tipo_edicion_cerrar` int(11) NOT NULL default '0' AFTER `tipo_edicion_modificar`;

CREATE TABLE `sgm_contratos_servicio_origen` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contratos_servicio_origen` ADD `codigo_origen` varchar(10) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_contratos_servicio_origen` ADD `descripcion_origen` varchar(55) NOT NULL default '' AFTER `codigo_origen`;
ALTER TABLE `sgm_contratos_servicio_origen` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion_origen`;

CREATE TABLE `sgm_contratos_sla_cobertura` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contratos_sla_cobertura` ADD `nombre` varchar(55) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_contratos_sla_cobertura` ADD `descripcion` longtext AFTER `nombre`;
ALTER TABLE `sgm_contratos_sla_cobertura` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;

CREATE TABLE `sgm_contratos_tipos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contratos_tipos` ADD `nombre` varchar(255) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_contratos_tipos` ADD `descripcion` longtext AFTER `nombre`;
ALTER TABLE `sgm_contratos_tipos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;

CREATE TABLE `sgm_contratos_usuarios` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_contratos_usuarios` ADD `id_contrato` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_contratos_usuarios` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_contrato`;

CREATE TABLE `sim_control_versiones` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_control_versiones` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `id`;
ALTER TABLE `sim_control_versiones` ADD `comentarios` longtext AFTER `fecha`;
ALTER TABLE `sim_control_versiones` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `comentarios`;
ALTER TABLE `sim_control_versiones` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sgm_cuerpo` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_cuerpo` ADD `id_origen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_cuerpo` ADD `linea` int(11) NOT NULL default '0' AFTER `id_origen`;
ALTER TABLE `sgm_cuerpo` ADD `id_cuerpo` int(11) NOT NULL default '0' AFTER `linea`;
ALTER TABLE `sgm_cuerpo` ADD `idfactura` int(11) NOT NULL default '0' AFTER `id_cuerpo`;
ALTER TABLE `sgm_cuerpo` ADD `id_estado` int(11) NOT NULL default '0' AFTER `idfactura`;
ALTER TABLE `sgm_cuerpo` ADD `fecha_prevision` date NOT NULL default '0000-00-00' AFTER `id_estado`;
ALTER TABLE `sgm_cuerpo` ADD `fecha_entrega` date NOT NULL default '0000-00-00' AFTER `fecha_prevision`;
ALTER TABLE `sgm_cuerpo` ADD `facturado` tinyint(1) NOT NULL default '0' AFTER `fecha_entrega`;
ALTER TABLE `sgm_cuerpo` ADD `id_facturado` int(11) NOT NULL default '0' AFTER `facturado`;
ALTER TABLE `sgm_cuerpo` ADD `codigo` varchar(20) NOT NULL default '' AFTER `id_facturado`;
ALTER TABLE `sgm_cuerpo` ADD `nombre` varchar(70) NOT NULL default '' AFTER `codigo`;
ALTER TABLE `sgm_cuerpo` ADD `pvd` decimal(11,3) NOT NULL default '0.000' AFTER `nombre`;
ALTER TABLE `sgm_cuerpo` ADD `pvp` decimal(11,3) NOT NULL default '0.000' AFTER `pvd`;
ALTER TABLE `sgm_cuerpo` ADD `unidades` decimal(11,3) NOT NULL default '0.000' AFTER `pvp`;
ALTER TABLE `sgm_cuerpo` ADD `descuento` decimal(11,3) NOT NULL default '0.000' AFTER `unidades`;
ALTER TABLE `sgm_cuerpo` ADD `descuento_absoluto` decimal(11,3) NOT NULL default '0.000' AFTER `descuento`;
ALTER TABLE `sgm_cuerpo` ADD `subtotaldescuento` decimal(11,3) NOT NULL default '0.000' AFTER `descuento_absoluto`;
ALTER TABLE `sgm_cuerpo` ADD `total` decimal(11,3) NOT NULL default '0.000' AFTER `subtotaldescuento`;
ALTER TABLE `sgm_cuerpo` ADD `notes` longtext AFTER `total`;
ALTER TABLE `sgm_cuerpo` ADD `bloqueado` tinyint(1) NOT NULL default '0' AFTER `notes`;
ALTER TABLE `sgm_cuerpo` ADD `id_article` int(11) NOT NULL default '0' AFTER `bloqueado`;
ALTER TABLE `sgm_cuerpo` ADD `stock` tinyint(1) NOT NULL default '0' AFTER `id_article`;
ALTER TABLE `sgm_cuerpo` ADD `prioridad` int(11) NOT NULL default '0' AFTER `stock`;
ALTER TABLE `sgm_cuerpo` ADD `controlcalidad` int(11) NOT NULL default '0' AFTER `prioridad`;
ALTER TABLE `sgm_cuerpo` ADD `id_tarifa` int(11) NOT NULL default '0' AFTER `controlcalidad` ;
ALTER TABLE `sgm_cuerpo` ADD `tarifa` decimal(11,3) NOT NULL default '0.000' AFTER `id_tarifa`;
ALTER TABLE `sgm_cuerpo` ADD `trz` int(11) NOT NULL default '0' AFTER `tarifa`;
ALTER TABLE `sgm_cuerpo` ADD `id_almacen` int(11) NOT NULL default '0' AFTER `trz`;
ALTER TABLE `sgm_cuerpo` ADD `vigente` tinyint(1) NOT NULL default '0' AFTER `id_almacen`;
ALTER TABLE `sgm_cuerpo` ADD `suma` tinyint(1) NOT NULL default '0' AFTER `vigente`;
ALTER TABLE `sgm_cuerpo` ADD `aprovat` tinyint(1) NOT NULL default '0' AFTER `suma`;
ALTER TABLE `sgm_cuerpo` ADD `fecha_prevision_propia` date NOT NULL default '0000-00-00' AFTER `aprovat`;

CREATE TABLE `sgm_dades_origen_factura` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_dades_origen_factura` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sgm_dades_origen_factura` ADD `nombre` varchar(255) default NULL AFTER `visible`;
ALTER TABLE `sgm_dades_origen_factura` ADD `nif` varchar(15) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sgm_dades_origen_factura` ADD `direccion` varchar(150) NOT NULL default '' AFTER `nif`;
ALTER TABLE `sgm_dades_origen_factura` ADD `poblacion` varchar(15) NOT NULL default '' AFTER `direccion`;
ALTER TABLE `sgm_dades_origen_factura` ADD `cp` varchar(5) NOT NULL default '' AFTER `poblacion`;
ALTER TABLE `sgm_dades_origen_factura` ADD `provincia` varchar(15) NOT NULL default '' AFTER `cp`;
ALTER TABLE `sgm_dades_origen_factura` ADD `mail` varchar(50) NOT NULL default '' AFTER `provincia`;
ALTER TABLE `sgm_dades_origen_factura` ADD `telefono` varchar(15) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sgm_dades_origen_factura` ADD `notas` longtext AFTER `telefono`;
ALTER TABLE `sgm_dades_origen_factura` ADD `logo1` varchar(50) NOT NULL default '' AFTER `notas`;
ALTER TABLE `sgm_dades_origen_factura` ADD `logo2` varchar(50) NOT NULL default '' AFTER `logo1`;
ALTER TABLE `sgm_dades_origen_factura` ADD `logo_ticket` varchar(50) NOT NULL default '' AFTER `logo2`;
ALTER TABLE `sgm_dades_origen_factura` ADD `logo_papel` varchar(50) NOT NULL default '' AFTER `logo_ticket`;
ALTER TABLE `sgm_dades_origen_factura` ADD `iva` decimal(11,3) NOT NULL default '0.000' AFTER `logo_papel`;

CREATE TABLE `sgm_dades_origen_factura_iban` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_dades_origen_factura_iban` ADD `id_dades_origen_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_dades_origen_factura_iban` ADD `entidad_bancaria` varchar(50) NOT NULL default '' AFTER `id_dades_origen_factura`;
ALTER TABLE `sgm_dades_origen_factura_iban` ADD `iban` varchar(50) NOT NULL default '' AFTER `entidad_bancaria`;
ALTER TABLE `sgm_dades_origen_factura_iban` ADD `descripcion` varchar(150) NOT NULL default '' AFTER `iban`;
ALTER TABLE `sgm_dades_origen_factura_iban` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `descripcion`;
ALTER TABLE `sgm_dades_origen_factura_iban` ADD `swift_bic` varchar(11) NOT NULL default '' AFTER `predefinido`;

CREATE TABLE `sgm_divisas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_divisas` ADD `divisa` varchar(255) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_divisas` ADD `abrev` varchar(3) NOT NULL default '' AFTER `divisa`;
ALTER TABLE `sgm_divisas` ADD `canvi` decimal(11,3) NOT NULL default '0.000' AFTER `abrev`;
ALTER TABLE `sgm_divisas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `canvi`;
ALTER TABLE `sgm_divisas` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sgm_divisas` ADD `simbolo` varchar(1) AFTER `predefinido`;

CREATE TABLE `sgm_divisas_canvis` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_divisas_canvis` ADD `id_divisa_origen` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sgm_divisas_canvis` ADD `id_divisa_destino` int(11) NOT NULL AFTER `id_divisa_origen`;
ALTER TABLE `sgm_divisas_canvis` ADD `canvi` decimal(11,4) NOT NULL default '0.0000' AFTER `id_divisa_destino`;
ALTER TABLE `sgm_divisas_canvis` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `canvi`;

CREATE TABLE `sgm_divisas_mod_canvi` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_divisas_mod_canvi` ADD `id_divisa_origen` int(11) NOT NULL AFTER `id`;
ALTER TABLE `sgm_divisas_mod_canvi` ADD `id_divisa_destino` int(11) NOT NULL AFTER `id_divisa_origen`;
ALTER TABLE `sgm_divisas_mod_canvi` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_divisa_destino`;
ALTER TABLE `sgm_divisas_mod_canvi` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `id_usuario`;
ALTER TABLE `sgm_divisas_mod_canvi` ADD `canvi` decimal(11,4) NOT NULL default '0.0000' AFTER `fecha`;

CREATE TABLE `sgm_factura_calendario` ( `id` int(11) NOT NULL AUTO_INCREMENT,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_calendario` ADD `fecha` int(15) NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `sgm_factura_calendario` ADD `gastos` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `fecha`;
ALTER TABLE `sgm_factura_calendario` ADD `pre_gastos` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `gastos`;
ALTER TABLE `sgm_factura_calendario` ADD `ingresos` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `pre_gastos`;
ALTER TABLE `sgm_factura_calendario` ADD `externos` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `ingresos`;
ALTER TABLE `sgm_factura_calendario` ADD `liquido` decimal(11,3) NOT NULL DEFAULT '0.000' AFTER `externos`;

CREATE TABLE `sgm_factura_canvi_data_entrega` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_canvi_data_entrega` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_factura_canvi_data_entrega` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sgm_factura_canvi_data_entrega` ADD `fecha_ant` date NOT NULL default '0000-00-00' AFTER `id_usuario`;
ALTER TABLE `sgm_factura_canvi_data_entrega` ADD `data` date NOT NULL default '0000-00-00' AFTER `fecha_ant`;

CREATE TABLE `sgm_factura_canvi_data_prevision` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_canvi_data_prevision` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_factura_canvi_data_prevision` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sgm_factura_canvi_data_prevision` ADD `fecha_ant` date NOT NULL default '0000-00-00' AFTER `id_usuario`;
ALTER TABLE `sgm_factura_canvi_data_prevision` ADD `data` date NOT NULL default '0000-00-00' AFTER `fecha_ant`;

CREATE TABLE `sgm_factura_canvi_data_prevision_cuerpo` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_canvi_data_prevision_cuerpo` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_factura_canvi_data_prevision_cuerpo` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sgm_factura_canvi_data_prevision_cuerpo` ADD `fecha_ant` date NOT NULL default '0000-00-00' AFTER `id_usuario`;
ALTER TABLE `sgm_factura_canvi_data_prevision_cuerpo` ADD `data` date NOT NULL default '0000-00-00' AFTER `fecha_ant`;
ALTER TABLE `sgm_factura_canvi_data_prevision_cuerpo` ADD `id_cuerpo` int(11) NOT NULL default '0' AFTER `data`;

CREATE TABLE `sgm_factura_modificacio` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_modificacio` ADD `id_factura` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_factura_modificacio` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sgm_factura_modificacio` ADD `fecha` int(25) NOT NULL default '0' AFTER `id_usuario`;

CREATE TABLE `sgm_factura_subtipos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_subtipos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sgm_factura_subtipos` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sgm_factura_subtipos` ADD `subtipo` varchar(50) default NULL AFTER `id_tipo`;
  
CREATE TABLE `sgm_factura_tipos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_tipos` ADD `orden` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_factura_tipos` ADD `tipo` varchar(150) NOT NULL default '' AFTER `orden`;
ALTER TABLE `sgm_factura_tipos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `tipo`;
ALTER TABLE `sgm_factura_tipos` ADD `descripcion` varchar(250) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sgm_factura_tipos` ADD `dias` int(11) NOT NULL default '0' AFTER `descripcion`;
ALTER TABLE `sgm_factura_tipos` ADD `facturable` tinyint(1) NOT NULL default '0' AFTER `dias`;
ALTER TABLE `sgm_factura_tipos` ADD `tpv` tinyint(1) NOT NULL DEFAULT '0' AFTER `facturable` ;
-- en el momento de seleccion destino, muestra un grupo o otro
ALTER TABLE `sgm_factura_tipos` ADD `filtro` tinyint(1) NOT NULL default '1' AFTER `tpv`;
ALTER TABLE `sgm_factura_tipos` ADD `cliente` tinyint(1) NOT NULL default '0' AFTER `filtro`;
ALTER TABLE `sgm_factura_tipos` ADD `proveedor` tinyint(1) NOT NULL default '0' AFTER `cliente`;
ALTER TABLE `sgm_factura_tipos` ADD `impacto` tinyint(1) NOT NULL default '0' AFTER `proveedor`;
-- ver la fecha de prevision
ALTER TABLE `sgm_factura_tipos` ADD `v_fecha_prevision` tinyint(1) NOT NULL default '0' AFTER `impacto`;
-- ver la fecha de vencimeinto
ALTER TABLE `sgm_factura_tipos` ADD `v_fecha_vencimiento` tinyint(1) NOT NULL default '0' AFTER `v_fecha_prevision`;
-- ver la referencia de pedido del cliente
ALTER TABLE `sgm_factura_tipos` ADD `v_numero_cliente` tinyint(1) NOT NULL default '0' AFTER `v_fecha_vencimiento`;
-- agrupacion de subtipos
ALTER TABLE `sgm_factura_tipos` ADD `v_subtipos` tinyint(1) NOT NULL default '0' AFTER `v_numero_cliente`;
-- ver el peso y los bultos 
ALTER TABLE `sgm_factura_tipos` ADD `v_pesobultos` tinyint(1) NOT NULL default '0' AFTER `v_subtipos`;
ALTER TABLE `sgm_factura_tipos` ADD `v_fecha_prevision_dias` int(11) NOT NULL default '0' AFTER `v_fecha_prevision` ;
ALTER TABLE `sgm_factura_tipos` ADD `v_recibos` tinyint(1) NOT NULL default '0' AFTER `v_pesobultos` ;
ALTER TABLE `sgm_factura_tipos` ADD `tipo_ot` tinyint(1) NOT NULL default '0' AFTER `v_recibos` ;
-- calculo de costes (presupuesto)
ALTER TABLE `sgm_factura_tipos` ADD `presu` tinyint(1) NOT NULL default '0' AFTER `tipo_ot`;
ALTER TABLE `sgm_factura_tipos` ADD `presu_dias` int(11) NOT NULL default '0' AFTER `presu` ;
ALTER TABLE `sgm_factura_tipos` ADD `stock` int(11) NOT NULL default '0' AFTER `presu_dias` ;
ALTER TABLE `sgm_factura_tipos` ADD `calidad` tinyint(1) NOT NULL default '0' AFTER `stock`;
ALTER TABLE `sgm_factura_tipos` ADD `caja` tinyint(1) NOT NULL default '0' AFTER `calidad`;
ALTER TABLE `sgm_factura_tipos` ADD `aprovado` tinyint(1) NOT NULL default '0' AFTER `caja`;
ALTER TABLE `sgm_factura_tipos` ADD `v_rfq` tinyint(1) NOT NULL default '0' AFTER `aprovado`;
ALTER TABLE `sgm_factura_tipos` ADD `contabilidad` int(11) NOT NULL default '0' AFTER `v_rfq`;

CREATE TABLE `sgm_factura_tipos_idiomas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_tipos_idiomas` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_factura_tipos_idiomas` ADD `id_idioma` int(11) NOT NULL default '0' AFTER `id_tipo`;
ALTER TABLE `sgm_factura_tipos_idiomas` ADD `tipo`  varchar(100) NOT NULL default '' AFTER `id_idioma`;

CREATE TABLE `sgm_factura_tipos_permisos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_tipos_permisos` ADD `id_user` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_factura_tipos_permisos` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `id_user`;
ALTER TABLE `sgm_factura_tipos_permisos` ADD `admin`  tinyint(1) NOT NULL default '0' AFTER `id_tipo`;

CREATE TABLE `sgm_factura_tipos_relaciones` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_factura_tipos_relaciones` ADD `id_tipo_o` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_factura_tipos_relaciones` ADD `id_tipo_d` int(11) NOT NULL default '0' AFTER `id_tipo_o`;
ALTER TABLE `sgm_factura_tipos_relaciones` ADD `cerrar` int(11) NOT NULL default '0' AFTER `id_tipo_d`;

CREATE TABLE `sgm_files` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_files` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sgm_files` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sgm_files` ADD `name` varchar(100) NOT NULL default '' AFTER `id_tipo`;
ALTER TABLE `sgm_files` ADD `type` varchar(20) NOT NULL default '' AFTER `name`;
ALTER TABLE `sgm_files` ADD `size` int(11) NOT NULL default '0' AFTER `type`;
ALTER TABLE `sgm_files` ADD `tipo_id_elemento` int(11) NOT NULL default '0' AFTER `size`;
ALTER TABLE `sgm_files` ADD `id_elemento` int(11) NOT NULL default '0' AFTER `tipo_id_elemento`;
/*tipo_id_elemento - 0=factura, 1=articulo, 2=cliente, 3=contrato, 4=incidencia, 5=dispositivo, 6=empleado;*/

CREATE TABLE `sgm_files_tipos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_files_tipos` ADD `nombre` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_files_tipos` ADD `limite_kb` int(11) NOT NULL default '0' AFTER `nombre`;
INSERT INTO `sgm_files_tipos` VALUES (1, 'Imagen', 250);
INSERT INTO `sgm_files_tipos` VALUES (2, 'Video', 5000);
INSERT INTO `sgm_files_tipos` VALUES (3, 'PDF', 1500);
INSERT INTO `sgm_files_tipos` VALUES (4, 'DOC', 250);
INSERT INTO `sgm_files_tipos` VALUES (5, 'DWG-Cad', 1500);
INSERT INTO `sgm_files_tipos` VALUES (6, 'Programa', 3500);

CREATE TABLE `sim_formato_documento` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_formato_documento` ADD `formato_documento` varchar(50) default NULL AFTER `id`;
ALTER TABLE `sim_formato_documento` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `formato_documento`;

CREATE TABLE `sgm_idiomas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_idiomas` ADD `idioma` varchar(2) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_idiomas` ADD `descripcion` varchar(15) NOT NULL default '' AFTER `idioma`;
ALTER TABLE `sgm_idiomas` ADD `imagen` varchar(15) NOT NULL default '' AFTER `descripcion`;
ALTER TABLE `sgm_idiomas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `imagen`;
ALTER TABLE `sgm_idiomas` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sgm_incidencias` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_incidencias` ADD `id_incidencia` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_incidencias` ADD `id_usuario_origen` int(11) NOT NULL default '0' AFTER `id_incidencia`;
ALTER TABLE `sgm_incidencias` ADD `id_usuario_registro` int(11) NOT NULL default '0' AFTER `id_usuario_origen`;
ALTER TABLE `sgm_incidencias` ADD `id_usuario_destino` int(11) NOT NULL default '0' AFTER `id_usuario_registro`;
ALTER TABLE `sgm_incidencias` ADD `id_usuario_finalizacion` int(11) NOT NULL default '0' AFTER `id_usuario_destino`;
ALTER TABLE `sgm_incidencias` ADD `fecha_prevision` int(15) NOT NULL default '0' AFTER `id_usuario_finalizacion`;
ALTER TABLE `sgm_incidencias` ADD `fecha_registro_inicio` int(15) NOT NULL default '0' AFTER `fecha_prevision`;
ALTER TABLE `sgm_incidencias` ADD `fecha_inicio` int(15) NOT NULL default '0' AFTER `fecha_registro_inicio`;
ALTER TABLE `sgm_incidencias` ADD `fecha_registro_cierre` int(15) NOT NULL default '0' AFTER `fecha_inicio`;
ALTER TABLE `sgm_incidencias` ADD `fecha_cierre` int(15) NOT NULL default '0' AFTER `fecha_registro_cierre`;
ALTER TABLE `sgm_incidencias` ADD `asunto` varchar(150) default NULL AFTER `fecha_cierre`;
ALTER TABLE `sgm_incidencias` ADD `notas_registro` longtext AFTER `asunto`;
ALTER TABLE `sgm_incidencias` ADD `notas_desarrollo` longtext AFTER `notas_registro`;
ALTER TABLE `sgm_incidencias` ADD `notas_conclusion` longtext AFTER `notas_desarrollo`;
ALTER TABLE `sgm_incidencias` ADD `id_estado` int(11) NOT NULL default '0' AFTER `notas_conclusion`;
ALTER TABLE `sgm_incidencias` ADD `id_entrada` int(11) NOT NULL default '0' AFTER `id_estado`;
ALTER TABLE `sgm_incidencias` ADD `id_servicio` int(11) NOT NULL default '0' AFTER `id_entrada`;
ALTER TABLE `sgm_incidencias` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id_servicio`;
ALTER TABLE `sgm_incidencias` ADD `duracion` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sgm_incidencias` ADD `sla` tinyint(1) NOT NULL default '0' AFTER `duracion` ;
ALTER TABLE `sgm_incidencias` ADD `visible_cliente` tinyint(1) NOT NULL default '1' AFTER `sla` ;
ALTER TABLE `sgm_incidencias` ADD `pausada` tinyint(1) NOT NULL default '0' AFTER `visible_cliente` ;
ALTER TABLE `sgm_incidencias` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `pausada` ;
ALTER TABLE `sgm_incidencias` ADD `temps_transcorregut` int(15) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sgm_incidencias` ADD `temps_pendent` int(15) NOT NULL default '0' AFTER `temps_transcorregut`;
ALTER TABLE `sgm_incidencias` ADD `correo` int(15) NOT NULL default '0' AFTER `temps_pendent`;
ALTER TABLE `sgm_incidencias` ADD `pausada_forzada` tinyint(1) NOT NULL default '0' AFTER `correo` ;
ALTER TABLE `sgm_incidencias` ADD `codigo_externo` varchar(50) default NULL AFTER `pausada_forzada`;
ALTER TABLE `sgm_incidencias` ADD `facturada` tinyint(1) NOT NULL default '0' AFTER `codigo_externo` ;
ALTER TABLE `sgm_incidencias` ADD `control_version` tinyint(1) NOT NULL default '0' AFTER `facturada` ;
ALTER TABLE `sgm_incidencias` ADD `nivel_tecnico` int(1) NOT NULL default '0' AFTER `control_version` ;
/*nivel_tecnico: 1, 2 o 3.*/
ALTER TABLE `sgm_incidencias` ADD `notificar_cliente` tinyint(1) NOT NULL default '1' AFTER `nivel_tecnico` ;
ALTER TABLE `sgm_incidencias` ADD `desplazamiento` tinyint(1) NOT NULL default '0' AFTER `notificar_cliente` ;

CREATE TABLE `sgm_incidencias_correos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_incidencias_correos` ADD `uid` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_incidencias_correos` ADD `destinatario` varchar(100) NOT NULL default '' AFTER `uid`;

CREATE TABLE `sgm_incidencias_correos_enviados` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_incidencias_correos_enviados` ADD `id_incidencia` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_incidencias_correos_enviados` ADD `destinatario` varchar(100) NOT NULL default '' AFTER `id_incidencia`;
ALTER TABLE `sgm_incidencias_correos_enviados` ADD `asunto` varchar(300) NOT NULL default '' AFTER `destinatario`;
ALTER TABLE `sgm_incidencias_correos_enviados` ADD `fecha` int(15) NOT NULL default '0' AFTER `asunto`;
ALTER TABLE `sgm_incidencias_correos_enviados` ADD `tipo` int(11) NOT NULL default '0' AFTER `fecha`;
ALTER TABLE `sgm_incidencias_correos_enviados` ADD `mensaje` longtext NOT NULL default '' AFTER `tipo`;

CREATE TABLE `sgm_incidencias_entrada` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_incidencias_entrada` ADD `entrada` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_incidencias_entrada` ADD `predeterminada` tinyint(1) NOT NULL default '0' AFTER `entrada`;
INSERT INTO `sgm_incidencias_entrada` VALUES (1, 'Teléfono',1);
INSERT INTO `sgm_incidencias_entrada` VALUES (2, 'Fax',0);
INSERT INTO `sgm_incidencias_entrada` VALUES (3, 'Mail',0);
INSERT INTO `sgm_incidencias_entrada` VALUES (4, 'Web',0);
INSERT INTO `sgm_incidencias_entrada` VALUES (5, 'Otra',0);

CREATE TABLE `sgm_incidencias_estados` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_incidencias_estados` ADD `estado` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_incidencias_estados` ADD `editable` tinyint(1) NOT NULL default '1' AFTER `estado`;
ALTER TABLE `sgm_incidencias_estados` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `editable`;

CREATE TABLE `sgm_inventario` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_inventario` ADD `nombre` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `nombre` ;
ALTER TABLE `sgm_inventario` ADD `id_client` int(11) NOT NULL default '0' AFTER `id_tipo` ;
ALTER TABLE `sgm_inventario` ADD `codigo` varchar(50) NOT NULL default '' AFTER `id_client`;
ALTER TABLE `sgm_inventario` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `codigo` ;
ALTER TABLE `sgm_inventario` ADD `num_serie` varchar(50) NOT NULL default '' AFTER `id_empleado` ;
ALTER TABLE `sgm_inventario` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `num_serie` ;

CREATE TABLE `sgm_inventario_actuacion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_inventario_actuacion` ADD `nombre` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario_actuacion` ADD `parada` tinyint(1) NOT NULL default '0' AFTER `nombre`;
ALTER TABLE `sgm_inventario_actuacion` ADD `duracion` int(11) NOT NULL default '0' AFTER `parada`;
ALTER TABLE `sgm_inventario_actuacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `duracion` ;

CREATE TABLE `sgm_inventario_actuacion_disp` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `id_actuacion` int(11) NOT NULL default '0' AFTER `id` ;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `id_dispositivo` int(11) NOT NULL default '0' AFTER `id_actuacion` ;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `id_user` int(11) NOT NULL default '0' AFTER `id_dispositivo` ;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `data_prevision` datetime default NULL AFTER `id_user`;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `data_finalizacion` datetime default NULL AFTER `data_prevision`;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `finalizada` tinyint(1) NOT NULL default '0' AFTER `data_finalizacion` ;
ALTER TABLE `sgm_inventario_actuacion_disp` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `finalizada` ;

CREATE TABLE `sgm_inventario_relacion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_inventario_relacion` ADD `id_disp1` int(11) NOT NULL default '0' AFTER `id` ;
ALTER TABLE `sgm_inventario_relacion` ADD `id_disp2` int(11) NOT NULL default '0' AFTER `id_disp1` ;
ALTER TABLE `sgm_inventario_relacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_disp2` ;

CREATE TABLE `sgm_inventario_tipo` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_inventario_tipo` ADD `tipo` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario_tipo` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `tipo` ;
ALTER TABLE `sgm_inventario_tipo` ADD `orden` int(11) NOT NULL default '0' AFTER `visible` ;
ALTER TABLE `sgm_inventario_tipo` ADD `codigo` int(4) NOT NULL default '0000' AFTER `orden` ;

CREATE TABLE `sgm_inventario_tipo_atributo` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_inventario_tipo_atributo` ADD `atributo` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario_tipo_atributo` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `atributo` ;
ALTER TABLE `sgm_inventario_tipo_atributo` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_tipo` ;

CREATE TABLE `sgm_inventario_tipo_atributo_dada` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_inventario_tipo_atributo_dada` ADD `dada` longtext NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_inventario_tipo_atributo_dada` ADD `id_atribut` int(11) NOT NULL default '0' AFTER `dada` ;
ALTER TABLE `sgm_inventario_tipo_atributo_dada` ADD `id_inventario` int(11) NOT NULL default '0' AFTER `id_atribut` ;
ALTER TABLE `sgm_inventario_tipo_atributo_dada` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_inventario` ;

CREATE TABLE `sim_licencias` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_licencias` ADD `id_cliente` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_licencias` ADD `id_cliente_final` int(11) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sim_licencias` ADD `fecha_ini` date NOT NULL default '0000-00-00' AFTER `id_cliente_final`;
ALTER TABLE `sim_licencias` ADD `fecha_fin` date NOT NULL default '0000-00-00' AFTER `fecha_ini`;
ALTER TABLE `sim_licencias` ADD `num_elementos` int(11) NOT NULL default '0' AFTER `fecha_fin`;
ALTER TABLE `sim_licencias` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `num_elementos`;
ALTER TABLE `sim_licencias` ADD `renovado` tinyint(1) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sim_licencias` ADD `facturado` tinyint(1) NOT NULL default '0' AFTER `renovado`;
ALTER TABLE `sim_licencias` ADD `id_producto` int(11) NOT NULL default '0' AFTER `facturado`;
ALTER TABLE `sim_licencias` ADD `num_poller` int(11) NOT NULL default '0' AFTER `id_producto`;
ALTER TABLE `sim_licencias` ADD `num_peer` int(11) NOT NULL default '0' AFTER `num_poller`;

CREATE TABLE `sim_licencias_articulos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_licencias_articulos` ADD `id_licencia` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_licencias_articulos` ADD `id_articulo` int(11) NOT NULL default '0' AFTER `id_licencia`;
ALTER TABLE `sim_licencias_articulos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_articulo`;

CREATE TABLE `sim_licencias_familias_articulos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_licencias_familias_articulos` ADD `id_familia` int(11) NOT NULL default '0' AFTER `id`;

CREATE TABLE `sim_licencias_productos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_licencias_productos` ADD `producto` varchar(100) default NULL AFTER `id`;
ALTER TABLE `sim_licencias_productos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `producto`;

CREATE TABLE `sim_medio_comunicacion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_medio_comunicacion` ADD `medio_comunicacion` varchar(50) default NULL AFTER `id`;
ALTER TABLE `sim_medio_comunicacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `medio_comunicacion`;

CREATE TABLE `sim_paises` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_paises` ADD `pais` varchar(50) default NULL AFTER `id`;
ALTER TABLE `sim_paises` ADD `siglas` char(3) default NULL AFTER `pais`;
ALTER TABLE `sim_paises` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `siglas`;
ALTER TABLE `sim_paises` ADD `predefinido` tinyint(1) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sim_provincias` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_provincias` ADD `provincia` varchar(30) DEFAULT NULL AFTER `id`;
ALTER TABLE `sim_provincias` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `provincia`;
INSERT INTO `sim_provincias` (`id`,`provincia`,`visible`) VALUES (2,'Albacete',1),(3,'Alicante/Alacant',1),(4,'Almería',1),(1,'Araba/Álava',1),(33,'Asturias',1),(5,'Ávila',1),(6,'Badajoz',1),(7,'Balears, Illes',1),(8,'Barcelona',1),(48,'Bizkaia',1),(9,'Burgos',1),(10,'Cáceres',1),(11,'Cádiz',1),(39,'Cantabria',1),(12,'Castellón/Castelló',1),(51,'Ceuta',1),(13,'Ciudad Real',1),(14,'Córdoba',1),(15,'Coruña, A',1),(16,'Cuenca',1),(20,'Gipuzkoa',1),(17,'Girona',1),(18,'Granada',1),(19,'Guadalajara',1),(21,'Huelva',1),(22,'Huesca',1),(23,'Jaén',1),(24,'León',1),(27,'Lugo',1),(25,'Lleida',1),(28,'Madrid',1),(29,'Málaga',1),(52,'Melilla',1),(30,'Murcia',1),(31,'Navarra',1),(32,'Ourense',1),(34,'Palencia',1),(35,'Palmas, Las',1),(36,'Pontevedra',1),(26,'Rioja, La',1),(37,'Salamanca',1),(38,'Santa Cruz de Tenerife',1),(40,'Segovia',1),(41,'Sevilla',1),(42,'Soria',1),(43,'Tarragona',1),(44,'Teruel',1),(45,'Toledo',1),(46,'Valencia/València',1),(47,'Valladolid',1),(49,'Zamora',1),(50,'Zaragoza',1);

CREATE TABLE `sgm_recibos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_recibos` ADD `numero` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_recibos` ADD `id_factura` int(11) NOT NULL default '0' AFTER `numero`;
ALTER TABLE `sgm_recibos` ADD `numero_serie` int(11) NOT NULL default '0' AFTER `id_factura`;
ALTER TABLE `sgm_recibos` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `numero_serie`;
ALTER TABLE `sgm_recibos` ADD `fecha_vencimiento` date NOT NULL default '0000-00-00' AFTER `fecha`;
ALTER TABLE `sgm_recibos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `fecha_vencimiento`;
ALTER TABLE `sgm_recibos` ADD `nombre` varchar(255) default NULL AFTER `visible`;
ALTER TABLE `sgm_recibos` ADD `nif` varchar(15) default NULL AFTER `nombre`;
ALTER TABLE `sgm_recibos` ADD `direccion` varchar(150) default NULL AFTER `nif`;
ALTER TABLE `sgm_recibos` ADD `poblacion` varchar(50) default NULL AFTER `direccion`;
ALTER TABLE `sgm_recibos` ADD `cp` varchar(5) default NULL AFTER `poblacion`;
ALTER TABLE `sgm_recibos` ADD `provincia` varchar(15) default NULL AFTER `cp`;
ALTER TABLE `sgm_recibos` ADD `onombre` varchar(255) default NULL AFTER `provincia`;
ALTER TABLE `sgm_recibos` ADD `onif` varchar(15) default NULL AFTER `onombre`;
ALTER TABLE `sgm_recibos` ADD `odireccion` varchar(150) default NULL AFTER `onif`;
ALTER TABLE `sgm_recibos` ADD `opoblacion` varchar(50) default NULL AFTER `odireccion`;
ALTER TABLE `sgm_recibos` ADD `ocp` varchar(5) default NULL AFTER `opoblacion`;
ALTER TABLE `sgm_recibos` ADD `oprovincia` varchar(15) default NULL AFTER `ocp`;
ALTER TABLE `sgm_recibos` ADD `entidad_bancaria` varchar(50) default NULL AFTER `oprovincia`;
ALTER TABLE `sgm_recibos` ADD `numero_cuenta` varchar(20) default NULL AFTER `entidad_bancaria`;
ALTER TABLE `sgm_recibos` ADD `total` decimal(11,3) NOT NULL default '0.000' AFTER `numero_cuenta`;
ALTER TABLE `sgm_recibos` ADD `id_cliente` int(5) NOT NULL default '0' AFTER `total`;
ALTER TABLE `sgm_recibos` ADD `id_user` int(5) NOT NULL default '0' AFTER `id_cliente`;
ALTER TABLE `sgm_recibos` ADD `id_tipo_pago` int(11) NOT NULL default '0' AFTER `id_user`;
ALTER TABLE `sgm_recibos` ADD `cobrada` tinyint(1) NOT NULL default '0' AFTER `id_tipo_pago`;

CREATE TABLE `sim_regiones` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_regiones` ADD `region` varchar(30) DEFAULT NULL AFTER `id`;
ALTER TABLE `sim_regiones` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `region`;

CREATE TABLE `sgm_rrhh_departamento` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_departamento` ADD `id_departamento` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_rrhh_departamento` ADD `departamento` varchar(255) default NULL AFTER `id_departamento`;
ALTER TABLE `sgm_rrhh_departamento` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `departamento`;

CREATE TABLE `sgm_rrhh_empleado` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_empleado` ADD `nombre` varchar(255) default NULL AFTER `id`;
ALTER TABLE `sgm_rrhh_empleado` ADD `fecha_incor` date NOT NULL default '0000-00-00' AFTER `nombre`;
ALTER TABLE `sgm_rrhh_empleado` ADD `fecha_baja` date NOT NULL default '0000-00-00' AFTER `fecha_incor`;
ALTER TABLE `sgm_rrhh_empleado` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `fecha_baja`;
ALTER TABLE `sgm_rrhh_empleado` ADD `codigo` int(15) NOT NULL default '0' AFTER `visible`;
ALTER TABLE `sgm_rrhh_empleado` ADD `nif` varchar(15) NOT NULL default '' AFTER `codigo`;
ALTER TABLE `sgm_rrhh_empleado` ADD `direccion` varchar(255) NOT NULL default '' AFTER `nif`;
ALTER TABLE `sgm_rrhh_empleado` ADD `poblacion` varchar(50) NOT NULL default '' AFTER `direccion`;
ALTER TABLE `sgm_rrhh_empleado` ADD `cp` varchar(5) NOT NULL default '' AFTER `poblacion`;
ALTER TABLE `sgm_rrhh_empleado` ADD `provincia` varchar(15) NOT NULL default '' AFTER `cp`;
ALTER TABLE `sgm_rrhh_empleado` ADD `id_pais` int(11) NOT NULL default '0' AFTER `provincia`;
ALTER TABLE `sgm_rrhh_empleado` ADD `telefono` varchar(15) NOT NULL default '' AFTER `id_pais`;
ALTER TABLE `sgm_rrhh_empleado` ADD `telefono2` varchar(15) NOT NULL default '' AFTER `telefono`;
ALTER TABLE `sgm_rrhh_empleado` ADD `mail` varchar(50) NOT NULL default '' AFTER `telefono2`;
ALTER TABLE `sgm_rrhh_empleado` ADD `notas` longtext AFTER `mail`;
ALTER TABLE `sgm_rrhh_empleado` ADD `cuentabancaria` varchar(30) default NULL AFTER `notas`;
ALTER TABLE `sgm_rrhh_empleado` ADD `entidadbancaria` varchar(100) NOT NULL default '' AFTER `cuentabancaria`;
ALTER TABLE `sgm_rrhh_empleado` ADD `domiciliobancario` varchar(255) NOT NULL default '' AFTER `entidadbancaria`;
ALTER TABLE `sgm_rrhh_empleado` ADD `id_usuario` int(11) NOT NULL default '0' AFTER `domiciliobancario`;
ALTER TABLE `sgm_rrhh_empleado` ADD `num_ins_segsoc` varchar(25) NOT NULL default '' AFTER `id_usuario`;
ALTER TABLE `sgm_rrhh_empleado` ADD `num_afil_segsoc` varchar(25) NOT NULL default '' AFTER `num_ins_segsoc`;

CREATE TABLE `sgm_rrhh_empleado_calendario` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_empleado_calendario` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_rrhh_empleado_calendario` ADD `data_ini` int(20) NOT NULL default '0' AFTER `id_empleado`;
ALTER TABLE `sgm_rrhh_empleado_calendario` ADD `data_fi` int(20) NOT NULL default '0' AFTER `data_ini`;
ALTER TABLE `sgm_rrhh_empleado_calendario` ADD `total_dias` int(20) NOT NULL default '0' AFTER `data_fi`;
ALTER TABLE `sgm_rrhh_empleado_calendario` ADD `motivo` varchar(255) NOT NULL default '' AFTER `total_dias`;
ALTER TABLE `sgm_rrhh_empleado_calendario` ADD `vacaciones` tinyint(1) NOT NULL default '0' AFTER `motivo`;
ALTER TABLE `sgm_rrhh_empleado_calendario` ADD `remunerado` tinyint(1) NOT NULL default '0' AFTER `vacaciones`;

CREATE TABLE `sgm_rrhh_empleado_horario` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `data_ini` date NOT NULL default '0000-00-00' AFTER `id_empleado`;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `data_fi` date NOT NULL default '0000-00-00' AFTER `data_ini`;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `hora_ini` varchar(11) NOT NULL default '00:00' AFTER `data_fi` ;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `hora_fi` varchar(11) NOT NULL default '00:00' AFTER `hora_ini` ;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `hora_ini2` varchar(11) NOT NULL default '00:00' AFTER `hora_fi` ;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `hora_fi2` varchar(11) NOT NULL default '00:00' AFTER `hora_ini2` ;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `hora_fi2`;
ALTER TABLE `sgm_rrhh_empleado_horario` ADD `dia_setmana` int(11) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sgm_rrhh_empleado_nominas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_empleado_nominas` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_rrhh_empleado_nominas` ADD `total` decimal(11,2) NOT NULL default '0.00' AFTER `id_empleado`;
ALTER TABLE `sgm_rrhh_empleado_nominas` ADD `data_ini` int(20) NOT NULL default '0' AFTER `id_empleado`;
ALTER TABLE `sgm_rrhh_empleado_nominas` ADD `data_fi` int(20) NOT NULL default '0' AFTER `data_ini`;

CREATE TABLE `sgm_rrhh_empleado_puesto` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_empleado_puesto` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_rrhh_empleado_puesto` ADD `id_puesto` int(11) NOT NULL default '0' AFTER `id_empleado`;
ALTER TABLE `sgm_rrhh_empleado_puesto` ADD `fecha_alta` date NOT NULL default '0000-00-00' AFTER `id_puesto`;
ALTER TABLE `sgm_rrhh_empleado_puesto` ADD `fecha_baja` date NOT NULL default '0000-00-00' AFTER `fecha_alta`;
ALTER TABLE `sgm_rrhh_empleado_puesto` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `fecha_baja`;

CREATE TABLE `sgm_rrhh_formacion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_formacion` ADD `numero` varchar(15) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sgm_rrhh_formacion` ADD `nombre` varchar(255) default NULL AFTER `numero`;
ALTER TABLE `sgm_rrhh_formacion` ADD `tipo` tinyint(1) NOT NULL default '1' AFTER `nombre`;
ALTER TABLE `sgm_rrhh_formacion` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `tipo`;
ALTER TABLE `sgm_rrhh_formacion` ADD `fecha_inicio` date NOT NULL default '0000-00-00' AFTER `fecha`;
ALTER TABLE `sgm_rrhh_formacion` ADD `fecha_fin` date NOT NULL default '0000-00-00' AFTER `fecha_inicio`;
ALTER TABLE `sgm_rrhh_formacion` ADD `impartidor` varchar(255) default NULL AFTER `fecha_fin`;
ALTER TABLE `sgm_rrhh_formacion` ADD `duracion` tinyint(11) NOT NULL default '1' AFTER `impartidor`;
ALTER TABLE `sgm_rrhh_formacion` ADD `observaciones` longtext NOT NULL AFTER `duracion`;
ALTER TABLE `sgm_rrhh_formacion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `observaciones`;
ALTER TABLE `sgm_rrhh_formacion` ADD `temario` longtext NOT NULL AFTER `visible`;
ALTER TABLE `sgm_rrhh_formacion` ADD `id_plan` int(11) NOT NULL default '0' AFTER `temario`;
ALTER TABLE `sgm_rrhh_formacion` ADD `planificado` tinyint(1) NOT NULL default '0' AFTER `id_plan`;
ALTER TABLE `sgm_rrhh_formacion` ADD `realizado` tinyint(1) NOT NULL default '0' AFTER `planificado`;
ALTER TABLE `sgm_rrhh_formacion` ADD `coste` varchar(15) NOT NULL default '0' AFTER `realizado`;

CREATE TABLE `sgm_rrhh_formacion_empleado` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_formacion_empleado` ADD `id_empleado` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_rrhh_formacion_empleado` ADD `id_curso` int(11) NOT NULL default '0' AFTER `id_empleado`;
ALTER TABLE `sgm_rrhh_formacion_empleado` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id_curso`;

CREATE TABLE `sgm_rrhh_formacion_plan` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_formacion_plan` ADD `nombre` varchar(50) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_rrhh_formacion_plan` ADD `necesidades` longtext NOT NULL AFTER `nombre`;
ALTER TABLE `sgm_rrhh_formacion_plan` ADD `objetivos` longtext NOT NULL AFTER `necesidades`;
ALTER TABLE `sgm_rrhh_formacion_plan` ADD `metodos` longtext NOT NULL AFTER `objetivos`;
ALTER TABLE `sgm_rrhh_formacion_plan` ADD `resultados` longtext NOT NULL AFTER `metodos`;
ALTER TABLE `sgm_rrhh_formacion_plan` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `resultados`;

CREATE TABLE `sgm_rrhh_jornada_anual` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_jornada_anual` ADD `num_horas_any` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_rrhh_jornada_anual` ADD `num_dias_vac` int(11) NOT NULL default '0' AFTER `num_horas_any`;
ALTER TABLE `sgm_rrhh_jornada_anual` ADD `num_dias_lib` int(11) NOT NULL default '0' AFTER `num_dias_vac`;


CREATE TABLE `sgm_rrhh_puesto_trabajo` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `puesto` varchar(255) default NULL AFTER `id`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `id_departamento` int(11) NOT NULL default '0' AFTER `puesto`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `tareas` longtext NOT NULL AFTER `id_departamento`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `f_general` longtext NOT NULL AFTER `tareas`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `f_especifica` longtext NOT NULL AFTER `f_general`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `experiencia` longtext NOT NULL AFTER `f_especifica`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `habilidades` longtext NOT NULL AFTER `experiencia`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `habilidades`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `activo` tinyint(1) NOT NULL default '1' AFTER `visible`;
ALTER TABLE `sgm_rrhh_puesto_trabajo` ADD `numero` int(15) NOT NULL default '0' AFTER `visible`;

CREATE TABLE `sgm_stock` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_stock` ADD `id_article` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_stock` ADD `id_almacen` int(11) NOT NULL default '0' AFTER `id_article`;
ALTER TABLE `sgm_stock` ADD `unidades` decimal(11,2) NOT NULL default '0.00' AFTER `id_almacen`;
ALTER TABLE `sgm_stock` ADD `id_cabezera` int(11) NOT NULL default '0' AFTER `unidades`;
ALTER TABLE `sgm_stock` ADD `entrada` tinyint(1) NOT NULL default '1' AFTER `id_cabezera`;
ALTER TABLE `sgm_stock` ADD `web` tinyint(1) NOT NULL default '0' AFTER `entrada`;
ALTER TABLE `sgm_stock` ADD `fecha` date NOT NULL default '0000-00-00' AFTER `web`;
ALTER TABLE `sgm_stock` ADD `id_user` int(11) NOT NULL default '0' AFTER `fecha`;
ALTER TABLE `sgm_stock` ADD `pvp` decimal(10,3) NOT NULL default '0.000' AFTER `id_user`;
ALTER TABLE `sgm_stock` ADD `pvd` decimal(10,3) NOT NULL default '0.000' AFTER `pvp`;
ALTER TABLE `sgm_stock` ADD `vigente` tinyint(1) NOT NULL default '0' AFTER `pvd`;
ALTER TABLE `sgm_stock` ADD `id_compte_entradas` int(11) NOT NULL default '0' AFTER `vigente` ;
ALTER TABLE `sgm_stock` ADD `id_divisa_pvp` int(11) NOT NULL default '0' AFTER `id_compte_entradas` ;
ALTER TABLE `sgm_stock` ADD `id_divisa_pvd` int(11) NOT NULL default '0' AFTER `id_divisa_pvp` ;
ALTER TABLE `sgm_stock` ADD `descuento` decimal(10,2) NOT NULL default '0.00' AFTER `id_divisa_pvd`;

CREATE TABLE `sgm_stock_almacenes` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_stock_almacenes` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sgm_stock_almacenes` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sgm_stock_almacenes` ADD `direccion` varchar(50) NOT NULL default '' AFTER `nombre`;
ALTER TABLE `sgm_stock_almacenes` ADD `poblacion` varchar(30) NOT NULL default '' AFTER `direccion`;
ALTER TABLE `sgm_stock_almacenes` ADD `cp` varchar(5) NOT NULL default '' AFTER `poblacion`;
ALTER TABLE `sgm_stock_almacenes` ADD `provincia` varchar(15) NOT NULL default '' AFTER `cp`;
ALTER TABLE `sgm_stock_almacenes` ADD `mail` varchar(50) NOT NULL default '' AFTER `provincia`;
ALTER TABLE `sgm_stock_almacenes` ADD `telefono` varchar(15) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sgm_stock_almacenes` ADD `notas` longtext AFTER `telefono`;

CREATE TABLE `sgm_stock_almacenes_pasillo` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_stock_almacenes_pasillo` ADD `id_almacen` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_stock_almacenes_pasillo` ADD `orden` int(11) NOT NULL default '0' AFTER `id_almacen`;
ALTER TABLE `sgm_stock_almacenes_pasillo` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `orden`;
ALTER TABLE `sgm_stock_almacenes_pasillo` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;

CREATE TABLE `sgm_stock_almacenes_pasillo_estanteria` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria` ADD `id_pasillo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria` ADD `orden` int(11) NOT NULL default '0' AFTER `id_pasillo`;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `orden`;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;

CREATE TABLE `sgm_stock_almacenes_pasillo_estanteria_seccion` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria_seccion` ADD `id_estanteria` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria_seccion` ADD `orden` int(11) NOT NULL default '0' AFTER `id_estanteria`;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria_seccion` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `orden`;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria_seccion` ADD `nombre` varchar(255) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sgm_stock_almacenes_pasillo_estanteria_seccion` ADD `porcentage` int(11) NOT NULL default '0' AFTER `nombre`;

CREATE TABLE `sgm_tarifas` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_tarifas` ADD `nombre` varchar(255) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_tarifas` ADD `porcentage` decimal(10,2) NOT NULL default '0.00' AFTER `nombre`;
ALTER TABLE `sgm_tarifas` ADD `descuento` tinyint(1) NOT NULL default '1' AFTER `porcentage`;
ALTER TABLE `sgm_tarifas` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descuento`;
  
CREATE TABLE `sgm_tpv_tipos_pago` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_tpv_tipos_pago` ADD `tipo` varchar(150) NOT NULL default '' AFTER `id`;
INSERT INTO `sgm_tpv_tipos_pago` VALUES (1, 'Efectivo');
INSERT INTO `sgm_tpv_tipos_pago` VALUES (2, 'Tarjeta');
INSERT INTO `sgm_tpv_tipos_pago` VALUES (3, 'Cheque');
INSERT INTO `sgm_tpv_tipos_pago` VALUES (4, 'Domiciliaci&oacute;n');
INSERT INTO `sgm_tpv_tipos_pago` VALUES (5, 'Transferencia');

CREATE TABLE `sgm_users` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_users` ADD `validado` tinyint(1) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_users` ADD `activo` tinyint(1) NOT NULL default '1' AFTER `validado`;
ALTER TABLE `sgm_users` ADD `public` tinyint(1) NOT NULL default '0' AFTER `activo`;
ALTER TABLE `sgm_users` ADD `usuario` varchar(30) NOT NULL default '' AFTER `public`;
ALTER TABLE `sgm_users` ADD `pass` varchar(30) NOT NULL default '' AFTER `usuario`;
ALTER TABLE `sgm_users` ADD `url` varchar(150) NOT NULL default '' AFTER `pass`;
ALTER TABLE `sgm_users` ADD `mail` varchar(50) NOT NULL default '' AFTER `url`;
ALTER TABLE `sgm_users` ADD `msn` varchar(50) NOT NULL default '' AFTER `mail`;
ALTER TABLE `sgm_users` ADD `icq` varchar(15) NOT NULL default '' AFTER `msn`;
ALTER TABLE `sgm_users` ADD `datejoin` date default NULL AFTER `icq`;
ALTER TABLE `sgm_users` ADD `dateborn` date default NULL AFTER `datejoin`;
ALTER TABLE `sgm_users` ADD `country` varchar(10) NOT NULL default '' AFTER `dateborn`;
ALTER TABLE `sgm_users` ADD `sgm` tinyint(1) NOT NULL default '0' AFTER `country`;
ALTER TABLE `sgm_users` ADD `sgm_remoto` tinyint(1) NOT NULL default '0' AFTER `sgm`;
ALTER TABLE `sgm_users` ADD `id_origen` int(11) NOT NULL default '0' AFTER `sgm_remoto`;
ALTER TABLE `sgm_users` ADD `firma` tinyint(1) NOT NULL default '0' AFTER `id_origen`;
ALTER TABLE `sgm_users` ADD `textfirma` longtext NOT NULL AFTER `firma`;
ALTER TABLE `sgm_users` ADD `id_tipus` int(11) NOT NULL default '0' AFTER `textfirma`;
INSERT INTO `sgm_users` (`id`, `validado`, `activo`, `usuario`, `pass`, `mail`, `sgm`, `id_origen`, `id_tipus`) VALUES (1, '1', '1', 'admin', 'admin', 'administracion@solucions-im.com', '1', '0','0');

CREATE TABLE `sgm_users_clients` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_users_clients` ADD `id_user` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_users_clients` ADD `id_client` int(11) NOT NULL default '0' AFTER `id_user`;
ALTER TABLE `sgm_users_clients` ADD `id_modulo` int(11) NOT NULL default '0' AFTER `id_client`;
ALTER TABLE `sgm_users_clients` ADD `admin` tinyint(1) NOT NULL default '0' AFTER `id_modulo`;

CREATE TABLE `sgm_users_permisos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_users_permisos` ADD `id_user` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_users_permisos` ADD `id_tipus` int(11) NOT NULL default '0' AFTER `id_user`;
ALTER TABLE `sgm_users_permisos` ADD `id_modulo` int(11) NOT NULL default '0' AFTER `id_tipus`;
ALTER TABLE `sgm_users_permisos` ADD `admin` tinyint(1) NOT NULL default '0' AFTER `id_modulo`;
INSERT INTO `sgm_users_permisos` VALUES (1, '1', '0', '1002', '1');
INSERT INTO `sgm_users_permisos` VALUES (2, '1', '0', '1022', '1');

CREATE TABLE `sgm_users_permisos_modulos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_users_permisos_modulos` ADD `id_modulo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sgm_users_permisos_modulos` ADD `nombre_es` varchar(30) NOT NULL default '' AFTER `id_modulo`;
ALTER TABLE `sgm_users_permisos_modulos` ADD `nombre_cat` varchar(30) NOT NULL default '' AFTER `nombre_es`;
ALTER TABLE `sgm_users_permisos_modulos` ADD `descripcion` varchar(130) NOT NULL default '' AFTER `nombre_cat`;
ALTER TABLE `sgm_users_permisos_modulos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `descripcion`;
ALTER TABLE `sgm_users_permisos_modulos` ADD `id_grupo` int(11) NOT NULL default '0' AFTER `visible` ;
INSERT INTO `sgm_users_permisos_modulos` VALUES (1, 1001, 'Contenidos','', 'Permite crear noticias, articulos i sus grupos.', 0, 5);
INSERT INTO `sgm_users_permisos_modulos` VALUES (2, 1002, 'Usuarios','', 'Permite conceder permisos y modificar usuarios.', 1, 5);
INSERT INTO `sgm_users_permisos_modulos` VALUES (3, 1003, 'Facturaci&oacute;n','', 'M&oacute;dulo para la gesti&oacute;n de facturaci&oacute;n y contabilidad', 0, 3);
INSERT INTO `sgm_users_permisos_modulos` VALUES (4, 1004, 'Art&iacute;culos','', 'Gesti&oacute;n de articulos y marcas de fabricantes.', 0, 6);
INSERT INTO `sgm_users_permisos_modulos` VALUES (5, 1005, 'Inventario','', 'Gesti&oacute;n del inventario que dispone cada cliente.', 0, 3);
INSERT INTO `sgm_users_permisos_modulos` VALUES (6, 1006, 'Tareas','', 'Gesti&oacute;n de las agenas y tareas', 0, 4);
INSERT INTO `sgm_users_permisos_modulos` VALUES (7, 1007, 'Pedidos','', 'Formulario de solucitud de material.', 0, 3);
INSERT INTO `sgm_users_permisos_modulos` VALUES (8, 1008, 'Contactos','', 'Gesti&oacute;n de clientes y todos sus datos.', 0, 1);
INSERT INTO `sgm_users_permisos_modulos` VALUES (9, 1009, 'Comercial','', 'Para la gesti&oacute;n de posibles clientes y su seguimiento', 0, 1);
INSERT INTO `sgm_users_permisos_modulos` VALUES (10, 1010, 'Compras','', 'Gesti&oacute;n de proveedores y pedidos', 0, 3);
INSERT INTO `sgm_users_permisos_modulos` VALUES (11, 1011, 'Contratos','', 'Gesti&oacute;n de contratos de servicios', 0, 3);
INSERT INTO `sgm_users_permisos_modulos` VALUES (12, 1012, 'Mailing','', 'Gesti&oacute; de e-mails masivos.', 0, 3);
INSERT INTO `sgm_users_permisos_modulos` VALUES (13, 1013, 'Inventario Incid.','', 'Gesti&oacute;n de incidencias técnicas en los registros de inventario.', 0, 1);
INSERT INTO `sgm_users_permisos_modulos` VALUES (14, 1014, 'Producci&oacute;n','', 'Control del proceso de producci&oacute;n y control de calidad.', 0, 6);
INSERT INTO `sgm_users_permisos_modulos` VALUES (15, 1015, 'Calidad','', 'Gesti&oacute;n del control de calidad para normativa ISO', 0, 6);
INSERT INTO `sgm_users_permisos_modulos` VALUES (16, 1016, 'Producci&oacute;n','', 'Gesti&oacute;n de OT, FT, etc', 0, 6);
INSERT INTO `sgm_users_permisos_modulos` VALUES (17, 1017, 'Tareas','', 'Gesti&oacute;n de las agendas y tareas', 0, 4);
INSERT INTO `sgm_users_permisos_modulos` VALUES (18, 1018, 'Incidencias','', 'Gesti&oacute; de incidencias', 0, 6);
INSERT INTO `sgm_users_permisos_modulos` VALUES (19, 1019, 'Contabilidad','', 'Contabilidad', 0, 0);
INSERT INTO `sgm_users_permisos_modulos` VALUES (20, 1020, 'RRHH','', 'Curriculums y ofertas de empleo', 0, 2);
INSERT INTO `sgm_users_permisos_modulos` VALUES (21, 1021, 'TPV','', 'Terminal Punto de Venta', 0, 3);
INSERT INTO `sgm_users_permisos_modulos` VALUES (22, 1022, 'Sistema','', 'Acceso a la configuraci&oacute;n del programa MGestion', 1, 5);
INSERT INTO `sgm_users_permisos_modulos` VALUES (23, 1023, 'Auxiliares','', 'Gesti&oacute;n de la Tablas Auxiliares de los M&oacute;dulos', 0, 5);
INSERT INTO `sgm_users_permisos_modulos` VALUES (24, 1024, 'Contrase&ntilde;as','', 'Gesti&oacute;n de contrase&ntilde;as de apliciones', 0, 6);
INSERT INTO `sgm_users_permisos_modulos` VALUES (25, 1025, 'Monitorizaci&oacute;n','', 'Gesti&oacute;n Monitorizaci&oacute;n', 0, 6);
INSERT INTO `sgm_users_permisos_modulos` VALUES (26, 1026, 'Licencias','', 'Gesti&oacute;n de licencias de productos', 0, 3);
INSERT INTO `sgm_users_permisos_modulos` VALUES (1001, 2001, 'Estado Servidor','', 'Permite conocer el estador del servidor o servidores del cliente', 0, 7);
INSERT INTO `sgm_users_permisos_modulos` VALUES (1002, 2002, 'Reports','', 'Permite descargar los reports del cliente', 0, 7);
INSERT INTO `sgm_users_permisos_modulos` VALUES (1003, 2003, 'Documentos','', 'Permite descargar los documentos asociados al cliente', 0, 7);

CREATE TABLE `sgm_users_permisos_modulos_grupos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_users_permisos_modulos_grupos` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `id`;
ALTER TABLE `sgm_users_permisos_modulos_grupos` ADD `nombre_es` varchar(30) NOT NULL default '' AFTER `visible`;
ALTER TABLE `sgm_users_permisos_modulos_grupos` ADD `nombre_cat` varchar(30) NOT NULL default '' AFTER `nombre_es`;
INSERT INTO `sgm_users_permisos_modulos_grupos` VALUES (1,1,'Gesti&oacute;n Comercial','');
INSERT INTO `sgm_users_permisos_modulos_grupos` VALUES (2,1,'Gesti&oacute;n Direcci&oacute;n','');
INSERT INTO `sgm_users_permisos_modulos_grupos` VALUES (3,1,'Gesti&oacute;n Administrativa','');
INSERT INTO `sgm_users_permisos_modulos_grupos` VALUES (4,1,'Agenda','');
INSERT INTO `sgm_users_permisos_modulos_grupos` VALUES (5,1,'Administraci&oacute;n','');
INSERT INTO `sgm_users_permisos_modulos_grupos` VALUES (6,1,'Producci&oacute;n','');

CREATE TABLE `sgm_users_tipus` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sgm_users_tipus` ADD `tipus` varchar(30) NOT NULL default '' AFTER `id`;
ALTER TABLE `sgm_users_tipus` ADD `visible` tinyint(1) NOT NULL default '1' AFTER `tipus`;

CREATE TABLE `sim_usuarios_tipos_departamentos` ( `id` int(11) NOT NULL auto_increment,    PRIMARY KEY  (`id`)) ENGINE=MyISAM;
ALTER TABLE `sim_usuarios_tipos_departamentos` ADD `id_tipo` int(11) NOT NULL default '0' AFTER `id`;
ALTER TABLE `sim_usuarios_tipos_departamentos` ADD `id_departamento` int(11) NOT NULL default '0' AFTER `id_tipo`;
