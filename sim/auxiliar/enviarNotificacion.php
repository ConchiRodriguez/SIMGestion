<?php
error_reporting(~E_ALL);

/*
$tipo: 1=incidencia nueva externa, 2=nota de incidencia externa, 3=incidencia nueva interna, 4=nota de incidencia interna, 5=cierre incidencia, 6=reabrir incidencia;
*/


function enviarNotificacion($correo_remitente,$id,$codigo,$id_codigo_externo,$tipo,$body){
	global $db,$dbhandle;

	$sqlm = "select * from sgm_incidencias where id=".$id;
	$resultm = mysqli_query($dbhandle,$sqlm);
	$rowm = mysqli_fetch_array($resultm);
	
	$asunto="[Solucions-IM]";
	if ($id != '') {$asunto.=" [SIM".$id."] ";}
	if ($codigo != '') { $asunto.= " ".$codigo." ";}
	if (($id_codigo_externo != '')) { $asunto.= " ".$id_codigo_externo." ";}
	$asunto.= comillasInver($rowm["asunto"]);
	$email="proves@solucions-im.net";

	$cuerpo="<font face=\"Calibri\" size=4>**Aquest es un missatge autom&agrave;tic.**<br><br>";
	
	if ($tipo == 1) { $cuerpo.="Hem rebut el seu e-mail i s'ha creat una incid&egrave;ncia que els nostres t&egrave;cnics gestionaran.<br><br>";}
	if ($tipo == 2){ $cuerpo.="Hem rebut el seu e-mail amb informaci&oacute; adicional.<br><br>";}
	if ($tipo == 3){ $cuerpo.="S'ha creat una incid&egrave;ncia relacionada amb la seva plataforma de monitoritzaci&oacute<br><br><em>".$body."</em><br><br>";}
	if ($tipo == 4){ $cuerpo.="La informaci&oacute; de la incid&egrave;ncia a estat actualitzada amb la seg&uuml;ent informaci&oacute :<br><br>".$body."<br><br>";}
	if ($tipo == 5){ $cuerpo.="La incid&egrave;ncia s'ha tancat amb la seg&uuml;ent informaci&oacute :<br><br><em>".$body."</em><br><br>";}
	if ($tipo == 6){ $cuerpo.="La incid&egrave;ncia s'ha reobert<br><br>";}

	if (($tipo != 5) and ($tipo != 6)){ $cuerpo.="Per facilitar mes informaci&oacute;, contesti aquest missatge.<br><br>";}

	$cuerpo.="Id Incid&egrave;ncia: ".$id."<br>";
	$cuerpo.="Assumpte: ".$asunto."<br>";
	$cuerpo.="Data: ".date(DATE_RFC2822,$rowm["fecha_registro_inicio"])."<br>";
	$cuerpo.="Remitent: ".$correo_remitente."<br><br>";

	$cuerpo.="Gr&agrave;cies per contactar amb el departament de suport de Solucions-IM.</font><br>";

	echo "<br>".$correo_remitente." - ".$asunto." - ".$email." - ".$cuerpo."<br>";

#	if (send_mail($correo_remitente,$asunto,$email,$cuerpo)){
		$camposInsert = "id_incidencia,destinatario,asunto,fecha";
		$datosInsert = array($id,$correo_remitente,$asunto,date('U'));
		insertFunction ("sgm_incidencias_correos_enviados",$camposInsert,$datosInsert);
#	}
}

?>