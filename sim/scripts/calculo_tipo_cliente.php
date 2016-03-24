<?php

include ("../config.php");
foreach (glob("../auxiliar/*.php") as $filename)
{
    include ($filename);
}

$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

	$sqld = "select * from sim_clientes_tipos where visible=1";
	$resultd = mysqli_query($dbhandle,$sqld);
	while ($rowd = mysqli_fetch_array($resultd)){
		echo $rowd["nombre"];
		$sql = "select * from sim_clientes where visible=1";
		$result = mysqli_query($dbhandle,$sql);
		while ($row = mysqli_fetch_array($result)){
			$apto = 1;
			if ($rowd["factura"] == 1){
				$sqlf = "select * from sgm_cabezera where  visible=1 and id_cliente=".$row["id"];
				if ($rowd["id_tipo_factura"] > 0) { $sqlf .= " and tipo=".$rowd["id_tipo_factura"];}
				$resultf = mysqli_query($dbhandle,$sqlf);
				$rowf = mysqli_fetch_array($resultf);
				echo $sqlf."- fact<br>";
				if (!$rowf){ $apto = 0; }
				echo $apto."- fact1<br>";
			} elseif ($rowd["factura"] == 0){
				$sqlf = "select * from sgm_cabezera where visible=1 and id_cliente=".$row["id"];
				$resultf = mysqli_query($dbhandle,$sqlf);
				$rowf = mysqli_fetch_array($resultf);
				echo $sqlf."- fact<br>";
				if ($rowf){ $apto = 0; }
				echo $apto."- fact0<br>";
			}
			if ($rowd["contrato"] == 1){
				$sqlc = "select * from sgm_contratos where visible=1 and id_cliente=".$row["id"];
				if ($rowd["contrato_activo"] > 0) { $sqlc .= " and activo=1";}
				$resultc = mysqli_query($dbhandle,$sqlc);
				$rowc = mysqli_fetch_array($resultc);
				if (!$rowc){ $apto = 0; }
				echo $apto."- contract1<br>";
			} elseif ($rowd["contrato"] == 0){
				$sqlc = "select * from sgm_contratos where visible=1 and id_cliente=".$row["id"];
				$resultc = mysqli_query($dbhandle,$sqlc);
				$rowc = mysqli_fetch_array($resultc);
				if ($rowc){ $apto = 0; }
				echo $apto."- contract0<br>";
			}
			if ($rowd["datos_fiscales"] == 1){
				if (($row["tipo_identificador"] == 2) or ($row["tipo_identificador"] == 3)) { $check_nif = 1;} else { $check_nif = valida_nif_cif_nie($row["nif"]);}
				if (($check_nif <= 0) OR ($row["nombre"] == "") OR ($row["direccion"] == "") OR ($row["cp"] == "") OR ($row["poblacion"] == "") OR ($row["provincia"] == "")) { 
					$apto = 0;
				}
				echo $apto."- fiscal1<br>";
			} elseif ($rowd["datos_fiscales"] == 0){
				if (($row["tipo_identificador"] == 2) or ($row["tipo_identificador"] == 3)) { $check_nif = 1;} else { $check_nif = valida_nif_cif_nie($row["nif"]);}
				if (($check_nif > 0) and ($row["nombre"] != "") and ($row["direccion"] != "") and ($row["cp"] != "") and ($row["poblacion"] != "") and ($row["provincia"] != "")) { 
					$apto = 0;
				}
				echo $apto."- fiscal0<br>";
			}
			echo $apto." -- <br>";
			if ($apto == 1){
				$sqlr = "select * from sim_clientes_rel_tipos where id_cliente=".$row["id"];
				$resultr = mysqli_query($dbhandle,$sqlr);
				$rowr = mysqli_fetch_array($resultr);
				if (!$rowr){
					$camposInsert = "id_tipo,id_cliente";
					$datosInsert = array($rowd["id"],$row["id"]);
					insertFunction ("sim_clientes_rel_tipos",$camposInsert,$datosInsert);
				} else {
					$camposUpdate = array('id_tipo','id_cliente');
					$datosUpdate = array($rowd["id"],$row["id"]);
					updateFunction("sim_clientes_rel_tipos",$rowr["id"],$camposUpdate,$datosUpdate);
				}
			}
			if ($apto == 0){
				$sqlr = "select * from sim_clientes_rel_tipos where id_cliente=".$row["id"]." and id_tipo=".$rowd["id"];
				$resultr = mysqli_query($dbhandle,$sqlr);
				$rowr = mysqli_fetch_array($resultr);
				if ($rowr){
					deleteFunction("sim_clientes_rel_tipos",$rowr["id"]);
				}
			}
		}
	}


	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo"<tr>";
			echo "<td style=\"vertical-align:top;\">";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						$sql = "select * from sim_clientes_rel_tipos";
						$result = mysqli_query($dbhandle,$sql);
						while ($row = mysqli_fetch_array($result)){
							$sqld = "select * from sim_clientes where id=".$row["id_cliente"];
							$resultd = mysqli_query($dbhandle,$sqld);
							$rowd = mysqli_fetch_array($resultd);
							$sqlt = "select * from sim_clientes_tipos where id=".$row["id_tipo"];
							$resultt = mysqli_query($dbhandle,$sqlt);
							$rowt = mysqli_fetch_array($resultt);
							echo "<tr><td style=\"white-space:nowrap;\">".$rowd["nombre"]." - ".$rowt["nombre"]."</td></tr>";
						}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
 
?>