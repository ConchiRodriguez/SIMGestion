<?php
#	if ($_GET['op'] != "") { $option = $_GET['op']; } else { $option = 0; }

	if ($option == 100) { include ("mgestion/registrarse.php");}
	if ($option == 200) { include ("mgestion/panel-usuario.php");}

	if ($option == 1001) { include ("mgestion/gestion-contenidos.php");}
	if ($option == 1002) { include ("mgestion/gestion-usuarios.php");}
	if ($option == 1003) { include ("mgestion/gestion-facturacion.php");}
	if ($option == 1004) { include ("mgestion/gestion-articulos.php");}
	if ($option == 1005) { include ("mgestion/gestion-inventario.php");}
	if ($option == 1006) { include ("mgestion/gestion-agenda.php");}
	if ($option == 1007) { include ("mgestion/gestion-pedidos.php");}
	if ($option == 1008) { include ("mgestion/gestion-clientes.php");}
	if ($option == 1009) { include ("mgestion/gestion-comercial-3.0.php");}

	if ($option == 1010) { include ("mgestion/gestion-compras.php");}
	if ($option == 1011) { include ("mgestion/gestion-contratos.php");}
	if ($option == 1012) { include ("mgestion/gestion-mailing.php");}
	if ($option == 1013) { include ("mgestion/gestion-proyectos.php");}
	if ($option == 1014) { include ("mgestion/gestion-control_produccion.php");}
	if ($option == 1015) { include ("mgestion/gestion-control_calidad.php");}
	if ($option == 1016) { include ("mgestion/gestion-control-produccion-3.0.php");}
	if ($option == 1017) { include ("mgestion/gestion-agenda-3.0.php");}
	if ($option == 1018) { include ("mgestion/gestion-incidencias.php");}
	if ($option == 1019) { include ("mgestion/contabilidad.php");}

	if ($option == 1020) { include ("mgestion/gestion-rrhh.php");}
	if ($option == 1021) { include ("mgestion/gestion-tpv.php");}
	if ($option == 1022) { include ("mgestion/gestion-sistema.php");}
	if ($option == 1023) { include ("mgestion/gestion-auxiliares.php");}
	if ($option == 1024) { include ("mgestion/gestion-contrasenyas.php");}
	if ($option == 1025) { include ("mgestion/gestion-monitorizacion.php");}
	if ($option == 1026) { include ("mgestion/gestion-licencias.php");}

	if ($option == 1030) { include ("mgestion/gestion-club.php");}

?>
