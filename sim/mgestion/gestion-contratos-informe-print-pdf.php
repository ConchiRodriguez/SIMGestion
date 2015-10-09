<?php 
error_reporting(E_ALL);

	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$idioma = strtolower($_POST["idioma"]);
	include ("../../archivos_comunes/factura-print-".$idioma.".php");

	define("FPDF_FONTPATH","../../archivos_comunes/font/");
	require('fpdf.php');

class PDF extends FPDF
{
	function Header()
	{
		$sqlele = "select * from sgm_dades_origen_factura";
		$resultele = mysql_query(convert_sql($sqlele));
		$rowele = mysql_fetch_array($resultele);

		$this->Image('../../archivos_comunes/images/logo1.jpg',10,5,80,18);
		$this->SetFont('Calibri','',8);
		$this->SetXY(100,5);
		$this->Cell(90,3,"".$rowele["nombre"],0,1);
		$this->SetXY(100,8);
		$this->Cell(90,3,"".$rowele["nif"],0,1);
		$this->SetXY(100,11);
		$this->Cell(90,3,$rowele["direccion"],0,1);
		$this->SetXY(100,14);
		$this->Cell(90,3,$rowele["poblacion"]." (".$rowele["cp"].") ".$rowele["provincia"],0,1);
		$this->SetXY(100,17);
		$this->Cell(90,3, "Teléfono: ".$rowele["telefono"],0,1);
		$this->SetXY(100,20);
		$this->Cell(90,3, "E-mail: ".$rowele["mail"],0,1);
		$this->SetXY(100,23);
		$this->Cell(90,3,"",0,1);
		$this->SetXY(10,30);
	}

	function Footer()
	{
		global $texto_pdatos;
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Calibri','',6);
		// Número de página
		$this->MultiCell(180,3,$texto_pdatos,0,1);
	}

