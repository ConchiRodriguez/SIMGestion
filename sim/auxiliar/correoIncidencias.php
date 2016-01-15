<?php
error_reporting(~E_ALL);


function correo_incidencias(){
	global $db,$dbhandle,$buzon_correo,$buzon_usuario,$buzon_pass;

#	$imap = imap_open ($buzon_correo, $buzon_usuario, $buzon_pass) or die("No Se Pudo Conectar Al Servidor:".imap_last_error());
	$imap = imap_open ("{mail.solucions-im.com:143/imap/notls}INBOX", "soporte@solucions-im.com", "Multi12") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
	$checar = imap_check($imap);
	// Detalles generales de todos los mensajes del usuario.
	$resultados = imap_fetch_overview($imap,"1:{$checar->Nmsgs}",0);
	// Ordenamos los mensajes arriba los más nuevos y abajo los más antiguos
#	krsort($resultados);
	foreach ($resultados as $detalles) {
		$id_cliente = 0;
		$id_usuario = 0;

		$destinatario = imap_utf8($detalles->to);
		$destinatario = str_replace('"','',$destinatario);
		$destinatario = str_replace("'","",$destinatario);
		$uid = $detalles->uid;
		$sqli = "select * from sgm_incidencias_correos";
		$resulti = mysqli_query($dbhandle,$sqli);
		$rowi = mysqli_fetch_array($resulti);
		if ($rowi["uid"]<$uid) {
			$sql = "update sgm_incidencias_correos set ";
			$sql = $sql."uid=".$uid;
			mysqli_query($dbhandle,$sql);
#			echo $sql."<br>";

			$asunto = imap_utf8($detalles->subject);
			$remitente = imap_utf8($detalles->from);
			$remite = imap_headerinfo($imap,$detalles->msgno);
			$correo_rem = $remite->from;
			foreach ($correo_rem as $correo_remite) {
				$correo_remitente = $correo_remite->mailbox."@".$correo_remite->host;
			}

#			$fecha = $detalles->date;
#			$id = $detalles->message_id;
#			$num_mensage = $detalles->msgno;
			$leido = $detalles->seen;
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
							$tipus = "image/";
						case 6: // video
						case 7: // other
							$filename = getFilenameFromPart($part);
							$tipus .= $part->subtype;
							$size = $part->bytes;
							if($filename) {
								// it's an attachment
								$attachment = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
								// now do something with the attachment, e.g. save it somewhere
								file_put_contents("../sim/files/incidencias/".$filename,$attachment,FILE_APPEND); 
							}
							else {
								// don't know what it is
							}
						break;
					}
	#				echo "<pre>".var_dump($message)."</pre>";
				}
			} else {
				$message = imap_body($imap, $detalles->msgno);
			}
#			echo "<img src=\"".$filename."\">";

			$cabeza = imap_header($imap, $detalles->msgno );
			$data_missatge = strtotime($cabeza->MailDate);
			$data = time();

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
			if ($id_usuario == "") { $id_usuario = 0;}
			if ($id_cliente == "") { $id_cliente = 0;}
			if ($asunto == "") { $asunto = "Sense assumpte";}
#			if (($remitente != "guardian@grupserhs.com") and ($remitente != "soporte@solucions-im.com")){
			if ($remitente != "soporte@solucions-im.com") {
				$sql = "insert into sgm_incidencias (correo,id_usuario_registro,id_usuario_origen,id_cliente,fecha_registro_inicio,fecha_inicio,id_estado,id_entrada,notas_registro,asunto,pausada)";
				$sql = $sql."values (";
				$sql = $sql."1";
				$sql = $sql.",".$id_usuario."";
				$sql = $sql.",".$id_usuario."";
				$sql = $sql.",".$id_cliente."";
				$sql = $sql.",".$data."";
				$sql = $sql.",".$data_missatge."";
				$sql = $sql.",-1";
				$sql = $sql.",3";
				$sql = $sql.",'".comillas(utf8_decode($message))."'";
				$sql = $sql.",'".comillas(utf8_decode($asunto))."'";
				$sql = $sql.",0";
				$sql = $sql.")";
				mysqli_query($dbhandle,$sql);
#	echo $sql."<br>";
				if ($filename){
					$sqlin = "select * from sgm_incidencias where fecha_registro_inicio=".$data." and fecha_inicio=".$data_missatge." and asunto='".comillas($asunto)."'";
					$resultin = mysqli_query($dbhandle,$sqlin);
					$rowin = mysqli_fetch_array($resultin);
					$sql2 = "insert into sgm_files (id_tipo,name,type,size,id_incidencia)";
					$sql2 = $sql2."values (";
					$sql2 = $sql2."1";
					$sql2 = $sql2.",'".$filename."'";
					$sql2 = $sql2.",'".$tipus."'";
					$sql2 = $sql2.",".$size;
					$sql2 = $sql2.",".$rowin["id"];
					$sql2 = $sql2.")";
					mysqli_query($dbhandle,$sql2);
#	echo $sql2."<br>";
				}
			}
		if ($leido == 0){imap_clearflag_full($imap, $uid, '\\Seen');}
		}
	}

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