<?php
error_reporting(~E_ALL);

function extraerDatosEmail(){
	global $db,$dbhandle,$asunto;

	//Abre conexión IMAP
	$imap = imap_open ("{mail.solucions-im.net:143/imap/notls}INBOX", "proves@solucions-im.net", "Proves15") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
	$checar = imap_check($imap);
	// Detalles generales de todos los mensajes del buzón.
	$resultados = imap_fetch_overview($imap,"1:{$checar->Nmsgs}",0);
	foreach ($resultados as $detalles) {
		$id_cliente = 0;
		$id_usuario = 0;

		$destinatario = imap_utf8($detalles->to);
		$destinatario = str_replace('"','',$destinatario);
		$destinatario = str_replace("'","",$destinatario);
		$uid = $detalles->uid;
		//Comprobación de que el correo ya ha sido gestionado o no
		$sqli = "select * from sgm_incidencias_correos where destinatario='".$destinatario."'";
		$resulti = mysqli_query($dbhandle,$sqli);
		$rowi = mysqli_fetch_array($resulti);
//Si hay correo ...
#		if (($rowi["uid"]<$uid) or (!$rowi)) {
			$correo_nuevo = 1;
			if ($rowi["uid"]<$uid){
				$sql = "update sgm_incidencias_correos set uid=".$uid;
#				mysqli_query($dbhandle,$sql);
			}

			$asunto = utf8_decode(imap_utf8($detalles->subject));
			$remitente = imap_utf8($detalles->from);
			//Extraer correo del remitente
			$remite = imap_headerinfo($imap,$detalles->msgno);
			$correo_rem = $remite->from;
			foreach ($correo_rem as $correo_remite) {
				$correo_remitente = $correo_remite->mailbox."@".$correo_remite->host;
			}
			$leido = $detalles->seen;
			//extraer las diferentes partes de un correo electrónico
			$estructura = imap_fetchstructure($imap,$detalles->msgno);
			$flattenedParts = flattenParts($estructura->parts);
			if ($flattenedParts){
				foreach($flattenedParts as $partNumber => $part) {
					switch($part->type) {
						case 0:
							// the HTML or plain text part of the email
							$message = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
							// now do something with the message, e.g. render it
							$message = str_replace("</p>","\r\n",$message);
							$message = strip_tags($message,'\r\n');
							$message = str_replace("&nbsp;", "", $message);
							$message = trim($message);
							break;
						case 1:
							// multi-part headers, can ignore
							break;
						case 2:
							// attached message headers, can ignore
							break;
						case 3: // application
						case 4: // audio
						case 5: // image
							$filetipus = "image/";
						case 6: // video
						case 7: // other
							$filename = getFilenameFromPart($part);
							$filetipus .= $part->subtype;
							$filesize = $part->bytes;
							if($filename) {
								$file = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
							}
							break;
					}
				}
			} else {
				$message = imap_body($imap, $detalles->msgno);
			}

			$cabeza = imap_header($imap, $detalles->msgno );
			$data_missatge = strtotime($cabeza->MailDate);

			// Buscar si el remitente corresponde con un usuario de SIMges
			$sqlum = "select * from sgm_users where mail='".$correo_remitente."'";
			$resultum = mysqli_query($dbhandle,$sqlum);
			$rowum = mysqli_fetch_array($resultum);
			if ($rowum){
				$sqluc = "select * from sgm_users_clients where id_user=".$rowum["id"];
				$resultuc = mysqli_query($dbhandle,$sqluc);
				$rowuc = mysqli_fetch_array($resultuc);
				$id_cliente = $rowuc["id_client"];
				$id_usuario = $rowum["id"];
			} else {
				$sqlcc = "select * from sgm_clients_contactos where mail='".$correo_remitente."'";
				$resultcc = mysqli_query($dbhandle,$sqlcc);
				$rowcc = mysqli_fetch_array($resultcc);
				if ($rowcc){
					$id_cliente = $rowcc["id_client"];
					$id_usuario = 0;
				} else {
					$sqlumh = "select * from sgm_users where mail like '%@".$correo_remite->host."'";
					$resultumh = mysqli_query($dbhandle,$sqlumh);
					$rowumh = mysqli_fetch_array($resultumh);
					if ($rowumh){
						$sqluch = "select * from sgm_users_clients where id_user=".$rowumh["id"];
						$resultuch = mysqli_query($dbhandle,$sqluch);
						$rowuch = mysqli_fetch_array($resultuch);
						$id_cliente = $rowuch["id_client"];
						$id_usuario = 0;
					}
				}
			}
			// Asigna valores a las variables que no han encontrado valor en el proceso
			if ($id_usuario == "") { $id_usuario = 0;}
			if ($id_cliente == "") { $id_cliente = 0;}
			if ($asunto == "") { $asunto = "Sense assumpte";}

			if ($remitente != "soporte@solucions-im.com") {
//Busca si contiene codigo de incidencia en el asunto
				$idinci = buscarCodigoIncidenciaEmail($asunto,$id_cliente);
				echo $remitente."--".$idinci."<br>";
//si se encuentra una sola coincidencia inserta una nota de desarrollo, si es 0 o mas de 1 añade una incidencia nueva.
				if ($idinci == 1){
//Añadir nota a incidencia
					$camposInsert = "id_incidencia,correo,id_usuario_registro,id_usuario_origen,id_cliente,fecha_registro_inicio,fecha_inicio,id_estado,id_entrada,notas_desarrollo,asunto,pausada";
					$datosInsert = array($id_inc,1,$id_user,$id_user,$id_cli,$data,$data_missatge,-1,3,comillas($mensa),comillas($asun),0);
					insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

					$sqlinc = "select id_servicio from sgm_incidencias where visible=1 and id=".$id_inc;
					$resultinc = mysqli_query($dbhandle,$sqlinc);
					$rowinc = mysqli_fetch_array($resultinc);
					
					$sqlser = "select auto_email from sgm_contratos_servicio where visible=1 and id=".$rowinc["id_servicio"];
					$resultser = mysqli_query($dbhandle,$sqlser);
					$rowser = mysqli_fetch_array($resultser);
//enviar notificación nueva nota en la incidencia
					if ($rowser["auto_email"] == 1){
					}
				} else {
//Buscar si contiene codigo de catalogo de servicio
					$idserv = buscarCodigoServicioEmail($asunto,$id_cliente);
					echo $remitente."--".$idserv."<br>";
					if ($idserv == 1){$id_servicio_con = $idserv;} else {$id_servicio_con = 0;}
//Añadir incidencia
					$camposInsert = "id_incidencia,correo,id_usuario_registro,id_usuario_origen,id_cliente,fecha_registro_inicio,fecha_inicio,id_estado,id_entrada,notas_registro,asunto,pausada,id_servicio";
					$datosInsert = array(0,1,$id_user,$id_user,$id_cli,$data,$data_missatge,-1,3,comillas($mensa),comillas($asun),0,$id_servicio_con);
					insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

					if ($filename){
						$sqlin = "select * from sgm_incidencias where fecha_registro_inicio=".$data." and fecha_inicio=".$data_missatge." and asunto='".comillas($asunto)."'";
						$resultin = mysqli_query($dbhandle,$sqlin);
						$rowin = mysqli_fetch_array($resultin);

						subirArchivo(0,$file,$filename,$filesize,$filetipus,4,$rowin["id"]);
					}
					//enviar notificación nueva incidencia
					
				}
			}
			//Marca el mensaje como leido en el buzón de correo
			if ($leido == 0){imap_clearflag_full($imap, $uid, '\\Seen');}
#		}
	}
	//Cierra la conexión IMAP
	imap_close($imap, CL_EXPUNGE);
}

function getPart($connection, $messageNumber, $partNumber, $encoding) {
	$data = imap_fetchbody($connection, $messageNumber, $partNumber);
	switch($encoding) {
		case 0: return $data; // 7BIT
		case 1: return $data; // 8BIT
		case 2: return $data; // BINARY
		case 3: return base64_decode($data); // BASE64
		case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
		case 5: return $data; // OTHER
	}
}

function getFilenameFromPart($part) {
	$filename = '';
	if($part->ifdparameters) {
		foreach($part->dparameters as $object) {
			if(strtolower($object->attribute) == 'filename') {
				$filename = $object->value;
			}
		}
	}
	if(!$filename && $part->ifparameters) {
		foreach($part->parameters as $object) {
			if(strtolower($object->attribute) == 'name') {
				$filename = $object->value;
			}
		}
	}
	return $filename;
}

function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {
	foreach($messageParts as $part) {
		$flattenedParts[$prefix.$index] = $part;
		if(isset($part->parts)) {
			if($part->type == 2) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
			}
			elseif($fullPrefix) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
			}
			else {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix);
			}
			unset($flattenedParts[$prefix.$index]->parts);
		}
		$index++;
	}
	return $flattenedParts;
}

?>