	function NbLines($w,$txt){
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0){
			$w=$this->w-$this->rMargin-$this->x;
		}
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n"){
			$nb--;
		}
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' '){
				$sep=$i;
			}
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j){
						$i++;
					}
				} else {
					$i=$sep+1;
				}
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			} else {
				$i++;
			}
		}
		return $nl;
	}

	function informe_print($id_cliente, $id_contrato){
		global $cobertura,$meses,$abierta,$pausada,$incidencias_pendientes,$total,$numero,$fecha_ini,$fecha_fin,$nombre,$nif,$direccion,$poblacion,$cp,$provincia,$descripcion,$responsable_cliente,$responsable_tecnico,$texto_pdatos,$abiertas,$cerradas,$pendientes,$pausadas,$fuera_sla,$pocentaje_sla,$tiempo,$total_contrato,$asunto,$estado;
		//Creación del objeto de la clase heredada

		$sqlcli = "select * from sgm_clients where id=".$id_cliente;
#		echo $sqlcli."<br>";
		$resultcli = mysql_query(convert_sql($sqlcli));
		$rowcli = mysql_fetch_array($resultcli);

		$sqlcon = "select * from sgm_contratos where visible=1 and id=".$id_contrato;
		$resultcon = mysql_query(convert_sql($sqlcon));
#		echo $sqlcon."<br>";
		$rowcon = mysql_fetch_array($resultcon);

		$this->SetFont('Calibri','B',10);
		$this->Cell(90,5,"Cliente",0,0);
		$this->Cell(90,5,"Contrato",0,1);
		$this->SetFont('Calibri','',8);
		$this->Cell(90,3,$nombre." : ".comillasInver($rowcli["nombre"]),0,0);
		$this->Cell(90,3,$numero." : ".$rowcon["num_contrato"],0,1);

		$this->Cell(90,3,$nif." / CIF: ".$rowcli["nif"],0,0);
		$this->Cell(90,3,$descripcion." : ".comillasInver($rowcon["descripcion"]),0,1);

		$this->Cell(90,3,$direccion." : ".comillasInver($rowcli["direccion"]),0,0);
		$this->Cell(90,3,$fecha_ini." : ".cambiarFormatoFechaDMY($rowcon["fecha_ini"]),0,1);

		$this->Cell(90,3,$poblacion.": ".comillasInver($rowcli["poblacion"]),0,0);
		$this->Cell(90,3,$fecha_fin." : ".cambiarFormatoFechaDMY($rowcon["fecha_fin"]),0,1);

		$sqlx = "select * from sgm_users where id=".$rowcon["id_responsable"];
		$resultx = mysql_query(convert_sql($sqlx));
		$rowx = mysql_fetch_array($resultx);

		$sqly = "select * from sgm_users where id=".$rowcon["id_tecnico"];
		$resulty = mysql_query(convert_sql($sqly));
		$rowy = mysql_fetch_array($resulty);

		$this->Cell(90,3,$cp." : ".$rowcli["cp"],0,0);
		$this->Cell(90,3,$responsable_cliente." : ".comillasInver($rowx["usuario"]),0,1);

		$this->Cell(90,3,$provincia.": ".comillasInver($rowcli["provincia"]),0,0);
		$this->Cell(90,3,$responsable_tecnico." : ".comillasInver($rowy["usuario"]),0,1);

		$this->Cell(90,6,"",0,1);

		list($mes,$any) = explode ("-",$_POST["fecha"]);
		if ($_POST["fecha_hasta"] > 0){ list($mes_fins,$any_fins) = explode ("-",$_POST["fecha_hasta"]); }
		else {list($mes_fins,$any_fins) = explode ("-",$_POST["fecha"]);}
		$mes_ini = date("U", mktime(0,0,0,$mes,1,$any));
		$mes_fin = date("U", mktime(0,0,0,$mes_fins,1,$any_fins));
		$mes_act = $mes_ini;

		while (($mes_act>=$mes_ini) and ($mes_act<=$mes_fin)){
			if ($_POST["horas"] == 1){ $ample = 40; } else { $ample = 60; }
			$any_inicio = date("Y",$mes_act);
			$mes_inicio = date("n",$mes_act);
			$dia_inicio = date("d",$mes_act);
			$mes_seg = date("U",mktime(0,0,0,$mes_inicio+1,1,$any_inicio));

			$this->SetFont('Calibri','B',8);
			$this->Cell(180,5,$meses[$mes_inicio-1]." ".$any_inicio,0,1);
			$this->SetFont('Calibri','',6);
			$this->Cell($ample,5,"",'LTBR',0,0);
			$this->Cell(20,5,"".$cobertura."",'LTBR',0);
			$this->Cell(17,5,"".$abiertas."",'LTBR',0);
			$this->Cell(17,5,"".$cerradas."",'TBR',0);
			$this->Cell(17,5,"".$pendientes."",'TBR',0);
			$this->Cell(17,5,"".$pausadas."",'TBR',0);
			$this->Cell(17,5,"".$fuera_sla."",'TBR',0);
			if ($_POST["horas"] == 1){
				$this->Cell(20,5,"".$pocentaje_sla."",'TBR',0);
				$this->Cell(15,5,"".$tiempo."",'TBR',1);
			} else {
				$this->Cell(25,5,"".$pocentaje_sla."",'TBR',1);
			}

			$open = 0;
			$close = 0;
			$pendin = 0;
			$stoped = 0;
			$outSLA = 0;
			$time = 0;

			$sqlcs = "select * from sgm_contratos_servicio where id_contrato=".$rowcon["id"]." and visible=1 order by servicio";
			$resultcs = mysql_query(convert_sql($sqlcs));
			while ($rowcs = mysql_fetch_array($resultcs)) {
				$sqli1 = "select count(*) as abiertas from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1";
				$sqli1 = $sqli1." and (fecha_inicio between ".$mes_act." and ".$mes_seg." or id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and fecha_inicio between ".$mes_act." and ".$mes_seg." and visible=1))";
#				echo $sqli1."<br>";
				$resulti1 = mysql_query(convert_sql($sqli1));
				$rowi1 = mysql_fetch_array($resulti1);
				$open =$open + $rowi1["abiertas"];
				$sqli2 = "select count(*) as cerradas from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1 and id_estado=-2";
				$sqli2 = $sqli2." and (fecha_inicio between ".$mes_act." and ".$mes_seg." or id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and fecha_inicio between ".$mes_act." and ".$mes_seg." and visible=1))";
				$resulti2 = mysql_query(convert_sql($sqli2));
				$rowi2 = mysql_fetch_array($resulti2);
				$close =$close + $rowi2["cerradas"];
				$sqli3 = "select count(*) as pendientes from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1 and id_estado<>-2 and pausada=0";
				$sqli3 = $sqli3." and (fecha_inicio between ".$mes_act." and ".$mes_seg." or id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and fecha_inicio between ".$mes_act." and ".$mes_seg." and visible=1))";
				$resulti3 = mysql_query(convert_sql($sqli3));
				$rowi3 = mysql_fetch_array($resulti3);
				$pendin =$pendin + $rowi3["pendientes"];
				$sqli4 = "select count(*) as pausadas from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1 and id_estado<>-2 and pausada=1";
				$sqli4 = $sqli4." and (fecha_inicio between ".$mes_act." and ".$mes_seg." or id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and fecha_inicio between ".$mes_act." and ".$mes_seg." and visible=1))";
				$resulti4 = mysql_query(convert_sql($sqli4));
				$rowi4 = mysql_fetch_array($resulti4);
				$stoped =$stoped + $rowi4["pausadas"];
				$sqli5 = "select count(*) as fora_sla from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1 and id_estado=-2 and sla=1";
				$sqli5 = $sqli5." and (fecha_inicio between ".$mes_act." and ".$mes_seg." or id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and fecha_inicio between ".$mes_act." and ".$mes_seg." and visible=1))";
				$resulti5 = mysql_query(convert_sql($sqli5));
				$rowi5 = mysql_fetch_array($resulti5);
				if ($rowcs["sla"] == 0){
					$fora_sla = "--";
				} else {
					$fora_sla = $rowi5["fora_sla"];
					$outSLA =$outSLA + $rowi5["fora_sla"];
				}

				if ($_POST["horas"] == 1){
					$sqli6 = "select sum(duracion) as temps from sgm_incidencias where visible=1 and fecha_inicio between ".$mes_act." and ".$mes_seg." and id_incidencia in (select id from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1)";
#echo $sqli6;
					$resulti6 = mysql_query(convert_sql($sqli6));
					$rowi6 = mysql_fetch_array($resulti6);
					$time =$time + $rowi6["temps"];
					$hora = $rowi6["temps"]/60;
					$horas = explode(".",$hora);
					$minuto = ($hora - $horas[0])*60;
					$minutos = explode(".",$minuto);
				}

				if ($rowcs["sla"] == 0){
					$porcentageSLA = "--";
				} else {
					$porcentageSLA = number_format(((100*($rowi1["abiertas"]-$fora_sla))/$rowi1["abiertas"]),2, ',', '.');
					if ($porcentageSLA > 0){
						$porcentageSLA = $porcentageSLA;
					} else {
						$porcentageSLA = "--";
					}
				}

				$sqlcsc = "select * from sgm_contratos_sla_cobertura where visible=1 and id=".$rowcs["id_cobertura"];
				$resultcsc = mysql_query(convert_sql($sqlcsc));
				$rowcsc = mysql_fetch_array($resultcsc);

				$this->SetFont('Calibri','',7);
				$text = comillasInver($rowcs["servicio"]);
				$num_lines = $this->NbLines($ample,$text);
				$height = (5*$num_lines);
				$this->MultiCell($ample,5,$text,'LTBR');
#				$this->Cell(40,5,$text,'LBR',0);
#				$this->CellFitSpace(40,$height,$text,'LTBR',0);
				$x=$this->GetX();
				$y=$this->GetY();
				$this->SetXY($x+$ample,$y-$height);
				$this->SetFont('Calibri','',6);
				if ($rowcs["nbd"] == 1) {$nbd = "nbd ";}
				$cober = $rowcsc["nombre"]." ".$nbd.$rowcs["sla"]."%";
				$this->Cell(20,$height,$cober,'LTBR',0);
				$this->Cell(17,$height,$rowi1["abiertas"],'LTBR',0);
				$this->Cell(17,$height,$rowi2["cerradas"],'LTBR',0);
				$this->Cell(17,$height,$rowi3["pendientes"],'LTBR',0);
				$this->Cell(17,$height,$rowi4["pausadas"],'LTBR',0);
				$this->Cell(17,$height,$fora_sla,'LTBR',0);
				if ($_POST["horas"] == 1){
					$this->Cell(20,$height,$porcentageSLA,'LTBR',0);
					$this->Cell(15,$height,$horas[0]." h. ".$minutos[0]." m.",'LTBR',1);
				} else {
					$this->Cell(25,$height,$porcentageSLA,'LTBR',1);
				}

			}
			$this->SetFont('Calibri','',7);
			$this->Cell($ample,5,$total,'LTBR',0);
			$this->SetFont('Calibri','',6);
			$this->Cell(20,5,'','LTBR',0);
			$this->Cell(17,5,$open,'LTBR',0);
			$this->Cell(17,5,$close,'LTBR',0);
			$this->Cell(17,5,$pendin,'LTBR',0);
			$this->Cell(17,5,$stoped,'LTBR',0);
			$this->Cell(17,5,$outSLA,'LTBR',0);
			$porcentageSLA_total = number_format(((100*($open-$outSLA))/$open),2, ',', '.');
			if ($_POST["horas"] == 1){
				$this->Cell(20,5,$porcentageSLA_total,'LTBR',0);
				$hora = $time/60;
				$horas = explode(".",$hora);
				$minuto = ($hora - $horas[0])*60;
				$minutos = explode(".",$minuto);
				$this->Cell(15,5,$horas[0]." h. ".$minutos[0]." m.",'LTBR',1);
			} else {
				$this->Cell(25,5,$porcentageSLA_total,'LTBR',1);
			}

			$this->Cell(90,6,"",0,1);

			$mes_act = $mes_seg;
		}

		$this->SetFont('Calibri','B',8);
		$this->Cell(180,5,"".$incidencias_pendientes."",0,1);
		$this->SetFont('Calibri','',6);
		$this->Cell(15,4,"Id.",'B',0);
		$this->Cell(125,4,$asunto,'B',0);
		$this->Cell(25,4,$estado,'B',0);
		$this->Cell(15,4,"SLA",'B',1);

		$sqlcs = "select * from sgm_contratos_servicio where id_contrato=".$rowcon["id"]." and visible=1 order by servicio";
		$resultcs = mysql_query(convert_sql($sqlcs));
		while ($rowcs = mysql_fetch_array($resultcs)) {
			$sqli0 = "select * from sgm_incidencias where id_servicio=".$rowcs["id"]." and id_estado<>-2 and visible=1";
			$resulti0 = mysql_query(convert_sql($sqli0));
			while ($rowi0 = mysql_fetch_array($resulti0)){
				if ($rowi0["id_estado"] == -1){$estatinc = $abierta;}
				if ($rowi0["pausada"] == 1){$estatinc = $pausada;}
				$this->Cell(15,4,$rowi0["id"],'',0);
				$this->Cell(125,4,$rowi0["asunto"],'',0);
				$this->Cell(25,4,$estatinc,'',0);
				$this->Cell(15,4,$rowi0["sla"],'',1);
			}
		}

		$this->ln(5);
		$this->SetFont('Calibri','B',8);
		$this->Cell(180,5,"".$total_contrato."",0,1);
		$this->SetFont('Calibri','',6);
		$this->Cell($ample,5,"",'LTBR',0,0);
		$this->Cell(20,5,"".$cobertura."",'LTBR',0);
		$this->Cell(17,5,"".$abiertas."",'LTBR',0);
		$this->Cell(17,5,"".$cerradas."",'LTBR',0);
		$this->Cell(17,5,"".$pendientes."",'LTBR',0);
		$this->Cell(17,5,"".$pausadas."",'LTBR',0);
		$this->Cell(17,5,"".$fuera_sla."",'LTBR',0);
		if ($_POST["horas"] == 1){
			$this->Cell(20,5,"".$pocentaje_sla."",'TBR',0);
			$this->Cell(15,5,"".$tiempo."",'TBR',1);
		} else {
			$this->Cell(25,5,"".$pocentaje_sla."",'TBR',1);
		}

		$open = 0;
		$close = 0;
		$pendin = 0;
		$stoped = 0;
		$outSLA = 0;
		$time = 0;

		$sqlcs = "select * from sgm_contratos_servicio where id_contrato=".$rowcon["id"]." and visible=1 order by servicio";
		$resultcs = mysql_query(convert_sql($sqlcs));
		while ($rowcs = mysql_fetch_array($resultcs)) {
			$sqli1 = "select count(*) as abiertas from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1";
			$resulti1 = mysql_query(convert_sql($sqli1));
			$rowi1 = mysql_fetch_array($resulti1);
			$open =$open + $rowi1["abiertas"];
			$sqli2 = "select count(*) as cerradas from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1 and id_estado=-2";
			$resulti2 = mysql_query(convert_sql($sqli2));
			$rowi2 = mysql_fetch_array($resulti2);
			$close =$close + $rowi2["cerradas"];
			$sqli3 = "select count(*) as pendientes from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1 and id_estado<>-2 and pausada=0";
			$resulti3 = mysql_query(convert_sql($sqli3));
			$rowi3 = mysql_fetch_array($resulti3);
			$pendin =$pendin + $rowi3["pendientes"];
			$sqli4 = "select count(*) as pausadas from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1 and id_estado<>-2 and pausada=1";
			$resulti4 = mysql_query(convert_sql($sqli4));
			$rowi4 = mysql_fetch_array($resulti4);
			$stoped =$stoped + $rowi4["pausadas"];
			$sqli5 = "select count(*) as fora_sla from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1 and id_estado=-2 and sla=1";
			$resulti5 = mysql_query(convert_sql($sqli5));
			$rowi5 = mysql_fetch_array($resulti5);
			if ($rowcs["sla"] == 0){
				$fora_sla = "--";
			} else {
				$fora_sla = $rowi5["fora_sla"];
				$outSLA =$outSLA + $rowi5["fora_sla"];
			}

			if ($_POST["horas"] == 1){
				$sqli6 = "select sum(duracion) as temps from sgm_incidencias where visible=1 and id_incidencia in (select id from sgm_incidencias where id_servicio=".$rowcs["id"]." and visible=1)";
				$resulti6 = mysql_query(convert_sql($sqli6));
				$rowi6 = mysql_fetch_array($resulti6);
				$time =$time + $rowi6["temps"];
				$hora = $rowi6["temps"]/60;
				$horas = explode(".",$hora);
				$minuto = ($hora - $horas[0])*60;
				$minutos = explode(".",$minuto);
			}

			if ($rowcs["sla"] == 0){
				$porcentageSLA = "--";
			} else {
				$porcentageSLA = number_format(((100*($rowi1["abiertas"]-$fora_sla))/$rowi1["abiertas"]),2, ',', '.');
				if ($porcentageSLA > 0){
					$porcentageSLA = $porcentageSLA;
				} else {
					$porcentageSLA = "--";
				}
			}

			$sqlcsc = "select * from sgm_contratos_sla_cobertura where visible=1 and id=".$rowcs["id_cobertura"];
			$resultcsc = mysql_query(convert_sql($sqlcsc));
			$rowcsc = mysql_fetch_array($resultcsc);

			$this->SetFont('Calibri','',7);
			$text = comillasInver($rowcs["servicio"]);
			$num_lines = $this->NbLines($ample,$text);
			$height = (5*$num_lines);
			$this->MultiCell($ample,5,$text,'LTBR');
#			$this->Cell(40,5,$text,'LBR',0);
#			$this->CellFitSpace(40,$height,$text,'LTBR',0);
			$x=$this->GetX();
			$y=$this->GetY();
			$this->SetXY($x+$ample,$y-$height);
			$this->SetFont('Calibri','',6);
			if ($rowcs["nbd"] == 1) {$nbd = "nbd ";}
			$cober = $rowcsc["nombre"]." ".$nbd.$rowcs["sla"]."%";
			$this->Cell(20,$height,$cober,'LTBR',0);
			$this->Cell(17,$height,$rowi1["abiertas"],'LTBR',0);
			$this->Cell(17,$height,$rowi2["cerradas"],'LTBR',0);
			$this->Cell(17,$height,$rowi3["pendientes"],'LTBR',0);
			$this->Cell(17,$height,$rowi4["pausadas"],'LTBR',0);
			$this->Cell(17,$height,$fora_sla,'LTBR',0);
			if ($_POST["horas"] == 1){
				$this->Cell(20,$height,$porcentageSLA,'LTBR',0);
				$this->Cell(15,$height,$horas[0]." h. ".$minutos[0]." m.",'LTBR',1);
			} else {
				$this->Cell(25,$height,$porcentageSLA,'LTBR',1);
			}
		}
		$this->SetFont('Calibri','',7);
		$this->Cell($ample,5,$total,'LTBR',0);
		$this->SetFont('Calibri','',6);
		$this->Cell(20,5,'','LTBR',0);
		$this->Cell(17,5,$open,'LTBR',0);
		$this->Cell(17,5,$close,'LTBR',0);
		$this->Cell(17,5,$pendin,'LTBR',0);
		$this->Cell(17,5,$stoped,'LTBR',0);
		$this->Cell(17,5,$outSLA,'LTBR',0);
		$porcentageSLA_total = number_format(((100*($open-$outSLA))/$open),2, ',', '.');
		if ($_POST["horas"] == 1){
			$this->Cell(20,5,$porcentageSLA_total,'LTBR',0);
			$hora = $time/60;
			$horas = explode(".",$hora);
			$minuto = ($hora - $horas[0])*60;
			$minutos = explode(".",$minuto);
			$this->Cell(15,5,$horas[0]." h. ".$minutos[0]." m.",'LTBR',1);
		} else {
			$this->Cell(25,5,$porcentageSLA_total,'LTBR',0);
		}
	}
}

	$pdf=new PDF();
	$pdf->AddFont('Calibri','','Calibri.php');
	$pdf->AddFont('Calibri-Bold','B','Calibrib.php');
	$pdf->AddFont('Calibri','B','Calibrib.php');
	$sql = "select * from sgm_clients where visible=1";
	if ($_POST["id_cliente"] > 0){ $sql .= " and id=".$_POST["id_cliente"]."";} else {$sql .= " and id in (select id_cliente from sgm_contratos where visible=1)";}
	$sql .= " order by nombre";
#	echo $sql;
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){
		if ($_POST["id_contrato"] == 0) {$sqlcon = "select * from sgm_contratos where visible=1 and id_cliente=".$row["id"];}
		else {$sqlcon = "select * from sgm_contratos where visible=1 and id=".$_POST["id_contrato"];}
		$resultcon = mysql_query(convert_sql($sqlcon));
		while ($rowcon = mysql_fetch_array($resultcon)){
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->informe_print($row["id"],$rowcon["id"]);
		}
	}
	$pdf->Output("../pdf/informe.pdf");
	header("Location: ../pdf/informe.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);

?>
