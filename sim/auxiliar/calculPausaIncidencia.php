<?php
error_reporting(~E_ALL);


function calculPausaIncidencia ($id_incidencia, $id_nota_incidencia,$data_nota_incidencia){
	global $db,$dbhandle;
	
	$pausada = 0;

	$sql = "select id_usuario_registro,pausada,id from sgm_incidencias where id_incidencia=".$id_incidencia." and visible=1 order by fecha_inicio";
	$result = mysql_query($sql);
	while ($row = mysqli_fetch_array($result)){
		if ($row["id_usuario_registro"] > 0) {
			$sqlu = "select id from sgm_users where id=".$row["id_usuario_registro"]." and validado=1 and activo=1 and sgm=1";
			$resultu = mysql_query($sqlu);
			$rowu = mysqli_fetch_array($resultu);
			if (($rowu) and ($row["pausada"] == 1)){
				$pausada = 1;
			} elseif (($rowu) and ($row["pausada"] == 0)) {
				$pausada = 0;
			} else {
				$pausada = $pausada;
			}
		}
		$sql = "update sgm_incidencias set ";
		$sql = $sql."pausada=".$pausada;
		$sql = $sql." WHERE id=".$row["id"]."";
		mysqli_query($dbhandle,convertSQL($sql));
#		echo $sql."<br>";
#		echo date("Y-m-d H:i:s", $row["fecha_inicio"])."--".$pausada."<br>";
	}
	$sql1 = "update sgm_incidencias set ";
	$sql1 = $sql1."pausada=".$pausada;
	$sql1 = $sql1." WHERE id=".$id_incidencia."";
	mysqli_query($dbhandle,convertSQL($sql1));
#	echo $sql1."<br>";
}	
	
?>