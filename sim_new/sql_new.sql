
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
ALTER TABLE `sim_clientes_busquedas` ADD `tipos` varchar(50) NOT NULL default '' AFTER `letras` ;
ALTER TABLE `sim_clientes_busquedas` ADD `sectores` varchar(50) NOT NULL default '' AFTER `tipos`;
ALTER TABLE `sim_clientes_busquedas` ADD `origenes` varchar(50) NOT NULL default '' AFTER `sectors` ;
ALTER TABLE `sim_clientes_busquedas` ADD `paises` varchar(50) NOT NULL default '' AFTER `origenes`;
ALTER TABLE `sim_clientes_busquedas` ADD `comunidades` varchar(50) NOT NULL default '' AFTER `paises`;
ALTER TABLE `sim_clientes_busquedas` ADD `provincias` varchar(50) NOT NULL default '' AFTER `comunidades`;
ALTER TABLE `sim_clientes_busquedas` ADD `regiones` varchar(50) NOT NULL default '' AFTER `provincias` ;
ALTER TABLE `sim_clientes_busquedas` ADD `likenombre` varchar(20) default NULL AFTER `regiones`;

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
