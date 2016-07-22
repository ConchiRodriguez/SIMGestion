<?php

include ("../config.php");
foreach (glob("../auxiliar/*.php") as $filename)
{
    include ($filename);
}

$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

	$sqld = "select * from sgm_clients";
	$resultd = mysqli_query($dbhandle,$sqld);
	while ($rowd = mysqli_fetch_array($resultd)){
		$sql = "select * from sim_clientes where visible=".$rowd["visible"]." and nombre='".$rowd["nombre"]."'";
		$result = mysqli_query($dbhandle,$sql);
		$row = mysqli_fetch_array($result);
		if (!$row){
			$camposInsert = "id,id_origen,id_agrupacion,visible,nombre,apellido1,apellido2,tipo_identificador,nif,direccion,poblacion,cp,provincia,id_pais,tipo_persona,tipo_residencia,dir3_oficina_contable,dir3_organo_gestor,dir3_unidad_tramitadora,mail,telefono,telefono2,fax,alias,id_idioma,cliente_fid,cliente_vip,dias_vencimiento,dias,dia_mes_vencimiento,cuenta_contable,entidad_bancaria,domicilio_bancario,cuenta_bancaria";
			$datosInsert = array($rowd["id"],$rowd["id_origen"],$rowd["id_agrupacion"],$rowd["visible"],comillas($rowd["nombre"]),comillas($rowd["apellido1"]),comillas($rowd["apellido2"]),$rowd["tipo_identificador"],$rowd["nif"],$rowd["direccion"],$rowd["poblacion"],$rowd["cp"],$rowd["provincia"],$rowd["id_pais"],$rowd["tipo_persona"],$rowd["tipo_residencia"],$rowd["dir3_oficina_contable"],$rowd["dir3_organo_gestor"],$rowd["dir3_unidad_tramitadora"],$rowd["mail"],$rowd["telefono"],$rowd["telefono2"],$rowd["fax"],$rowd["alias"],$rowd["id_idioma"],$rowd["client"],$rowd["clientvip"],$rowd["dias_vencimiento"],$rowd["dias"],$rowd["dia_mes_vencimiento"],$rowd["cuentacontable"],$rowd["entidadbancaria"],$rowd["domiciliobancario"],$rowd["cuentabancaria"]);
			insertFunction ("sim_clientes",$camposInsert,$datosInsert);
		}
	}


	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo"<tr>";
			echo "<td style=\"vertical-align:top;\">";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						$sqld = "select * from sgm_clients";
						$resultd = mysqli_query($dbhandle,$sqld);
						while ($rowd = mysqli_fetch_array($resultd)){
							echo "<tr><td style=\"white-space:nowrap;\">".$rowd["id"]." - ".$rowd["nombre"]."</td></tr>";
						}
				echo "</table>";
			echo "</td>";
			echo "<td style=\"vertical-align:top;\">";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						$sqld = "select * from sim_clientes";
						$resultd = mysqli_query($dbhandle,$sqld);
						while ($rowd = mysqli_fetch_array($resultd)){
							echo "<tr><td style=\"white-space:nowrap;\">".$rowd["id"]." - ".$rowd["nombre"]."</td></tr>";
						}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
 
?>