<?php
error_reporting(~E_ALL);

/*
$tipo: 1=incidencia nueva externa, 2=nota de incidencia externa, 3=incidencia nueva interna, 4=nota de incidencia interna, 5=cierre incidencia, 6=reabrir incidencia, 7=relacionar incidencia, 8=eliminar incidencia;
*/


function enviarNotificacion($correo_remitente,$id,$codigo,$id_codigo_externo,$tipo,$body){
	global $db,$dbhandle,$buzon_usuario;
	
	$cuerpo = '';

	$sqlm = "select * from sgm_incidencias where id=".$id;
	$resultm = mysqli_query($dbhandle,$sqlm);
	$rowm = mysqli_fetch_array($resultm);
	
	$asunto="[Solucions-IM]";
	if ($id != '') {$asunto.=" [SIM".$id."] ";}
	if ($codigo != '') { $asunto.= " ".$codigo." ";}
	if (($id_codigo_externo != '')) { $asunto.= " ".$id_codigo_externo." ";}
	$asunto.= comillasInver($rowm["asunto"]);
	$email=$buzon_usuario;

	if (($id_codigo_externo == '')) {$cuerpo.="**Aquest &eacute;s un missatge autom&agrave;tic.**<br><br>";}
	
	if (($id_codigo_externo == '')) {
		if ($tipo == 1) { $cuerpo.="Hem rebut el seu e-mail i s'ha creat una incid&egrave;ncia que els nostres t&egrave;cnics gestionaran.<br><br>";}
		if ($tipo == 2){ $cuerpo.="Hem rebut el seu e-mail amb informaci&oacute; adicional.<br><br>";}
		if ($tipo == 3){ $cuerpo.="S'ha creat una incid&egrave;ncia relacionada amb la seva plataforma de monitoritzaci&oacute<br><br><em>".$body."</em><br><br>";}
		if ($tipo == 4){ $cuerpo.="La informaci&oacute; de la incid&egrave;ncia a estat actualitzada amb la seg&uuml;ent informaci&oacute :<br><br>".$body."<br><br>";}
		if ($tipo == 5){ $cuerpo.="La incid&egrave;ncia s'ha tancat amb la seg&uuml;ent informaci&oacute :<br><br><em>".$body."</em><br><br>";}
		if ($tipo == 6){ $cuerpo.="La incid&egrave;ncia s'ha reobert<br><br>";}
		if ($tipo == 7){ $cuerpo.="La incid&egrave;ncia s'ha realcionat amb la seg&uuml;ent incidencia :<br><br><em>".$body."</em><br><br>";}
		if ($tipo == 8){ $cuerpo.="La incid&egrave;ncia s'ha eliminat<br><br>";}
	} else {
		$cuerpo.= $body;
	}

	if (($tipo != 5) and ($tipo != 6) and ($id_codigo_externo == '')){ $cuerpo.="Per facilitar m&eacute;s informaci&oacute;, contesti aquest missatge.<br><br>";}

	if (($id_codigo_externo == '')) {$cuerpo.="Id Incid&egrave;ncia: ".$id."<br>";}
	if (($id_codigo_externo == '')) {$cuerpo.="Assumpte: ".$asunto."<br>";}
	if (($id_codigo_externo == '')) {$cuerpo.="Data: ".date(DATE_RFC2822,$rowm["fecha_registro_inicio"])."<br>";}
	if (($id_codigo_externo == '')) {$cuerpo.="Remitent: ".$correo_remitente."<br><br>";}

	if (($id_codigo_externo == '')) {$cuerpo.="Gr&agrave;cies per contactar amb el departament de suport de Solucions-IM.<br>";}

	echo "<br>".$correo_remitente." - ".$asunto." - ".$email." - ".$cuerpo."<br>";

	if (send_mail($correo_remitente,$asunto,$email,$cuerpo)){
		$camposInsert = "id_incidencia,destinatario,asunto,fecha,tipo";
		$datosInsert = array($id,$correo_remitente,$asunto,date('U'),$tipo);
		insertFunction ("sgm_incidencias_correos_enviados",$camposInsert,$datosInsert);
	}
}

?>