<?php
error_reporting(~E_ALL);

#function mail365(){

	//Abre conexión IMAP
	$imap = imap_open ("{outlook.office365.com:993/imap/ssl/novalidate-cert}INBOX", "conchi.rodriguez@solucionsim.onmicrosoft.com", "9501Conchi") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
#	$imap = imap_open ("{mail.solucions-im.net:143/imap/notls}INBOX", "proves@solucions-im.net", "Proves15") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
	$checar = imap_check($imap);
	// Detalles generales de todos los mensajes del buzón.
	$resultados = imap_fetch_overview($imap,"1:{$checar->Nmsgs}",0);
	rsort($resultados);
	foreach ($resultados as $detalles) {
		$destinatario = utf8_decode(imap_utf8($detalles->to));
		$destinatario = str_replace('"','',$destinatario);
		$destinatario = str_replace("'","",$destinatario);
		$uid = $detalles->uid;
		if ($uid > '7400'){
			$asunto = utf8_decode(imap_utf8($detalles->subject));
			$remitente = imap_utf8($detalles->from);
			$estructura = imap_fetchstructure($imap,$detalles->msgno);
			$flattenedParts = flattenParts($estructura->parts);
			if ($flattenedParts){
				foreach($flattenedParts as $partNumber => $part) {
					switch($part->type) {
							case 0:
								// the HTML or plain text part of the email
								$message = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
								// now do something with the message, e.g. render it
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
#									file_put_contents("../sim/archivos/incidencias/".$filename,$file);
								}
							break;
					}
				}
			} else {
				$message = imap_body($imap, $detalles->msgno)."xx";
			}

				$message = str_replace("</p>","\r\n",$message);
				$message = strip_tags($message);
				if (mb_detect_encoding($message, 'UTF-8', true)){
					$message = utf8_decode($message);
				}

	#		echo $uid."-".$destinatario."-".$asunto."-".$remitente."-".$message."<br>";
			echo $uid."-".$destinatario."-".$asunto."<br>".$message."<br><br>";
		}
	}
#}

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