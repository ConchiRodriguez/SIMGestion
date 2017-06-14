<?php
error_reporting(~E_ALL);
include ("../config.php");
foreach (glob("../auxiliar/*.php") as $filename)
{
	include ($filename);
}

$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

list($mes,$any) = explode ("-",$_POST["fecha2"]);
if ($_POST["fecha_hasta2"] > 0){ list($mes_fins,$any_fins) = explode ("-",$_POST["fecha_hasta2"]); }
else {list($mes_fins,$any_fins) = explode ("-",$_POST["fecha2"]);}
$ini_con = date("U", mktime(0,0,0,$mes,1,$any));
$fin_con = date("U", mktime(0,0,0,$mes_fins,1,$any_fins));


header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=resum_incidencies.csv');
$output = fopen('php://output', 'w');

$titulos = array('Cliente','Contrato','Asunto','Nivel Tecnico','Fecha Inicio','Fecha Cierre','Duracion (Min.)','Usuario');
fputcsv($output, $titulos,';');

$sql = "select * from sgm_contratos where visible=1";
if ($_POST["id_cliente2"] > 0){ $sql .= " and id_cliente=".$_POST["id_cliente2"]."";} else {$sql .= "  and id_cliente<>5";}
if ($_POST["id_tipo2"] == 1){ $sql .= " and activo=1";} elseif ($_POST["id_tipo2"] == 2){ $sql .= " and activo=0";}
if ($_POST["id_contrato2"] > 0){ $sql .= " and id=".$_POST["id_contrato2"]."";}
$result = mysqli_query($dbhandle,convertSQL($sql));
while ($row = mysqli_fetch_array($result)){
	$sqlc = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$row["id_cliente"];
	$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
	$rowc = mysqli_fetch_array($resultc);

	$sqli = "select * from sgm_incidencias where (fecha_inicio>".$ini_con.") and (fecha_inicio<".$fin_con.") and id_servicio in (select id from sgm_contratos_servicio where id_contrato=".$row["id"].") and visible=1 order by fecha_inicio";
	$resulti = mysqli_query($dbhandle,convertSQL($sqli));
	while ($rowi = mysqli_fetch_array($resulti)) {
		$sqlu = "select usuario from sgm_users where id=".$rowi["id_usuario_destino"];
		$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
		$rowu = mysqli_fetch_array($resultu);

		$sqldd = "select sum(duracion) as temps from sgm_incidencias where visible=1 and id_incidencia=".$rowi["id"]."";
		$resultdd = mysqli_query($dbhandle,convertSQL($sqldd));
		$rowdd = mysqli_fetch_array($resultdd);
		$horad = $rowdd["temps"]/60;
		$horasd = explode(".",$horad);
		$minutosd = $rowdd["temps"] % 60;

		$incid = array(comillasInver($rowc["nombre"].$rowc["cognom1"].$rowc["cognom2"]),comillasInver($row["descripcion"]),comillasInver($rowi["asunto"]),$rowi["nivel_tecnico"],date('d-m-Y',$rowi["fecha_inicio"]),date('d-m-Y',$rowi["fecha_cierre"]),$rowdd["temps"],$rowu["usuario"]);
        fputcsv($output, $incid,';');
	}
}

#if (count($incid) > 0) {
 #   foreach ($incid as $row) {
 #   }
#}


?>
