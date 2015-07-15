<?php



$idbhost = "192.168.1.8:/Nemesis/empresas/ALVAREZ.2008/empresa.fdb";
$idbuname = "INVITADO";
$idbpass = "nemesis";
$idbname = "NEMESIS";


### conexio interbase
$idb = ibase_connect($idbhost, $idbuname, $idbpass) or die("Couldn't connect to interbase on $idbhost");

	######## TRASPASA CLIENTES
	$x = 0;
	$sql = "select * from CLIENTES";
	$result = ibase_query($idb,$sql);
	while ($row = ibase_fetch_object($result)) {
		$sqlx = "select count(*) as total from sgm_clients where codcliente='".$row->CODCLIENTE."'";
		$resultx = mysql_query(convert_sql($sqlx));
		$rowx = mysql_fetch_array($resultx);
		if ($rowx["total"] == 0) {
			$sql = "insert into sgm_clients (nombre,nif,direccion,poblacion,cp,provincia,mail,telefono,telefono2,fax,web,codcliente)";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($row->RAZONSOCIAL)."'";
			$sql = $sql.",'".comillas($row->DNINIF)."'";
			$sql = $sql.",'".comillas($row->VIAPUBLICA)."".comillas($row->NUMERO)."".comillas($row->ESCALERA)."".comillas($row->PISO)."".comillas($row->PUERTA)."'";
			$sql = $sql.",'".comillas($row->LOCALIDAD)."'";
			$sql = $sql.",'".comillas($row->CODPOSTAL)."'";
			$sql = $sql.",'".comillas($row->PROVINCIA)."'";
			$sql = $sql.",'".comillas($row->CORREOELEC)."'";
			$sql = $sql.",'".comillas($row->TELEFONO1)."'";
			$sql = $sql.",'".comillas($row->TELEFONO2)."'";
			$sql = $sql.",'".comillas($row->FAX)."'";
			$sql = $sql.",'".comillas($row->WEB)."'";
			$sql = $sql.",'".comillas($row->CODCLIENTE)."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
			$x++;
		}
	}
	echo "<br><strong>Se han traspasado ".$x." registros CLIENTES.</strong>";


	######## TRASPASA ARTICULOS
	$x = 0;
	$sql = "select * from ARTIGEN";
	$result = ibase_query($idb,$sql);
	while ($row = ibase_fetch_object($result)) {
		$sqlx = "select count(*) as total from sgm_articles where codigo2='".$row->CODARTICULO."'";
		$resultx = mysql_query(convert_sql($sqlx));
		$rowx = mysql_fetch_array($resultx);
		if ($rowx["total"] == 0) {
			$sql = "insert into sgm_articles (id_subgrupo,id_marca,codigo2,nombre,codigoext,subctacompras,subctaventas,codigo)";
			$sql = $sql."values (";
			$sql = $sql."1";
			$sql = $sql.",1";
			$sql = $sql.",'".comillas($row->CODARTICULO)."'";
			$sql = $sql.",'".comillas($row->DESCARTICULO)."'";
			$sql = $sql.",'".comillas($row->CODEXTERNO)."'";
			$sql = $sql.",'".comillas($row->SUBCTACOMPRAS)."'";
			$sql = $sql.",'".comillas($row->SUBCTAVENTAS)."'";
				$sqlgc = "select * from sgm_articles where codigo<>'' order by codigo desc";
				$resultgc = mysql_query(convert_sql($sqlgc));
				$rowgc = mysql_fetch_array($resultgc);
				$codigo = $rowgc["codigo"]+1;
				if ($codigo > 99999) { $codigo = $codigo; }
				if (($codigo < 100000) and ($codigo > 9999)) { $codigo = "0".$codigo; }
				if (($codigo < 10000) and ($codigo > 999)) { $codigo = "00".$codigo; }
				if (($codigo < 1000) and ($codigo > 99)) { $codigo = "000".$codigo; }
				if (($codigo < 100) and ($codigo > 9)) { $codigo = "0000".$codigo; }
				if ($codigo < 10) { $codigo = "00000".$codigo; }
			$sql = $sql.",'".$codigo."')";
			mysql_query(convert_sql($sql));
#			echo "<br>".$sql;
			$x++;
		}
	}
	echo "<br><strong>Se han traspasado ".$x." registros ARTICULOS.</strong>";


#	$sql = "select * from CLIEPEDIDO";
#	$result = ibase_query($idb,$sql);
#	while ($row = ibase_fetch_object($result)) {
#		$sqlx = "select count(*) as total from sgm_articles where codigo2='".$row->CODARTICULO."'";
#		$resultx = mysql_query(convert_sql($sqlx));
#		$rowx = mysql_fetch_array($resultx);
#		if ($rowx["total"] == 0) {
#			$sql = "insert into sgm_articles (id_subgrupo,id_marca,codigo2,nombre,codigoext,subctacompras,subctaventas,codigo)";
#			$sql = $sql."values (";
#			$sql = $sql."1";
#			$sql = $sql.",1";
#			$sql = $sql.",'".comillas($row->ALBARAN)."'";
#			$sql = $sql.",'".comillas($row->CODIGOCLIENTE)."'";
#			$sql = $sql.",'".comillas($row->FECHA)."'";
#			$sql = $sql.",'".comillas($row->FECHAENVIO)."'";
#			$sql = $sql.",'".comillas($row->SUBCTAVENTAS)."'";
#			$sql = $sql.",'".$codigo."')";
#			mysql_query(convert_sql($sql));
#			echo "<br>".$sql;
#		}
#	}

?>